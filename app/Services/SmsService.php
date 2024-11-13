<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService {


    protected $host       = null;
    protected $segment    = null;
    protected $username   = null;
    protected $password   = null;
    protected $type       = null;
    protected $dlr        = null;
    protected $sender     = null;

    public function __construct() {

        $this->host       = env("SMS_HOST");
        $this->segment    = env("SMS_SEGMENT");
        $this->username   = env("SMS_USERNAME");
        $this->password   = env("SMS_PASSWORD");
        $this->type       = env("SMS_TYPE");
        $this->dlr        = env("SMS_dlr");
        $this->sender     = env("SMS_SENDER");
    }

    /**
     * Send SMS to a Number
     *
     * @param string $mobile
     * @param string $message
     * @return boolean
     */
    public function send(string $mobile, string $message)
    {
        $response = Http::get($this->host.$this->segment, [
                "username"      => $this->username, 
                "password"      => $this->password, 
                "type"          => $this->type, 
                "dlr"           => $this->dlr, 
                "source"        => $this->sender, 
                "destination"   => $mobile,
                "message"       => $message,
        ])->body();

        Log::info($response);

        return $response;
    }
}