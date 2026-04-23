<?php

namespace Modules\AdminManagement\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\AdminManagement\Action\Auditing\RouteName;
use Modules\AdminManagement\Models\Admin;
use Modules\AdminManagement\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        // Build a cleanly normalized filter array — anything missing or
        // obviously-invalid collapses to null so downstream logic can use
        // simple `!== null` checks.
        $filters = [
            'q'          => trim((string) $request->query('q', '')),
            'adminId'    => ctype_digit((string) $request->query('adminId')) ? (int) $request->query('adminId') : null,
            'method'     => in_array($request->query('method'), ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true) ? $request->query('method') : null,
            'route_name' => $request->query('route_name') ?: null,
            'start_date' => $this->parseDate($request->query('start_date')),
            'end_date'   => $this->parseDate($request->query('end_date')),
        ];

        $query = AuditLog::query()->with(['admin']);

        if (filled($filters['q'])) {
            $term = '%' . $filters['q'] . '%';
            $query->where(function ($q) use ($term) {
                $q->where('url', 'like', $term)
                  ->orWhere('route_name', 'like', $term)
                  ->orWhere('ip', 'like', $term);
            });
        }
        if ($filters['adminId']) {
            $query->where('auditable_type', Admin::class)
                  ->where('auditable_id', $filters['adminId']);
        }
        if ($filters['method']) {
            $query->where('method', $filters['method']);
        }
        if ($filters['route_name']) {
            $query->where('route_name', $filters['route_name']);
        }
        if ($filters['start_date']) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if ($filters['end_date']) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        $data = $query
            ->orderByDesc('created_at')
            ->paginate(Pagination::PAG->value)
            ->withQueryString();

        // Lightweight stats — unfiltered counts so cards don't jitter while
        // the admin types into the search box. Today = last 24 hours.
        $stats = [
            'total'    => AuditLog::query()->count(),
            'today'    => AuditLog::query()->where('created_at', '>=', now()->subDay())->count(),
            'admins'   => AuditLog::query()->where('auditable_type', Admin::class)->distinct('auditable_id')->count('auditable_id'),
            'mutations'=> AuditLog::query()->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])->count(),
        ];

        $admins = Admin::query()->orderBy('name')->get(['id', 'name', 'email']);
        $routes = RouteName::Routes();

        return view('adminmanagement::audit_log.index', compact(
            'data',
            'filters',
            'stats',
            'admins',
            'routes',
        ));
    }

    /**
     * Safely parse a date string (accepts Y-m-d, d/m/Y, m/d/Y).
     * Returns null on any parse failure so controllers can branch safely.
     */
    private function parseDate(?string $raw): ?string
    {
        if (!$raw || strtolower($raw) === 'undefined') {
            return null;
        }
        try {
            return Carbon::parse($raw)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    public function getPayload($id): JsonResponse
    {
        /** @var AuditLog|null $auditing */
        $auditing = AuditLog::query()->with('admin')->find($id);
        if (!$auditing) {
            return response()->json(['payload' => '<p class="text-muted m-0">Log not found.</p>'], 404);
        }

        // Normalize payload — model cast is `array`, but in case the row
        // predates the cast we also handle raw JSON strings.
        $payload = $auditing->payload;
        if (is_string($payload)) {
            $payload = json_decode($payload, true) ?: [];
        }
        if (!is_array($payload)) {
            $payload = [];
        }

        // Hide framework noise that isn't useful to an auditor.
        unset($payload['_token'], $payload['_method'], $payload['password'], $payload['password_confirmation']);

        $methodClass = match (strtoupper((string) $auditing->method)) {
            'GET'    => 'bg-label-info',
            'POST'   => 'bg-label-success',
            'PUT', 'PATCH' => 'bg-label-warning',
            'DELETE' => 'bg-label-danger',
            default  => 'bg-label-secondary',
        };

        // Build an explicit metadata block + a payload table so the modal
        // shows who / what / when / where, not just the form fields.
        $meta = [
            'Admin'      => $auditing->admin?->name ?: ('#' . $auditing->auditable_id),
            'Email'      => $auditing->admin?->email ?: '—',
            'IP address' => $auditing->ip ?: '—',
            'URL'        => $auditing->url ?: '—',
            'Route'      => RouteName::GetRouteName($auditing->route_name) ?: ($auditing->route_name ?: '—'),
            'When'       => $auditing->created_at?->format('Y-m-d H:i:s') ?: '—',
        ];

        $html  = '<div class="mb-3 d-flex align-items-center gap-2">';
        $html .= '<span class="badge '.$methodClass.' text-uppercase">'.e((string) $auditing->method).'</span>';
        $html .= '<span class="text-muted small">'.e($auditing->created_at?->diffForHumans() ?? '').'</span>';
        $html .= '</div>';

        $html .= '<table class="table table-sm mb-3">';
        foreach ($meta as $label => $value) {
            $html .= '<tr><th class="text-muted" style="width:140px">'.e($label).'</th><td class="text-break">'.e((string) $value).'</td></tr>';
        }
        $html .= '</table>';

        if (empty($payload)) {
            $html .= '<p class="text-muted small m-0"><i class="ti tabler-info-circle me-1"></i>No payload captured for this request.</p>';
        } else {
            $html .= '<h6 class="text-uppercase text-muted small mb-2">Payload</h6>';
            $html .= '<table class="table table-sm table-striped mb-0" style="direction: ltr;">';
            foreach ($payload as $key => $value) {
                // Render nested arrays as compact JSON so the table stays
                // scannable even when the payload has nested structures.
                if (is_array($value) || is_object($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
                $html .= '<tr>';
                $html .= '<th class="text-muted" style="width:180px">'.e((string) $key).'</th>';
                $html .= '<td><pre class="mb-0 small" style="white-space: pre-wrap; word-break: break-word;">'.e((string) $value).'</pre></td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        }

        return response()->json(['payload' => $html]);
    }

    /**
     * Get audit logs for a specific auditable model
     */
    public function getAuditLogsForModel(Request $request): JsonResponse
    {
        $auditableType = $request->get('auditable_type');
        $auditableId = $request->get('auditable_id');

        if (!$auditableType || !$auditableId) {
            return response()->json(['error' => 'Missing auditable_type or auditable_id'], 400);
        }

        $auditLogs = AuditLog::query()
            ->where('auditable_type', $auditableType)
            ->where('auditable_id', $auditableId)
            ->with('auditable')
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json($auditLogs);
    }

    /**
     * Get audit log statistics
     */
    public function getStatistics(): JsonResponse
    {
        $stats = [
            'total_logs' => AuditLog::count(),
            'logs_by_type' => AuditLog::selectRaw('auditable_type, COUNT(*) as count')
                ->groupBy('auditable_type')
                ->get(),
            'logs_by_method' => AuditLog::selectRaw('method, COUNT(*) as count')
                ->groupBy('method')
                ->get(),
            'recent_activity' => AuditLog::with('auditable')
                ->latest()
                ->limit(10)
                ->get(),
        ];

        return response()->json($stats);
    }
}
