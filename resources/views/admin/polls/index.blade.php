<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold">All Polls</h2>

            <a href="{{ url('/admin/polls/create') }}">
                <x-primary-button>Create Poll</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @foreach($polls as $poll)
            <div class="p-4 mb-3 border rounded shadow-sm">
                <p class="font-bold">{{ $poll->question }}</p>

                <div class="mt-2 flex gap-4">
                    <a href="{{ url('/poll/'.$poll->uuid) }}" class="text-blue-500">View</a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>