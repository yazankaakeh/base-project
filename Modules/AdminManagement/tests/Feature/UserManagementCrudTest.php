<?php

/*
|--------------------------------------------------------------------------
| User Management CRUD feature tests
|--------------------------------------------------------------------------
|
| Exercises the /admin/user-management routes end-to-end. These tests
| intentionally DO NOT mock the repository — they hit the real store /
| update / status endpoints so regressions in validation, role syncing,
| password hashing, or the admin factory all surface here.
|
| Super-admin bypass is used so the authorize middleware doesn't need
| permissions pre-seeded. Each test is isolated via RefreshDatabase.
|
*/

use Modules\AdminManagement\Enums\ActiveAdminEnum;
use Modules\AdminManagement\Models\Admin;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    // Every user-management test needs a logged-in super-admin + a
    // "target" role the new admin will be assigned to.
    $this->superAdmin = $this->actingAsSuperAdmin();
    $this->targetRole = Role::query()->firstOrCreate(
        ['name' => 'Editor', 'guard_name' => 'admin'],
    );
});

// ─── INDEX ────────────────────────────────────────────────────────────

it('renders the user-management index', function () {
    $response = $this->get(route('admin.user_management.index'));

    $response->assertOk();
    $response->assertViewIs('adminmanagement::users.index');
    $response->assertViewHas('users');
    $response->assertViewHas('stats');
});

it('filters users by search query across name and email', function () {
    Admin::factory()->create(['name' => 'Jane Matcher', 'email' => 'jane@example.com']);
    Admin::factory()->create(['name' => 'Nobody',       'email' => 'nobody@example.com']);

    $response = $this->get(route('admin.user_management.index', ['q' => 'matcher']));

    $response->assertOk();
    // The paginator coerces to an iterable collection via ->getCollection().
    $users = collect($response->viewData('users')->items());
    expect($users->pluck('email')->all())->toContain('jane@example.com');
    expect($users->pluck('email')->all())->not->toContain('nobody@example.com');
});

it('filters users by status', function () {
    Admin::factory()->create(['email' => 'active@codliy.test']);
    Admin::factory()->inactive()->create(['email' => 'inactive@codliy.test']);

    $response = $this->get(route('admin.user_management.index', ['status' => '0']));

    $emails = collect($response->viewData('users')->items())->pluck('email')->all();
    expect($emails)->toContain('inactive@codliy.test');
    expect($emails)->not->toContain('active@codliy.test');
});

// ─── STORE ───────────────────────────────────────────────────────────

it('creates an admin and assigns a role', function () {
    $payload = [
        'name' => 'New Editor',
        'email' => 'editor@codliy.test',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => $this->targetRole->id,
        'is_active' => 'on',
    ];

    $this->post(route('admin.user_management.store'), $payload)
        ->assertRedirect(route('admin.user_management.index'));

    $admin = Admin::query()->where('email', 'editor@codliy.test')->first();
    expect($admin)->not->toBeNull();
    expect($admin->name)->toBe('New Editor');
    expect($admin->is_active)->toBe(ActiveAdminEnum::ACTIVE);
    // Cast ran — password is hashed, not plaintext.
    expect($admin->password)->not->toBe('secret123');
    expect(Hash::check('secret123', $admin->password))->toBeTrue();
    expect($admin->hasRole($this->targetRole))->toBeTrue();
});

it('rejects store when email is already taken', function () {
    Admin::factory()->create(['email' => 'dup@codliy.test']);

    $response = $this->post(route('admin.user_management.store'), [
        'name' => 'Dup',
        'email' => 'dup@codliy.test',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => $this->targetRole->id,
    ]);

    $response->assertSessionHasErrors('email');
});

it('rejects store when password confirmation mismatches', function () {
    $response = $this->post(route('admin.user_management.store'), [
        'name' => 'Mismatch',
        'email' => 'mismatch@codliy.test',
        'password' => 'secret123',
        'password_confirmation' => 'different',
        'role' => $this->targetRole->id,
    ]);

    $response->assertSessionHasErrors('password');
});

// ─── UPDATE ──────────────────────────────────────────────────────────

it('updates an admin and reassigns the role', function () {
    /** @var Admin $target */
    $target = Admin::factory()->create(['name' => 'Old Name']);
    $target->assignRole($this->targetRole);

    $newRole = Role::query()->firstOrCreate(
        ['name' => 'Viewer', 'guard_name' => 'admin'],
    );

    $this->put(route('admin.user_management.update'), [
        'id' => $target->id,
        'name' => 'New Name',
        'email' => $target->email,
        'role' => $newRole->id,
        'is_active' => 'on',
    ])->assertRedirect(route('admin.user_management.index'));

    $target->refresh();
    expect($target->name)->toBe('New Name');
    expect($target->hasRole($newRole))->toBeTrue();
    // Role detach/reassign — old role should no longer apply.
    expect($target->hasRole($this->targetRole))->toBeFalse();
});

it('leaves password untouched on update when none is submitted', function () {
    /** @var Admin $target */
    $target = Admin::factory()->create();
    $target->assignRole($this->targetRole);
    $originalHash = $target->password;

    $this->put(route('admin.user_management.update'), [
        'id' => $target->id,
        'name' => 'Renamed',
        'email' => $target->email,
        'role' => $this->targetRole->id,
        'is_active' => 'on',
    ])->assertRedirect(route('admin.user_management.index'));

    $target->refresh();
    expect($target->password)->toBe($originalHash);
});

// ─── STATUS TOGGLE ───────────────────────────────────────────────────

it('deactivates an admin via the status route', function () {
    /** @var Admin $target */
    $target = Admin::factory()->create();
    expect($target->is_active)->toBe(ActiveAdminEnum::ACTIVE);

    $this->delete(route('admin.user_management.status'), [
        'id' => $target->id,
        'is_active' => 'off',
    ])->assertRedirect(route('admin.user_management.index'));

    $target->refresh();
    expect($target->is_active)->toBe(ActiveAdminEnum::DE_ACTIVE);
});

it('reactivates an admin via the status route', function () {
    /** @var Admin $target */
    $target = Admin::factory()->inactive()->create();
    expect($target->is_active)->toBe(ActiveAdminEnum::DE_ACTIVE);

    $this->delete(route('admin.user_management.status'), [
        'id' => $target->id,
        'is_active' => 'on',
    ])->assertRedirect(route('admin.user_management.index'));

    $target->refresh();
    expect($target->is_active)->toBe(ActiveAdminEnum::ACTIVE);
});
