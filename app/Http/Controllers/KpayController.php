<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KpayController extends Controller
{
    public function paymentProcess(Request $request)
    {
        $requestData = [
            "action" => "pay",
            "msisdn" => "250791903386",
            "details" => "order",
            "refid" => "15947234071471114",
            "amount" => 4200,
            "currency" => "RWF",
            "email" => "user@user.rw",
            "cname" => "CUSTOMER NAME",
            "cnumber" => "123456789",
            "pmethod" => "momo",
            "retailerid" => "02",
            "returl" => "https://www.tercera.rw",
            "redirecturl" => "https://www.tercera.rw/review"
        ];

        // Set your API key
        $apiKey = 'tercera:5Wmo5w';

        // Initialize cURL session
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pay.esicia.com/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => array(
                'secret_key: ' . $apiKey,
                'Content-Type: application/json'
            )
        ));

        // Execute cURL request
        $response = curl_exec($curl);
        $error = curl_error($curl);

        // Close cURL session
        curl_close($curl);

        // Check for errors
        if ($error) {
            return response()->json(['error' => 'cURL Error: ' . $error], 500);
        } else {
            // Return response
            return response()->json(json_decode($response), 200);
        }
    }
}
