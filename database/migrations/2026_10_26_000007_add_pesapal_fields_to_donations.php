<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('merchant_reference')->nullable()->unique()->after('id');
            $table->string('pesapal_tracking_id')->nullable()->after('transaction_reference');
            $table->string('pesapal_status')->nullable()->after('status'); // PENDING, COMPLETED, FAILED, INVALID
            $table->string('payment_method')->nullable()->change();
            $table->json('pesapal_response')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['merchant_reference', 'pesapal_tracking_id', 'pesapal_status', 'pesapal_response']);
        });
    }
};
