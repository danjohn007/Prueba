<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CRMSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Cámara de Comercio');
    }

    public function test_user_can_register_as_business()
    {
        $response = $this->post('/register', [
            'name' => 'Test Business User',
            'email' => 'test@business.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'business',
            'phone' => '5551234567',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'test@business.com',
            'role' => 'business',
        ]);
    }

    public function test_user_can_register_as_collaborator()
    {
        $response = $this->post('/register', [
            'name' => 'Test Collaborator',
            'email' => 'test@collaborator.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'collaborator',
            'phone' => '5551234567',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'test@collaborator.com',
            'role' => 'collaborator',
        ]);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_business_user_cannot_access_admin_dashboard()
    {
        $business = User::factory()->create([
            'role' => 'business',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($business)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_business_can_be_created_with_all_required_fields()
    {
        $user = User::factory()->create(['role' => 'business']);
        $collaborator = User::factory()->create(['role' => 'collaborator']);

        $business = Business::create([
            'user_id' => $user->id,
            'collaborator_id' => $collaborator->id,
            'business_name' => 'Test Business',
            'rfc' => 'TEST123456789',
            'business_type' => 'Comercio',
            'address' => 'Test Address 123',
            'city' => 'Test City',
            'state' => 'Test State',
            'postal_code' => '12345',
            'contact_phone' => '5551234567',
            'contact_email' => 'contact@test.com',
        ]);

        $this->assertDatabaseHas('businesses', [
            'business_name' => 'Test Business',
            'rfc' => 'TEST123456789',
            'status' => 'pending',
        ]);

        $this->assertTrue($business->isPending());
        $this->assertFalse($business->isApproved());
    }

    public function test_business_status_can_be_updated()
    {
        $business = Business::factory()->create(['status' => 'pending']);
        
        $business->update(['status' => 'approved']);
        
        $this->assertTrue($business->isApproved());
        $this->assertFalse($business->isPending());
    }
}