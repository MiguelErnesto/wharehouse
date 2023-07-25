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
        Schema::table('almacenes_productos', function (Blueprint $table) {
            $table->bigInteger('recepcion_producto_id')->nullable();
            $table
                ->foreign('recepcion_producto_id')
                ->references('id')
                ->on('recepcion_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('almacenes_productos', function (Blueprint $table) {
            $table->dropColumn('recepcion_producto_id');
        });
    }
};
