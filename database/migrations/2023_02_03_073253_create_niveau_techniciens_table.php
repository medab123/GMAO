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
        Schema::create('niveau_techniciens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('niveau_intervontion_id')->nullable();
            $table->foreign('niveau_intervontion_id')->references('id')->on('niveau_intervontions')->onDelete('cascade');
            $table->unsignedBigInteger('technicien_id')->nullable();
            $table->foreign('technicien_id')->references('id')->on('techniciens')->onDelete('cascade');
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
        Schema::dropIfExists('niveau_techniciens');
    }
};
