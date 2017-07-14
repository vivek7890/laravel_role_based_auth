<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_user = Role::where('name', 'user')->first();
      $role_admin  = Role::where('name', 'admin')->first();

      $user = new User();
      $user->name = 'User Name';
      $user->email = 'user@example.com';
      $user->password = bcrypt('secret');
      $user->image = '';
      $user->save();
      $user->roles()->attach($role_user);

      $admin = new User();
      $admin->name = 'Admin Name';
      $admin->email = 'admin@example.com';
      $admin->password = bcrypt('secret');
      $admin->save();
      $admin->roles()->attach($role_admin);
    }
}
