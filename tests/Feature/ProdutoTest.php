<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use NumberFormatter;
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
        $this->withoutExceptionHandling();

        $lanceMinimo = $this->faker->randomFloat(2);
        $attrs = [
            'nome' => ucfirst($this->faker->word()),
            'descricao' => $this->faker->sentence(),
            'lance_minimo' => $lanceMinimo,
            'ordem' => $this->faker->numberBetween(0, 200),
            'valor_buyout' => $lanceMinimo * $this->faker->randomFloat(2, 1.5, 10)
        ];

        $response = $this->post('/produtos', $attrs)->assertRedirect('/produtos');

        $this->assertDatabaseHas('produtos', $attrs);

        $this->get('/produtos')->assertSee($attrs['nome']);
    }

    /**
     * @test
     * @testdox Exibe produto em leilão
     */
    public function exibe_produto_em_leilao()
    {
        $this->withoutExceptionHandling();

        $produtos = Produto::factory()->times(30)->create();

        // Pega o produto com menor valor de ordem, ou seja, o próximo a ser leiloado.
        $produto = Produto::orderBy('ordem', 'asc')->first();


        $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY );

        // Vê os dados do produto
        $this->get('/produtos/em-leilao')
            ->assertSee($produto->nome)
            ->assertSee($fmt->formatCurrency($produto->lance_minimo, 'BRL'))
            ->assertSee($fmt->formatCurrency($produto->valor_buyout, 'BRL'));
    }
}
