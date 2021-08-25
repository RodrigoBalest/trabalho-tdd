<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ProdutoVendido;
use Illuminate\Http\Request;

class LeilaoController extends Controller
{
    private $produtos;
    private $produtosVendidos;

    public function __construct(Produto $produtos, ProdutoVendido $produtosVendidos)
    {
        $this->produtos = $produtos;
        $this->produtosVendidos = $produtosVendidos;
    }

    public function lance(Request $request)
    {
        $produto = $this->produtos->orderBy('ordem', 'asc')->firstOrFail();
        $lance = $request->input('valor');

        if ($lance < $produto->lance_minimo) {
            return redirect('/produtos/em-leilao')
                ->withErrors('Valor do lance abaixo do mínimo');
        }

        if ($lance <= $produto->maior_lance && $lance < $produto->valor_buyout) {
            return redirect('/produtos/em-leilao')
                ->withErrors('Valor do lance abaixo ou igual a um lance anterior');
        }

        if (($lance - $produto->valor_buyout) > 0.01) {
            return redirect('/produtos/em-leilao')
                ->withErrors('Valor do lance acima do valor de buyout');
        }

        $min = max($produto->lance_minimo, $produto->maior_lance + 0.01);
        $max = $produto->valor_buyout - 0.01;
        if ($lance >= $min && $lance <= $max) {
            $produto->maior_lance = $lance;
            $produto->save();

            return redirect('/produtos/em-leilao')
                ->with('success', 'Lance aceito');
        }

        $diff = abs($lance - $produto->valor_buyout);
        if ($diff < 0.01) {
            $pv = $this->produtosVendidos->newInstance([
                'id' => $produto->getKey(),
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'lance_minimo' => $produto->lance_minimo,
                'ordem' => $produto->ordem,
                'valor_buyout' => $produto->valor_buyout,
                'maior_lance' => $lance
            ]);
            $pv->save();
            $produto->delete();

            return redirect('/produtos')
                ->with('success', 'Lance aceito com valor de buyout. Leilão encerrado.');
        }
    }

    public function encerrar()
    {
        $produto = $this->produtos->orderBy('ordem', 'asc')->firstOrFail();
        $pv = $this->produtosVendidos->newInstance([
            'id' => $produto->getKey(),
            'nome' => $produto->nome,
            'descricao' => $produto->descricao,
            'lance_minimo' => $produto->lance_minimo,
            'ordem' => $produto->ordem,
            'valor_buyout' => $produto->valor_buyout,
            'maior_lance' => $produto->maior_lance
        ]);
        $pv->save();
        $produto->delete();

        return redirect('/produtos')
            ->with('success', 'Leilão encerrado.');
    }
}
