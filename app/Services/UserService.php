<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @param array $user_attributes
     * @param bool $is_admin
     * @return User|Model
     */
    public function create(array $user_attributes, bool $is_admin = false): Model|User
    {
        $user_attributes['is_admin'] = $is_admin;
        $data = User::create($user_attributes);
        $data['token'] = Auth::login($data);

        return $data;
    }
}
