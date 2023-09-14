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
        Schema::create('recepcion_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto_almacen_id');
            $table->bigInteger('user_id');
            $table->date('fecha');
            $table->timestamps();

            $table
                ->foreign('producto_almacen_id')
                ->references('id')
                ->on('almacenes_productos')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepcion_productos');
    }
};
