<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;

class ChirpPolicy
{
    public function update(User $user, Chirp $chirp): bool
    {
        return $user->id === $chirp->user_id;
    }

    public function delete(User $user, Chirp $chirp): bool
    {
        return $user->id === $chirp->user_id;
    }

    public function restore(User $user, Chirp $chirp): bool
    {
        return $user->id === $chirp->user_id;
    }

    public function forceDelete(User $user, Chirp $chirp): bool
    {
        return $user->id === $chirp->user_id;
    }
}