<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('requester_name');
            $table->string('requester_phone')->nullable();
            $table->string('requester_email')->nullable();
            $table->string('relationship_to_child')->nullable(); // parent, guardian, social_worker, self, other
            $table->string('child_age_range')->nullable();
            $table->string('preferred_location')->nullable();
            $table->string('request_type'); // admission_info, emergency, referral, counselling, material_support, other
            $table->text('message');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['new', 'assigned', 'in_progress', 'resolved', 'closed'])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('internal_notes')->nullable();
            $table->boolean('consent_given')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_requests');
    }
};
