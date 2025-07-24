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
        Schema::create('event_session_activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('activity',250);
            $table->string('speaker_name', 150); 
            $table->string('speaker_title', 150)->nullable(); 
            $table->integer('session_id')->unsigned()->index();
            $table->foreign('session_id')->references('id')->on('event_sessions')->onDelete('cascade');
            $table->integer('schedule_id')->unsigned()->index();
            $table->foreign('schedule_id')->references('id')->on('event_session_schedules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_session_activities');
    }
};
