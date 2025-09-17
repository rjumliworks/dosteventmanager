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
        Schema::table('event_exhibitors', function (Blueprint $table) {
            $table->tinyInteger('type_id')->unsigned()->nullable()->after('is_active');
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_exhibitors', function (Blueprint $table) {
            //
        });
    }
};
