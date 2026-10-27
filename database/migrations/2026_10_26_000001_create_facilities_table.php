<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('childrens_home'); // childrens_home, school, social_welfare, health, other
            $table->text('description')->nullable();
            $table->string('region')->default('Coast');
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('services')->nullable(); // e.g. ["kindergarten", "vocational", "shelter"]
            $table->text('accessibility_info')->nullable();
            $table->enum('status', ['active', 'temporarily_unavailable', 'pending_verification'])->default('pending_verification');
            $table->date('verified_at')->nullable();
            $table->date('next_review_at')->nullable();
            $table->string('verification_source')->nullable();
            $table->boolean('is_salama_owned')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
