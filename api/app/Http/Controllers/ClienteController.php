<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
        ]);

        $cliente = Cliente::create($validated);
        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'cpf' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string',
        ]);

        $cliente->update($validated);
        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}
