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
        Schema::create('event_sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('title',250);
            $table->boolean('is_closed')->default(0);
            $table->boolean('is_whole_day')->default(0);
            $table->boolean('is_invitational')->default(0); //invite only
            $table->boolean('is_exclusive')->default(0); //only one to be attended 
            $table->boolean('is_limited')->default(0);
            $table->boolean('has_registration')->default(1);
            $table->integer('venue_id')->unsigned()->index();
            $table->foreign('venue_id')->references('id')->on('event_venues')->onDelete('cascade');
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedTinyInteger('status_id')->default(16);
            $table->foreign('status_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sessions');
    }
};
