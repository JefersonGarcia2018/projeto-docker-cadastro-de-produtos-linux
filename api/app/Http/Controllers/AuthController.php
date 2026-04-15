<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string',
            'cnpj' => 'nullable|string',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        try {
            DB::beginTransaction();

            $tenant = Tenant::create([
                'razao_social' => $request->razao_social,
                'cnpj' => $request->cnpj,
                'status_assinatura' => 'active'
            ]);

            $user = clone User::create([
                'tenant_id' => $tenant->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Oficina registrada com sucesso!',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => clone $user,
                'tenant' => $tenant
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao registrar oficina.', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => clone $user,
            'tenant' => $user->tenant
        ]);
    }
    
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'tenant' => $request->user()->tenant
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
