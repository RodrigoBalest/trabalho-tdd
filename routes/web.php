<?php

use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\LeilaoController;
use Illuminate\Support\Facades\Route;

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

Route::post('/produtos', [ProdutosController::class, 'store']);

route::get('/produtos',  [ProdutosController::class, 'index']);

Route::get('/produtos/em-leilao', [ProdutosController::class, 'leilao']);

Route::post('/produtos/em-leilao/lance', [LeilaoController::class, 'lance']);
