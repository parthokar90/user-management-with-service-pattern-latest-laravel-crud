<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UserService implements UserServiceInterface
{
    public function getUsersForDataTable()
    {
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

    public function createUser(array $data)
    {
        if (isset($data['avatar'])) {
            $data['avatar'] = $this->uploadAvatar($data['avatar']);
        }
        return User::create($data);
    }

    public function findUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function updateUser(int $id, array $data)
    {
        $user = User::findOrFail($id);

        if (isset($data['avatar'])) {
            $data['avatar'] = $this->uploadAvatar($data['avatar']);
            if ($user->avatar) {
                $avatarPath = public_path('backend/avatar/') . $user->avatar;
                if (File::exists($avatarPath)) {
                    File::delete($avatarPath);
                }
            }
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }

    public function getTrashedUsersForDataTable()
    {
        $users = User::onlyTrashed()->orderByDesc('id');

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

    public function restoreUser(int $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();
    }

    public function permanentlyDeleteUser(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->avatar) {
            $avatarPath = public_path('backend/avatar/') . $user->avatar;
            if (File::exists($avatarPath)) {
                File::delete($avatarPath);
            }
        }

        $user->forceDelete();
    }

    public function restoreAllTrashedUsers()
    {
        return User::onlyTrashed()->restore();
    }


    protected function uploadAvatar($avatar)
    {
        
        $filename = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();

        $avatar->move(public_path('backend/avatar'), $filename);

        return $filename;
    }
}
