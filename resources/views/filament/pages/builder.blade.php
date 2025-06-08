<x-filament::page>
    <form wire:submit="submit" class="space-y-4">

        {{ $this->form }}

        <div class="text-center mt-10">
            <x-filament::button
                    wire:target="submit"
                    wire:loading.attr="disabled"
                    form="submit"
                    type="submit"
            >
                {{ __('Save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
