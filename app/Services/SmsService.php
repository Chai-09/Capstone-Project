<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public static function send($number, $message)
    {
        return Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => config('services.semaphore.key'),
            'number' => $number,
            'message' => $message,
            'sendername' => config('services.semaphore.sender'),
        ]);
    }
}
