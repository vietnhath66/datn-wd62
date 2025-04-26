<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::factory()->create([
            'role_id' => 1,
            'name' => 'Trường no 1',
            'email' => 'truongno1@gmail.com',
            'password' => '0123456',
            'phone' => '01234562222'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 2,
            'name' => 'Hoàng',
            'email' => 'hoang@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 3,
            'name' => 'Hoàng 2',
            'email' => 'hoang2@gmail.com',
            'password' => '0123456',
            'phone' => '1234567890'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Hoàng 3',
            'email' => 'hoang3@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Nhật',
            'email' => 'nhat@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Tú',
            'email' => 'tu@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Hiếu',
            'email' => 'hieu@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Dũng',
            'email' => 'dung@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
        \App\Models\User::factory()->create([
            'role_id' => 4,
            'name' => 'Nam',
            'email' => 'Nam@gmail.com',
            'password' => '0123456',
            'phone' => '0987654321'
        ]);
    }
}
