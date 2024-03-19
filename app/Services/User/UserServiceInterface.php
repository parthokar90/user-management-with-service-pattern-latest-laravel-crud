<?php

namespace App\Services\User;

interface UserServiceInterface
{
    public function getUsersForDataTable();
    
    public function createUser(array $data);

    public function findUserById(int $id);

    public function updateUser(int $id, array $data);

    public function deleteUser(int $id);

    public function getTrashedUsersForDataTable();

    public function restoreUser(int $id);

    public function permanentlyDeleteUser(int $id);

    public function restoreAllTrashedUsers();

}

