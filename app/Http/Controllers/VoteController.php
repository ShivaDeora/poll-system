<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoteService;
use App\Models\Poll;

class VoteController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        try {
            $this->voteService->submitVote(
                $poll->id,
                $request->option_id,
                $request->ip()
            );

            return response()->json([
                'message' => 'Vote submitted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
