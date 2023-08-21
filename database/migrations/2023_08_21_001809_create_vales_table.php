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
        Schema::create('vales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entidad_id');
            $table->bigInteger('almacen_id');
            $table->char('tipo_vale', 1);
            $table->float('importe_total');
            $table->string('persona_emisor');
            $table->string('persona_receptor');
            $table->timestamps();

            $table
                ->foreign('entidad_id')
                ->references('id')
                ->on('entidades');

            $table
                ->foreign('almacen_id')
                ->references('id')
                ->on('almacenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vales');
    }
};
