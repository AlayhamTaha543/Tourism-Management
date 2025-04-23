  <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Management Routes
Route::prefix('users')->group(function () {
    // Routes will be implemented here
});

// Location Management Routes
Route::prefix('locations')->group(function () {
    // Routes will be implemented here
});

// Tour Management Routes
Route::prefix('tours')->group(function () {
    // Routes will be implemented here
});

// Hotel Management Routes
Route::prefix('hotels')->group(function () {
    // Routes will be implemented here
});

// Restaurant Management Routes
Route::prefix('restaurants')->group(function () {
    // Routes will be implemented here
});

// Taxi Service Management Routes
Route::prefix('taxi-services')->group(function () {
    // Routes will be implemented here
});

// Travel Agency Management Routes
Route::prefix('travel-agencies')->group(function () {
    // Routes will be implemented here
});

// Booking Management Routes
Route::prefix('bookings')->group(function () {
    // Routes will be implemented here
});

// Payment Management Routes
Route::prefix('payments')->group(function () {
    // Routes will be implemented here
});

// Rating and Feedback Routes
Route::prefix('ratings')->group(function () {
    // Routes will be implemented here
});

// Promotions and Marketing Routes
Route::prefix('promotions')->group(function () {
    // Routes will be implemented here
});

// System Management Routes
Route::prefix('system')->group(function () {
    // Routes will be implemented here
});
