# Tourism-Management
# Tourism Management System
## Overview
Tourism Management System is a comprehensive web application built with Laravel that streamlines the management of tourism-related services. This platform integrates various tourism services including hotel bookings, restaurant reservations, tour packages, taxi services, and travel packages into a single, user-friendly interface.

## Features
### User Management
- User registration and authentication
- Role-based access control (Admin, Manager, Customer)
- User profile management
### Hotel Management
- Hotel listings with detailed information
- Room type management
- Room availability tracking
- Hotel amenities
- Booking management
### Restaurant Services
- Restaurant listings with details
- Menu categories and items
- Table reservation system
- Restaurant ratings and reviews
### Tour Management
- Tour packages with descriptions
- Tour scheduling
- Tour guide assignment
- Tour booking system
### Taxi Services
- Taxi service listings
- Vehicle type management
- Driver management
- Taxi booking system
### Travel Packages
- Comprehensive travel packages
- Package inclusions and destinations
- Package booking management
### Booking System
- Integrated booking for all services
- Booking status tracking
- Payment processing
- Cancellation management
### Rating and Review System
- User ratings for all services
- Review moderation
- Average rating calculation
## Technical Stack
- Framework : Laravel
- Database : MySQL
- Frontend : Blade templates, Bootstrap, JavaScript
- Authentication : Laravel's built-in authentication system
## Installation
1. Clone the repository:
```bash
git clone https://github.com/yourusername/Tourism-Management.git
cd Tourism-Management
 ```
```

2. Install dependencies:
```bash
composer install
npm install
 ```

3. Set up environment variables:
```bash
cp .env.example .env
php artisan key:generate
 ```

4. Configure your database in the .env file:
```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tourism_management
DB_USERNAME=root
DB_PASSWORD=
 ```

5. Run migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
 ```

6. Start the development server:
```bash
php artisan serve
 ```

## Project Structure
The project follows Laravel's MVC architecture:

- Models : Located in app/Models/
- Controllers : Located in app/Http/Controllers/
- Views : Located in resources/views/
- Routes : Defined in routes/web.php and routes/api.php
- Migrations : Located in database/migrations/
## License
This project is licensed under the MIT License - see the LICENSE file for details.