<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoVendido extends Model
{
    protected $table = 'produtos_vendidos';

    protected $fillable = ['id', 'nome', 'descricao', 'lance_minimo', 'ordem', 'valor_buyout', 'maior_lance'];
}
