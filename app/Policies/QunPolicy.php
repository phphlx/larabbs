<?php

namespace App\Policies;

use App\Models\Qun;
use App\Models\User;

class QunPolicy extends Policy
{
    public function update(User $user, Qun $qun)
    {
        return $user->isAuthorOf($qun);
    }

    public function destroy(User $user, Qun $qun)
    {
        return $user->isAuthorOf($qun);
    }
}
