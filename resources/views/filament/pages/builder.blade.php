<x-filament::page>
    <form wire:submit="submit" class="space-y-4">

        {{ $this->mainWidgetForm }}

        <div class="grid grid-cols-12 gap-4 w-full">
            @foreach (\LaraZeus\DynamicDashboard\DynamicDashboardPlugin::get()->getModel('Columns')::all() as $layout)
                <x-filament::section class="w-full {{ $layout->class }}">
                    <p>{{ $layout->name }}</p>
                    {{ $this->{'widgetsFrom'.$layout->key} }}
                </x-filament::section>
            @endforeach
        </div>

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
