<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'user-view', 'label' => 'View', 'group_name' => 'user'],
            ['name' => 'user-add', 'label' => 'Add', 'group_name' => 'user'],
            ['name' => 'user-edit', 'label' => 'Edit', 'group_name' => 'user'],
            ['name' => 'user-delete', 'label' => 'Delete', 'group_name' => 'user'],

            ['name' => 'subadmin-view', 'label' => 'View', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-add', 'label' => 'Add', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-edit', 'label' => 'Edit', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-delete', 'label' => 'Delete', 'group_name' => 'subadmin'],

            ['name' => 'category-view', 'label' => 'View', 'group_name' => 'category'],
            ['name' => 'category-add', 'label' => 'Add', 'group_name' => 'category'],
            ['name' => 'category-edit', 'label' => 'Edit', 'group_name' => 'category'],
            ['name' => 'category-delete', 'label' => 'Delete', 'group_name' => 'category'],

            // ['name' => 'sub-category-view', 'label' => 'View', 'group_name' => 'sub-category'],
            // ['name' => 'sub-category-add', 'label' => 'Add', 'group_name' => 'sub-category'],
            // ['name' => 'sub-category-edit', 'label' => 'Edit', 'group_name' => 'sub-category'],
            // ['name' => 'sub-category-delete', 'label' => 'Delete', 'group_name' => 'sub-category'],

            ['name' => 'role-view', 'label' => 'View', 'group_name' => 'role'],
            ['name' => 'role-add', 'label' => 'Add', 'group_name' => 'role'],
            ['name' => 'role-edit', 'label' => 'Edit', 'group_name' => 'role'],
            ['name' => 'role-delete', 'label' => 'Delete', 'group_name' => 'role'],

            ['name' => 'plan-view', 'label' => 'View', 'group_name' => 'plan'],
            ['name' => 'plan-add', 'label' => 'Add', 'group_name' => 'plan'],
            ['name' => 'plan-edit', 'label' => 'Edit', 'group_name' => 'plan'],
            ['name' => 'plan-delete', 'label' => 'Delete', 'group_name' => 'plan'],

            ['name' => 'transaction-view', 'label' => 'View', 'group_name' => 'transaction'],

            ['name' => 'cms-view', 'label' => 'View', 'group_name' => 'cms'],
            ['name' => 'cms-edit', 'label' => 'Edit', 'group_name' => 'cms'],

            ['name' => 'commission-view', 'label' => 'View', 'group_name' => 'commission'],
            ['name' => 'commission-edit', 'label' => 'Edit', 'group_name' => 'commission'],

            ['name' => 'payment-setting-view', 'label' => 'View', 'group_name' => 'payment-setting'],
            ['name' => 'payment-setting-add', 'label' => 'Add', 'group_name' => 'payment-setting'],
            ['name' => 'payment-setting-edit', 'label' => 'Edit', 'group_name' => 'payment-setting'],
            ['name' => 'payment-setting-delete', 'label' => 'Delete', 'group_name' => 'payment-setting'],

            ['name' => 'user-activity-view', 'label' => 'View', 'group_name' => 'user-activity'],

            ['name' => 'store-view', 'label' => 'View', 'group_name' => 'store'],
            ['name' => 'store-add', 'label' => 'Add', 'group_name' => 'store'],
            ['name' => 'store-edit', 'label' => 'Edit', 'group_name' => 'store'],
            ['name' => 'store-delete', 'label' => 'Delete', 'group_name' => 'store'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'name'  =>  $permission['name']
            ], [
                'label'  =>  $permission['label'],
                'group_name'  =>  $permission['group_name'],
                'guard_name'  =>  'web',
            ]);
        }
    }
}
