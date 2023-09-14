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
        Schema::table('ordenes_despacho', function (Blueprint $table) {
            $table->dropColumn('transferencia_id');
        });

        Schema::table('ordenes_despacho', function (Blueprint $table) {
            $table->dropColumn('vale_id');
        });

        Schema::table('ordenes_despacho', function (Blueprint $table) {
            $table->bigInteger('transferencia_id')->nullable();
            $table
                ->foreign('transferencia_id')
                ->references('id')
                ->on('transferencias')
                ->onDelete('cascade');

            $table->bigInteger('vale_id')->nullable();
            $table
                ->foreign('vale_id')
                ->references('id')
                ->on('vales')
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
        Schema::table('ordenes_despacho', function (Blueprint $table) {
            //
        });
    }
};
