<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Owner',
            'photo' => 'default.jpg',
            'email' => 'oketoys@gmail.com',
            'phone_number' => '081234567890',
            'email_verified_at' => null,
            'password' => '$2y$12$TW4THRgEPPDe/qEV2xIIqupGn74UyiphI5ODr1CHPG3RU38dYxMoG',
            'role' => 'owner',
            'remember_token' => null,
            'created_at' => '2025-05-03 00:21:01',
            'updated_at' => '2025-07-14 19:08:02',
            'deleted_at' => null
        ]);
    }
}
