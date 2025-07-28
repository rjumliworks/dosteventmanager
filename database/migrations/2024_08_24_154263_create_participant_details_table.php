<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('designation',10)->nullable();
            $table->string('affiliation',10)->nullable();
            $table->date('birthdate')->nullable();
            $table->tinyInteger('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->tinyInteger('sex_id')->unsigned()->index();
            $table->foreign('sex_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->string('avatar', 200)->default('avatar.jpg');
            $table->unsignedInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_details');
    }
};
