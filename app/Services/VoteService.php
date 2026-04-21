<?php

namespace App\Services;

use App\Models\Vote;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VoteService
{
    public function submitVote($pollId, $optionId, $ipAddress)
    {
        return DB::transaction(function () use ($pollId, $optionId, $ipAddress) {
            $userId = Auth::id();
            $alreadyVoted = Vote::where('poll_id', $pollId)
                ->when($userId, function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }, function ($query) use ($ipAddress) {
                    $query->where('ip_address', $ipAddress);
                })
                ->exists();

            if ($alreadyVoted) {
                throw new \Exception('You have already voted.');
            }

            Vote::create([
                'poll_id' => $pollId,
                'poll_option_id' => $optionId,
                'user_id' => $userId,
                'ip_address' => $userId ? null : $ipAddress,
            ]);

            PollOption::where('id', $optionId)->increment('vote_count');

            return true;
        });
    }
}