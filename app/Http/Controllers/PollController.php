<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::latest()->get();
        return view('polls.index', compact('polls'));
    }

    public function show(Poll $poll)
    {
        $poll->load('pollOptions');
        return view('polls.show', compact('poll'));
    }

    public function results(Poll $poll)
    {
        $poll->load('pollOptions');
        return view('polls.partials.results', compact('poll'));
    }
}
