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
        Schema::create('participants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('email');
            $table->string('email_hash', 64)->unique()->index();
            $table->text('contact_no');
            $table->string('contact_no_hash', 64)->unique()->index();
            $table->text('firstname',150);
            $table->string('firstname_hash', 64)->unique()->index();
            $table->text('lastname',150);
            $table->string('lastname_hash', 64)->unique()->index();
            $table->text('middlename',100)->nullable();
            $table->string('middlename_hash', 64)->unique()->index();
            $table->string('suffix',10)->nullable();
            $table->string('avatar', 200)->default('avatar.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
