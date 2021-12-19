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
    }
}
