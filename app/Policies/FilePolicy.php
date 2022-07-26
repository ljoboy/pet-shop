<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

final class FilePolicy
{
    use HandlesAuthorization;

    /**
     * @param  User  $user
     * @param  string  $ability
     * @return bool|null
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->is_admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User|null  $user
     * @param  File  $file
     * @return Response|bool
     */
    public function view(?User $user, File $file): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return true;
    }
}
