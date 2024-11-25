<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update(int $id, array $data): ?User
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);

        return $user ? $user->delete() : false;
    }

    public function userExists(int $id): bool
    {
        $user = User::find($id);

        return $user ? $user->exists : false;
    }
}
