<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\KpayService;
class MomoController extends Controller
{
    public function checkout($order, $amount)
    {
        session(['amount' => $amount]);  // Store amount in session
        return view('momo-checkout', [
            "order" => $order,
            "amount" => $amount
        ]);
    }

    public function payment($order, $amount)
    {
        return ['order_id' => $order, 'amount' => $amount];
    }
}