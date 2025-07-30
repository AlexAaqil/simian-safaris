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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedTinyInteger('status')->nullable();
            $table->unsignedTinyInteger('method')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('response_code')->nullable();
            $table->string('response_description')->nullable();
            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->text('customer_message')->nullable();
            $table->date('transaction_date')->nullable();

            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
