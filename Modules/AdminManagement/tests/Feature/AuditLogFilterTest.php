<?php

/*
|--------------------------------------------------------------------------
| Audit Log filter + admin-relation tests
|--------------------------------------------------------------------------
|
| Regression guard for two bugs we fixed in the audit log:
|   1. AuditLog::admin() relation previously had `->where('auditable_type', …)`
|      baked into the belongsTo, which Laravel applies to the related table.
|      That threw `Unknown column 'auditable_type' in admins` whenever
|      anything touched that relation. We keep the relation clean now.
|   2. The index filter logic (?q, ?adminId, ?method, ?route_name, ?start_date,
|      ?end_date) needs to compose correctly. Any filter that silently 500s
|      would lock admins out of the audit log exactly when they need it most.
|
*/

use Modules\AdminManagement\Models\Admin;
use Modules\AdminManagement\Models\AuditLog;

beforeEach(function () {
    $this->actingAsSuperAdmin();
});

it('eager-loads the admin relation without touching auditable_type', function () {
    /** @var Admin $admin */
    $admin = Admin::factory()->create(['name' => 'Logged User']);

    AuditLog::query()->create([
        'auditable_type' => Admin::class,
        'auditable_id' => $admin->id,
        'url' => 'http://localhost/admin/dashboard',
        'method' => 'GET',
        'payload' => [],
        'ip' => '127.0.0.1',
        'route_name' => 'admin.dashboard',
    ]);

    // Previously this would throw SQLSTATE[42S22] Unknown column auditable_type.
    $log = AuditLog::query()->with('admin')->latest()->first();

    expect($log)->not->toBeNull();
    expect($log->admin)->not->toBeNull();
    expect($log->admin->name)->toBe('Logged User');
});

it('renders the audit log index page', function () {
    $response = $this->get(route('admin.audits.index'));

    $response->assertOk();
    $response->assertViewIs('adminmanagement::audit_log.index');
    $response->assertViewHas('data');
    $response->assertViewHas('stats');
});

it('filters by admin id', function () {
    $alice = Admin::factory()->create(['name' => 'Alice']);
    $bob = Admin::factory()->create(['name' => 'Bob']);

    foreach ([$alice->id, $alice->id, $bob->id] as $id) {
        AuditLog::query()->create([
            'auditable_type' => Admin::class,
            'auditable_id' => $id,
            'url' => 'http://localhost/admin/dashboard',
            'method' => 'GET',
            'payload' => [],
            'ip' => '127.0.0.1',
            'route_name' => 'admin.dashboard',
        ]);
    }

    $response = $this->get(route('admin.audits.index', ['adminId' => $alice->id]));

    $logs = collect($response->viewData('data')->items());
    expect($logs->every(fn ($log) => $log->auditable_id === $alice->id))->toBeTrue();
    expect($logs->count())->toBe(2);
});

it('filters by HTTP method', function () {
    $admin = Admin::factory()->create();
    foreach (['GET', 'POST', 'DELETE'] as $method) {
        AuditLog::query()->create([
            'auditable_type' => Admin::class,
            'auditable_id' => $admin->id,
            'url' => 'http://localhost/admin/x',
            'method' => $method,
            'payload' => [],
            'ip' => '127.0.0.1',
            'route_name' => 'admin.x',
        ]);
    }

    $response = $this->get(route('admin.audits.index', ['method' => 'POST']));

    $methods = collect($response->viewData('data')->items())->pluck('method')->unique()->all();
    expect($methods)->toBe(['POST']);
});

it('ignores invalid method filter values', function () {
    $admin = Admin::factory()->create();
    AuditLog::query()->create([
        'auditable_type' => Admin::class,
        'auditable_id' => $admin->id,
        'url' => 'http://localhost/admin/x',
        'method' => 'GET',
        'payload' => [],
        'ip' => '127.0.0.1',
        'route_name' => 'admin.x',
    ]);

    // `HEAD` isn't in the controller's whitelist → should fall through to null
    // rather than being passed to the query (which would zero-result).
    $response = $this->get(route('admin.audits.index', ['method' => 'HEAD']));

    $response->assertOk();
    expect($response->viewData('data')->total())->toBeGreaterThan(0);
});

it('returns payload HTML via getPayload', function () {
    $admin = Admin::factory()->create(['name' => 'Recorded Admin']);

    $log = AuditLog::query()->create([
        'auditable_type' => Admin::class,
        'auditable_id' => $admin->id,
        'url' => 'http://localhost/admin/user-management/store',
        'method' => 'POST',
        'payload' => ['name' => 'Brand New', 'email' => 'brand@new.test'],
        'ip' => '127.0.0.1',
        'route_name' => 'admin.user_management.store',
    ]);

    $response = $this->get(route('admin.audits.getPayload', $log->id));

    $response->assertOk();
    $json = $response->json();
    expect($json)->toHaveKey('payload');

    // Should surface both the meta block (admin name) AND the payload fields.
    expect($json['payload'])->toContain('Recorded Admin');
    expect($json['payload'])->toContain('Brand New');
    expect($json['payload'])->toContain('brand@new.test');
    // Should NOT leak framework noise.
    expect($json['payload'])->not->toContain('_token');
});
