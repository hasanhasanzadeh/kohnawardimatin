<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys=[
            'article',
            'country',
            'province',
            'city',
            'role',
            'setting',
            'customer',
            'category',
            'contact',
            'page',
            'page-cat',
            'question',
            'symbol',
            'search',
            'brand',
            'payment',
            'order',
            'product',
            'send',
            'post',
            'slider',
            'base',
            'permission'
        ];

        $values=[
            'all',
            'find',
            'create',
            'store',
            'edit',
            'update',
            'delete'
        ];

        $role=Role::whereName('superAdmin')->firstOrFail();

        foreach ($keys as $item){
            foreach ($values as $value){
                $permission=new Permission();
                $permission->name=$item.'-'.$value;
                $permission->display_name=$item.' '.$value;
                $permission->save();
                $role->givePermissionTo($permission);
            }
        }
        $user=User::whereEmail('hasan.hasanzadeh.dev@gmail.com')->firstOrFail();
        $user->assignRole($role);
    }
}
