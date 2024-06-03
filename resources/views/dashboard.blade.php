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
    </x-container>

</x-app-layout>
