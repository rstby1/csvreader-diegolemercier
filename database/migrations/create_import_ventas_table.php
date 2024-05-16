<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('import_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('Fecha', 15);
            $table->char('TipoComprobante', 1);
            $table->string('PuntoVenta', 5);
            $table->string('NumeroComprobante', 10);
            $table->decimal('ImporteVenta', 15, 2);
            $table->bigInteger('CUITCliente');
            //$table->bigInteger('CUITCliente')->references('CUITCliente')->on('clientes');
            $table->foreign('CUITCliente')->references('CUITCliente')->on('Clientes');
        });
    }

    public function down(): void {
        Schema::dropIfExists('import_ventas');
    }
};
