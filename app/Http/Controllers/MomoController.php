<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
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
        $phoneNumber = str_replace(' ', '', $request->phoneNumber);

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
        $fullName = $orderCheck->billing_fullname;
        $nameParts = explode(' ', $fullName);

        $firstName = count($nameParts) === 1 ? $nameParts[0] : $nameParts[0];
        $lastName = count($nameParts) === 1 ? $nameParts[0] : $nameParts[count($nameParts) - 1];

        // Store request and payment_id in session
        Session::put('request', $request->all());
        Session::put('payment_id', $refNo);

        // Set CURL
        $curl = curl_init();
        $PURL = "https://pay.esicia.rw"; // Replace with the actual URL
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
                'action' => "pay",
                'msisdn' => $phoneNumber,
                'details' => $details,
                'refid' => $refNo,
                'amount' => (int)$amount,
                'currency' => $currency,
                'email' => $email,
                'cname' => $firstName . ' ' . $lastName,
                'cnumber' => $phoneNumber,
                'pmethod' => "momo",
                'retailerid' => $retailerId,
                'returl' => $retUrl,
                'redirecturl' => $redirecturl,
                'bankid' => "040",
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode('tercera:5Wmo5w'),
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            dd($err);
        }

        $transaction = json_decode($response);

        if (isset($transaction->success) && $transaction->success == 1 && $transaction->retcode == 01) {
            Order::where('id', $this->orderId)
                ->update(['payment_method' => 'paynow']);

            return redirect()->route('my-orders.index');
        } elseif (isset($transaction->reply) && $transaction->reply == "PENDING" && $transaction->retcode == 0) {
            // Check transaction status until it is no longer pending
            do {
                sleep(5); // Wait for 5 seconds before rechecking
                $status = $this->checkTransactionStatus($refNo);
            } while ($status == "PENDING");

            if ($status == "SUCCESS") {
                Order::where('id', $this->orderId)
                    ->update(['payment_method' => 'paynow']);

                return redirect()->route('my-orders.index');
            } else {
                Order::where('id', $this->orderId)->delete();
                return redirect()->route('momo.checkout', [$this->orderId])
                    ->with('error', 'Payment failed or was cancelled.');
            }
        } elseif (isset($transaction->success) && $transaction->success == 0 && ($transaction->retcode == 02 || $transaction->retcode == 606)) {
            Order::where('id', $this->orderId)->delete();
        } else {
            dd($transaction->reply);
        }
    }

    public function checkTransactionStatus($refNo)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pay.esicia.rw/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'refid' => $refNo,
                'action' => 'checkstatus'
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode('tercera:5Wmo5w'),
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        $resp = json_decode($response, true);

        if (isset($resp['statusid']) && $resp['statusid'] == '01') {
            return "SUCCESS";
        } elseif (isset($resp['statusid']) && $resp['statusid'] == '02') {
            return "FAILED";
        } else {
            return "PENDING";
        }
    }

    public function successPage()
    {
        $requestData = Session::get('request');
        $request = Session::get('request');
        $paymentFor = Session::get('paymentFor');

        $payment_id = Session::get('payment_id');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pay.esicia.rw/',
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
            // Update the order's payment_method to 'failed'
            $order = Order::find($this->orderId);

            // Flash the error message to the session
            session()->flash('error', "Payment Failed!");

            // Redirect to the checkout route
            return redirect()->route('momo.checkout', [$this->orderId]);
        }

        if ($resp['statusid'] == '01') {
            $transaction_id = $payment_id;
            $transaction_details = $resp['statusdesc'];
            // Handle successful payment here (e.g., update order status)
            $order = Order::find($this->orderId);
            if ($order) {
                $order->payment_method = 'paynow';
                $order->save();
            }
            Session::forget('request');
            Session::forget('payment_id');
            Session::forget('paymentFor');
            Cart::destroy();

            session()->flash('success', "Payment Successful, your order is being processed!");

            return redirect(route('my-orders.index'));
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
 