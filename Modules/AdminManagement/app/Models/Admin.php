<?php

namespace Modules\AdminManagement\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\AdminManagement\Database\Factories\AdminFactory;
use Modules\AdminManagement\Enums\ActiveAdminEnum;
use Modules\Auth\app\Models\SocialAccount;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed        $name
 * @property mixed        $email
 * @property mixed|string $password
 * @property mixed|string $img
 * @property int|mixed    $is_active
 * @property mixed        $phone
 *
 * @method addMedia(string $string)
 */
class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected string $guard = 'admin';

    /**
     * Tells Laravel where to find the factory. Required because the factory
     * lives under the module namespace (Modules\AdminManagement\Database\
     * Factories\AdminFactory) rather than the default Database\Factories\.
     */
    protected static function newFactory(): Factory
    {
        return AdminFactory::new();
    }

    protected $table = 'admins';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => ActiveAdminEnum::class,
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'img',
        'is_active',
    ];

    /**
     * Get the social accounts for the admin.
     */
    public function socialAccounts()
    {
        return $this->morphMany(SocialAccount::class, 'user');
    }
}
