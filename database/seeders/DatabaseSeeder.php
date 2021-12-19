<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
