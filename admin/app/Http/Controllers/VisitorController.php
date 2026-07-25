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
            $search = $request->search;
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

        $visitors = $query->latest('last_visit')->paginate(15)->withQueryString();

        $stats = [
            'total' => Visitor::count(),
            'today' => Visitor::whereDate('last_visit', today())->count(),
            'thisWeek' => Visitor::where('last_visit', '>=', now()->subWeek())->count(),
            'thisMonth' => Visitor::where('last_visit', '>=', now()->subMonth())->count(),
        ];

        return view('admin.visitors.index', compact('visitors', 'stats'));
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
        $browsers = Visitor::select('browser', DB::raw('count(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $os = Visitor::select('os', DB::raw('count(*) as total'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $devices = Visitor::select('device', DB::raw('count(*) as total'))
            ->whereNotNull('device')
            ->groupBy('device')
            ->get();

        $countries = Visitor::select('country', DB::raw('count(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $daily = Visitor::select(DB::raw('DATE(first_visit) as date'), DB::raw('count(*) as total'))
            ->where('first_visit', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pages = \App\Models\VisitorLog::select('page', DB::raw('count(*) as total'))
            ->groupBy('page')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        return view('admin.visitors.analytics', compact('browsers', 'os', 'devices', 'countries', 'daily', 'pages'));
    }
}
