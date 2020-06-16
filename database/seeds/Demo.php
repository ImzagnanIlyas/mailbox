<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class Demo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'send mail']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo('add user');
        $role1->givePermissionTo('edit user');
        $role1->givePermissionTo('delete user');
        $role1->givePermissionTo('send mail');

        $role2 = Role::create(['name' => 'moderator']);
        $role2->givePermissionTo('add user');
        $role2->givePermissionTo('edit user');
        $role2->givePermissionTo('send mail');

        $role3 = Role::create(['name' => 'user']);
        $role3->givePermissionTo('send mail');

        // create demo users
        $user = Factory(App\User::class)->create([
            'name' => 'Admin Ilyas',
            'birthday' => '1989-06-11',
            'gender' => 'H',
            'phone' => '01234',
            'type' => 't1',
            'post' => 'p1',
            'email' => 'a@a.a',
            'password' => bcrypt('aaaa'),
        ]);
        $user->assignRole($role1);

        $user = Factory(App\User::class)->create([
            'name' => 'Moderator Saad',
            'birthday' => '1987-05-15',
            'gender' => 'H',
            'phone' => '01234',
            'type' => 't2',
            'post' => 'p2',
            'email' => 's@s.s',
            'password' => bcrypt('ssss'),
        ]);
        $user->assignRole($role2);

        $user = Factory(App\User::class)->create([
            'name' => 'User Zayn',
            'birthday' => '1989-08-17',
            'gender' => 'H',
            'phone' => '01234',
            'type' => 't1',
            'post' => 'p1',
            'email' => 'z@z.z',
            'password' => bcrypt('zzzz'),
        ]);
        $user->assignRole($role3);
    }
}
