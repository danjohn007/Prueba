<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory()->business(),
            'collaborator_id' => User::factory()->collaborator(),
            'business_name' => fake()->company(),
            'rfc' => strtoupper(fake()->regexify('[A-Z]{3}[0-9]{6}[A-Z0-9]{3}')),
            'business_type' => fake()->randomElement([
                'Restaurante', 'Comercio', 'Servicios', 'Tecnología', 
                'Moda', 'Construcción', 'Salud', 'Educación'
            ]),
            'description' => fake()->paragraph(),
            'website' => fake()->optional()->url(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->companyEmail(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'canceled']),
            'affiliation_date' => fake()->optional()->dateTimeBetween('-2 years', 'now'),
            'expiration_date' => fake()->optional()->dateTimeBetween('now', '+2 years'),
            'commission_rate' => fake()->randomFloat(2, 0, 15),
            'benefits' => [
                'descuentos_especiales' => fake()->boolean(),
                'capacitaciones_gratuitas' => fake()->boolean(),
                'networking_eventos' => fake()->boolean(),
                'directorio_publico' => fake()->boolean(),
            ],
        ];
    }

    public function approved()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'affiliation_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'expiration_date' => fake()->dateTimeBetween('now', '+1 year'),
        ]);
    }

    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'affiliation_date' => null,
            'expiration_date' => null,
        ]);
    }

    public function rejected()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'affiliation_date' => null,
            'expiration_date' => null,
        ]);
    }
}