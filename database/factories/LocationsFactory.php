<?php

namespace Database\Factories;

use App\Models\Locations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Locations>
 */
class LocationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Locations::class;

    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
        ];
    }
}
