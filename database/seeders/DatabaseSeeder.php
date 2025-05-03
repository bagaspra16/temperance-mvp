<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('temperancedev123'),
            'deleted' => false,
            'created_by' => null,
            'updated_by' => null,
        ]);

        // Create admin user preferences
        UserPreference::create([
            'user_id' => $admin->id,
            'theme' => 'light',
            'accent_color' => '#4F46E5',
            'email_notifications' => true,
            'push_notifications' => true,
            'weekly_summary' => true,
            'default_view' => 'calendar',
            'start_day' => 'monday',
            'date_format' => 'Y-m-d',
            'show_completed' => true,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@temperance.com',
            'password' => Hash::make('password123'),
            'deleted' => false,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Create test user preferences
        UserPreference::create([
            'user_id' => $user->id,
            'theme' => 'dark',
            'accent_color' => '#10B981',
            'email_notifications' => true,
            'push_notifications' => true,
            'weekly_summary' => true,
            'default_view' => 'list',
            'start_day' => 'sunday',
            'date_format' => 'd/m/Y',
            'show_completed' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }
}
