<?php

namespace App\Policies;

use App\Models\Qun;
use App\Models\User;

class QunPolicy extends Policy
{
    public function store(User $user)
    {
        return $user->isMember();
    }

    public function update(User $user, Qun $qun)
    {
        return $user->isAuthorOf($qun) && $user->isMember();
    }

    public function destroy(User $user, Qun $qun)
    {
        return $user->isAuthorOf($qun) && $user->isMember();
    }
}
