<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        return response()->json(Veiculo::with('cliente')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'placa' => 'required|string|max:10',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'ano' => 'nullable|integer',
            'cor' => 'nullable|string|max:50',
        ]);

        $veiculo = Veiculo::create($validated);
        return response()->json($veiculo->load('cliente'), 201);
    }

    public function show(Veiculo $veiculo)
    {
        return response()->json($veiculo->load('cliente'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'placa' => 'sometimes|required|string|max:10',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'ano' => 'nullable|integer',
            'cor' => 'nullable|string|max:50',
        ]);

        $veiculo->update($validated);
        return response()->json($veiculo->load('cliente'));
    }

    public function destroy(Veiculo $veiculo)
    {
        $veiculo->delete();
        return response()->json(null, 204);
    }
}
