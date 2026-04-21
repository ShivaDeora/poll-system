<x-app-layout>
    <x-slot name="header">
        Polls
    </x-slot>

    <div class="p-6">
        @foreach($polls as $poll)
            <div class="mb-4 p-4 border rounded">
                <p class="font-bold">{{ $poll->question }}</p>
                <a href="{{ url('/poll/'.$poll->id) }}" class="text-blue-500">
                    View Poll
                </a>
            </div>
        @endforeach
    </div>
</x-app-layout>