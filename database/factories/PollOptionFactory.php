<?php

namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

class PollOptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'poll_id'     => Poll::factory(),
            'option_text' => $this->faker->words(3, true),
            'vote_count'  => 0,
        ];
    }
}
