<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    private const TOKEN_CACHE_KEY = 'fcm_access_token';

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $projectId = config('services.fcm.project_id');
        $accessToken = $this->getAccessToken();

        if (!$projectId || !$accessToken) {
            Log::warning('FCM configuration missing, notification not sent.');
            return false;
        }

        $payload = [
            'message' => [
                'topic' => $this->applyTopicPrefix($topic),
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyData($data),
                'android' => [
                    'priority' => 'HIGH',
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                ],
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

        if (!$response->successful()) {
            Log::warning('FCM send failed.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->successful();
    }

    public function isEnabled(): bool
    {
        return (bool) config('services.fcm.enabled', false);
    }

    private function applyTopicPrefix(string $topic): string
    {
        $prefix = config('services.fcm.topic_prefix', '');
        return $prefix . $topic;
    }

    private function getAccessToken(): ?string
    {
        return Cache::remember(self::TOKEN_CACHE_KEY, now()->addMinutes(55), function () {
            $serviceAccount = $this->getServiceAccount();

            if (!$serviceAccount) {
                return null;
            }

            $tokenUri = $serviceAccount['token_uri'] ?? 'https://oauth2.googleapis.com/token';
            $jwt = $this->createJwt(
                $serviceAccount['client_email'] ?? null,
                $serviceAccount['private_key'] ?? null,
                $tokenUri
            );

            if (!$jwt) {
                return null;
            }

            $response = Http::asForm()->post($tokenUri, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);

            if (!$response->successful()) {
                Log::warning('FCM token request failed.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            return $response->json('access_token');
        });
    }

    private function getServiceAccount(): ?array
    {
        $path = config('services.fcm.service_account_path');

        if (!$path || !is_readable($path)) {
            Log::warning('FCM service account file not found.', ['path' => $path]);
            return null;
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            return null;
        }

        $decoded = json_decode($contents, true);
        return is_array($decoded) ? $decoded : null;
    }

    private function createJwt(?string $clientEmail, ?string $privateKey, string $tokenUri): ?string
    {
        if (!$clientEmail || !$privateKey) {
            return null;
        }

        $now = time();
        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT',
        ]));
        $claims = $this->base64UrlEncode(json_encode([
            'iss' => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => $tokenUri,
            'iat' => $now,
            'exp' => $now + 3600,
        ]));

        $unsignedToken = $header . '.' . $claims;

        $signature = '';
        $result = openssl_sign($unsignedToken, $signature, $privateKey, 'sha256');

        if (!$result) {
            Log::warning('FCM JWT signing failed.');
            return null;
        }

        return $unsignedToken . '.' . $this->base64UrlEncode($signature);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function stringifyData(array $data): array
    {
        $stringified = [];
        foreach ($data as $key => $value) {
            $stringified[$key] = is_scalar($value) ? (string) $value : json_encode($value);
        }
        return $stringified;
    }
}
