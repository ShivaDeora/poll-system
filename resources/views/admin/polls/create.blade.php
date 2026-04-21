<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Create Poll</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <form method="POST" action="/admin/polls">
            @csrf

            <!-- Question -->
            <div class="mb-4">
                <x-input-label value="Question" />
                <x-text-input name="question" class="w-full" />
                <x-input-error :messages="$errors->get('question')" />
            </div>

            <!-- Options -->
            <div id="options">
                <div class="mb-2">
                    <x-text-input name="options[]" placeholder="Option 1" class="w-full" />
                </div>
                <div class="mb-2">
                    <x-text-input name="options[]" placeholder="Option 2" class="w-full" />
                </div>
            </div>

            <div class="mb-4">
                <button type="button" onclick="addOption()" class="text-blue-500">+ Add Option</button>
            </div>

            <div class="mt-6">
                <x-primary-button>Create</x-primary-button>
            </div>
        </form>

    </div>

    <script>
        function addOption() {
            let div = document.getElementById('options');
            let inputWrapper = document.createElement('div');
            inputWrapper.classList.add('mb-2');

            inputWrapper.innerHTML = `<input type="text" name="options[]" class="w-full border rounded" placeholder="New option">`;

            div.appendChild(inputWrapper);
        }
    </script>
</x-app-layout>