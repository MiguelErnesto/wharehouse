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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('entidad_id');
            $table->string('nro_factura');
            $table->date('fecha_modelo');
            $table->date('fecha_entrega');
            $table->date('fecha_recepcion');
            $table->date('fecha_recepcion_transportador');
            $table->float('importe_total');
            $table->float('porciento');
            $table->string('datos_registro');
            $table->string('operaciones');
            $table->string('moneda_pago');
            $table->string('persona_contabiliza');
            $table->string('persona_entrega');
            $table->string('persona_recibe');
            $table->string('transportista');
            $table->string('persona_transportador');
            $table->timestamps();

            $table
                ->foreign('entidad_id')
                ->references('id')
                ->on('entidades');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};
