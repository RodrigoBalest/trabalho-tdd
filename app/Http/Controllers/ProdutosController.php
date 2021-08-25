<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

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
}
