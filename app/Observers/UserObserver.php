<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the user "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(User $user)
    {
        $name = $user->name;

        if ( ! User::where('name', $name)->first() ) {

            $user->slug = Str::slug($name);

        } else {

            $token = Str::random(5);

            $user->slug = Str::slug($name . ' ' . $token);

        }

    }
}
