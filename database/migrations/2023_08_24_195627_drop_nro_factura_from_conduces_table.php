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
        Schema::table('conduces', function (Blueprint $table) {
            $table->dropColumn('nro_factura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conduces', function (Blueprint $table) {
            $table->string('nro_factura');
            $table
                ->foreign('nro_factura')
                ->references('nro_factura')
                ->on('facturas');
        });
    }
};
