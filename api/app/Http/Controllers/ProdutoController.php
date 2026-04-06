<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    { 
        return Produto::all(); 

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Produto::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produto = Produto::findOrFail($id);
    
        // Validação básica para evitar erros de tipo
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'integer'
        ]);

        $produto->update($validated);

        return response()->json($produto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Produto::destroy($id);
    }
}
