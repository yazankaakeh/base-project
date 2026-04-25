<?php

namespace Modules\AdminManagement\Tests;

use Illuminate\Support\Facades\Config;
use Modules\AdminManagement\Enums\Roles;
use Modules\AdminManagement\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase as BaseTestCase;

/**
 * Module-level TestCase for AdminManagement.
 *
 * Centralizes the "give me a logged-in admin" boilerplate so individual
 * tests stay focused on the behavior they're asserting, not on setting
 * up the auth guard, Spatie permissions, and super-admin bypass.
 */
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // also calls $this->withoutVite() on the root TestCase

        // spatie/permission caches role/permission lookups aggressively.
        // Flush between tests so an `assignRole(...)` in one test doesn't
        // bleed into the next via the cached pivot.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Guarantee an 'admin' guard exists in config even when the app
        // env loader hasn't populated it. Most of our routes resolve
        // permissions against this guard.
        if (! Config::get('auth.guards.admin')) {
            Config::set('auth.guards.admin', [
                'driver' => 'session',
                'provider' => 'admins',
            ]);
        }
        if (! Config::get('auth.providers.admins')) {
            Config::set('auth.providers.admins', [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ]);
        }
    }

    /**
     * Create + log in a super-admin. Super-admins bypass the
     * AdminPermissionsMiddleware check (see the middleware's `hasRole`
     * fallback), so tests don't have to pre-assign every individual
     * permission to exercise admin routes.
     */
    protected function actingAsSuperAdmin(array $attributes = []): Admin
    {
        /** @var Admin $admin */
        $admin = Admin::factory()->create($attributes);

        $role = Role::query()->firstOrCreate(
            ['name' => Roles::SUPER_ADMIN->value, 'guard_name' => 'admin'],
        );
        $admin->assignRole($role);

        $this->actingAs($admin, 'admin');

        return $admin;
    }

    /**
     * Create + log in a plain admin with optional roles. Useful for testing
     * permission-gated routes (e.g. proving a non-super-admin without the
     * right permission gets a 403).
     */
    protected function actingAsAdmin(array $roleNames = [], array $attributes = []): Admin
    {
        /** @var Admin $admin */
        $admin = Admin::factory()->create($attributes);

        foreach ($roleNames as $name) {
            $role = Role::query()->firstOrCreate(
                ['name' => $name, 'guard_name' => 'admin'],
            );
            $admin->assignRole($role);
        }

        $this->actingAs($admin, 'admin');

        return $admin;
    }
}
