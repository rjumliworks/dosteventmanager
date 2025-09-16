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
            $table->string('designation',250)->nullable();
            $table->string('affiliation',250)->nullable();
            $table->date('birthdate')->nullable();
            $table->boolean('is_pwd')->default(0);
            $table->boolean('is_4ps')->default(0);
            $table->boolean('is_ip')->default(0);
            $table->tinyInteger('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->tinyInteger('sex_id')->unsigned()->index();
            $table->foreign('sex_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->string('avatar', 200)->default('avatar.jpg');
            $table->string('signature', 200);
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
