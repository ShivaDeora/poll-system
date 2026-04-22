<x-app-layout>
    <x-slot name="header">
        {{ $poll->question }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

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
        const form = document.getElementById('voteForm');
        const messageEl = document.getElementById('message');

        form?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = form.querySelector('button[type="submit"]');
            const radios = form.querySelectorAll('input[name="option_id"]');

            btn.disabled = true;

            const formData = new FormData(form);

            try {
                const res = await fetch("{{ url('/poll/'.$poll->uuid.'/vote') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData
                });

                const data = await res.json();

                if (data.error) {
                    messageEl.innerText = data.error;
                    btn.disabled = false;
                    return;
                }

                messageEl.innerText = data.message;

                radios.forEach(r => r.disabled = true);
                //await loadResults();
            } catch (e) {
                messageEl.innerText = "Something went wrong. Try again.";
                btn.disabled = false;
            }
        });

        async function loadResults() {
            const res = await fetch("{{ url('/poll/'.$poll->uuid.'/results') }}");
            const html = await res.text();
            document.getElementById('results').innerHTML = html;
        }
    </script>

</x-app-layout>