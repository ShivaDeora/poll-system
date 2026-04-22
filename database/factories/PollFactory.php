<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PollFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question'   => $this->faker->sentence(6, true) . '?',
            'created_by' => User::factory(),
            'uuid'       => (string) Str::uuid(),
        ];
    }
}
