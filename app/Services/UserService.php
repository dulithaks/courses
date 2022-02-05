<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Delete user with associated results
     *
     * @return void
     * @throws \Throwable
     */
    public function delete(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->results()->delete();
            $user->delete();
        });
    }
}