@php
$totalVotes = $poll->pollOptions->sum('vote_count');
@endphp

@foreach($poll->pollOptions as $option)
    @php
        $percent = $totalVotes > 0 ? round(($option->vote_count / $totalVotes) * 100) : 0;
    @endphp

    <div class="mb-2">
        <div class="flex justify-between text-sm">
            <span>{{ $option->option_text }}</span>
            <span>{{ $percent }}%</span>
        </div>

        <div class="w-full bg-gray-200 rounded h-3">
            <div class="bg-blue-500 h-3 rounded" style="width: {{ $percent }}%"></div>
        </div>
    </div>
@endforeach