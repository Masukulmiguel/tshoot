<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorLog;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'service' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['service'] ?? 'Contacto via site',
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mensagem enviada com sucesso!'
        ]);
    }

    public function trackVisitor(Request $request)
    {
        $ip = $request->ip();

        $visitor = Visitor::where('ip_address', $ip)
            ->where('last_visit', '>=', now()->subMinutes(30))
            ->first();

        $geoData = $this->getGeoData($ip, $request->input('timezone'));

        $lat = $request->input('lat') ?? $geoData['lat'] ?? null;
        $lon = $request->input('lon') ?? $geoData['lon'] ?? null;

        $agent = $request->userAgent();
        $browser = $this->parseBrowser($agent);
        $os = $this->parseOS($agent);
        $device = $this->parseDevice($agent);
        $screen = $request->input('screen') ?? null;
        $language = $request->input('lang') ?? $request->header('Accept-Language', 'pt');
        $timezone = $request->input('timezone') ?? $geoData['timezone'] ?? null;

        if ($visitor) {
            $update = [
                'pages_visited' => $visitor->pages_visited + 1,
                'last_visit' => now(),
            ];
            if ($lat && $lon) {
                $update['latitude'] = $lat;
                $update['longitude'] = $lon;
            }
            if (!empty($geoData['country']) && empty($visitor->country)) {
                $update['country'] = $geoData['country'];
            }
            if (!empty($geoData['city']) && empty($visitor->city)) {
                $update['city'] = $geoData['city'];
            }
            $visitor->update($update);
        } else {
            $visitor = Visitor::create([
                'ip_address' => $ip,
                'country' => $geoData['country'] ?? null,
                'city' => $geoData['city'] ?? null,
                'latitude' => $lat,
                'longitude' => $lon,
                'timezone' => $timezone,
                'isp' => $geoData['isp'] ?? null,
                'browser' => $browser,
                'os' => $os,
                'device' => $device,
                'screen_resolution' => $screen,
                'language' => $language,
                'referrer' => $request->header('referer'),
                'landing_page' => $request->input('page', '/'),
                'pages_visited' => 1,
                'first_visit' => now(),
                'last_visit' => now(),
            ]);
        }

        VisitorLog::create([
            'visitor_id' => $visitor->id,
            'page' => $request->input('page', '/'),
            'referrer' => $request->header('referer'),
        ]);

        return response()->json(['success' => true]);
    }

    private function getGeoData($ip, $clientTimezone = null)
    {
        if ($this->isPrivateIp($ip)) {
            return [
                'country' => 'Angola',
                'city' => 'Luanda',
                'timezone' => $clientTimezone ?: 'Africa/Luanda',
                'isp' => 'Rede Local',
                'lat' => null,
                'lon' => null,
            ];
        }

        $geoData = [];

        try {
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}?fields=status,country,city,lat,lon,timezone,isp");
            if ($response->successful() && ($response->json('status') ?? '') === 'success') {
                $geoData = $response->json();
            }
        } catch (\Exception $e) {}

        if (empty($geoData['country']) || empty($geoData['city'])) {
            try {
                $response = Http::timeout(5)->get("https://ipinfo.io/{$ip}/json");
                if ($response->successful() && !isset($response->json()['error'])) {
                    $data = $response->json();
                    $geoData['country'] = $geoData['country'] ?? $data['country'] ?? null;
                    $geoData['city'] = $geoData['city'] ?? $data['city'] ?? null;
                    $geoData['timezone'] = $geoData['timezone'] ?? $data['timezone'] ?? null;
                    $geoData['isp'] = $geoData['isp'] ?? $data['org'] ?? null;
                    if (empty($geoData['lat']) && !empty($data['loc'])) {
                        $parts = explode(',', $data['loc']);
                        $geoData['lat'] = $parts[0] ?? null;
                        $geoData['lon'] = $parts[1] ?? null;
                    }
                }
            } catch (\Exception $e) {}
        }

        if (empty($geoData['country']) && !empty($clientTimezone)) {
            $tzMap = [
                'Africa/Luanda' => ['Angola', 'Luanda'],
                'Africa/Maputo' => ['Mozambique', 'Maputo'],
                'Africa/Johannesburg' => ['South Africa', 'Johannesburg'],
                'Africa/Nairobi' => ['Kenya', 'Nairobi'],
                'Africa/Lagos' => ['Nigeria', 'Lagos'],
                'America/Sao_Paulo' => ['Brazil', 'São Paulo'],
                'America/New_York' => ['United States', 'New York'],
                'Europe/London' => ['United Kingdom', 'London'],
                'Europe/Paris' => ['France', 'Paris'],
                'Asia/Dubai' => ['UAE', 'Dubai'],
            ];
            if (isset($tzMap[$clientTimezone])) {
                $geoData['country'] = $tzMap[$clientTimezone][0];
                $geoData['city'] = $tzMap[$clientTimezone][1];
            }
        }

        return $geoData;
    }

    private function isPrivateIp($ip)
    {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    private function parseBrowser($agent)
    {
        if (str_contains($agent, 'Firefox')) return 'Firefox';
        if (str_contains($agent, 'Edg')) return 'Edge';
        if (str_contains($agent, 'Chrome')) return 'Chrome';
        if (str_contains($agent, 'Safari')) return 'Safari';
        if (str_contains($agent, 'Opera') || str_contains($agent, 'OPR')) return 'Opera';
        return 'Outro';
    }

    private function parseOS($agent)
    {
        if (str_contains($agent, 'Windows')) return 'Windows';
        if (str_contains($agent, 'Mac OS')) return 'macOS';
        if (str_contains($agent, 'Linux')) return 'Linux';
        if (str_contains($agent, 'Android')) return 'Android';
        if (str_contains($agent, 'iPhone') || str_contains($agent, 'iPad')) return 'iOS';
        return 'Outro';
    }

    private function parseDevice($agent)
    {
        if (preg_match('/mobile|android|iphone/i', $agent)) return 'Mobile';
        if (preg_match('/tablet|ipad/i', $agent)) return 'Tablet';
        return 'Desktop';
    }
}