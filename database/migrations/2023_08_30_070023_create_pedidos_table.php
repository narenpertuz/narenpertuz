<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('idPedido');
            $table->unsignedBigInteger('idCuenta');
            $table->string('producto');
            $table->integer('cantidad');
            $table->decimal('valor', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
            
            $table->foreign('idCuenta')->references('idCuenta')->on('cuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
