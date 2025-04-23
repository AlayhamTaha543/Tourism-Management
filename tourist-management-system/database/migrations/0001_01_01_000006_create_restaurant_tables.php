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
        // Restaurants table
        Schema::create('Restaurants', function (Blueprint $table) {
            $table->id('RestaurantID');
            $table->string('RestaurantName')->notNull();
            $table->text('Description')->nullable();
            $table->foreignId('LocationID')->constrained('Locations', 'LocationID');
            $table->string('Cuisine')->nullable();
            $table->integer('PriceRange')->nullable()->comment('1=Inexpensive, 2=Moderate, 3=Expensive, 4=Very Expensive');
            $table->time('OpeningTime')->nullable();
            $table->time('ClosingTime')->nullable();
            $table->decimal('AverageRating', 3, 2)->default(0);
            $table->integer('TotalRatings')->default(0);
            $table->string('MainImageURL')->nullable();
            $table->string('Website')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Email')->nullable();
            $table->boolean('HasReservation')->default(true);
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsFeatured')->default(false);
            $table->foreignId('ManagerID')->nullable()->constrained('users', 'UserID');
            $table->timestamps();
        });

        // Restaurant Images table
        Schema::create('RestaurantImages', function (Blueprint $table) {
            $table->id('ImageID');
            $table->foreignId('RestaurantID')->constrained('Restaurants', 'RestaurantID');
            $table->string('ImageURL')->notNull();
            $table->integer('DisplayOrder')->default(0);
            $table->string('Caption')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Menu Categories table
        Schema::create('MenuCategories', function (Blueprint $table) {
            $table->id('CategoryID');
            $table->foreignId('RestaurantID')->constrained('Restaurants', 'RestaurantID');
            $table->string('CategoryName')->notNull();
            $table->text('Description')->nullable();
            $table->integer('DisplayOrder')->default(0);
            $table->boolean('IsActive')->default(true);
        });

        // Menu Items table
        Schema::create('MenuItems', function (Blueprint $table) {
            $table->id('ItemID');
            $table->foreignId('CategoryID')->constrained('MenuCategories', 'CategoryID');
            $table->string('ItemName')->notNull();
            $table->text('Description')->nullable();
            $table->decimal('Price', 10, 2)->notNull();
            $table->boolean('IsVegetarian')->default(false);
            $table->boolean('IsVegan')->default(false);
            $table->boolean('IsGlutenFree')->default(false);
            $table->integer('Spiciness')->nullable()->comment('0=Not Spicy, 1=Mild, 2=Medium, 3=Hot');
            $table->string('ImageURL')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsFeatured')->default(false);
        });

        // Restaurant Tables table
        Schema::create('RestaurantTables', function (Blueprint $table) {
            $table->id('TableID');
            $table->foreignId('RestaurantID')->constrained('Restaurants', 'RestaurantID');
            $table->string('TableNumber')->notNull();
            $table->integer('Capacity')->notNull();
            $table->string('Location')->nullable()->comment('Indoor, Outdoor, Private');
            $table->boolean('IsActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RestaurantTables');
        Schema::dropIfExists('MenuItems');
        Schema::dropIfExists('MenuCategories');
        Schema::dropIfExists('RestaurantImages');
        Schema::dropIfExists('Restaurants');
    }
};
