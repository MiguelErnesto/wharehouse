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
        Schema::create('conduces', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entidad_id');
            $table->bigInteger('user_id');
            $table->string('nro_conduce');
            $table->string('nro_factura');
            $table->date('fecha_modelo');
            $table->date('fecha_recepcion_transportador');
            $table->date('fecha_entrega');
            $table->date('fecha_recepcion');
            $table->string('persona_entrega');
            $table->string('persona_recpecion');
            $table->string('persona_actualiza');
            $table->string('persona_contabiliza');
            $table->string('transportador');
            $table->string('lugar_entrega');
            $table->string('comprador');
            $table->timestamps();

            $table
                ->foreign('entidad_id')
                ->references('id')
                ->on('entidades');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('nro_factura')
                ->references('nro_factura')
                ->on('facturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conduces');
    }
};
