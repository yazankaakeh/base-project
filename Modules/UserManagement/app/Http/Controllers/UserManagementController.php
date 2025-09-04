<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\UserManagement\app\Http\Requests\AdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateAdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateStatusAminRequest;
use Modules\UserManagement\app\Repository\User\UserInterface;
use Modules\UserManagement\app\Repository\User\UserRepository;

class UserManagementController extends Controller
{

    public function __construct(public UserInterface $userInterface) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        /** @var UserRepository $userRepo */
        $userRepo = $this->userInterface->index();
        $users = $userRepo['users'];
        $roles = $userRepo['roles'];
        return view('usermanagement::users.index', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request): RedirectResponse
    {
        $this->userInterface->update($request);
        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('mps::mps.success.updatedSuccess'),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $this->userInterface->store($request);
        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('mps::mps.success.createdSuccess'),
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(UpdateStatusAminRequest $request): RedirectResponse
    {
        $this->userInterface->activateDeActivate($request);
        return redirect()->route('admin.user_management.index')->with(
            'success',
            trans('mps::mps.success.updateStatusSuccess'),
        );
    }
}
