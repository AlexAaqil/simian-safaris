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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title')->unique();
            $table->string('slug')->index();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->string('summary');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('duration_days')->nullable();
            $table->unsignedTinyInteger('duration_nights')->nullable();
            $table->string('currency');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_ranges_to', 10, 2)->nullable();

            $table->foreignId('tour_category_id')->constrained('tour_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
