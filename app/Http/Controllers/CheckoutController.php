<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('checkout.index');
    }

    /**
     * Show checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // return view('checkout.show');
    }

    /**
     * Show checkout success page.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
         return view('checkout.success');
    }

    public function placeOrder(Request $request)
    {
        switch ($request->input('action')) {
            case 'pay-with-card':
                return $this->payWithCard($request);
                break;

            case 'pay-with-pagaleve':
                return redirect('/pagaleve/pay-with-pagaleve')->with(['data' => $request->all()]);
                break;

            default:
                return false;
                break;
        }
    }

    private function payWithCard(Request $request)
    {
        return view('checkout.success');
    }

    public function checkoutComplete(Request $request)
    {
        return redirect('/pagaleve/process-payment')->with(['process' => 'release', 'data' => $request->all()]);
    }

    public function checkoutApprove(Request $request)
    {
        return redirect('/pagaleve/process-payment')->with(['process' => 'approve', 'data' => $request->all()]);
    }

    public function checkoutCancel(Request $request)
    {
        return redirect('/pagaleve/process-payment')->with(['process' => 'capture', 'data' => $request->all()]);
    }
}
