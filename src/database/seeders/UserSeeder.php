<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->testUser1()->create();
        User::factory()->testUser2()->create();
        User::factory()->testUser3()->create();
    }
}