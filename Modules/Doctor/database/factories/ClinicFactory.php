<?php

namespace Modules\Doctor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Doctor\Models\Clinic;

class ClinicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Clinic::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}

