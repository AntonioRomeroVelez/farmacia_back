<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('NombreProducto');
            $table->string('Presentacion')->nullable();
            $table->string('PrincipioActivo')->nullable();
            $table->decimal('PrecioFarmacia', 10, 2)->nullable();
            $table->decimal('PVP', 10, 2)->nullable();
            $table->string('Promocion')->nullable();
            $table->string('Descuento')->nullable();
            $table->string('Marca')->nullable();
            $table->string('IVA')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
