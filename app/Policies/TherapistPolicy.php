<?php

namespace App\Policies;

use App\Models\User;

class TherapistPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function provideInvoice(User $user)
    {
        return $user->role === 'psychiatrist';
    }
}
