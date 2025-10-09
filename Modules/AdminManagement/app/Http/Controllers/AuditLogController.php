<?php

namespace Modules\AdminManagement\App\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\AdminManagement\app\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $data = AuditLog::query()->with('doctor');
        $data = AuditLog::IndexFilter($data, $request->all());
        $data = $data->orderByDesc('created_at')->paginate(Pagination::PAG->value);
        return view('adminmanagement::audit_log.index', compact('data'));
    }

    public function getPayload($id): JsonResponse
    {
        $auditing = AuditLog::query()->find($id);
        $payload_html = "<table class='table table-vcenter' style='direction: ltr !important;'>";
        foreach (
            !is_array($auditing->payload) ? json_decode(
                $auditing->payload,
            ) : $auditing->payload as $index => $payload
        ) {
            if (is_string($payload) && $index != '_token') {
                $payload_html .= "<tr>";
                $payload_html .= "<td>$index : </td><td>$payload</td>";
                $payload_html .= "</tr>";
            }
        }
        $payload_html .= "</table>";

        return response()->json(['payload' => $payload_html]);
    }
}
