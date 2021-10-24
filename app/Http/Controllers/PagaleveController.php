<?php

namespace App\Http\Controllers;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;

class PagaleveController extends Controller
{
    private $client;
    private $http_response_codes = [200, 201, 202, 203, 204];

    private $PAGALEVE_BASE_URL;
    private $PAGALEVE_USER;
    private $PAGALEVE_PASSWORD;
    private $pagaleve_token;

    private $idempotency_key;

    /**
     * Instantiate a new CheckoutController instance.
     */
    public function __construct()
    {
        $this->pagaleve_token  = session('pagaleve.token');
        $this->idempotency_key = $this->getUuidString();

        $this->PAGALEVE_BASE_URL = env('PAGALEVE_BASE_URL');
        $this->PAGALEVE_USER     = env('PAGALEVE_API_USER');
        $this->PAGALEVE_PASSWORD = env('PAGALEVE_API_PASSWORD');

        $this->client = new Client([
            'base_uri' => $this->PAGALEVE_BASE_URL,
            'verify' => false,
            'headers' => [
                'Content-Type'  => 'application/json'
            ],
        ]);
    }

    public function payWithPagaleve(Request $request)
    {
        $data = session('data');
        if (!$data) {
            return redirect('/checkout')->with(['error' => 'data not found']);
        }

        // Create API session if not created or expired - token is passed in the header for all future pagaleve API calls
        $this->getToken();

        if (!$this->pagaleve_token) {
            #TODO: redirect with error;
            return redirect('/checkout')->with(['error' => 'token not found']);
        }

        #TODO: Create Checkout(api) for purchase - Return redirect URL
        $checkout = $this->createCheckout($data);

        if (!$checkout) {
            return redirect('/checkout')->with(['error' => 'Error creating checkout']);
        }

        #redirects the customer to the redirect_url returned by pagaleve (Pagaleve UI)
        return Redirect::to($checkout->redirect_url);
    }

    public function processPayment()
    {
        $process = session('process');
        $data    = session('data');

        $payment = $this->createPayment($data);
        if (!$payment) {
            return redirect('/checkout')->with(['error' => 'Error creating payment']);
        }

        switch ($process)
        {
            case "release":
                $payment_process = $this->releasePayment($payment->id, $data);
                break;

            case "approve":
                $payment_process = $this->releasePayment($payment->id, $data);
                break;

            case "capture":
                $payment_process = $this->capturePayment($payment->id, $data);
                break;

            default:
                return redirect()->back();
                break;
        }

        if (!$payment_process) {
            return redirect('/checkout')->with(['error' => 'Error processing payment']);
        }

        return redirect('checkout/success');
    }

    private  function getUuidString()
    {
        return Uuid::uuid4()->toString();
    }

    private function getToken()
    {
        if ($this->isTokenExpired()) {
            try {
                $request_body = [
                    'username' => $this->PAGALEVE_USER,
                    'password' =>  $this->PAGALEVE_PASSWORD
                ];
                $response = $this->client->request('POST', 'authentication', [
                    'body' => json_encode($request_body)
                ]);

                if (in_array($response->getStatusCode(), $this->http_response_codes)) {
                    $response_body = json_decode($response->getBody());

                    #store JWT in the browser session. (NOT SECURE! USED AS DEMO ONLY)
                    session()->put('pagaleve.token', $response_body->token);
                    session()->put('pagaleve.exp', $response_body->expiration_date);

                    $this->pagaleve_token = $response_body->token;
                }
            } catch (ClientException $e) {
                Log::error(json_encode($e->getRequest()));
                Log::error(json_encode($e->getResponse()));
                return false;
            }
        }
    }

    private function isTokenExpired()
    {
        $token_exp = session('pagaleve.exp');
        if (!$token_exp) {
            return true;
        }

        $token_exp = new DateTime($token_exp);
        $token_exp = $token_exp->format('Y-m-d h:i:s');
        $datetime_now = date('Y-m-d h:i:s');

        if ($datetime_now > $token_exp) {
            return true;
        }
        return false;
    }

    private function createCheckout(array $data = [])
    {
        $request_body = [
            "approve_url"  => url('checkout/checkout-approve'),
            "cancel_url"   => url('checkout/checkout-cancel'),
            "complete_url" => url('checkout/checkout-complete'),
            "shopper" => [
                "first_name" => $data['first_name'],
                "last_name"  => $data['last_name'],
                "phone"      => $data['mobile_phone'],
                "email"      => $data['email'],
                "birth_date" => $data['dob'],
                "cpf"        => $data['cpf'],
            ],
            "order" => [
                "reference" => "",
                "amount" => 1, //$data['cart_value'],
                "items" => [
                    [
                        "name" => "",
                        "quantity" => 1,
                        "price" => 1
                    ]
                ]
            ]
        ];
        $headers['Authorization']   = $this->pagaleve_token;
        $headers['Idempotency-Key'] = $this->idempotency_key;

        try {
            # TODO: for some reason is returning error 500
            $response = $this->client->request('POST', 'checkouts', [
                'headers' => $headers,
                'body' => json_encode($request_body),
            ]);

            if (!in_array($response->getStatusCode(), $this->http_response_codes)) {
                return false;
            }
            return json_decode($response->getBody());

        } catch (ClientException $e) {
            Log::error(json_encode($e->getRequest()));
            Log::error(json_encode($e->getResponse()));
        }
        return false;
    }

    public function createPayment(array $data = [])
    {
        $request_body = [
            "checkout_id" => $data['checkout_id'],
            "intent" => $data['intent'],
            "currency" => $data['currency'],
            "amount" => $data['amount'],
        ];
        $headers['Authorization']   = $this->pagaleve_token;
        $headers['Idempotency-Key'] = $this->idempotency_key;

        try {
            $response = $this->client->request('POST', 'payments', [
                'headers' => $headers,
                'body' => json_encode($request_body),
            ]);

            if (!in_array($response->getStatusCode(), $this->http_response_codes)) {
                return false;
            }
            return json_decode($response->getBody());

        } catch (ClientException $e) {
            Log::error(json_encode($e->getRequest()));
            Log::error(json_encode($e->getResponse()));
        }
        return false;
    }

    private function releasePayment($payment_id, array $data = [])
    {
        $request_body = [
            "amount" => $data['amount'],
        ];
        $headers['Authorization']   = $this->pagaleve_token;
        $headers['Idempotency-Key'] = $this->idempotency_key;

        try {
            $response = $this->client->request('POST', "payments/$payment_id/release", [
                'headers' => $headers,
                'body' => json_encode($request_body),
            ]);

            if (!in_array($response->getStatusCode(), $this->http_response_codes)) {
                return false;
            }
            return json_decode($response->getBody());

        } catch (ClientException $e) {
            Log::error(json_encode($e->getRequest()));
            Log::error(json_encode($e->getResponse()));
        }
        return false;
    }

    private function capturePayment($payment_id, array $data = [])
    {
        $request_body = [
            "amount" => $data['amount'],
            "is_partial_capture" => $data['is_partial_capture']
        ];
        $headers['Authorization']   = $this->pagaleve_token;
        $headers['Idempotency-Key'] = $this->idempotency_key;

        try {
            $response = $this->client->request('POST', "payments/$payment_id/capture", [
                'headers' => $headers,
                'body' => json_encode($request_body),
            ]);

            if (!in_array($response->getStatusCode(), $this->http_response_codes)) {
                return false;
            }
            return json_decode($response->getBody());

        } catch (ClientException $e) {
            Log::error(json_encode($e->getRequest()));
            Log::error(json_encode($e->getResponse()));
        }
        return false;
    }
}
