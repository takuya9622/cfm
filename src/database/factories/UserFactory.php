<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'postal_code' => $this->faker->optional()->postcode(),
            'address' => $this->faker->optional()->address(),
            'building' => $this->faker->optional()->secondaryAddress,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function testUser1()
    {
        return $this->state([
            'name' => 'test_user1',
            'email' => 'testUser1@example.com',
        ]);
    }

    public function testUser2()
    {
        return $this->state([
            'name' => 'test_user2',
            'email' => 'testUser2@example.com',
        ]);
    }

    public function testUser3()
    {
        return $this->state([
            'name' => 'test_user3',
            'email' => 'testUser3@example.com',
        ]);
    }
}
