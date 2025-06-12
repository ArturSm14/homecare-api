<?php

namespace Database\Factories\Attendance;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'symptoms' => fake()->optional(0.7)->sentence(),
            'status' => AttendanceStatus::PENDING,
        ];
    }
}
