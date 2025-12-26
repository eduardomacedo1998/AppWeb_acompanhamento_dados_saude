<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_usuario', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('idade');
            $table->float('peso');
            $table->float('altura');
            $table->string('sexo');
            $table->float('objetivo_peso');
            $table->date('data_objetivo');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_usuario');
    }
};
