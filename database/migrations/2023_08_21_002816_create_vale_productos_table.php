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
        Schema::create('vale_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vale_id');
            $table->bigInteger('producto_id');
            $table->bigInteger('cantidad');
            $table->timestamps();

            $table
                ->foreign('vale_id')
                ->references('id')
                ->on('vales');

            $table
                ->foreign('producto_id')
                ->references('id')
                ->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vale_productos');
    }
};
