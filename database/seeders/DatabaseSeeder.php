<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Coach;
use App\Models\Payment;
use App\Models\Photo;
use App\Models\Timetable;
use App\Models\User;
use App\Models\Video;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            "name" => "Tegar Santoso",
            "email" => "user@gmail.com",
            "password" => "rahasia",
            "role" => "user",
            "jenis_kelamin" => "L",
            "telepon" => "0879076582341"
        ]);

        User::create([
            "name" => "Tegar Santoso",
            "email" => "admin@gmail.com",
            "password" => "rahasia",
            "role" => 'admin',
            "jenis_kelamin" => "L",
            "telepon" => "0879076582341"
        ]);

        Photo::create([
            'title' => 'Photo 1',
            'content' => 'Photo 1.',
            'img' => '/assets/images/photo (1).png',
        ]);

        Photo::create([
            'title' => 'Photo 2',
            'content' => 'Photo 2.',
            'img' => '/assets/images/photo (2).png',
        ]);

        Photo::create([
            'title' => 'Photo 3',
            'content' => 'Photo 3.',
            'img' => '/assets/images/photo (3).png',
        ]);

        Photo::create([
            'title' => 'Photo 4',
            'content' => 'Photo 4.',
            'img' => '/assets/images/photo (4).png',
        ]);

        Photo::create([
            'title' => 'Photo 5',
            'content' => 'Photo 5.',
            'img' => '/assets/images/photo (5).png',
        ]);

        Video::create([
            'title' => 'Video 1',
            'content' => 'Video 1.',
            'video_path' => '/assets/videos/video (1).mp4',
            'type' => 'local',
        ]);

        Video::create([
            'title' => 'Video 2',
            'content' => 'Video 2.',
            'video_path' => '/assets/videos/video (2).mp4',
            'type' => 'local',
        ]);

        Video::create([
            'title' => 'Video 3',
            'content' => 'Video 3.',
            'video_path' => '/assets/videos/video (3).mp4',
            'type' => 'local',
        ]);

        Video::create([
            'title' => 'Video 4',
            'content' => 'Video 4.',
            'video_path' => '/assets/videos/video (4).mp4',
            'type' => 'local',
        ]);

        Video::create([
            'title' => 'Video 5',
            'content' => 'Video 5.',
            'video_path' => '/assets/videos/video (5).mp4',
            'type' => 'local',
        ]);
        Coach::create([
            'name' => 'Achmad Fauzal',
            'specialty' => 'Beginner Coaching',
            'photo_url' => 'https://example.com/photos/john_doe.webp',
        ]);

        Coach::create([
            'name' => 'Ferizwan',
            'specialty' => 'Beginner Coaching',
            'photo_url' => 'https://example.com/photos/john_doe.webp',
        ]);

        Coach::create([
            'name' => 'Rizky Ramadhan',
            'specialty' => 'Intermediate Coaching',
            'photo_url' => 'https://example.com/photos/jane_smith.webp',
        ]);

        Timetable::create([
            'coach_id' => 1,
            'date' => '2023-12-01',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'level' => 'Beginner',
            'price' => '100000',
            'max_slots' => '5',
        ]);

        Timetable::create([
            'coach_id' => 2,
            'date' => '2023-12-04',
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
            'level' => 'Beginner',
            'price' => '100000',
            'max_slots' => '5',
        ]);

        Timetable::create([
            'coach_id' => 3,
            'date' => now()->addDays(3)->format('Y-m-d'),
            'start_time' => '14:00:00',
            'end_time' => '15:00:00',
            'level' => 'Intermediate',
            'price' => '150000',
            'max_slots' => '5',
        ]);

        Booking::create([
            'timetable_id' => 1,
            'user_id' => 1,
            'guest_name' => 'Tegar Santoso',
            'guest_phone' => '0879076582341',
            'person_count' => 1,
            'notes' => 'Seeder booking',
        ]);

        Payment::create([
            'booking_id' => 1,
            'payment_method' => 'credit_card',
            'gross_amount' => 100000,
            'status' => 'paid',
            'payment_code' => 'PAY123456',
            'order_id' => 'ORDER123456',
            'payment_url' => 'https://paymentgateway.com/pay/PAY123456',
            'paid_at' => now(),
            'expired_at' => now()->addHours(2),
            'settlement_time' => now(),
            'response_payload' => [
                'transaction_id' => 'TXN123456',
                'payment_status' => 'success',
            ],
        ]);
    }
}
