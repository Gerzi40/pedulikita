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
        Schema::create('volunteer_point_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained();
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedBigInteger('rating_total')->default(0);
            $table->unsignedBigInteger('rating_count')->default(0);
            $table->decimal('point_total', total: 8, places: 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_point_ratings');
    }
};
