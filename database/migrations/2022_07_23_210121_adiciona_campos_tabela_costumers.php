<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdicionaCamposTabelaCostumers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costumers', function (Blueprint $table) {
            $table->date('birth_date')->nullable();
            $table->string('cpf')->nullable();
            $table->integer('is_recommendation');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('costumers', function (Blueprint $table) {
            $table->dropColumn('birth_date');
            $table->dropColumn('cpf');
            $table->dropColumn('is_recommendation');
            $table->dropColumn('note');
        });
    }
}
