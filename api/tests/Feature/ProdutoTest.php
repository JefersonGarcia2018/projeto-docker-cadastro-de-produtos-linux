<?php

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Teste: Acessando a Rota "/api/produtos". E listando os produtos da Oficina logada', function () {
    loginAsTenantAdmin();

    // Cria um produto vinculado à oficina automaticamente pela Trait
    Produto::create([
        'nome' => 'Óleo de Motor',
        'preco' => 35.90
    ]);

    $response = $this->getJson('/api/produtos');

    $response->assertStatus(200)
             ->assertJsonFragment(['nome' => 'Óleo de Motor']);
});

it('Teste: Rejeita criação de produto sem nome', function () {
    loginAsTenantAdmin();

    $response = $this->postJson('/api/produtos', [
        'preco' => 100.00
    ]);

    $response->assertStatus(422) // Unprocessable Entity (Erro de validação)
             ->assertJsonValidationErrors(['nome']);
});