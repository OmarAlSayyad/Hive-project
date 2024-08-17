<?php

namespace Database\Factories;

use App\Models\Communication;
use App\Models\Company;
use App\Models\Locations;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'company'])->id,
            'location_id' => Locations::factory()->create()->id,  // Fixed the class name to `Location`
            'communication_id' => Communication::factory()->create()->id,
            'rating' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'picture' => $this->faker->imageUrl(),
            'industry' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'approved' => $this->faker->boolean(),
        ];
    }
}
