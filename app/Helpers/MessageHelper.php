<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

function sendWhatsAppNotification($phoneNumber, $message)
{
    $apiKey = env('WA_API_KEY');
    $apiUrl = env('WA_API_URL');
      try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
            ])->post($apiUrl, [
                'recipient_type' => 'individual',
                'to' => $phoneNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
}

