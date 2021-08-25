<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaTblProdutosVendidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_vendidos', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('lance_minimo', 10, 2, true);
            $table->unsignedInteger('ordem');
            $table->decimal('valor_buyout', 10, 2, true);
            $table->decimal('maior_lance', 10, 2, true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_vendidos');
    }
}
