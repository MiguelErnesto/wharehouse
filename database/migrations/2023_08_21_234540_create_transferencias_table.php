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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entidad_id');
            $table->bigInteger('almacen_origen_id');
            $table->bigInteger('almacen_destino_id');
            $table->string('nro_transferencia');
            $table->date('fecha_modelo');
            $table->date('fecha_traslado');
            $table->date('fecha_recepcion');
            $table->string('persona_autoriza');
            $table->string('persona_entrega');
            $table->string('persona_recibe');
            $table->string('persona_actualiza_origen');
            $table->string('persona_actualiza_destino');
            $table->string('persona_contabiliza_origen');
            $table->string('persona_contabiliza_destino');
            $table->float('importe_total_entrega');
            $table->float('importe_total_destino');
            $table->timestamps();

            $table
                ->foreign('entidad_id')
                ->references('id')
                ->on('entidades')
                ->onDelete('cascade');

            $table
                ->foreign('almacen_origen_id')
                ->references('id')
                ->on('almacenes')
                ->onDelete('cascade');

            $table
                ->foreign('almacen_destino_id')
                ->references('id')
                ->on('almacenes')
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
        Schema::dropIfExists('transferencias');
    }
};
