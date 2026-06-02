# BookMyShow - Laravel Movie Ticket Booking Platform

A full-featured movie ticket booking platform built with Laravel, inspired by BookMyShow. Users can browse movies, select theaters, choose seats, and book tickets online.

## Features

✅ **Movie Listings** - Browse available movies with details
✅ **Theater & Show Management** - View theaters and available shows
✅ **Seat Selection** - Interactive seat map for selecting tickets
✅ **Booking System** - Complete booking flow with confirmation
✅ **User Authentication** - Secure login and registration
✅ **Booking History** - View and manage user bookings
✅ **Responsive Design** - Mobile-friendly interface with Tailwind CSS

## Tech Stack

- **Framework**: Laravel 11+
- **Database**: MySQL (or any Laravel-supported database)
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel's built-in authentication

## Installation & Setup

### Prerequisites

- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & npm (for Vite/asset compilation)

### Step 1: Install Dependencies

```bash
composer install
npm install
```

### Step 2: Configure Environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### Step 3: Database Setup

Update your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookmyshow
DB_USERNAME=root
DB_PASSWORD=
```

Create database:

```bash
mysql -u root -p
CREATE DATABASE bookmyshow;
EXIT;
```

### Step 4: Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed
```

This will create all tables and seed sample data including:
- 4 sample movies
- 4 sample theaters
- Multiple shows per movie/theater
- 144 seats per show (12 rows × 12 seats)
- Test user account

### Step 5: Build Frontend Assets

```bash
npm run dev
```

Or for production:

```bash
npm run build
```

### Step 6: Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Testing

### Default Test Credentials

**Email**: test@example.com  
**Password**: password

### Sample Movies

1. **Inception** - English, Sci-Fi/Thriller
2. **The Dark Knight** - English, Action/Crime/Drama
3. **Interstellar** - English, Sci-Fi/Drama
4. **Bollywood Romance** - Hindi, Romance/Drama

## Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── MovieController.php
│   │       ├── ShowController.php
│   │       └── BookingController.php
│   └── Models/
│       ├── Movie.php
│       ├── Theater.php
│       ├── Show.php
│       ├── Seat.php
│       └── Booking.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── MovieTheaterSeeder.php
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── movies/
│       ├── shows/
│       └── bookings/
├── routes/
│   └── web.php
└── config/
```

## Database Schema

### Movies Table
```
id, title, description, genre, duration, rating, poster_url, language, release_date, is_active
```

### Theaters Table
```
id, name, city, address, total_screens
```

### Shows Table
```
id, movie_id, theater_id, show_date_time, screen_number, ticket_price, total_seats, available_seats, is_active
```

### Seats Table
```
id, show_id, seat_number, status (available/booked/blocked)
```

### Bookings Table
```
id, user_id, show_id, seat_numbers (JSON), total_seats, total_price, status, booking_reference
```

## Key Routes

### Public Routes
- `GET /` - Home page
- `GET /movies` - List all movies
- `GET /movies/{id}` - Movie details with shows
- `GET /shows/{id}/seats` - Seat selection page

### Authenticated Routes
- `GET /bookings/create/{show_id}` - Booking review
- `POST /bookings/store/{show_id}` - Confirm booking
- `GET /bookings/{id}/confirmation` - Booking confirmation
- `GET /my-bookings` - User's booking history

## Features Explanation

### 1. Movie Listing
- Browse all active movies
- View movie details (genre, rating, duration, language)
- See available shows for each movie

### 2. Show Details
- Shows grouped by date
- Display theater name, location, screen number
- Show seat availability percentage
- Display ticket price

### 3. Seat Selection
- Interactive seat map with visual feedback
- Seats grouped by rows (A-L)
- Real-time booking summary
- Dynamic price calculation with taxes

### 4. Booking Flow
1. Select seats → Review → Confirm → Get booking reference
2. Automatic seat status update (available → booked)
3. Theater available seats count updated
4. Booking reference format: `BMS + 8 random characters`

### 5. Price Calculation
- Ticket Price × Number of Seats
- GST: 18% of ticket price
- Convenience Charges: 2% of ticket price
- Total = Subtotal + GST + Charges

### 6. Booking History
- View all past and upcoming bookings
- Booking status (Confirmed/Pending/Cancelled)
- Complete show and seat information
- Price breakdown for each booking

## Authentication

- Uses Laravel's built-in authentication scaffolding
- Users register with name, email, and password
- Login required for bookings
- Authenticated users can view booking history
- Session-based authentication

## Customization

### Add More Movies
```bash
php artisan tinker
```

```php
App\Models\Movie::create([
    'title' => 'Your Movie',
    'description' => 'Description',
    'genre' => 'Genre',
    'duration' => 120,
    'rating' => 'UA',
    'language' => 'English',
    'release_date' => now(),
    'is_active' => true,
]);
```

### Modify Seat Layout
Edit `database/seeders/MovieTheaterSeeder.php` to change:
- Number of rows
- Seats per row
- Seat naming convention

### Change Pricing
Update `ticket_price` in:
1. Show controller
2. Database seeder
3. Seat selection view

## Future Enhancements

- [ ] Payment gateway integration (Razorpay, Stripe)
- [ ] Email notifications for bookings
- [ ] Admin dashboard for theater management
- [ ] Advanced filtering (ratings, languages, genres)
- [ ] User reviews and ratings
- [ ] Promotional codes and discounts
- [ ] Seat blocking for maintenance
- [ ] Cancellation and refund system
- [ ] Real-time seat availability updates (WebSockets)
- [ ] Mobile app

## API Endpoints (for future mobile app)

The project is ready to be extended with API endpoints:

- `GET /api/movies` - Get all movies
- `GET /api/shows/{movie_id}` - Get shows for a movie
- `GET /api/shows/{show_id}/seats` - Get seat information
- `POST /api/bookings` - Create a booking

## Troubleshooting

### Database Migration Errors
```bash
php artisan migrate:refresh
php artisan db:seed
```

### Asset Not Found
```bash
npm install
npm run dev
```

### Session Errors
Clear cache and config:
```bash
php artisan cache:clear
php artisan config:clear
php artisan auth:clear-resets
```

## Support & Contributing

For issues or contributions, please reach out or submit a pull request.

## License

This project is open-source and available under the MIT license.

---

**Built with ❤️ using Laravel**
