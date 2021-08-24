<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * @testdox Um produto pode ser criado
     */
    public function um_produto_pode_ser_criado()
    {
        $lanceMinimo = $this->faker->randomFloat(2);
        $attrs = [
            'nome' => ucfirst($this->faker->word()),
            'descricao' => $this->faker->sentence(),
            'lance_minimo' => $lanceMinimo,
            'ordem' => $this->faker->numberBetween(0, 200),
            'buyout' => $lanceMinimo * $this->faker->randomFloat(2, 1.5, 10)
        ];

        $response = $this->post('/produtos', $attrs);

        $this->assertDatabaseHas('produtos', $attrs);
    }
}
