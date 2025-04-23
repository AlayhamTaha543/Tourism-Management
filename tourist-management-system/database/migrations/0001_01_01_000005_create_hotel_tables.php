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
        // Hotels table
        Schema::create('Hotels', function (Blueprint $table) {
            $table->id('HotelID');
            $table->string('HotelName')->notNull();
            $table->text('Description')->nullable();
            $table->foreignId('LocationID')->constrained('Locations', 'LocationID');
            $table->integer('StarRating')->nullable();
            $table->time('CheckInTime')->nullable();
            $table->time('CheckOutTime')->nullable();
            $table->decimal('AverageRating', 3, 2)->default(0);
            $table->integer('TotalRatings')->default(0);
            $table->string('MainImageURL')->nullable();
            $table->string('Website')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Email')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsFeatured')->default(false);
            $table->foreignId('ManagerID')->nullable()->constrained('users', 'UserID');
            $table->timestamps();
        });

        // Hotel Images table
        Schema::create('HotelImages', function (Blueprint $table) {
            $table->id('ImageID');
            $table->foreignId('HotelID')->constrained('Hotels', 'HotelID');
            $table->string('ImageURL')->notNull();
            $table->integer('DisplayOrder')->default(0);
            $table->string('Caption')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Hotel Amenities table
        Schema::create('HotelAmenities', function (Blueprint $table) {
            $table->id('AmenityID');
            $table->string('AmenityName')->notNull();
            $table->string('IconURL')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Hotel Amenity Mapping table
        Schema::create('HotelAmenityMapping', function (Blueprint $table) {
            $table->id('MappingID');
            $table->foreignId('HotelID')->constrained('Hotels', 'HotelID');
            $table->foreignId('AmenityID')->constrained('HotelAmenities', 'AmenityID');
            $table->unique(['HotelID', 'AmenityID']);
        });

        // Room Types table
        Schema::create('RoomTypes', function (Blueprint $table) {
            $table->id('RoomTypeID');
            $table->foreignId('HotelID')->constrained('Hotels', 'HotelID');
            $table->string('RoomTypeName')->notNull();
            $table->text('Description')->nullable();
            $table->integer('MaxOccupancy')->notNull();
            $table->decimal('BasePrice', 10, 2)->notNull();
            $table->decimal('DiscountPercentage', 5, 2)->default(0);
            $table->string('Size')->nullable();
            $table->string('BedType')->nullable();
            $table->string('ImageURL')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Room Availability table
        Schema::create('RoomAvailability', function (Blueprint $table) {
            $table->id('AvailabilityID');
            $table->foreignId('RoomTypeID')->constrained('RoomTypes', 'RoomTypeID');
            $table->date('Date')->notNull();
            $table->integer('AvailableRooms')->notNull();
            $table->decimal('Price', 10, 2)->nullable();
            $table->boolean('IsBlocked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RoomAvailability');
        Schema::dropIfExists('RoomTypes');
        Schema::dropIfExists('HotelAmenityMapping');
        Schema::dropIfExists('HotelAmenities');
        Schema::dropIfExists('HotelImages');
        Schema::dropIfExists('Hotels');
    }
};
