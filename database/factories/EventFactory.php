<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        // Массив с именами локальных изображений
        $images = [
            'event1.jpg',
        ];
        
        return [
            'title' => fake()->sentence(3),
            'age_limit' => fake()->numberBetween(0, 18),
            'date_start' => fake()->dateTimeBetween('now', '+1 year'),
            'date_end' => fake()->dateTimeBetween('+1 day', '+1 year'),
            'description' => fake()->paragraph(3),
            'preview_image' => 'events/' . fake()->randomElement($images),
            'main_image' => 'events/' . fake()->randomElement($images),
            'price' => fake()->randomFloat(2, 0, 1000),
            'max_participants' => fake()->numberBetween(10, 100),
            'status' => fake()->randomElement(['active', 'cancelled', 'completed']),
            'user_id' => User::inRandomOrder()->first()->id,
            'address_id' => Address::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
} 