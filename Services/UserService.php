<?php

use App\Models\User;

class UserService
{
    /**
     * Delete user with associated results
     *
     * @return void
     */
    public function delete(User $user)
    {
        $user->delete();
    }
}