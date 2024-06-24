<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class MomoController extends Controller
{
    public $amount;
    public $order;
    public $orderId;

    public function checkout($order)
    {
        $this->order = $order;
        $orderTable = Order::findOrFail($order);
        $amount = $orderTable->billing_total;
        $this->amount = $amount;
        $orderNumber = $orderTable->order_number;

        return view('momo-checkout', [
            "order" => $order,
            "amount" => $amount,
            "orderNumber" => $orderNumber
        ]);
    }

    public function payment(Request $request)
    {
        $refNo = $request->refNo;
        $phoneNumber = $request->phoneNumber;
        $phoneNumber = str_replace(' ', '', $phoneNumber);

        // Find the order by order_number or fail if not found
        $orderCheck = Order::where('order_number', $refNo)->firstOrFail();
        $orderId = $orderCheck->id;
        $this->orderId = $orderId;

        // Get the billing total from the retrieved order
        $currency = 'RWF';
        $retailerId = 61;
        $redirecturl = "https://ter.maicourse.com/my-orders/" . $orderId;
        $retUrl = "https://ter.maicourse.com/momo-checkout/" . $orderId;

        $amount = $orderCheck->billing_total;
        $email = $orderCheck->billing_email;
        $details = empty($orderCheck->notes) ? "order" : $orderCheck->notes;
        
        // Split the billing_fullname into first and last name
        $fullName = $orderCheck->billing_fullname;
        $nameParts = explode(' ', $fullName);

        if (count($nameParts) === 1) {
            $firstName = $nameParts[0];
            $lastName = $nameParts[0];
        } else {
            $firstName = $nameParts[0];
            $lastName = $nameParts[count($nameParts) - 1];
        }

        // Store request and payment_id in session
        Session::put('request', $request->all());
        Session::put('payment_id', $refNo);

        // Prepare the data for the API request
        $postData = [
            'action' => 'pay',
            'msisdn' => $phoneNumber,
            'details' => $details,
            'refid' => $refNo,
            'amount' => (int)$amount,
            'currency' => $currency,
            'email' => $email,
            'cname' => $firstName . ' ' . $lastName,
            'cnumber' => $phoneNumber,
            'pmethod' => 'momo',
            'retailerid' => $retailerId,
            'returl' => $retUrl,
            'redirecturl' => $redirecturl,
            'bankid' => '040'
        ];

        // Send the payment request to the Kpay API
        $client = new Client([
            'base_uri' => 'https://pay.esicia.com/',
            'timeout'  => 30.0,
        ]);

        try {
            $response = $client->post('api/payment', [
                'json' => $postData,
                'auth' => ['tercera', '5Wmo5w'], // replace with actual username and password
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $responseBody = json_decode($response->getBody(), true);
            
            if ($responseBody['retcode'] == 0) {
                // Handle successful response
                return redirect($responseBody['url']);
            } else {
                // Handle errors returned by the API
                return back()->with('error', 'Payment request failed: ' . $responseBody['statusdesc']);
            }
        } catch (\Exception $e) {
            // Handle Guzzle exceptions
            return back()->with('error', 'Payment request failed: ' . $e->getMessage());
        }
    }
}
