<?php

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)
            ->create()
            ->each(function (User $user) {
                factory(Contact::class, 50)->create(['user_id' => $user->id]);
            });
    }
}
