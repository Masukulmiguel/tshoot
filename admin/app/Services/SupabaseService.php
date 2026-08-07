<?php

namespace App\Services;

class SupabaseService
{
    private string $url;
    private string $serviceKey;
    private string $anonKey;

    public function __construct()
    {
        $this->url = config('services.supabase.url') ?? '';
        $this->serviceKey = config('services.supabase.service_key') ?? '';
        $this->anonKey = config('services.supabase.anon_key') ?? '';
    }

    public function isConfigured(): bool
    {
        return !empty($this->url) && !empty($this->serviceKey);
    }

    public function upload($file, string $bucket = 'uploads', string $folder = ''): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $filePath = is_string($file) ? $file : $file->getRealPath();
        $mimeType = mime_content_type($filePath);
        $extension = is_string($file) ? pathinfo($filePath, PATHINFO_EXTENSION) : $file->getClientOriginalExtension();
        if (empty($extension)) {
            $extension = match($mimeType) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                'image/gif' => 'gif',
                default => 'jpg',
            };
        }
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $path = $folder ? "{$folder}/{$filename}" : $filename;

        $ch = curl_init("{$this->url}/storage/v1/object/{$bucket}/{$path}");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => file_get_contents($filePath),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->serviceKey}",
                "Content-Type: {$mimeType}",
                "x-upsert: true",
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 || $httpCode === 201) {
            return "{$this->url}/storage/v1/object/public/{$bucket}/{$path}";
        }

        \Log::error('Supabase upload failed', [
            'http_code' => $httpCode,
            'response' => $response,
        ]);

        return null;
    }

    public function delete(?string $url, string $bucket = 'uploads'): bool
    {
        if (!$this->isConfigured() || empty($url)) {
            return false;
        }

        $path = $this->extractPath($url, $bucket);
        if (!$path) {
            return false;
        }

        $ch = curl_init("{$this->url}/storage/v1/object/{$bucket}/{$path}");
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->serviceKey}",
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode === 200;
    }

    private function extractPath(string $url, string $bucket): ?string
    {
        $pattern = "/\/storage\/v1\/object\/public\/{$bucket}\/(.+)$/";
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
