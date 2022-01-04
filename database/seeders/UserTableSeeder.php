<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $admin_role = Role::where('title', 'admin')->first();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'ssmAdmin@ssm.com';
        $admin->role_id = $admin_role->id;
        $admin->email_verified_at = date("Y-m-d H:i:s");
        $admin->password = bcrypt('admin@123');
        $admin->save();

        // $advisor_role = Role::where('title', 'advisor')->first();

        // $advisor = new User();
        // $advisor->name = 'advisor';
        // $advisor->email = 'advisor@gmail.com';
        // $advisor->role_id = $advisor_role->id;
        // $advisor->email_verified_at = date("Y-m-d H:i:s");
        // $advisor->password = bcrypt('12345678');
        // $advisor->save();

        // $student_role = Role::where('title', 'student')->first();
        // $student = new User();
        // $student->name = 'Nazmus Sakib';
        // $student->email = 'sakibn55@gmail.com';
        // $student->role_id = $student_role->id;
        // $student->email_verified_at = date("Y-m-d H:i:s");
        // $student->password = bcrypt('12345678');
        // $student->save();
    }
}
