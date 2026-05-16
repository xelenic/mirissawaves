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

        // Create permissions
        $permissions = [
            // Package permissions
            'view packages',
            'create packages',
            'edit packages',
            'delete packages',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Blog permissions
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
            
            // Review permissions
            'view reviews',
            'create reviews',
            'edit reviews',
            'delete reviews',
            'approve reviews',
            'feature reviews',
            
            // Booking permissions
            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',
            'update booking status',
            
            // Media permissions
            'view media',
            'upload media',
            'edit media',
            'delete media',
            
            // Admin permissions
            'access admin panel',
            'view dashboard',
            'manage users',
            'manage settings',
            
            // User Management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage user roles',
            'manage user permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $adminRole->syncPermissions(Permission::all());

        $userRole->syncPermissions([
            'view packages',
            'create bookings',
            'view blogs',
            'create reviews',
        ]);

        $this->command->info('Roles and permissions ensured successfully!');
        $this->command->info('Admin role has all permissions.');
        $this->command->info('User role has limited permissions.');
    }
}