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
        // Bookings table
        Schema::create('Bookings', function (Blueprint $table) {
            $table->id('BookingID');
            $table->string('BookingReference')->unique()->notNull();
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->integer('BookingType')->notNull()->comment('1=Tour, 2=Hotel, 3=Taxi, 4=Restaurant, 5=Package');
            $table->dateTime('BookingDate')->default(now());
            $table->integer('Status')->default(1)->comment('1=Pending, 2=Confirmed, 3=Cancelled, 4=Completed');
            $table->decimal('TotalPrice', 10, 2)->notNull();
            $table->decimal('DiscountAmount', 10, 2)->default(0);
            $table->integer('PaymentStatus')->default(1)->comment('1=Pending, 2=Paid, 3=Refunded, 4=Failed');
            $table->text('SpecialRequests')->nullable();
            $table->text('CancellationReason')->nullable();
            $table->dateTime('LastUpdated')->default(now());
        });

        // Tour Bookings table
        Schema::create('TourBookings', function (Blueprint $table) {
            $table->id('TourBookingID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->foreignId('TourID')->constrained('Tours', 'TourID');
            $table->foreignId('ScheduleID')->constrained('TourSchedules', 'ScheduleID');
            $table->integer('NumberOfAdults')->notNull()->default(1);
            $table->integer('NumberOfChildren')->notNull()->default(0);
            $table->foreignId('GuideID')->nullable()->constrained('users', 'UserID');
        });

        // Hotel Bookings table
        Schema::create('HotelBookings', function (Blueprint $table) {
            $table->id('HotelBookingID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->foreignId('HotelID')->constrained('Hotels', 'HotelID');
            $table->foreignId('RoomTypeID')->constrained('RoomTypes', 'RoomTypeID');
            $table->date('CheckInDate')->notNull();
            $table->date('CheckOutDate')->notNull();
            $table->integer('NumberOfRooms')->notNull()->default(1);
            $table->integer('NumberOfGuests')->notNull();
        });

        // Restaurant Bookings table
        Schema::create('RestaurantBookings', function (Blueprint $table) {
            $table->id('RestaurantBookingID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->foreignId('RestaurantID')->constrained('Restaurants', 'RestaurantID');
            $table->foreignId('TableID')->nullable()->constrained('RestaurantTables', 'TableID');
            $table->date('ReservationDate')->notNull();
            $table->time('ReservationTime')->notNull();
            $table->integer('NumberOfGuests')->notNull();
            $table->integer('Duration')->default(120)->comment('Duration in minutes');
        });

        // Taxi Bookings table
        Schema::create('TaxiBookings', function (Blueprint $table) {
            $table->id('TaxiBookingID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->foreignId('TaxiServiceID')->constrained('TaxiServices', 'TaxiServiceID');
            $table->foreignId('VehicleTypeID')->constrained('VehicleTypes', 'VehicleTypeID');
            $table->foreignId('PickupLocationID')->constrained('Locations', 'LocationID');
            $table->foreignId('DropoffLocationID')->constrained('Locations', 'LocationID');
            $table->dateTime('PickupDateTime')->notNull();
            $table->decimal('EstimatedDistance', 10, 2)->nullable();
            $table->foreignId('DriverID')->nullable()->constrained('Drivers', 'DriverID');
            $table->foreignId('VehicleID')->nullable()->constrained('Vehicles', 'VehicleID');
        });

        // Package Bookings table
        Schema::create('PackageBookings', function (Blueprint $table) {
            $table->id('PackageBookingID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->foreignId('PackageID')->constrained('TravelPackages', 'PackageID');
            $table->date('StartDate')->notNull();
            $table->integer('NumberOfAdults')->notNull()->default(1);
            $table->integer('NumberOfChildren')->notNull()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PackageBookings');
        Schema::dropIfExists('TaxiBookings');
        Schema::dropIfExists('RestaurantBookings');
        Schema::dropIfExists('HotelBookings');
        Schema::dropIfExists('TourBookings');
        Schema::dropIfExists('Bookings');
    }
};
