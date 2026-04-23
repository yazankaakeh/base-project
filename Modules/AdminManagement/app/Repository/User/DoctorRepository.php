<?php

namespace Modules\AdminManagement\Repository\User;

use App\Enum\Pagination;
use Illuminate\Support\Facades\Hash;
use Modules\AdminManagement\Http\Requests\DoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateDoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateStatusAminRequest;
use Modules\AdminManagement\Models\Admin;
use Spatie\Permission\Models\Role;

/**
 * Class DoctorRepository
 *
 * Historical name retained for the DI binding. This repository manages
 * generic Admin users for the Codliy CMS (not medical doctors). The class
 * name is kept only to preserve the DoctorInterface → DoctorRepository
 * binding wired in AdminManagementServiceProvider.
 */
class DoctorRepository implements DoctorInterface
{
    public function store(DoctorRequest $request): void
    {
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->is_active = $request->is_active == 'on' ? 1 : 0;

        if ($request->file('img')) {
            $admin->img = $request->file('img')->store('admins', 'public');
        }

        $admin->save();

        /** @var Role $role */
        $role = Role::query()->findOrFail($request->role);
        $admin->assignRole($role);
    }

    public function update(UpdateDoctorRequest $request): void
    {
        /** @var Admin $admin */
        $admin = Admin::query()->updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->is_active == 'on' ? 1 : 0,
            ],
        );

        if ($request->password !== null) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->file('img')) {
            $admin->img = $request->file('img')->store('admins', 'public');
        }

        $admin->save();

        $admin->roles()->detach();
        /** @var Role $role */
        $role = Role::query()->findOrFail($request->role);
        $admin->assignRole($role);
    }

    public function activateDeActivate(UpdateStatusAminRequest $request): void
    {
        Admin::query()->updateOrCreate(
            ['id' => $request->id],
            ['is_active' => $request->is_active == 'on' ? 1 : 0],
        );
    }

    /**
     * Paginated admin list with optional search/role/status filters + a
     * compact stats summary for the UI header cards.
     *
     * @param array{q?: ?string, role?: mixed, status?: mixed} $filters
     * @return array{
     *     users: \Illuminate\Contracts\Pagination\LengthAwarePaginator,
     *     roles: \Illuminate\Support\Collection,
     *     stats: array{total: int, active: int, inactive: int, roles: int}
     * }
     */
    public function index(array $filters = []): array
    {
        $query = Admin::query()->with('roles');

        // Search — matches name OR email, case-insensitive via LIKE.
        // Using `filled()` so a whitespace-only query doesn't run a
        // meaningless `%   %` scan.
        if (filled($filters['q'] ?? null)) {
            $term = '%' . trim($filters['q']) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        // Role filter — ID from the roles select. `whereHas` keeps the
        // pivot semantics, and we coerce to int so ?role=abc is ignored.
        $roleId = isset($filters['role']) && ctype_digit((string) $filters['role'])
            ? (int) $filters['role']
            : null;
        if ($roleId !== null) {
            $query->whereHas('roles', fn ($q) => $q->where('id', $roleId));
        }

        // Status filter — admins.is_active is stored as 1/0 (enum-cast).
        // Accept "1" or "0" only; anything else falls through.
        $statusRaw = $filters['status'] ?? null;
        if ($statusRaw === '0' || $statusRaw === '1' || $statusRaw === 0 || $statusRaw === 1) {
            $query->where('is_active', (int) $statusRaw);
        }

        $users = $query
            ->orderBy('id', 'desc')
            ->paginate(Pagination::PAG->value)
            ->withQueryString(); // keep filters in pagination links

        $roles = Role::query()->pluck('name', 'id');

        // Lightweight stats — uses unfiltered counts so the "Total users"
        // card doesn't whiplash as the admin types in the search box.
        $stats = [
            'total' => Admin::query()->count(),
            'active' => Admin::query()->where('is_active', 1)->count(),
            'inactive' => Admin::query()->where('is_active', 0)->count(),
            'roles' => $roles->count(),
        ];

        return [
            'users' => $users,
            'roles' => $roles,
            'stats' => $stats,
        ];
    }
}
