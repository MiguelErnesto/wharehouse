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
        Schema::table('recepcion_productos', function (Blueprint $table) {
            $table->dropColumn('producto_almacen_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recepcion_productos', function (Blueprint $table) {
            $table->bigInteger('producto_almacen_id');
            $table
                ->foreign('producto_almacen_id')
                ->references('id')
                ->on('almacenes_productos');
        });
    }
};
