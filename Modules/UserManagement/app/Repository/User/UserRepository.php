<?php

namespace Modules\UserManagement\app\Repository\User;

use App\Enum\Pagination;
use Illuminate\Support\Facades\Hash;
use Modules\Core\app\Helpers\FileUploadHelper;
use Modules\UserManagement\app\Http\Requests\AdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateAdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateStatusAminRequest;
use Modules\UserManagement\app\Models\Admin;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface
{

    public function store(AdminRequest $request): void
    {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->phone = $request->phone;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->is_active = $request->is_active == 'on' ? 1 : 0;
        if ($request->file('img')) {
            $photo = FileUploadHelper::uploadFile($request->file('img'), '/img/admins');
            $admin->img = $photo;
        }
        $admin->save();
        /** @var Role $role */
        $role = Role::query()->findOrFail($request->role);
        $admin->assignRole($role);
    }

    public function update(UpdateAdminRequest $request): void
    {
        /** @var Admin $admin */
        $admin = Admin::query()->updateOrCreate(['id' => $request->id], [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_active' => $request->is_active == 'on' ? 1 : 0,
        ]);
        if ($request->password !== null) {
            $admin->password = Hash::make($request->password);
        }
        if ($request->file('img')) {
            $photo = FileUploadHelper::uploadFile($request->file('img'), '/img/admins');
            $admin->img = $photo;
        }
        $admin->save();


        // Remove each role from the user
        $admin->roles()->detach();
        /** @var Role $role */
        $role = Role::query()->findOrFail($request->role);

        $admin->assignRole($role);
    }

    public function activateDeActivate(UpdateStatusAminRequest $request): void
    {
        Admin::query()->updateOrCreate(['id' => $request->id],
            [
                'is_active' => $request->is_active == 'on' ? 1 : 0,
            ]);
    }

    public function index(): array
    {
        $users = Admin::query()->with('roles')
            ->paginate(Pagination::PAG->value);
        $roles = Role::query()->pluck('name', 'id');
        return [
            'users' => $users,
            'roles' => $roles,
        ];
    }
}
