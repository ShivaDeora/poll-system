<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Results</h2>
            <a href="{{ url('/admin/polls') }}" class="text-sm text-gray-500 hover:underline">&larr; All Polls</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $poll->question }}</h3>
            <p class="text-sm text-gray-500 mb-6">{{ $totalVotes }} total {{ $totalVotes === 1 ? 'vote' : 'votes' }}</p>

            @foreach($poll->pollOptions as $option)
                @php
                    $percent = $totalVotes > 0 ? round(($option->vote_count / $totalVotes) * 100) : 0;
                @endphp

                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-800">{{ $option->option_text }}</span>
                        <span class="text-gray-500">{{ $option->vote_count }} {{ $option->vote_count === 1 ? 'vote' : 'votes' }} &middot; {{ $percent }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded h-4">
                        <div class="bg-blue-500 h-4 rounded transition-all duration-300" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 pt-4 border-t">
                <p class="text-sm text-gray-500 mb-1">Shareable link</p>
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        readonly
                        value="{{ url('/poll/'.$poll->uuid) }}"
                        class="flex-1 text-sm border rounded px-3 py-2 text-gray-600 bg-gray-50"
                        onclick="this.select()"
                    >
                    <button
                        onclick="copyLink(this, '{{ url('/poll/'.$poll->uuid) }}')"
                        class="text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded border"
                    >Copy</button>
                </div>
            </div>
        </div>

    </div>

    <script>
        function copyLink(btn, url) {
            navigator.clipboard.writeText(url).then(() => {
                btn.textContent = 'Copied!';
                setTimeout(() => btn.textContent = 'Copy', 2000);
            });
        }
    </script>

</x-app-layout>