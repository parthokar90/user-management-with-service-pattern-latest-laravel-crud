<?php

namespace App\Http\Controllers\backend\user;

use App\Http\Controllers\Controller;

use App\Http\Requests\CreateUserRequest;

use App\Http\Requests\UpdateUserRequest;

use App\Services\User\UserServiceInterface;

use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userService->getUsersForDataTable();
        }
        return view('backend.user.index');
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        $this->userService->createUser($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(string $id)
    {
        $user = $this->userService->findUserById($id);

        return view('backend.user.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = $this->userService->findUserById($id);

        return view('backend.user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validatedData = $request->validated();

        $this->userService->updateUser($id, $validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            return $this->userService->getTrashedUsersForDataTable();
        }
        return view('backend.user.trash');
    }

    public function restore(string $id)
    {
        $this->userService->restoreUser($id);

        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    public function permanentDelete(string $id)
    {
        $this->userService->permanentlyDeleteUser($id);
        
        return redirect()->route('users.index')->with('success', 'User permanently deleted.');
    }
}

