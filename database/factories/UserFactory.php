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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'collaborator', 'business']),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function collaborator()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'collaborator',
        ]);
    }

    public function business()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'business',
        ]);
    }
}