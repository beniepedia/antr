<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Send WhatsApp message using the gateway API.
     *
     * @param string $to The recipient's phone number
     * @param string $text The message text
     * @return bool True if successful, false otherwise
     */
    public static function sendMessage($to, $text)
    {
        return self::sendRequest('/api/send-text', [
            'to' => $to,
            'text' => $text,
        ]);
    }

    /**
     * Send WhatsApp image using the gateway API.
     *
     * @param string $to The recipient's phone number
     * @param string $imageUrl The image URL
     * @param string|null $caption The image caption
     * @return bool True if successful, false otherwise
     */
    public static function sendImage($to, $imageUrl, $caption = null)
    {
        $data = [
            'to' => $to,
            'image' => $imageUrl,
        ];

        if ($caption) {
            $data['caption'] = $caption;
        }

        return self::sendRequest('/api/send-image', $data);
    }

    /**
     * Send request to WhatsApp gateway API.
     *
     * @param string $endpoint The API endpoint
     * @param array $data The request data
     * @return bool True if successful, false otherwise
     */
    private static function sendRequest($endpoint, array $data)
    {
        $apiKey = config('services.whatsapp.api_key');
        $url = config('services.whatsapp.url');

        if (!$apiKey || !$url) {
            // Handle missing config, maybe log or throw exception
            return false;
        }

        $response = Http::withHeaders([
            'api-key' => $apiKey,
        ])->post($url . $endpoint, $data);

        return $response->successful();
    }
}