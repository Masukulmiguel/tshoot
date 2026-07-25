<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Visitor;
use App\Models\VisitorLog;
use App\Models\SiteImage;
use Illuminate\Support\Facades\DB;

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
        $recentVisitors = Visitor::latest()->take(10)->get();

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
}
