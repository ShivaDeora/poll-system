<x-app-layout>
    <x-slot name="header">
        Polls
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @foreach($polls as $poll)
            <div class="mb-4 p-4 border rounded">
                <p class="font-bold">{{ $poll->question }}</p>
                <a href="{{ url('/poll/'.$poll->uuid) }}" class="text-blue-500">
                    View Poll
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>