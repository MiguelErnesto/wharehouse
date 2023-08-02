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
        Schema::table('informe_recepcion', function (Blueprint $table) {
            Schema::rename('recepcion_productos', 'informes_recepcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informes_recepcion', function (Blueprint $table) {
            Schema::rename('informes_recepcion', 'recepcion_productos');
        });
    }
};
