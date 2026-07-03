<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlowKirimService
{
    protected string $token;
    protected string $sessionId;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token     = config('services.flowkirim.token');
        $this->sessionId = config('services.flowkirim.session_id');
        $this->baseUrl   = config('services.flowkirim.base_url');
    }

    /**
     * Format nomor WA: 628xxx → 628xxx@s.whatsapp.net
     */
    protected function formatNumber(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        return $number . '@s.whatsapp.net';
    }

    /**
     * Kirim dokumen PDF via URL publik
     */
    public function sendDocument(string $to, string $pdfUrl, string $caption): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . '/api/whatsapp/messages/media', [
                'session_id' => $this->sessionId,
                'to'         => $this->formatNumber($to),
                'media_url'  => $pdfUrl,
                'type'       => 'document',
                'caption'    => $caption,
            ]);

            Log::info('FlowKirim response', $response->json());
            return $response->successful();

        } catch (\Exception $e) {
            Log::error('FlowKirim error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim pesan teks biasa
     */
    public function sendText(string $to, string $message): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type'  => 'application/json',
            ])->post($this->baseUrl . '/api/whatsapp/messages/text', [
                'session_id' => $this->sessionId,
                'to'         => $this->formatNumber($to),
                'message'    => $message,
            ]);

            Log::info('FlowKirim text response', $response->json());
            return $response->successful();

        } catch (\Exception $e) {
            Log::error('FlowKirim text error: ' . $e->getMessage());
            return false;
        }
    }
}
