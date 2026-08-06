<?php

namespace App\Services;

class CloudinaryService
{
    private string $cloudName;
    private string $uploadPreset;
    private string $baseUrl;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name') ?? '';
        $this->uploadPreset = config('services.cloudinary.upload_preset') ?? '';
        $this->baseUrl = "https://api.cloudinary.com/v1_1/{$this->cloudName}";
    }

    public function isConfigured(): bool
    {
        return !empty($this->cloudName) && !empty($this->uploadPreset);
    }

    public function upload($file, string $folder = 'tshoot'): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $filePath = is_string($file) ? $file : $file->getRealPath();
        $mimeType = mime_content_type($filePath);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);

        $ch = curl_init("{$this->baseUrl}/image/upload");
        $postFields = [
            'file' => new \CURLFile($filePath, $mimeType),
            'upload_preset' => $this->uploadPreset,
            'folder' => $folder,
            'public_id' => $filename . '_' . time(),
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
        return true;
    }
}
