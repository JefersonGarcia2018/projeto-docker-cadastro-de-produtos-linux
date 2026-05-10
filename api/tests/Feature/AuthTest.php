<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Garante que o banco seja limpo a cada teste
uses(RefreshDatabase::class);

it('Teste: Registrando uma nova Oficina (Tenant + User)', function () {
    $response = $this->postJson('/api/auth/register', [
        'razao_social' => 'Super Mecânica',
        'name' => 'Admin Silva',
        'email' => 'admin@mecanica.com',
        'password' => 'senha123',
    ]);

    // Afirmações da Resposta
    $response->assertStatus(201)
             ->assertJsonStructure(['access_token', 'user', 'tenant']);
             
    // Afirmações do Banco de Dados
    $this->assertDatabaseHas('tenants', ['razao_social' => 'Super Mecânica']);
    $this->assertDatabaseHas('users', ['email' => 'admin@mecanica.com']);
});

it('Teste: Tentando fazer Login com credenciais incorretas', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'admin@naoexiste.com',
        'password' => 'errada',
    ]);

    $response->assertStatus(401);
});