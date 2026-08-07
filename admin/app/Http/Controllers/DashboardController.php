<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Visitor;
use App\Models\VisitorLog;
use App\Models\SiteImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalContacts = Contact::count();
        $newContacts = Contact::where('status', 'new')->count();
        $totalVisitors = Visitor::count();
        $totalImages = SiteImage::count();

        $visitorsToday = Visitor::whereDate('last_visit', today())->count();
        $contactsThisWeek = Contact::where('created_at', '>=', now()->subWeek())->count();

        $recentContacts = Contact::latest()->take(5)->get();
        $recentVisitors = Visitor::latest()->take(5)->get();

        // Visitantes por dia (últimos 14 dias)
        $visitorsByDay = Visitor::where('last_visit', '>=', now()->subDays(14))
            ->select(DB::raw('DATE(last_visit) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Visitantes por browser
        $visitorsByBrowser = Visitor::select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get();

        // Visitantes por país
        $visitorsByCountry = Visitor::whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        // Visitantes por dispositivo
        $visitorsByDevice = Visitor::select('device', DB::raw('COUNT(*) as count'))
            ->groupBy('device')
            ->orderByDesc('count')
            ->get();

        // Visitantes por sistema operativo
        $visitorsByOS = Visitor::select('os', DB::raw('COUNT(*) as count'))
            ->groupBy('os')
            ->orderByDesc('count')
            ->get();

        // Páginas mais visitadas
        $topPages = VisitorLog::select('page', DB::raw('COUNT(*) as count'))
            ->groupBy('page')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        // Contactos por dia (últimos 14 dias)
        $contactsByDay = Contact::where('created_at', '>=', now()->subDays(14))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalContacts', 'newContacts', 'totalVisitors', 'totalImages',
            'visitorsToday', 'contactsThisWeek', 'recentContacts', 'recentVisitors',
            'visitorsByDay', 'visitorsByBrowser', 'visitorsByCountry',
            'visitorsByDevice', 'visitorsByOS', 'topPages', 'contactsByDay'
        ));
    }

    public function moreContacts(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $contacts = Contact::latest()
            ->skip($offset)
            ->take($perPage)
            ->get();

        $total = Contact::count();
        $hasMore = ($offset + $perPage) < $total;

        return response()->json([
            'contacts' => $contacts->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'subject' => $contact->subject ?? 'Sem assunto',
                    'status' => $contact->status,
                    'show_url' => route('admin.contacts.show', $contact),
                ];
            }),
            'hasMore' => $hasMore,
        ]);
    }

    public function moreVisitors(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $visitors = Visitor::latest()
            ->skip($offset)
            ->take($perPage)
            ->get();

        $total = Visitor::count();
        $hasMore = ($offset + $perPage) < $total;

        return response()->json([
            'visitors' => $visitors->map(function ($visitor) {
                return [
                    'id' => $visitor->id,
                    'ip_address' => $visitor->ip_address ?? 'IP desconhecido',
                    'city' => $visitor->city,
                    'country' => $visitor->country,
                    'browser' => $visitor->browser ?? '-',
                    'device' => $visitor->device ?? '-',
                    'pages_visited' => $visitor->pages_visited,
                    'show_url' => route('admin.visitors.show', $visitor),
                ];
            }),
            'hasMore' => $hasMore,
        ]);
    }
}
