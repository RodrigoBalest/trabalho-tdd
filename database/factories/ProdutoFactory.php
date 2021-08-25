<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lanceMinimo = $this->faker->randomFloat(2);
        return [
            'nome' => ucfirst($this->faker->word()),
            'descricao' => $this->faker->sentence(),
            'lance_minimo' => $lanceMinimo,
            'ordem' => $this->faker->numberBetween(0, 200),
            'valor_buyout' => $lanceMinimo * $this->faker->randomFloat(2, 1.5, 10)
        ];
    }
}
