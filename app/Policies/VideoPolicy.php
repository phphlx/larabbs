<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(User $user)
    {
        return $user->isMember();
    }

    public function update(User $user, Video $video)
    {
        return $user->isAuthorOf($video) && $user->isMember();
    }

    public function destroy(User $user, Video $video)
    {
        return $user->isAuthorOf($video) && $user->isMember();
    }
}