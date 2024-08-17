<?php

namespace Database\Factories;

use App\Models\Communication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Communication>
 */
class CommunicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Communication::class;

    public function definition()
    {
        return [
            'mobile_phone' => $this->faker->phoneNumber(),
            'line_phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'linkedin_account' => $this->faker->url(),
            'github_account' => $this->faker->url(),
            'facebook_account' => $this->faker->url(),
        ];
    }
}
