<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // TourParticipants View
        DB::statement("CREATE VIEW TourParticipants AS
            SELECT T.TourID, U.FirstName, U.LastName
            FROM Tours T
            JOIN TourBookings TB ON T.TourID = TB.TourID
            JOIN Bookings B ON TB.BookingID = B.BookingID
            JOIN users U ON B.UserID = U.UserID");

        // HotelEarnings View
        DB::statement("CREATE VIEW HotelEarnings AS
            SELECT H.HotelID, SUM(P.Amount) AS TotalEarnings
            FROM Hotels H
            JOIN HotelBookings HB ON H.HotelID = HB.HotelID
            JOIN Bookings B ON HB.BookingID = B.BookingID
            JOIN Payments P ON B.BookingID = P.BookingID
            GROUP BY H.HotelID");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS HotelEarnings");
        DB::statement("DROP VIEW IF EXISTS TourParticipants");
    }
};
