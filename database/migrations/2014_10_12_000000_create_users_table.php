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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('bio')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('birthday')->nullable();
            $table->string('blood_group', 4)->nullable();
            $table->string('image_path')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('suspension_ends_at')->nullable();
            $table->string('suspension_reason')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
