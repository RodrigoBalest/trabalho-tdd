<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use NumberFormatter;

class ProdutosController extends Controller
{
    private $produtos;

    public function __construct(Produto $produtos)
    {
        $this->produtos = $produtos;
    }

    public function index()
    {
        $produtos = $this->produtos->all();
        return view('produtos.index', compact('produtos'));
    }

    public function store(Request $request)
    {
        $this->produtos->create($request->all([
            'nome',
            'descricao',
            'lance_minimo',
            'ordem',
            'valor_buyout'
        ]));

        return redirect('/produtos');
    }

    public function leilao(Request $request)
    {
        $produto = $this->produtos->orderBy('ordem', 'asc')->first();
        $fmt = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY );

        return view('produtos.leilao', compact('produto', 'fmt'));
    }

    public function create()
    {
        return view('produtos.create');
    }
}
