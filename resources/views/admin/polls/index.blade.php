<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">All Polls</h2>
            <a href="{{ url('/admin/polls/create') }}">
                <x-primary-button>Create Poll</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @forelse($polls as $poll)
            <div class="p-4 mb-4 border rounded shadow-sm bg-white">
                <p class="font-bold text-gray-900">{{ $poll->question }}</p>

                <div class="mt-2 flex items-center gap-2">
                    <input type="text" readonly value="{{ url('/poll/'.$poll->uuid) }}" class="flex-1 text-sm border rounded px-2 py-1 text-gray-600 bg-gray-50" onclick="this.select()">
                    <button onclick="copyLink(this, '{{ url('/poll/'.$poll->uuid) }}')" class="text-sm px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded border">Copy</button>
                </div>

                <div class="mt-3 flex gap-4 text-sm">
                    <a href="{{ url('/admin/polls/'.$poll->uuid) }}" class="text-blue-600 hover:underline">Results</a>
                    <a href="{{ url('/poll/'.$poll->uuid) }}" class="text-gray-500 hover:underline" target="_blank">View Poll</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No polls yet. <a href="{{ url('/admin/polls/create') }}" class="text-blue-500 underline">Create one.</a></p>
        @endforelse

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