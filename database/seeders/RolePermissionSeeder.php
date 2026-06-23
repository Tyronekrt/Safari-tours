<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = [
            'super_admin',
            'admin',
            'sales_agent',
            'customer'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.assign_roles',

            // Enquiry Management
            'enquiries.view',
            'enquiries.create',
            'enquiries.edit',
            'enquiries.delete',
            'enquiries.assign',
            'enquiries.export',

            // Package Management
            'packages.view',
            'packages.create',
            'packages.edit',
            'packages.delete',
            'packages.publish',

            // Dashboard
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'users.view', 'users.create', 'users.edit', 'users.assign_roles',
            'enquiries.view', 'enquiries.create', 'enquiries.edit', 'enquiries.assign', 'enquiries.export',
            'packages.view', 'packages.create', 'packages.edit', 'packages.publish',
            'dashboard.view',
        ]);

        $salesAgent = Role::findByName('sales_agent');
        $salesAgent->givePermissionTo([
            'enquiries.view',
            'enquiries.edit',
            'enquiries.create',
            'dashboard.view',
        ]);

        $customer = Role::findByName('customer');
        $customer->givePermissionTo([
            'enquiries.create',
        ]);
    }
}
