<?php

namespace Modules\Doctor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\App\Enum\Gender;
use Modules\Core\app\Enums\UserStatusEnum;
use Modules\Doctor\Enums\BloodType;
use Modules\Doctor\Models\Patient;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(1, 90),
            'gender' => $this->faker->randomElement(Gender::cases()),
            'children' => $this->faker->numberBetween(0, 6),
            'work' => $this->faker->jobTitle(),
            'blood_type' => $this->faker->randomElement(BloodType::cases()), // enum
            'drug_allergies' => $this->faker->optional()->sentence(),
            'disabilities' => $this->faker->optional()->sentence(),
            'medical_history' => $this->faker->optional()->paragraph(),
            'surgical_history' => $this->faker->optional()->paragraph(),
            'accident_history' => $this->faker->optional()->paragraph(),
            'password' => 'password', // will be hashed by the cast
            'is_active' => $this->faker->randomElement(UserStatusEnum::cases()), // enum
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn()
            => [
            'is_active' => UserStatusEnum::DEACTIVATE,
        ]);
    }
}

