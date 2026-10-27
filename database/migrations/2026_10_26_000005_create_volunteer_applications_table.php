<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->text('skills')->nullable();
            $table->text('availability')->nullable();
            $table->text('motivation');
            $table->string('preferred_program')->nullable(); // kindergarten, mechanics, tailoring, general
            $table->enum('status', ['new', 'reviewed', 'accepted', 'rejected', 'onboarded'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_applications');
    }
};
