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
    public function show()
    {
        return view('checkout.index');
    }

    public function placeOrder(Request $request)
    {
        #TODO...
    }

    public function payWithPagaleve(Request $request)
    {
        #TODO...
    }
}
