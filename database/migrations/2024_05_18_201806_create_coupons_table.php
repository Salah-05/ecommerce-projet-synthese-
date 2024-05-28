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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('prix');  
            $table->string('code')->unique();
            $table->decimal('discount_percentage', 5, 2)->default(3.00);
            $table->date('expiry_date');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('coupons');
    }
};
