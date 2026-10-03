<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
use App\Services\Security\AnomalyDetector;
use Illuminate\Http\Request;

class LoginActivityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->value();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $base = LoginActivity::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%");
                });
            })
            ->when($startDate, fn ($query) => $query->whereDate('logged_in_at', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('logged_in_at', '<=', $endDate));

        $activities = (clone $base)
            ->latest('logged_in_at')
            ->paginate(15)
            ->withQueryString();

        // Stats follow the active filter so numbers stay in sync with the data.
        $stats = [
            'total' => (clone $base)->count(),
            'today' => (clone $base)->whereDate('logged_in_at', today())->count(),
            'week' => (clone $base)->where('logged_in_at', '>=', now()->subDays(7))->count(),
            'unique' => (clone $base)->whereNotNull('user_uuid')->distinct()->count('user_uuid'),
        ];

        $detector = app(AnomalyDetector::class);
        $suspiciousUsers = $detector->suspiciousUserUuids();
        $suspiciousIps = $detector->suspiciousIps();
        $stats['suspicious'] = $detector->countSuspiciousLogins($suspiciousUsers, $suspiciousIps);

        return view('pages.security.login-activity.index', compact(
            'activities',
            'stats',
            'search',
            'startDate',
            'endDate',
            'detector',
            'suspiciousUsers',
            'suspiciousIps',
        ));
    }

    public function destroy(LoginActivity $loginActivity)
    {
        $loginActivity->delete();

        return back()->with('success', 'Login history deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No data selected.');
        }
        $count = LoginActivity::whereIn('id', array_map('intval', $ids))->delete();
        return back()->with('success', $count . ' login history records deleted successfully.');
    }

    public function clear()
    {
        LoginActivity::query()->delete();

        return back()->with('success', 'All login history cleared successfully.');
    }
}
