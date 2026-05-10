<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razao_social' => fake()->company() . ' Mecânica',
            'cnpj' => fake()->unique()->numerify('##.###.###/0001-##'),
            'status_assinatura' => 'active',
        ];
    }
}