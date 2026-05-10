<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Veiculo;
use App\Models\Servico;
use App\Models\Produto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'clientes_count' => Cliente::count(),
            'veiculos_count' => Veiculo::count(),
            'servicos_count' => Servico::count(),
            'produtos_count' => Produto::count(),
        ]);
    }
}
