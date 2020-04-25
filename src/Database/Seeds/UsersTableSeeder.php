<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mchljams\TravelLog\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        User::truncate();

        $users = factory(User::class, 50)->create();
    }
}
