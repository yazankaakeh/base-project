<?php

/*
|--------------------------------------------------------------------------
| Module-level Pest bootstrap (AdminManagement)
|--------------------------------------------------------------------------
|
| Binds every test under this module's `Feature/` folder to the
| module TestCase so the `actingAsSuperAdmin()` helper is available
| without explicit `extends`.
|
| RefreshDatabase rolls back after each test so suites stay isolated
| — tests can freely create admins / roles / permissions without
| leaking into siblings.
|
*/

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\AdminManagement\Tests\TestCase as AdminManagementTestCase;

uses(AdminManagementTestCase::class, RefreshDatabase::class)->in('Feature');
uses(AdminManagementTestCase::class)->in('Unit');
