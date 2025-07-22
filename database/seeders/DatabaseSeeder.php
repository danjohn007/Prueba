<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador General',
            'email' => 'admin@camaracomercio.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '5551234567',
            'address' => 'Av. Principal 123, Centro, Ciudad de México',
            'email_verified_at' => now(),
        ]);

        // Crear usuarios colaboradores de ejemplo
        $collaborator1 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@camaracomercio.com',
            'password' => Hash::make('password123'),
            'role' => 'collaborator',
            'phone' => '5551234568',
            'address' => 'Calle Secundaria 456, Colonia Norte',
            'email_verified_at' => now(),
        ]);

        $collaborator2 = User::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@camaracomercio.com',
            'password' => Hash::make('password123'),
            'role' => 'collaborator',
            'phone' => '5551234569',
            'address' => 'Av. Reforma 789, Zona Rosa',
            'email_verified_at' => now(),
        ]);

        // Crear usuarios comercio de ejemplo
        $business1User = User::create([
            'name' => 'Carlos Ramírez',
            'email' => 'carlos@restauranteelbueno.com',
            'password' => Hash::make('password123'),
            'role' => 'business',
            'phone' => '5551234570',
            'address' => 'Calle Comercio 100, Centro Histórico',
            'email_verified_at' => now(),
        ]);

        $business2User = User::create([
            'name' => 'Ana López',
            'email' => 'ana@modaana.com',
            'password' => Hash::make('password123'),
            'role' => 'business',
            'phone' => '5551234571',
            'address' => 'Av. Moda 200, Zona Fashion',
            'email_verified_at' => now(),
        ]);

        // Crear registros de comercios
        Business::create([
            'user_id' => $business1User->id,
            'collaborator_id' => $collaborator1->id,
            'business_name' => 'Restaurante El Bueno',
            'rfc' => 'REB123456789',
            'business_type' => 'Restaurante',
            'description' => 'Restaurante de comida mexicana tradicional con 15 años de experiencia.',
            'website' => 'https://restauranteelbueno.com',
            'address' => 'Calle Comercio 100, Centro Histórico',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '06000',
            'contact_phone' => '5551234570',
            'contact_email' => 'contacto@restauranteelbueno.com',
            'status' => 'approved',
            'affiliation_date' => now()->subMonths(6),
            'expiration_date' => now()->addMonths(6),
            'commission_rate' => 5.00,
            'benefits' => [
                'descuentos_especiales' => true,
                'capacitaciones_gratuitas' => true,
                'networking_eventos' => true,
                'directorio_publico' => true,
            ],
        ]);

        Business::create([
            'user_id' => $business2User->id,
            'collaborator_id' => $collaborator2->id,
            'business_name' => 'Boutique Moda Ana',
            'rfc' => 'BMA987654321',
            'business_type' => 'Moda y Vestimenta',
            'description' => 'Boutique especializada en moda femenina contemporánea y accesorios.',
            'website' => 'https://modaana.com',
            'address' => 'Av. Moda 200, Zona Fashion',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '11000',
            'contact_phone' => '5551234571',
            'contact_email' => 'info@modaana.com',
            'status' => 'approved',
            'affiliation_date' => now()->subMonths(3),
            'expiration_date' => now()->addMonths(9),
            'commission_rate' => 7.50,
            'benefits' => [
                'descuentos_especiales' => true,
                'capacitaciones_gratuitas' => true,
                'networking_eventos' => true,
                'directorio_publico' => true,
                'eventos_exclusivos' => true,
            ],
        ]);

        // Crear comercio pendiente
        $business3User = User::create([
            'name' => 'Roberto Silva',
            'email' => 'roberto@tecnosilva.com',
            'password' => Hash::make('password123'),
            'role' => 'business',
            'phone' => '5551234572',
            'address' => 'Av. Tecnología 300, Zona Sur',
            'email_verified_at' => now(),
        ]);

        Business::create([
            'user_id' => $business3User->id,
            'collaborator_id' => $collaborator1->id,
            'business_name' => 'TecnoSilva Computadoras',
            'rfc' => 'TSC111222333',
            'business_type' => 'Tecnología',
            'description' => 'Venta y reparación de equipos de cómputo y electrónicos.',
            'website' => 'https://tecnosilva.com',
            'address' => 'Av. Tecnología 300, Zona Sur',
            'city' => 'Ciudad de México',
            'state' => 'CDMX',
            'postal_code' => '14000',
            'contact_phone' => '5551234572',
            'contact_email' => 'ventas@tecnosilva.com',
            'status' => 'pending',
            'commission_rate' => 6.00,
        ]);

        $this->command->info('Datos de ejemplo creados exitosamente!');
        $this->command->info('Usuario Admin: admin@camaracomercio.com / password123');
        $this->command->info('Colaborador 1: juan.perez@camaracomercio.com / password123');
        $this->command->info('Colaborador 2: maria.gonzalez@camaracomercio.com / password123');
        $this->command->info('Comercio 1: carlos@restauranteelbueno.com / password123');
        $this->command->info('Comercio 2: ana@modaana.com / password123');
        $this->command->info('Comercio 3: roberto@tecnosilva.com / password123');
    }
}