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
        Schema::create('paiments', function (Blueprint $table) {
            $table->id();
            $table->string('montant');
            $table->unsignedBigInteger('Id_carte');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('Id_commande');
            $table->foreign('Id_carte')->references('id')->on('cartes');
            $table->foreign('id_client')->references('id')->on('users');
            $table->foreign('Id_commande')->references('id')->on('commandes')->onDelete('cascade');
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
        Schema::dropIfExists('paiments');
    }
};
