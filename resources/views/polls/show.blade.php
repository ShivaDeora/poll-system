<x-app-layout>
    <x-slot name="header">
        {{ $poll->question }}
    </x-slot>

    <div class="p-6">

        <form id="voteForm">
            @csrf

            @foreach($poll->pollOptions as $option)
                <div class="mb-2">
                    <label>
                        <input type="radio" name="option_id" value="{{ $option->id }}">
                        {{ $option->option_text }}
                        ({{ $option->vote_count }} votes)
                    </label>
                </div>
            @endforeach

            <x-primary-button type="submit">
                Vote
            </x-primary-button>
        </form>

        <p id="message" class="mt-4 text-green-500"></p>

    </div>

    <script>
        document.getElementById('voteForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch("{{ url('/poll/'.$poll->id.'/vote') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('message').innerText = data.message;
                location.reload(); // temporary refresh
            });
        });
    </script>

</x-app-layout>