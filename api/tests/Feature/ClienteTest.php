<?php

use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Teste: Acessando a Rota "/api/clientes". E listando os clientes da Oficina logada', function () {
    // 1. Cria e loga o dono da Oficina
    loginAsTenantAdmin();

    // 2. Fabrica 15 clientes para Oficina logada! (A Trait preenche a coluna tenant_id do modelo Cliente" automaticamente)
    Cliente::factory()->count(15)->create();

    // 3. Faz a requisição
    $response = $this->getJson('/api/clientes');

    // 4. Valida se a API retornou todos os 15 perfeitamente.
    $response->assertStatus(200);
    expect($response->json())->toHaveCount(15);
});

it('Teste: Criação de Cliente e seus Veículos na mesma tacada', function () {
    loginAsTenantAdmin();

    $clienteComCarros = Cliente::factory()
        ->has(Veiculo::factory()->count(3), 'veiculos') // Mágica do Eloquent
        ->create();

    expect($clienteComCarros->veiculos)->toHaveCount(3);
});