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
        Schema::create('certificates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('subjectable_id');   
            $table->string('subjectable_type'); 
            $table->unsignedInteger('participant_id');
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->tinyInteger('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');   
            $table->datetime('issued_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
