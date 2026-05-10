<?php

use App\Models\Cliente;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('aplica o tenant_id automaticamente ao criar um modelo', function () {
    // 1. Loga no sistema (usa a nossa função do Pest.php)
    $user = loginAsTenantAdmin();

    // 2. Cria um cliente (Repare que não estamos passando o tenant_id)
    $cliente = Cliente::create([
        'nome' => 'João da Silva',
        'cpf' => '111.111.111-11',
        'email' => 'joao@teste.com'
    ]);

    // 3. Afirmações (Assertions)
    expect($cliente->tenant_id)->toBe($user->tenant_id);
});