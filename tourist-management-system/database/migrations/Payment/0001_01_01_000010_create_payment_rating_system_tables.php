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
        // Payments table
        Schema::create('Payments', function (Blueprint $table) {
            $table->id('PaymentID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->string('PaymentReference')->unique()->notNull();
            $table->decimal('Amount', 10, 2)->notNull();
            $table->dateTime('PaymentDate')->default(now());
            $table->integer('PaymentMethod')->notNull()->comment('1=Credit Card, 2=PayPal, 3=Bank Transfer');
            $table->string('TransactionID')->nullable();
            $table->integer('Status')->default(1)->comment('1=Pending, 2=Success, 3=Failed, 4=Refunded');
            $table->text('GatewayResponse')->nullable();
            $table->decimal('RefundAmount', 10, 2)->default(0);
            $table->dateTime('RefundDate')->nullable();
            $table->text('RefundReason')->nullable();
        });

        // Ratings table
        Schema::create('Ratings', function (Blueprint $table) {
            $table->id('RatingID');
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->foreignId('BookingID')->constrained('Bookings', 'BookingID');
            $table->integer('RatingType')->notNull()->comment('1=Tour, 2=Hotel, 3=Taxi, 4=Restaurant, 5=Package, 6=Guide, 7=Driver');
            $table->integer('EntityID')->notNull()->comment('TourID, HotelID, TaxiServiceID, RestaurantID, PackageID, GuideID, DriverID');
            $table->integer('Rating')->notNull();
            $table->text('Comment')->nullable();
            $table->dateTime('RatingDate')->default(now());
            $table->boolean('IsVisible')->default(true);
            $table->text('AdminResponse')->nullable();
            $table->unique(['UserID', 'BookingID', 'RatingType']);
        });

        // Feedback table
        Schema::create('Feedback', function (Blueprint $table) {
            $table->id('FeedbackID');
            $table->foreignId('UserID')->nullable()->constrained('users', 'UserID');
            $table->text('FeedbackText')->notNull();
            $table->dateTime('FeedbackDate')->default(now());
            $table->integer('FeedbackType')->notNull()->comment('1=App, 2=Service, 3=Other');
            $table->integer('Status')->default(1)->comment('1=Unread, 2=Read, 3=Responded');
            $table->text('ResponseText')->nullable();
            $table->dateTime('ResponseDate')->nullable();
            $table->foreignId('RespondedBy')->nullable()->constrained('users', 'UserID');
        });

        // Promotions table
        Schema::create('Promotions', function (Blueprint $table) {
            $table->id('PromotionID');
            $table->string('PromotionCode')->unique()->notNull();
            $table->text('Description')->nullable();
            $table->integer('DiscountType')->notNull()->comment('1=Percentage, 2=Fixed Amount');
            $table->decimal('DiscountValue', 10, 2)->notNull();
            $table->decimal('MinimumPurchase', 10, 2)->default(0);
            $table->dateTime('StartDate')->notNull();
            $table->dateTime('EndDate')->notNull();
            $table->integer('UsageLimit')->nullable();
            $table->integer('CurrentUsage')->default(0);
            $table->integer('ApplicableType')->nullable()->comment('1=All, 2=Tour, 3=Hotel, 4=Taxi, 5=Restaurant, 6=Package');
            $table->boolean('IsActive')->default(true);
            $table->foreignId('CreatedBy')->constrained('users', 'UserID');
            $table->dateTime('CreatedAt')->default(now());
        });

        // Wishlist table
        Schema::create('Wishlist', function (Blueprint $table) {
            $table->id('WishlistID');
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->integer('ItemType')->notNull()->comment('1=Tour, 2=Hotel, 3=Restaurant, 4=Package');
            $table->integer('ItemID')->notNull();
            $table->dateTime('AddedDate')->default(now());
            $table->unique(['UserID', 'ItemType', 'ItemID']);
        });

        // Notifications table
        Schema::create('Notifications', function (Blueprint $table) {
            $table->id('NotificationID');
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->string('Title')->notNull();
            $table->text('Message')->notNull();
            $table->integer('NotificationType')->notNull()->comment('1=Booking, 2=Payment, 3=Tour, 4=System');
            $table->integer('ReferenceID')->nullable();
            $table->boolean('IsRead')->default(false);
            $table->dateTime('CreatedAt')->default(now());
        });

        // User Sessions table
        Schema::create('UserSessions', function (Blueprint $table) {
            $table->id('SessionID');
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->string('SessionToken')->notNull();
            $table->string('IPAddress')->nullable();
            $table->string('DeviceInfo')->nullable();
            $table->dateTime('LoginTime')->default(now());
            $table->dateTime('LogoutTime')->nullable();
            $table->boolean('IsActive')->default(true);
        });

        // Audit Log table
        Schema::create('AuditLog', function (Blueprint $table) {
            $table->id('LogID');
            $table->foreignId('UserID')->nullable()->constrained('users', 'UserID');
            $table->string('EntityType')->notNull();
            $table->integer('EntityID')->notNull();
            $table->string('Action')->notNull();
            $table->text('OldValues')->nullable();
            $table->text('NewValues')->nullable();
            $table->string('IPAddress')->nullable();
            $table->dateTime('LogDate')->default(now());
        });

        // User Ranks table
        Schema::create('UserRanks', function (Blueprint $table) {
            $table->id('RankID');
            $table->foreignId('UserID')->constrained('users', 'UserID');
            $table->string('RankName')->nullable();
            $table->integer('PointsEarned')->nullable();
        });

        // Tour Translations table
        Schema::create('TourTranslations', function (Blueprint $table) {
            $table->id('TranslationID');
            $table->foreignId('TourID')->constrained('Tours', 'TourID');
            $table->string('LanguageCode');
            $table->text('TranslatedDescription');
        });

        // Partnerships table
        Schema::create('Partnerships', function (Blueprint $table) {
            $table->id('PartnershipID');
            $table->foreignId('GuideID')->nullable()->constrained('users', 'UserID');
            $table->foreignId('HotelID')->nullable()->constrained('Hotels', 'HotelID');
            $table->foreignId('RestaurantID')->nullable()->constrained('Restaurants', 'RestaurantID');
            $table->foreignId('TaxiServiceID')->nullable()->constrained('TaxiServices', 'TaxiServiceID');
            $table->decimal('DiscountPercentage', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Partnerships');
        Schema::dropIfExists('TourTranslations');
        Schema::dropIfExists('UserRanks');
        Schema::dropIfExists('AuditLog');
        Schema::dropIfExists('UserSessions');
        Schema::dropIfExists('Notifications');
        Schema::dropIfExists('Wishlist');
        Schema::dropIfExists('Promotions');
        Schema::dropIfExists('Feedback');
        Schema::dropIfExists('Ratings');
        Schema::dropIfExists('Payments');
    }
};
