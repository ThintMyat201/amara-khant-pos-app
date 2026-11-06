<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::firstOrCreate(
            ['email' => 'admin123@gmail.com'],
            [
                'name' => 'Thint Myat Htet Myet Shwe',
                'password' => Hash::make('admin123!@#'),
                'role' => 'Admin',
                'address' => 'Jalan PBS 14/2, Taman Perindustrian Bukit Serdang, 43300 Seri Kembangan, Selangor',
                'phone' => '09880001025'
            ]
        );

        User::firstOrCreate(
            ['email' => 'demo@pos.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('demo123!@#'),
                'role' => 'Admin',
                'address' => 'Jalan PBS 14/2, Taman Perindustrian Bukit Serdang, 43300 Seri Kembangan, Selangor',
                'phone' => '09880001025'
            ]
        );
    }
}
