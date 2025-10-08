<?php

namespace Modules\Doctor\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Core\App\Enums\Gender;
use Modules\Core\app\Models\Country;
use Modules\Doctor\Enums\BloodType;
use Modules\Doctor\Enums\MaritalStatus;
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
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'work' => $this->faker->jobTitle(),
            'blood_type' => $this->faker->randomElement(BloodType::cases()), // enum
            'marital_status' => $this->faker->randomElement(MaritalStatus::cases()), // enum
            'drug_allergies' => $this->faker->sentence(3),
            'disabilities' => $this->faker->sentence(3),
            'medical_history' => $this->faker->sentence(3),
            'surgical_history' => $this->faker->sentence(3),
            'accident_history' => $this->faker->sentence(3),
            'password' => 'password', // will be hashed by the cast
            'nationality_id' => Country::inRandomOrder()->value('id'),
            'is_active' => $this->faker->randomElement(ActiveEnum::cases()), // enum
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn()
            => [
            'is_active' => ActiveEnum::INACTIVE,
        ]);
    }

    /*public function configure(): PatientFactory
    {
        return $this->afterCreating(function (Patient $patient) {
            $clinics = Clinic::query()
                ->inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');
            $patient->clinics()->attach($clinics);
        });
    }*/
}

