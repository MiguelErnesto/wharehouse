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
        Schema::create('conduce_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('conduce_id');
            $table->bigInteger('producto_id');
            $table->bigInteger('cantidad');
            $table->timestamps();

            $table
                ->foreign('conduce_id')
                ->references('id')
                ->on('conduces')
                ->onDelete('cascade');

            $table
                ->foreign('producto_id')
                ->references('id')
                ->on('productos')
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
        Schema::dropIfExists('conduce_productos');
    }
};
