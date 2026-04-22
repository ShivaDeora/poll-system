<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('admin.polls.index', compact('polls'));
    }

    public function create()
    {
        return view('admin.polls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            $poll = Poll::create([
                'question' => $request->question,
                'created_by' => auth()->id(),
            ]);

            foreach ($request->options as $option) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'option_text' => $option,
                ]);
            }
        });

        return redirect('/admin/polls')->with('success', 'Poll created!');
    }

    public function show(Poll $poll)
    {
        $poll->load('pollOptions');
        $totalVotes = $poll->pollOptions->sum('vote_count');
        return view('admin.polls.show', compact('poll', 'totalVotes'));
    }
}
