<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->randomElement(['Pastilha de Freio', 'Óleo de Motor', 'Filtro de Ar', 'Vela de Ignição', 'Bateria 60Ah', 'Correia Dentada']),
            'preco' => fake()->randomFloat(2, 50, 800), // Preço entre 50.00 e 800.00
            'quantidade' => fake()->numberBetween(1, 100),
        ];
    }
}