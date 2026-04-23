<?php

namespace Modules\AdminManagement\Repository\User;

use App\Enum\Pagination;
use Illuminate\Support\Facades\Hash;
use Modules\AdminManagement\Models\Admin;
use Modules\AdminManagement\Http\Requests\DoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateDoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateStatusAminRequest;
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
        $admin = new Admin();
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

    public function index(): array
    {
        $users = Admin::query()
            ->with('roles')
            ->paginate(Pagination::PAG->value);

        $roles = Role::query()->pluck('name', 'id');

        return [
            'users' => $users,
            'roles' => $roles,
        ];
    }
}
