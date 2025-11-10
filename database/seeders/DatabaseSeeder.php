<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Coach;
use App\Models\Payment;
use App\Models\Timetable;
use App\Models\User;
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

        Coach::create([
            'name' => 'Achmad Fauzal',
            'specialty' => 'Beginner Coaching',
            'photo_url' => 'https://example.com/photos/john_doe.jpg',
        ]);

        Coach::create([
            'name' => 'Ferizwan',
            'specialty' => 'Beginner Coaching',
            'photo_url' => 'https://example.com/photos/john_doe.jpg',
        ]);

        Coach::create([
            'name' => 'Rizky Ramadhan',
            'specialty' => 'Intermediate Coaching',
            'photo_url' => 'https://example.com/photos/jane_smith.jpg',
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
