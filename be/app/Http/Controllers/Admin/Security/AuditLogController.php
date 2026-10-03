<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->value();
        $event = $request->input('event');
        $model = $request->input('model');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userUuid = $request->input('user_uuid');

        $base = $this->filteredQuery($request);

        $logs = (clone $base)
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        // Stats follow the active filter so numbers stay in sync with the data.
        $stats = [
            'total' => (clone $base)->count(),
            'today' => (clone $base)->whereDate('created_at', today())->count(),
            'created' => (clone $base)->where('event', 'created')->count(),
            'updated' => (clone $base)->where('event', 'updated')->count(),
            'deleted' => (clone $base)->where('event', 'deleted')->count(),
        ];

        $events = ['created', 'updated', 'deleted', 'restored'];

        $models = AuditLog::query()
            ->whereNotNull('auditable_type')
            ->distinct()
            ->orderBy('auditable_type')
            ->pluck('auditable_type')
            ->mapWithKeys(fn ($type) => [$type => class_basename($type)]);

        $users = AuditLog::query()
            ->whereNotNull('user_uuid')
            ->whereNotNull('user_name')
            ->select('user_uuid', 'user_name', 'user_email')
            ->distinct()
            ->orderBy('user_name')
            ->get()
            ->mapWithKeys(fn ($u) => [$u->user_uuid => $u->user_name . ' (' . $u->user_email . ')']);

        return view('pages.security.audit-log.index', compact(
            'logs',
            'stats',
            'events',
            'models',
            'users',
            'search',
            'event',
            'model',
            'startDate',
            'endDate',
            'userUuid',
        ));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return back()->with('success', 'Audit log deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No data selected.');
        }
        $ids = array_map('intval', $ids);
        $count = AuditLog::whereIn('id', $ids)->delete();
        return back()->with('success', $count . ' audit logs deleted successfully.');
    }

    public function clear()
    {
        AuditLog::query()->delete();

        return back()->with('success', 'All audit logs cleared successfully.');
    }

    public function exportPdf(Request $request)
    {
        $logs = $this->filteredQuery($request)
            ->latest('created_at')
            ->limit(1000)
            ->get();

        $periode = '-';
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $periode = $request->input('start_date') . ' to ' . $request->input('end_date');
        } elseif ($request->filled('start_date')) {
            $periode = 'Since ' . $request->input('start_date');
        } elseif ($request->filled('end_date')) {
            $periode = 'Until ' . $request->input('end_date');
        } else {
            $periode = 'All Periods';
        }

        $filterUser = '-';
        if ($request->filled('user_uuid')) {
            $u = AuditLog::where('user_uuid', $request->input('user_uuid'))->first();
            $filterUser = $u ? ($u->user_name . ' (' . $u->user_email . ')') : $request->input('user_uuid');
        }

        $pdf = Pdf::loadView('pages.security.audit-log.laporan', [
            'logs' => $logs,
            'total' => $logs->count(),
            'periode' => $periode,
            'filterUser' => $filterUser,
            'filterEvent' => $request->input('event', 'All'),
            'filterModel' => $request->input('model') ? class_basename($request->input('model')) : 'All',
            'dicetakOleh' => $request->user()->name ?? 'Sistem',
            'waktuCetak' => now()->translatedFormat('d F Y H:i'),
            'search' => $request->input('search'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('audit-log-' . now()->format('Ymd-His') . '.pdf');
    }

    private function filteredQuery(Request $request)
    {
        $search = $request->string('search')->trim()->value();
        $event = $request->input('event');
        $model = $request->input('model');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userUuid = $request->input('user_uuid');

        return AuditLog::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('user_name', 'like', "%{$search}%")
                        ->orWhere('user_email', 'like', "%{$search}%")
                        ->orWhere('auditable_label', 'like', "%{$search}%")
                        ->orWhere('auditable_id', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%");
                });
            })
            ->when($event, fn ($query) => $query->where('event', $event))
            ->when($model, fn ($query) => $query->where('auditable_type', $model))
            ->when($userUuid, fn ($query) => $query->where('user_uuid', $userUuid))
            ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate));
    }
}
