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
            $table->string('nro_informe')->after('id');
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
            $table->dropColumn('nro_informe');
        });
    }
};
