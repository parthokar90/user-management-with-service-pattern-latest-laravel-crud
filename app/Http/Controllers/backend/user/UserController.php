<?php

namespace App\Http\Controllers\backend\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->orderByDesc('id');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('avatar', function ($user) {
                    if ($user->avatar) {
                        return '<img src="' . asset('backend/avatar/' . $user->avatar) . '" alt="Avatar" class="avatar-img">';
                    } else {
                        return 'No Avatar';
                    }
                })
                ->addColumn('action', function ($user) {
                    return '<a href="' . route('users.show', $user->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            <form action="' . route('users.destroy', $user->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger delete-btn" data-name="' . $user->name . '"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }
        return view('backend.user.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('avatar')) {
            $avatarFileName = uniqid('avatar_') . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('backend/avatar'), $avatarFileName);
            $validatedData['avatar'] = $avatarFileName;
        }

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $previousAvatarPath = public_path('backend/avatar/') . $user->avatar;
                if (File::exists($previousAvatarPath)) {
                    File::delete($previousAvatarPath);
                }
            }

            $avatarFileName = uniqid('avatar_') . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('backend/avatar'), $avatarFileName);
            $validatedData['avatar'] = $avatarFileName;
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * all deleted user specified resource from storage.
     */
    public function trash(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->onlyTrashed()->orderByDesc('id');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('avatar', function ($user) {
                    if ($user->avatar) {
                        return '<img src="' . asset('backend/avatar/' . $user->avatar) . '" alt="Avatar" class="avatar-img">';
                    } else {
                        return 'No Avatar';
                    }
                })
                ->addColumn('action', function ($user) {
                    return '<form action="' . route('user.permanent-delete', $user->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" title="Permanent Delete" class="btn btn-sm btn-danger delete-btn delete-btn-permanent" data-name="' . $user->name . '"><i class="fas fa-trash"></i></button>
                            </form>
                            <form action="' . route('user.restore', $user->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                <button type="submit" title="Restore" class="btn btn-sm btn-primary restore-btn" data-name="' . $user->name . '"><i class="fas fa-undo"></i></button>
                            </form>';
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }
        return view('backend.user.trash');
    }

    /**
     * restore all trash user specified resource from storage.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->back()->with('success', 'User restored successfully.');
    }

    /**
     * Permanent Remove specified resource from storage.
     */
    public function permanentDelete(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->avatar) {
            $previousAvatarPath = public_path('backend/avatar/') . $user->avatar;
            if (File::exists($previousAvatarPath)) {
                File::delete($previousAvatarPath);
            }
        }
        $user->forceDelete();

        return redirect()->route('users.index')->with('success', 'User permanently deleted.');
    }
}
