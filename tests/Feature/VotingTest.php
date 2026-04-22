<?php

namespace Tests\Feature;

use App\Events\VoteUpdated;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class VotingTest extends TestCase
{
    use RefreshDatabase;

    private function createPollWithOptions(int $optionCount = 2): array
    {
        $poll = Poll::factory()->create();
        $options = PollOption::factory()->count($optionCount)->create(['poll_id' => $poll->id]);
        return [$poll, $options];
    }

    private function userRole(): Role
    {
        return Role::firstOrCreate(['slug' => 'user'], ['name' => 'User']);
    }

    public function test_authenticated_user_can_vote(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions();
        $user = User::factory()->create(['role_id' => $this->userRole()->id]);

        $response = $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $options->first()->id,
        ]);

        $response->assertOk()->assertJson(['message' => 'Vote submitted successfully']);
        $this->assertDatabaseHas('votes', ['poll_id' => $poll->id, 'user_id' => $user->id]);
        $this->assertEquals(1, $options->first()->fresh()->vote_count);
    }

    public function test_guest_can_vote_using_ip(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions();

        $response = $this->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $options->first()->id,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('votes', ['poll_id' => $poll->id, 'user_id' => null]);
    }

    public function test_authenticated_user_cannot_vote_twice(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions();
        $user = User::factory()->create(['role_id' => $this->userRole()->id]);

        $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $options->first()->id,
        ]);

        $response = $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $options->last()->id,
        ]);

        $response->assertStatus(422)->assertJson(['error' => 'You have already voted.']);
        $this->assertCount(1, Vote::where('poll_id', $poll->id)->get());
    }

    public function test_guest_cannot_vote_twice_from_same_ip(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions();

        $this->post("/poll/{$poll->uuid}/vote", ['option_id' => $options->first()->id]);

        $response = $this->post("/poll/{$poll->uuid}/vote", ['option_id' => $options->last()->id]);

        $response->assertStatus(422)->assertJson(['error' => 'You have already voted.']);
        $this->assertCount(1, Vote::where('poll_id', $poll->id)->get());
    }

    public function test_vote_count_increments_on_selected_option_only(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions(3);
        $user = User::factory()->create(['role_id' => $this->userRole()->id]);
        $target = $options->get(1);

        $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $target->id,
        ]);

        $this->assertEquals(1, $target->fresh()->vote_count);
        $this->assertEquals(0, $options->first()->fresh()->vote_count);
        $this->assertEquals(0, $options->last()->fresh()->vote_count);
    }

    public function test_vote_broadcasts_vote_updated_event(): void
    {
        Event::fake();

        [$poll, $options] = $this->createPollWithOptions();
        $user = User::factory()->create(['role_id' => $this->userRole()->id]);

        $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => $options->first()->id,
        ]);

        Event::assertDispatched(VoteUpdated::class, function ($event) use ($poll) {
            return $event->poll->id === $poll->id;
        });
    }

    public function test_vote_requires_valid_option(): void
    {
        [$poll] = $this->createPollWithOptions();
        $user = User::factory()->create(['role_id' => $this->userRole()->id]);

        $response = $this->actingAs($user)->post("/poll/{$poll->uuid}/vote", [
            'option_id' => 99999,
        ]);

        $response->assertSessionHasErrors(['option_id']);
    }
}
