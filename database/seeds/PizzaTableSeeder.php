<?php

use App\User;
use App\Pizza;
use Illuminate\Database\Seeder;

class PizzaTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'              => 'admin',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('1111'),
        ]);

        Pizza::create([
            'name' => 'Margherita',
            'slug' => 'margherita',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella, and oregano',
            'image' => 'pizza00.jpg'
        ]);

        Pizza::create([
            'name' => 'Marinara',
            'slug' => 'marinara',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, garlic and basil',
            'image' => 'pizza01.jpg'
        ]);

        Pizza::create([
            'name' => 'Frutti di Mare',
            'slug' => 'frutti-di-mare',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce and seafood',
            'image' => 'pizza02.jpg'
        ]);

        Pizza::create([
            'name' => 'Crudo',
            'slug' => 'crudo',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella and Parma ham',
            'image' => 'pizza03.jpg'
        ]);

        Pizza::create([
            'name' => 'Capricciosa',
            'slug' => 'capricciosa',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella, ham, artichokes, mushrooms, and olives',
            'image' => 'pizza04.jpg'
        ]);

        Pizza::create([
            'name' => 'Schiacciata',
            'slug' => 'schiacciata',
            'price' => rand(100, 300),
            'description' => 'Olive oil and rosemary',
            'image' => 'pizza05.jpg'
        ]);

        Pizza::create([
            'name' => 'Tonno',
            'slug' => 'tonno',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella, tuna, and onions',
            'image' => 'pizza06.jpg'
        ]);

        Pizza::create([
            'name' => 'Rustica',
            'slug' => 'rustica',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella, gorgonzola cheese, and eggplants',
            'image' => 'pizza07.jpg'
        ]);

        Pizza::create([
            'name' => 'Funghi',
            'slug' => 'funghi',
            'price' => rand(100, 300),
            'description' => 'Tomato sauce, mozzarella, mushrooms, parsley and olive oil',
            'image' => 'pizza08.jpg'
        ]);
    }
}
