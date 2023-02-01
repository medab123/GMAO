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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedBigInteger('demandeur_id')->nullable();
            $table->foreign('demandeur_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('niveau_intervontion_id')->nullable();
            $table->foreign('niveau_intervontion_id')->references('id')->on('niveau_intervontions')->onDelete('cascade');
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->foreign('machine_id')->references('id')->on('machins')->onDelete('cascade');
            $table->unsignedBigInteger('type_intervontion_id')->nullable();
            $table->foreign('type_intervontion_id')->references('id')->on('type_intervontions')->onDelete('cascade');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('demandes');
    }
};
