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
        Schema::create('csf_ratings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('answer')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('importance')->nullable();
            $table->integer('question_id')->unsigned()->index();
            $table->foreign('question_id')->references('id')->on('csf_questions')->onDelete('cascade');
            $table->bigInteger('csf_id')->unsigned()->index();
            $table->foreign('csf_id')->references('id')->on('csf_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csf_ratings');
    }
};
