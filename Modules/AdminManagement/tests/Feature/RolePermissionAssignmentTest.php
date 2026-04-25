<?php

/*
|--------------------------------------------------------------------------
| Role-Permission assignment tests
|--------------------------------------------------------------------------
|
| Guards the /admin/role-management routes — the admin UI for creating,
| editing, and deleting roles with synced permissions. These tests prove:
|   - Role create persists with `guard_name = 'admin'`.
|   - Permissions selected in the form get synced via Spatie.
|   - Role update reassigns permissions without orphaning the pivot.
|   - Role destroy removes the record (and Spatie cascades cleanly).
|
| Permissions need real rows in the `permissions` table because the
| PermissionsRequest validates `exists:permissions,name`. We seed a small
| set in beforeEach.
|
*/

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->actingAsSuperAdmin();

    // Seed a minimal permission set mirroring what the app uses. Section
    // field matches the real seeder so the grouped-by-section view logic
    // doesn't explode on missing data.
    foreach (['admin.user_management.index', 'admin.user_management.store', 'admin.posts.index'] as $name) {
        Permission::query()->firstOrCreate(
            ['name' => $name, 'guard_name' => 'admin'],
            ['section' => explode('.', $name)[1] ?? 'etc'],
        );
    }
});

it('creates a role with synced permissions', function () {
    $response = $this->post(route('admin.role_management.store'), [
        'name' => 'Content Editor',
        'permissions' => ['admin.user_management.index', 'admin.posts.index'],
    ]);

    $response->assertRedirect(route('admin.role_management.index'));

    /** @var Role $role */
    $role = Role::query()->where('name', 'Content Editor')->first();
    expect($role)->not->toBeNull();
    expect($role->guard_name)->toBe('admin');
    expect($role->permissions->pluck('name')->sort()->values()->all())
        ->toBe(['admin.posts.index', 'admin.user_management.index']);
});

it('rejects role create when name is taken', function () {
    Role::query()->create(['name' => 'Dup', 'guard_name' => 'admin']);

    $this->post(route('admin.role_management.store'), [
        'name' => 'Dup',
        'permissions' => ['admin.user_management.index'],
    ])->assertSessionHasErrors('name');
});

it('rejects role create when permissions missing or invalid', function () {
    // No permissions key at all
    $this->post(route('admin.role_management.store'), [
        'name' => 'NoPerms',
    ])->assertSessionHasErrors('permissions');

    // Unknown permission — validator's exists:permissions,name should reject.
    $this->post(route('admin.role_management.store'), [
        'name' => 'BadPerm',
        'permissions' => ['nonexistent.permission'],
    ])->assertSessionHasErrors('permissions.0');
});

it('updates a role and replaces its permissions', function () {
    $role = Role::query()->create(['name' => 'OldRole', 'guard_name' => 'admin']);
    $role->syncPermissions(['admin.user_management.index']);

    $response = $this->put(route('admin.role_management.update', $role->id), [
        'name' => 'RenamedRole',
        'permissions' => ['admin.posts.index'],
    ]);

    $response->assertRedirect(route('admin.role_management.index'));

    $role->refresh();
    expect($role->name)->toBe('RenamedRole');
    expect($role->permissions->pluck('name')->all())->toBe(['admin.posts.index']);
});

it('deletes a role', function () {
    $role = Role::query()->create(['name' => 'ToDelete', 'guard_name' => 'admin']);

    $this->delete(route('admin.role_management.destroy', $role->id))
        ->assertRedirect(route('admin.role_management.index'));

    expect(Role::query()->where('name', 'ToDelete')->exists())->toBeFalse();
});

it('renders the role create form with grouped permissions', function () {
    $response = $this->get(route('admin.role_management.create'));

    $response->assertOk();
    $response->assertViewIs('adminmanagement::roles.create');

    $permissions = $response->viewData('permissions');
    // Grouped by section → each key is a section name, value is a collection.
    expect($permissions->keys()->all())->toContain('user_management');
});
