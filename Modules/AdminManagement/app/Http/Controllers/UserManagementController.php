<?php

namespace Modules\AdminManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\AdminManagement\Http\Requests\DoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateDoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateStatusAminRequest;
use Modules\AdminManagement\Repository\User\DoctorInterface;
use Modules\AdminManagement\Repository\User\DoctorRepository;

class UserManagementController extends Controller
{
    public function __construct(public DoctorInterface $userInterface) {}

    public function index(): View|Application|Factory|\Illuminate\Foundation\Application
    {
        /** @var DoctorRepository $userRepo */
        $userRepo = $this->userInterface->index();
        $users = $userRepo['users'];
        $roles = $userRepo['roles'];

        return view('adminmanagement::users.index', compact('users', 'roles'));
    }

    public function update(UpdateDoctorRequest $request): RedirectResponse
    {
        $this->userInterface->update($request);

        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('adminmanagement::admin_management.success.updatedSuccess'),
        );
    }

    public function store(DoctorRequest $request): RedirectResponse
    {
        $this->userInterface->store($request);

        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('adminmanagement::admin_management.success.createdSuccess'),
        );
    }

    public function status(UpdateStatusAminRequest $request): RedirectResponse
    {
        $this->userInterface->activateDeActivate($request);

        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('adminmanagement::admin_management.success.updateStatusSuccess'),
        );
    }
}
