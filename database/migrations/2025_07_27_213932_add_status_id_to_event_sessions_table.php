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
        Schema::table('event_sessions', function (Blueprint $table) {
            $table->unsignedTinyInteger('status_id')->default(16)->after('event_id');
            $table->foreign('status_id')->references('id')->on('dropdowns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            //
        });
    }
};
