<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::query();

        if ($request->filled('search')) {
            $search = addcslashes($request->search, '%_\\');
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('first_visit', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('first_visit', '<=', $request->date_to . ' 23:59:59');
        }

        $totalVisitors = Visitor::count();
        $todayVisitors = Visitor::whereDate('last_visit', today())->count();
        $weekVisitors = Visitor::where('last_visit', '>=', now()->subWeek())->count();
        $monthVisitors = Visitor::where('last_visit', '>=', now()->subMonth())->count();

        $visitors = $query->latest('last_visit')->paginate(10)->withQueryString();

        return view('admin.visitors.index', compact('visitors', 'totalVisitors', 'todayVisitors', 'weekVisitors', 'monthVisitors'));
    }

    public function show(Visitor $visitor)
    {
        $logs = $visitor->logs()->latest()->paginate(20);
        return view('admin.visitors.show', compact('visitor', 'logs'));
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('admin.visitors.index')
            ->with('success', 'Visitante eliminado.');
    }

    public function analytics()
    {
        $totalVisitors = Visitor::count();

        $topBrowsers = Visitor::select('browser', DB::raw('count(*) as count'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->take(10)
            ->get()
            ->each(function ($item) use ($totalVisitors) {
                $item->percentage = $totalVisitors > 0 ? round(($item->count / $totalVisitors) * 100) : 0;
            });

        $topOs = Visitor::select('os', DB::raw('count(*) as count'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('count')
            ->take(10)
            ->get()
            ->each(function ($item) use ($totalVisitors) {
                $item->percentage = $totalVisitors > 0 ? round(($item->count / $totalVisitors) * 100) : 0;
            });

        $topDevices = Visitor::select('device', DB::raw('count(*) as count'))
            ->whereNotNull('device')
            ->groupBy('device')
            ->get()
            ->each(function ($item) use ($totalVisitors) {
                $item->percentage = $totalVisitors > 0 ? round(($item->count / $totalVisitors) * 100) : 0;
            });

        $topCountries = Visitor::select('country', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(10)
            ->get()
            ->each(function ($item) use ($totalVisitors) {
                $item->percentage = $totalVisitors > 0 ? round(($item->count / $totalVisitors) * 100) : 0;
            });

        $dailyVisitors = Visitor::select(DB::raw('DATE(first_visit) as day'), DB::raw('count(*) as count'))
            ->where('first_visit', '>=', now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $maxDaily = $dailyVisitors->max('count') ?: 1;
        $dailyVisitors->each(function ($item) use ($maxDaily) {
            $item->percentage = round(($item->count / $maxDaily) * 100);
        });

        $topPages = \App\Models\VisitorLog::select('page', DB::raw('count(*) as count'))
            ->groupBy('page')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $maxPages = $topPages->max('count') ?: 1;
        $topPages->each(function ($item) use ($maxPages) {
            $item->percentage = round(($item->count / $maxPages) * 100);
        });

        return view('admin.visitors.analytics', compact('topBrowsers', 'topOs', 'topDevices', 'topCountries', 'dailyVisitors', 'topPages'));
    }
}
