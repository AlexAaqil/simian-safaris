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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('booking_code');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->unsignedTinyInteger('number_of_adults');
            $table->unsignedTinyInteger('number_of_children')->nullable();
            $table->date('date_of_travel')->nullable()->index();
            $table->text('additional_information')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('payment_status')->nullable();
            $table->unsignedTinyInteger('payment_method')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
