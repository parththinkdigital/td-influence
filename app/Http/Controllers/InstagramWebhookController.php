<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InstagramWebhookController extends Controller
{
    /**
     * Handle Meta / Instagram Webhook Verification Handshake (GET).
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode', $request->input('hub_mode', $request->input('hub.mode')));
        $token = $request->query('hub_verify_token', $request->input('hub_verify_token', $request->input('hub.verify_token')));
        $challenge = $request->query('hub_challenge', $request->input('hub_challenge', $request->input('hub.challenge')));

        $expectedToken = config('services.meta.webhook_verify_token', 'talent_marketplace_secret_2026');

        if ($mode === 'subscribe' && (string) $token === (string) $expectedToken) {
            Log::info('Instagram Webhook Verified Successfully!', ['challenge' => $challenge]);

            return response((string) $challenge, 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Content-Length' => strlen((string) $challenge),
            ]);
        }

        Log::warning('Instagram Webhook Verification Failed', [
            'mode' => $mode,
            'token_received' => $token,
            'expected_token' => $expectedToken,
        ]);

        return response('Forbidden', 403);
    }

    /**
     * Handle Incoming Instagram Webhook Events (POST).
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Instagram Webhook Event Received:', $payload);

        // Process incoming events if needed (e.g., media updates, mentions)
        return response('EVENT_RECEIVED', 200);
    }

    /**
     * Handle Meta Data Deletion Request Callback (GET / POST).
     */
    public function dataDeletionCallback(Request $request)
    {
        Log::info('Meta Data Deletion Callback Invoked', $request->all());

        $confirmationCode = 'TD-DEL-'.strtoupper(substr(md5(uniqid(rand(), true)), 0, 10));
        $statusUrl = url('/data-deletion?code='.$confirmationCode);

        // Meta requires a JSON response containing 'url' and 'confirmation_code'
        return response()->json([
            'url' => $statusUrl,
            'confirmation_code' => $confirmationCode,
        ]);
    }
}
