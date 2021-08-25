<?php

use Illuminate\Support\Facades\Route;
use App\Models\Produto;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/produtos', function () {
    Produto::create(request([
        'nome',
        'descricao',
        'lance_minimo',
        'ordem',
        'valor_buyout'
    ]));
});

route::get('/produtos', function () {
    $produtos = Produto::all();
    return view('produtos.index', compact('produtos'));
});
