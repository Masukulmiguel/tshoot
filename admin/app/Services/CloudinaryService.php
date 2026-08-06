<?php

namespace App\Services;

class CloudinaryService
{
    private string $cloudName;
    private string $apiKey;
    private string $apiSecret;
    private string $baseUrl;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name') ?? '';
        $this->apiKey = config('services.cloudinary.api_key') ?? '';
        $this->apiSecret = config('services.cloudinary.api_secret') ?? '';
        $this->baseUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}";
    }

    public function isConfigured(): bool
    {
        return !empty($this->cloudName) && !empty($this->apiKey) && !empty($this->apiSecret);
    }

    public function upload($file, string $folder = 'tshoot'): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $filePath = is_string($file) ? $file : $file->getRealPath();
        $mimeType = mime_content_type($filePath);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        $timestamp = time();

        $params = [
            'folder' => $folder,
            'public_id' => $filename . '_' . $timestamp,
            'timestamp' => $timestamp,
        ];

        ksort($params);
        $signature = $this->generateSignature($params);

        $data = [];
        foreach ($params as $key => $value) {
            $data[] = "-F \"{$key}={$value}\"";
        }

        $ch = curl_init("{$this->baseUrl}/image/upload");
        $postFields = [
            'file' => new \CURLFile($filePath, $mimeType),
            'api_key' => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder' => $folder,
            'public_id' => $filename . '_' . $timestamp,
        ];

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            return $result['secure_url'] ?? null;
        }

        \Log::error('Cloudinary upload failed', [
            'http_code' => $httpCode,
            'response' => $response,
        ]);

        return null;
    }

    public function delete(string $publicId): bool
    {
        if (!$this->isConfigured() || empty($publicId)) {
            return false;
        }

        $timestamp = time();
        $params = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];

        $signature = $this->generateSignature($params);

        $ch = curl_init("{$this->baseUrl}/image/destroy");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'public_id' => $publicId,
                'api_key' => $this->apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return ($result['result'] ?? '') === 'ok';
    }

    private function generateSignature(array $params): string
    {
        ksort($params);
        $toSign = '';
        foreach ($params as $key => $value) {
            $toSign .= "{$key}={$value}&";
        }
        $toSign = rtrim($toSign, '&') . $this->apiSecret;
        return md5($toSign);
    }
}
