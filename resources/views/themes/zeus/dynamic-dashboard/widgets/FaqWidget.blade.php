<div class="space-y-3 bg-white dark:bg-black shadow my-10 py-3 px-4 hover:shadow-lg transition-all ease-in-out duration-500 ltr:rounded-tr-none rtl:rounded-tl-none rounded-3xl border border-primary-100 dark:border-primary-700/50">
    @if($data['faqs'] !== null)
        @foreach($data['faqs'] as $faq)
            <x-filament::section class="my-4" collapsible :collapsed="$data['faqs']->count() >1">
                <x-slot name="heading">
                    <h3 class="font-semibold">{{ $faq->question }}</h3>
                </x-slot>
                {!! $faq->answer !!}
            </x-filament::section>
        @endforeach
    @endif
</div>
