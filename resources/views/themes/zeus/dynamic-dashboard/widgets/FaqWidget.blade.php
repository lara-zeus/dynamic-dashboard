<div>
    @if($data['faqs'] !== null)
        @foreach($data['faqs'] as $faq)
            <x-filament::section class="my-4" collapsible :collapsed="$data['faqs']->count() > 1">
                <x-slot name="heading">
                    <h3 class="font-semibold">{{ $faq->question }}</h3>
                </x-slot>
                {!! $faq->answer !!}
            </x-filament::section>
        @endforeach
    @endif
</div>
