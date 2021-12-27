<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = new Role();
        $student->title = 'student';
        $student->save();

        $advisor = new Role();
        $advisor->title = 'advisor';
        $advisor->save();

        $role_admin = new Role();
        $role_admin->title = 'admin';
        $role_admin->save();
    }
}
