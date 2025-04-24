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
        // Tour Categories table
        Schema::create('TourCategories', function (Blueprint $table) {
            $table->id('CategoryID');
            $table->string('CategoryName')->notNull();
            $table->text('Description')->nullable();
            $table->foreignId('ParentCategoryID')->nullable()->constrained('TourCategories', 'CategoryID')->nullOnDelete();
            $table->string('IconURL')->nullable();
            $table->integer('DisplayOrder')->default(0);
            $table->boolean('IsActive')->default(true);
        });

        // Tours table
        Schema::create('Tours', function (Blueprint $table) {
            $table->id('TourID');
            $table->string('TourName')->notNull();
            $table->text('Description')->nullable();
            $table->string('ShortDescription')->nullable();
            $table->foreignId('LocationID')->constrained('Locations', 'LocationID');
            $table->decimal('DurationHours', 5, 2)->nullable();
            $table->integer('DurationDays')->nullable();
            $table->decimal('BasePrice', 10, 2)->notNull();
            $table->decimal('DiscountPercentage', 5, 2)->default(0);
            $table->integer('MaxCapacity')->notNull();
            $table->integer('MinParticipants')->default(1);
            $table->integer('DifficultyLevel')->default(1)->comment('1=Easy, 2=Moderate, 3=Difficult');
            $table->decimal('AverageRating', 3, 2)->default(0);
            $table->integer('TotalRatings')->default(0);
            $table->string('MainImageURL')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsFeatured')->default(false);
            $table->foreignId('CreatedBy')->constrained('users', 'UserID');
            $table->timestamps();
        });

        // Tour Images table
        Schema::create('TourImages', function (Blueprint $table) {
            $table->id('ImageID');
            $table->foreignId('TourID')->constrained('Tours', 'TourID');
            $table->string('ImageURL')->notNull();
            $table->integer('DisplayOrder')->default(0);
            $table->string('Caption')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Tour Category Mapping table
        Schema::create('TourCategoryMapping', function (Blueprint $table) {
            $table->id('MappingID');
            $table->foreignId('TourID')->constrained('Tours', 'TourID');
            $table->foreignId('CategoryID')->constrained('TourCategories', 'CategoryID');
            $table->unique(['TourID', 'CategoryID']);
        });

        // Tour Schedules table
        Schema::create('TourSchedules', function (Blueprint $table) {
            $table->id('ScheduleID');
            $table->foreignId('TourID')->constrained('Tours', 'TourID');
            $table->date('StartDate')->notNull();
            $table->date('EndDate')->nullable();
            $table->time('StartTime')->nullable();
            $table->integer('AvailableSpots')->notNull();
            $table->decimal('Price', 10, 2)->nullable();
            $table->boolean('IsActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TourSchedules');
        Schema::dropIfExists('TourCategoryMapping');
        Schema::dropIfExists('TourImages');
        Schema::dropIfExists('Tours');
        Schema::dropIfExists('TourCategories');
    }
};
