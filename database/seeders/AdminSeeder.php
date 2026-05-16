<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin users already exist
        if (User::where('email', 'admin@mirissawaves.com')->exists()) {
            $this->command->info('Admin users already exist. Skipping...');
            return;
        }

        // Create main admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@mirissawaves.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create additional admin user
        $admin2 = User::create([
            'name' => 'Site Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create a regular user for testing
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Assign roles
        $admin->assignRole('admin');
        $admin2->assignRole('admin');
        $user->assignRole('user');

        $this->command->info('✅ Admin users created successfully!');
        $this->command->info('');
        $this->command->info('🔑 Admin Login Credentials:');
        $this->command->info('📧 Email: admin@mirissawaves.com');
        $this->command->info('🔒 Password: admin123');
        $this->command->info('');
        $this->command->info('🔑 Alternative Admin:');
        $this->command->info('📧 Email: admin@example.com');
        $this->command->info('🔒 Password: password123');
        $this->command->info('');
        $this->command->info('👤 Test User:');
        $this->command->info('📧 Email: user@example.com');
        $this->command->info('🔒 Password: password123');
        $this->command->info('');
        $this->command->info('🌐 Access the admin panel at: /admin');
        $this->command->info('🔗 Or click "Admin Panel" in the user dropdown menu');
    }
}