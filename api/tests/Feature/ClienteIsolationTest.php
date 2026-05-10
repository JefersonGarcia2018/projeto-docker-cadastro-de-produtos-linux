<?php

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('não permite que uma oficina veja clientes de outra oficina', function () {
    // 1. Criamos a Oficina A e logamos nela
    $adminA = loginAsTenantAdmin();
    
    // Oficina A cadastra um Cliente
    Cliente::create(['nome' => 'Cliente da Oficina A', 'cpf' => '111']);

    // 2. Criamos a Oficina B (mas sem logar nela agora, logamos depois)
    $adminB = loginAsTenantAdmin(); // Ao chamar isso, ele cria novo Tenant e LOGA nele
    
    // Oficina B cadastra um Cliente
    Cliente::create(['nome' => 'Cliente da Oficina B', 'cpf' => '222']);

    // 3. Oficina B busca a lista de clientes
    $response = $this->getJson('/api/clientes');

    $response->assertStatus(200);
    
    // 4. Afirmamos que a Oficina B SÓ VÊ 1 cliente, e não 2!
    expect($response->json())->toHaveCount(1);
    expect($response->json('0.nome'))->toBe('Cliente da Oficina B');
});