<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use Illuminate\Auth\Access\Response;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->roles()->where('title', RoleEnum::ADMIN->value)->exists();
    }

    protected function isManager(User $user): bool
    {
        return $user->roles()->where('title', RoleEnum::MANAGER->value)->exists();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user) || $this->isManager($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return $this->isAdmin($user) || $this->isManager($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function publish(User $user): bool
    {
        return $this->isAdmin($user);
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $this->isAdmin($user) || $this->isManager($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return $this->isAdmin($user) || $this->isManager($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $this->isAdmin($user);
    }
}
