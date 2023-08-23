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
        Schema::create('transferencia_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transferencia_id');
            $table->bigInteger('producto_id');
            $table->bigInteger('cantidad_remitida');
            $table->bigInteger('cantidad_recibida');
            $table->timestamps();

            $table
                ->foreign('transferencia_id')
                ->references('id')
                ->on('transferencias');

            $table
                ->foreign('producto_id')
                ->references('id')
                ->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transferencia_productos');
    }
};
