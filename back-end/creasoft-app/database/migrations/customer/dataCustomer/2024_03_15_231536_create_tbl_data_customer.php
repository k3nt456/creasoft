<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_data_customer', function (Blueprint $table) {
            $table->id();
            $table->string('cellphone', 9);
            $table->string('dni', 8);
            $table->string('ip')->nullable();
            $table->char('revision_status', 1)->default(0)->comment('0:No contactado, 1:Aceptó oferta, 2:Rechazó oferta, 3:No contesto, 4: Hacer seguimiento');
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_data_customer');
    }
};
