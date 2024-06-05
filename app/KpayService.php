<?php 

namespace App;

use Illuminate\Support\Facades\Http;

class KpayService
{
    public function __construct()
    {
        $this->initializeService();
    }

    private function initializeService()
    {
        Http::setDefaultOptions([
            'base_uri' => 'https://pay.esicia.rw',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function initiate($transactionDto)
    {
        try {
            $payload = [
                'amount' => $transactionDto['amount'],
                'phoneNumber' => $transactionDto['phoneNumber'],
                'retailerid' => '61',
                'redirecturl' => 'https://www.tercera.rw/review',
                'returl' => 'https://www.tercera.rw',
                'msisdn' => $transactionDto['cnumber'],
                'bankId' => '040',
                'refid' => str_replace(' ', '', $transactionDto['refid']),
            ];
            
            $response = Http::withBasicAuth(env('KPAY_USERNAME'), env('KPAY_PASSWORD'))
                             ->post('/', $payload);
            
            return $response->json();
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }
}
