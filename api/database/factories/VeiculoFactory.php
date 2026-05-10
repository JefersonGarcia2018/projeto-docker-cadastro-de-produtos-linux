<?php

namespace Database\Factories;

use App\Models\Veiculo;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Veiculo>
 */
class VeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Se o teste não informar o cliente_id, a Factory cria um cliente no banco automaticamente
            'cliente_id' => Cliente::factory(), 
            
            'placa' => strtoupper(fake()->lexify('???-####')),
            'marca' => fake()->randomElement(['Volkswagen', 'Chevrolet', 'Fiat', 'Ford', 'Honda', 'Toyota']),
            'modelo' => fake()->randomElement(['Gol', 'Onix', 'Argo', 'Ka', 'Civic', 'Corolla']),
            'ano' => fake()->numberBetween(2010, 2024),
            'cor' => fake()->colorName(),
        ];
    }
}