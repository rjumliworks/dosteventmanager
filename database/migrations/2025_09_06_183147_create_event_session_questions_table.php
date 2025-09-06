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
        Schema::create('event_session_questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->longText('question');
            $table->integer('participant_id')->unsigned()->index();
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->integer('session_id')->unsigned()->index();
            $table->foreign('session_id')->references('id')->on('event_sessions')->onDelete('cascade');
            $table->unique(['participant_id', 'session_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_session_questions');
    }
};
