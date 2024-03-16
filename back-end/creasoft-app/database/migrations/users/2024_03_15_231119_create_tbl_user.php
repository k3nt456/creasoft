<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 80)->unique();
            $table->text('avatar')->nullable();
            $table->string('dni', 8)->unique();
            $table->string('name', 50);
            $table->string('surname', 100);
            $table->string('email', 50)->nullable()->unique();
            $table->string('cellphone', 9)->nullable()->unique();
            $table->date('birthdate');
            $table->text('password');
            $table->text('encrypted_password')->nullable();
            $table->char('email_confirmation', 1)->default(0)->comment('0:No realizado, 1:Confirmado');
            $table->bigInteger('idtype_user')->unsigned();
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado, 3:Bloqueado');
            $table->timestamps();

            $table->foreign('idtype_user')->references('id')->on('tbl_type_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_user');
    }
};
