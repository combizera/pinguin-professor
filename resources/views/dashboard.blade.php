<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form post :action="route('question.store')">
            <div class="form__item mb-4">
                <x-textarea name="question" label="Question" placeholder="Ask me anything..." />
            </div>
            <x-button type="submit" text="Make Question" />
            <x-button.secondary type="reset" text="Cancel" />
        </x-form>

        <hr class="border-gray-700 my-4">

        {{-- Listagem --}}
        <section>
            <h2 class="text-gray-400 uppercase font-bold">List of Questions</h2>

            <ul class="text-gray-300 space-y-4">
                @foreach($questions as $item)
                    <x-question :question="$item" />
                @endforeach
            </ul>
        </section>

    </x-container>

</x-app-layout>
