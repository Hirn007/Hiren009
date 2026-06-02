<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Show;
use App\Models\Seat;

class MovieTheaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample movies
        $movies = [
            [
                'title' => 'Inception',
                'description' => 'A skilled thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea.',
                'genre' => 'Sci-Fi, Thriller',
                'duration' => 148,
                'rating' => 'A',
                'language' => 'English',
                'release_date' => now()->subDays(30),
                'is_active' => true,
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on Gotham, Batman must accept one of the largest psychological and physical tests.',
                'genre' => 'Action, Crime, Drama',
                'duration' => 152,
                'rating' => 'A',
                'language' => 'English',
                'release_date' => now()->subDays(60),
                'is_active' => true,
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'genre' => 'Sci-Fi, Drama',
                'duration' => 169,
                'rating' => 'UA',
                'language' => 'English',
                'release_date' => now()->subDays(15),
                'is_active' => true,
            ],
            [
                'title' => 'Bollywood Romance',
                'description' => 'A modern love story set in Mumbai.',
                'genre' => 'Romance, Drama',
                'duration' => 135,
                'rating' => 'UA',
                'language' => 'Hindi',
                'release_date' => now()->addDays(5),
                'is_active' => true,
            ],
        ];

        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }

        // Create sample theaters
        $theaters = [
            [
                'name' => 'PVR Cinemas',
                'city' => 'Mumbai',
                'address' => 'High Street Phoenix, Mumbai',
                'total_screens' => 10,
            ],
            [
                'name' => 'IMAX Multiplex',
                'city' => 'Delhi',
                'address' => 'Connaught Place, New Delhi',
                'total_screens' => 8,
            ],
            [
                'name' => 'Cinepolis',
                'city' => 'Bangalore',
                'address' => 'UB City, Bangalore',
                'total_screens' => 12,
            ],
            [
                'name' => 'Inox',
                'city' => 'Mumbai',
                'address' => 'R City Mall, Mumbai',
                'total_screens' => 9,
            ],
        ];

        foreach ($theaters as $theaterData) {
            Theater::create($theaterData);
        }

        // Create shows and seats
        $movies = Movie::all();
        $theaters = Theater::all();

        foreach ($movies as $movie) {
            foreach ($theaters->take(2) as $theater) {
                for ($i = 0; $i < 3; $i++) {
                    $showDateTime = now()->addDays($i)->setHour(18)->setMinute(0);
                    
                    $show = Show::create([
                        'movie_id' => $movie->id,
                        'theater_id' => $theater->id,
                        'show_date_time' => $showDateTime,
                        'screen_number' => 'A' . ($i + 1),
                        'ticket_price' => 200,
                        'total_seats' => 144,
                        'available_seats' => 144,
                        'is_active' => true,
                    ]);

                    // Create seats for the show (12 rows x 12 seats)
                    $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
                    foreach ($rows as $row) {
                        for ($j = 1; $j <= 12; $j++) {
                            Seat::create([
                                'show_id' => $show->id,
                                'seat_number' => $row . $j,
                                'status' => 'available',
                            ]);
                        }
                    }
                }
            }
        }
    }
}
