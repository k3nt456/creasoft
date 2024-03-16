<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_data_customer_exports', function (Blueprint $table) {
            $table->id();
            $table->uuid('iduser')->comment('Usuario que inicio la exportación');
            $table->dateTime('date_export')->comment('Fecha de exportación');
            $table->text('path')->nullable()->comment('Ruta de la exportación');
            $table->integer('total')->comment('Total de registros exportados');
            $table->text('search_filters')->comment('Filtros de búsqueda utilizados');
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('tbl_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_data_customer_exports');
    }
};
