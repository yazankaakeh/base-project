<?php

namespace Modules\AdminManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AdminManagement\Enums\ActiveAdminEnum;
use Modules\AdminManagement\Models\Admin;

/**
 * @extends Factory<Admin>
 *
 * Used by tests + seeders. The password cast on Admin is `hashed`, so
 * `bcrypt()`-ing here would double-hash — we just pass the plaintext and
 * let the cast handle it. Tests that want a known login credential can
 * override with `->create(['password' => 'secret'])` and then call
 * `->attempt(['email' => ..., 'password' => 'secret'])`.
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => $this->faker->e164PhoneNumber(),
            'password' => 'password',
            'img' => 'img/admin.png',
            'is_active' => ActiveAdminEnum::ACTIVE,
            'remember_token' => \Illuminate\Support\Str::random(10),
        ];
    }

    /**
     * Convenience state for disabled admins — used by tests that verify
     * the AdminEnabled middleware and status-toggle flow.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => ActiveAdminEnum::DE_ACTIVE]);
    }
}
