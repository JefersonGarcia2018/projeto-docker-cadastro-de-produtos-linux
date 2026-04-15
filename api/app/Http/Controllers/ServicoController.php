<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index()
    {
        return response()->json(Servico::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'valor_padrao' => 'required|numeric|min:0',
            'tempo_estimado_minutos' => 'nullable|integer|min:0',
        ]);

        $servico = Servico::create($validated);
        return response()->json($servico, 201);
    }

    public function show(Servico $servico)
    {
        return response()->json($servico);
    }

    public function update(Request $request, Servico $servico)
    {
        $validated = $request->validate([
            'descricao' => 'sometimes|required|string|max:255',
            'valor_padrao' => 'sometimes|required|numeric|min:0',
            'tempo_estimado_minutos' => 'nullable|integer|min:0',
        ]);

        $servico->update($validated);
        return response()->json($servico);
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();
        return response()->json(null, 204);
    }
}
