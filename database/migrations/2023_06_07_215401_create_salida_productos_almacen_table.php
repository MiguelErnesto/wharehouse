<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salida_productos_almacen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto_almacen_id');
            $table->string('tipo_salida');
            $table->date('fecha');
            $table->string('destino');
            $table->bigInteger('cantidad');
            $table->timestamps();

            $table
                ->foreign('producto_almacen_id')
                ->references('id')
                ->on('almacenes_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salida_productos_almacen');
    }
};
