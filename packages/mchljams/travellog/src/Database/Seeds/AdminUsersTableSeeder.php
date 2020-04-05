<?php

namespace Mchljams\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Models\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        AdminUser::truncate();

        $adminUsers = factory(AdminUser::class, 2)->create();
    }
}
