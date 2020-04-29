<?php

namespace Mchljams\TravelLog\Database\Seeds;

use Illuminate\Database\Seeder;
use Mchljams\TravelLog\Models\AdminUser;
use Illuminate\Support\Facades\DB;

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
        DB::statement("SET foreign_key_checks=0");
        AdminUser::truncate();
        DB::statement("SET foreign_key_checks=1");

        $adminUsers = factory(AdminUser::class, 2)->create();
    }
}
