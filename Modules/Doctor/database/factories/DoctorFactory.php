<?php

namespace Modules\Doctor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\App\Enum\Gender;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Models\Doctor;

class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'age' => $this->faker->numberBetween(1, 90),
            'gender' => $this->faker->randomElement(Gender::cases()),
            'password' => 'password', // will be hashed by the cast
            'is_active' => $this->faker->randomElement(ActiveEnum::cases()), // enum
        ];
    }
}

