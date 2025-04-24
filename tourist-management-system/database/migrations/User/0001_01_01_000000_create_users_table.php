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
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('Email')->unique()->notNull();
            $table->string('PasswordHash')->notNull();
            $table->string('PasswordSalt')->notNull();
            $table->string('FirstName')->notNull();
            $table->string('LastName')->notNull();
            $table->string('Phone')->nullable();
            $table->integer('CountryID')->nullable();
            $table->integer('UserType')->notNull()->comment('1=Client, 2=Admin, 3=Guide, 4=HotelManager, 5=TaxiAgent, 6=RestaurantManager, 7=TravelAgencyRep');
            $table->dateTime('RegistrationDate')->default(now());
            $table->dateTime('LastLoginDate')->nullable();
            $table->integer('Status')->default(1)->comment('1=Active, 0=Inactive');
            $table->string('ProfileImageURL')->nullable();
            $table->string('PreferredLanguage')->default('en');
            $table->boolean('IsEmailVerified')->default(false);
            $table->boolean('IsPhoneVerified')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
