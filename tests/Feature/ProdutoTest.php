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
            ->assertSee($fmt->formatCurrency($produto->lance_minimo, 'BRL'))
            ->assertSee($fmt->formatCurrency($produto->maior_lance, 'BRL'));
    }

    /**
     * @test
     * @testdox Não aceita lance abaixo do mínimo
     */
    public function nao_aceita_lance_abaixo_do_minimo()
    {
        $this->withoutExceptionHandling();

        $produto = Produto::factory()->create();

        $attrs = [
            'valor' => $produto->lance_minimo - 1
        ];
        $this->post('/produtos/em-leilao/lance', $attrs)
            ->assertRedirect('/produtos/em-leilao')
            ->assertSessionHasErrors();

        $this->get('/produtos/em-leilao')
            ->assertSee('Valor do lance abaixo do mínimo')
            ->assertSee($produto->nome);

        $this->assertDatabaseMissing('produtos', [
            'id' => $produto->getKey(),
            'maior_lance' => $attrs['valor']
        ]);
    }

    /**
     * @test
     * @testdox Não aceita lance inferior ao maior lance
     */
    public function nao_aceita_lance_inferior_ao_maior_lance()
    {
        $this->withoutExceptionHandling();

        $produto = Produto::factory()->create();
        $produto->maior_lance = $produto->lance_minimo + 200;
        $produto->save();

        $attrs = [
            'valor' => $produto->lance_minimo + 100
        ];
        $this->post('/produtos/em-leilao/lance', $attrs)
            ->assertRedirect('/produtos/em-leilao')
            ->assertSessionHasErrors();

        $this->get('/produtos/em-leilao')
            ->assertSee('Valor do lance abaixo ou igual a um lance anterior')
            ->assertSee($produto->nome);

        $this->assertDatabaseMissing('produtos', [
            'id' => $produto->getKey(),
            'maior_lance' => $attrs['valor']
        ]);
    }

    /**
     * @test
     * @testdox Não aceita lance maior que valor de buyout
     */
    public function nao_aceita_lance_maior_que_valor_de_buyout()
    {
        $this->withoutExceptionHandling();

        $produto = Produto::factory()->create();

        $attrs = [
            'valor' => $produto->valor_buyout + 1
        ];
        $this->post('/produtos/em-leilao/lance', $attrs)
            ->assertRedirect('/produtos/em-leilao')
            ->assertSessionHasErrors();

        $this->get('/produtos/em-leilao')
            ->assertSee('Valor do lance acima do valor de buyout')
            ->assertSee($produto->nome);

        $this->assertDatabaseMissing('produtos', [
            'id' => $produto->getKey(),
            'maior_lance' => $attrs['valor']
        ]);
    }

    /**
     * @test
     * @testdox Lance é aceito
     */
    public function lance_e_aceito()
    {
        $this->withoutExceptionHandling();

        $produto = Produto::factory()->create();

        $attrs = [
            'valor' => $this->faker->randomFloat(
                2,
                max($produto->lance_minimo, $produto->maior_lance + 0.01),
                $produto->valor_buyout - 0.01
            )
        ];
        $this->post('/produtos/em-leilao/lance', $attrs)
            ->assertRedirect('/produtos/em-leilao')
            ->assertSessionDoesntHaveErrors();

        $this->get('/produtos/em-leilao')
            ->assertSee('Lance aceito')
            ->assertSee($produto->nome);

        $this->assertDatabaseHas('produtos', [
            'id' => $produto->getKey(),
            'maior_lance' => $attrs['valor']
        ]);
    }

    /**
     * @test
     * @testdox Lance é encerrado com valor de buyout
     */
    public function lance_e_encerrado_com_valor_de_buyout()
    {
        $this->withoutExceptionHandling();

        $produto = Produto::factory()->create();

        $attrs = [
            'valor' => $produto->valor_buyout
        ];

        $this->post('/produtos/em-leilao/lance', $attrs)
            ->assertRedirect('/produtos')
            ->assertSessionDoesntHaveErrors();

        $this->get('/produtos')
            ->assertSee('Lance aceito com valor de buyout.')
            ->assertSee('Leilão encerrado.')
            ->assertDontSee($produto->nome);

        $this->assertDatabaseHas('produtos_vendidos', [
            'id' => $produto->getKey(),
            'descricao' => $produto->descricao,
            'lance_minimo' => $produto->lance_minimo,
            'ordem' => $produto->ordem,
            'valor_buyout' => $produto->valor_buyout,
            'maior_lance' => $attrs['valor']
        ]);

        $this->assertDatabaseMissing('produtos', [
            'id' => $produto->getKey(),
        ]);
    }
}
