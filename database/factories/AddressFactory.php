<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    public function definition(): array
    {
        $city = $this->faker->city;
        $street = $this->faker->streetName;
        $house = $this->faker->buildingNumber;
        $title = "$city, $street, $house";
        return [
            'title' => $title,
            'city' => $city,
            'street' => $street,
            'house_number' => $house,
            'latitude' => $this->faker->latitude(54, 56),
            'longitude' => $this->faker->longitude(36, 38),
        ];
    }
} 