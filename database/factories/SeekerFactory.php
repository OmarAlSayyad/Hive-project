<?php

namespace Database\Factories;

use App\Models\Communication;
use App\Models\Locations;
use App\Models\Seeker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seeker>
 */
class SeekerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Seeker::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['role' => 'seeker'])->id,
            'location_id' => Locations::factory()->create()->id,
            'communication_id' => Communication::factory()->create()->id,
            'rating' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'cv' => $this->faker->filePath(),
            'level' => $this->faker->randomElement(['Beginner', 'Middle', 'Advanced', 'Expert']),
            'on_time_percentage' => $this->faker->randomFloat(2, 0, 100),
            'bio' => $this->faker->paragraph(),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Not_determined']),
            'picture' => $this->faker->imageUrl(),
            'hourly_rate' => $this->faker->randomFloat(2, 10, 100),
            'birth_date' => $this->faker->date(),
        ];
    }
}
