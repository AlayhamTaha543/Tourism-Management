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
        // Travel Agencies table
        Schema::create('TravelAgencies', function (Blueprint $table) {
            $table->id('AgencyID');
            $table->string('AgencyName')->notNull();
            $table->text('Description')->nullable();
            $table->foreignId('LocationID')->constrained('Locations', 'LocationID');
            $table->decimal('AverageRating', 3, 2)->default(0);
            $table->integer('TotalRatings')->default(0);
            $table->string('LogoURL')->nullable();
            $table->string('Website')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Email')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->foreignId('ManagerID')->nullable()->constrained('users', 'UserID');
            $table->timestamps();
        });

        // Travel Packages table
        Schema::create('TravelPackages', function (Blueprint $table) {
            $table->id('PackageID');
            $table->foreignId('AgencyID')->constrained('TravelAgencies', 'AgencyID');
            $table->string('PackageName')->notNull();
            $table->text('Description')->nullable();
            $table->integer('DurationDays')->notNull();
            $table->decimal('BasePrice', 10, 2)->notNull();
            $table->decimal('DiscountPercentage', 5, 2)->default(0);
            $table->integer('MaxParticipants')->nullable();
            $table->decimal('AverageRating', 3, 2)->default(0);
            $table->integer('TotalRatings')->default(0);
            $table->string('MainImageURL')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsFeatured')->default(false);
            $table->timestamps();
        });

        // Package Destinations table
        Schema::create('PackageDestinations', function (Blueprint $table) {
            $table->id('DestinationID');
            $table->foreignId('PackageID')->constrained('TravelPackages', 'PackageID');
            $table->foreignId('LocationID')->constrained('Locations', 'LocationID');
            $table->integer('DayNumber')->notNull();
            $table->text('Description')->nullable();
            $table->string('Duration')->nullable();
        });

        // Package Inclusions table
        Schema::create('PackageInclusions', function (Blueprint $table) {
            $table->id('InclusionID');
            $table->foreignId('PackageID')->constrained('TravelPackages', 'PackageID');
            $table->integer('InclusionType')->notNull()->comment('1=Tour, 2=Hotel, 3=Transport, 4=Meal, 5=Other');
            $table->string('Description')->notNull();
            $table->boolean('IsHighlighted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PackageInclusions');
        Schema::dropIfExists('PackageDestinations');
        Schema::dropIfExists('TravelPackages');
        Schema::dropIfExists('TravelAgencies');
    }
};
