<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-6">

        {{ $this->{'widgetsFromMain'} }}

        <div class="grid grid-cols-12 gap-2 w-full">
            @foreach (config('zeus-rain.models.columns')::all() as $layout)
                <x-filament::card class="w-full {{ $layout->class }} p-2">
                    <p>{{ $layout->name }}</p>
                    {{ $this->{'widgetsFrom'.$layout->key} }}
                </x-filament::card>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <x-filament::button type="submit">
                {{ __('Save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
