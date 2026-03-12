<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqProxyController extends Controller
{
    /**
     * Proxy endpoint: menerima request dari JS frontend,
     * meneruskan ke Groq API, mengembalikan hasilnya.
     *
     * POST /api/groq/chat
     */
    public function chat(Request $request)
    {
        $request->validate([
            'system_prompt' => 'required|string',
            'user_prompt'   => 'required|string',
            'temperature'   => 'nullable|numeric|min:0|max:2',
            'max_tokens'    => 'nullable|integer|min:100|max:8000',
        ]);

        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'error' => 'Groq API key belum dikonfigurasi di server.'
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(60)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => config('services.groq.model', 'llama-3.3-70b-versatile'),
                'messages'    => [
                    ['role' => 'system', 'content' => $request->system_prompt],
                    ['role' => 'user',   'content' => $request->user_prompt],
                ],
                'temperature' => $request->input('temperature', 0.3),
                'max_tokens'  => $request->input('max_tokens', 2048),
            ]);

            if ($response->failed()) {
                $body = $response->json();
                Log::error('[GroqProxy] API error', ['status' => $response->status(), 'body' => $body]);
                return response()->json([
                    'error' => $body['error']['message'] ?? 'Groq API error: ' . $response->status()
                ], $response->status());
            }

            $data = $response->json();
            $text = $data['choices'][0]['message']['content'] ?? '';

            return response()->json(['text' => $text]);

        } catch (\Exception $e) {
            Log::error('[GroqProxy] Exception: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}