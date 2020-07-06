<?php

namespace App\Observers;

use App\Models\Contact;
use Illuminate\Support\Str;

class ContactObserver
{
    /**
     * Handle the contact "created" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function saving(Contact $contact)
    {
        $first_name = $contact->first_name;
        $last_name = $contact->last_name;

        $token = Str::random(5);

        $contact->slug = Str::slug($first_name . ' ' . $last_name . ' ' . $token);
    }

}
