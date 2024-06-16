<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $redirecturl = "http://143.110.165.130/my-orders/" . $orderId;
        $retUrl = "http://143.110.165.130/momo-checkout/" . $orderId;

        $amount = $orderCheck->billing_total;
        $email = $orderCheck->billing_email;
        $details = $orderCheck->notes;

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

        // Set CURL
        $curl = curl_init();
        $PURL = "https://pay.esicia.com"; // Replace with the actual URL
        curl_setopt_array($curl, array(
            CURLOPT_URL => $PURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'msisdn' => "25".$phoneNumber,
                'details' => $details,
                'refid' => $refNo,
                'amount' => (int)$amount,
                'currency' => $currency,
                'email' => $email,
                'cname' => $firstName . ' ' . $lastName,
                'retailerid' => $retailerId,
                'returl' => $retUrl,
                'redirecturl' => $redirecturl,
                'bankid' => '040',
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode('tercera:5Wmo5w'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the API
            dd($err);
            return redirect($redirecturl)->with('error', 'Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);
  
        if (!$transaction->url) {
            // there was an error from the API
            dd($transaction->reply);
            return redirect($redirecturl)->with('error', 'API returned error: ' . $transaction->reply);
        }

        return redirect($transaction->url);
    }

    public function successPage()
    {
        $requestData = Session::get('request');
        $request = Session::get('request');
        $paymentFor = Session::get('paymentFor');

        $payment_id = Session::get('payment_id');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pay.esicia.com/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'refid' => $payment_id,
                'action' => 'checkstatus'
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode('tercera:5Wmo5w'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $resp = json_decode($response, true);

        if ($resp['statusid'] == '02') {
            return redirect()->route('momo.checkout', [$this->orderId]);
        }
        if ($resp['statusid'] == '01') {
            $transaction_id = $payment_id;
            $transaction_details = $resp['statusdesc'];
            // Handle successful payment here (e.g., update order status)
            Session::forget('request');
            Session::forget('payment_id');
            Session::forget('paymentFor');

            session()->flash('success', __('Payment completed!'));

            return redirect()->route('my-profile.show', [$this->orderId]);
        }
    }

    public function cancelPayment()
    {
        return redirect()->back()->with('error', __('Something went wrong. Please try again'))->withInput();
    }

    public function returnPayment()
    {
        //
    }
}
