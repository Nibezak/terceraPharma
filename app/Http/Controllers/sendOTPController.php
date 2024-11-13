<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\SmsService;


class sendOTPController extends Controller
{
    

    public function index() {
        Log::info("=======VERIFICATION======");
        Log::info(request()->all());
        try {
            // 1. Generate OTP
            $shop = User::register(request()->mobile_number);
            
            // 2. Send OTP to the mobile
            (new SmsService)->send($shop->mobile, "Your OTP for Dukapp is {$shop->otp_token}.");

            return $shop;

        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            // 3. For us to reach here, the OTP is not matching.
            return response([
                "code" => 422,
                "status" => "INVALID_INPUT",
                "message" => $th->getMessage()
            ], 422);
        }
    }
}
