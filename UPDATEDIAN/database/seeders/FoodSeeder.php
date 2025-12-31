<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Food;
use App\Models\User;
use App\Models\Category;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the admin from AdminSeeder
        $admin = User::where('email', 'admin1@gmail.com')->first();
        if (!$admin) {
             $admin = User::create([
                'name' => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'password' => bcrypt('admin1'),
                'role' => 'admin',
            ]);
        }

        // Ensure categories exist
        $makanan = Category::firstOrCreate(['name' => 'Makanan'], ['slug' => 'makanan', 'description' => 'Aneka Makanan']);
        $minuman = Category::firstOrCreate(['name' => 'Minuman'], ['slug' => 'minuman', 'description' => 'Aneka Minuman']);

        Food::create([
            'user_id' => $admin->id,
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng lezat dengan telur mata sapi, kerupuk, dan sayuran segar.',
            'image' => 'products/nasi_goreng.png',
            'price' => 25000,
            'category_id' => $makanan->id,
        ]);

        Food::create([
            'user_id' => $admin->id,
            'name' => 'Mie Goreng Ayam',
            'description' => 'Mie goreng dengan potongan ayam, sayuran, dan bumbu spesial.',
            'image' => 'products/mie_goreng.png',
            'price' => 22000,
            'category_id' => $makanan->id,
        ]);

        Food::create([
            'user_id' => $admin->id,
            'name' => 'Es Teh Manis',
            'description' => 'Minuman teh manis dingin yang menyegarkan.',
            'image' => 'products/es_teh_manis.png',
            'price' => 5000,
            'category_id' => $minuman->id,
        ]);
    }
}
