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
        Schema::create('ordenes_despacho', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entidad_id');
            $table->bigInteger('almacen_id');
            $table->bigInteger('cliente_id');
            $table->bigInteger('user_id');
            $table->bigInteger('tipo_salida_id');
            $table->date('fecha');
            $table->string('lugar_entrega');
            $table->date('fecha_entrega');
            $table->timestamps();

            $table
                ->foreign('entidad_id')
                ->references('id')
                ->on('entidades')
                ->onDelete('cascade');

            $table
                ->foreign('almacen_id')
                ->references('id')
                ->on('almacenes')
                ->onDelete('cascade');

            $table
                ->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table
                ->foreign('tipo_salida_id')
                ->references('id')
                ->on('tipos_salida')
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
        Schema::dropIfExists('ordenes_despacho');
    }
};
