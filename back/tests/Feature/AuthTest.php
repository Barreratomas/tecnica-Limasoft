<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_login_con_credenciales_correctas_devuelve_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('student');

        $response = $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);
    }

    public function test_login_con_credenciales_incorrectas_devuelve_401(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_endpoint_protegido_sin_token_devuelve_401(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    public function test_logout_revoca_token(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('student');

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
                         ->postJson('/api/auth/logout');

        $response->assertStatus(200);
        
        // Verificar que el token ya no existe en la base de datos
        $this->assertDatabaseCount('personal_access_tokens', 0);

        // Forzar el olvido del usuario autenticado en el guard para que el siguiente request
        // tenga que volver a autenticarse (y falle porque el token ya no existe)
        $this->app['auth']->forgetGuards();

        $this->withToken($token)
             ->getJson('/api/auth/me')
             ->assertStatus(401);
    }
}