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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('idade')->nullable();
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->string('sexo')->nullable();
            $table->float('objetivo_peso')->nullable();
            $table->date('data_objetivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['idade', 'peso', 'altura', 'sexo', 'objetivo_peso', 'data_objetivo']);
        });
    }
};
