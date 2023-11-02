<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::created([
            // 'id' => Uuid::uuid4()->toString(),
            'id' => Str::uuid(),
            'name' => 'Test User',
            'username' => 'test_user',
            'password' => Hash::make('password'),
            'email' => 'test_user@laravel.com',
        ]);
    }
}
