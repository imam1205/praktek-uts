<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Admin Dummy',
                'email' => 'admin@dummy.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        $dummyPosts = [
            [
                'title' => 'Panduan Lengkap Liburan ke Bali',
                'location' => 'Bali, Indonesia',
                'body' => 'Bali selalu menjadi destinasi impian. Dari pantai Kuta hingga Ubud yang tenang, selalu ada hal menarik yang bisa dieksplor.',
                'category' => 'Panduan',
                'status' => 'published',
            ],
            [
                'title' => 'Menjelajah Keindahan Gunung Bromo',
                'location' => 'Jawa Timur',
                'body' => 'Melihat matahari terbit di Bromo adalah pengalaman tak terlupakan. Pastikan Anda membawa jaket tebal karena suhu sangat dingin.',
                'category' => 'Petualangan',
                'status' => 'published',
            ],
            [
                'title' => 'Wisata Kuliner di Jogja',
                'location' => 'Yogyakarta',
                'body' => 'Gudeg, Bakmi Jawa, dan Kopi Joss. Jogja bukan hanya kota pelajar, tapi juga surga bagi para pecinta kuliner.',
                'category' => 'Kuliner',
                'status' => 'published',
            ]
        ];

        foreach ($dummyPosts as $index => $post) {
            \App\Models\Post::create([
                'title' => $post['title'],
                'slug' => \Illuminate\Support\Str::slug($post['title']) . '-' . time() . '-' . $index,
                'location' => $post['location'],
                'body' => $post['body'],
                'category' => $post['category'],
                'status' => $post['status'],
                'user_id' => $admin->id,
                'views' => rand(10, 500)
            ]);
        }
    }
}
