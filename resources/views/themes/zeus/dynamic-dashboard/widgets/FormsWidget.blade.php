<div class="my-4">
    @if($data['form_slug'] !== null)
        @php
            $checkForm = config('zeus-bolt.models.Form')::whereSlug($data['form_slug'])->first();
        @endphp
        @if($checkForm !== null)
            <livewire:bolt.fill-form :inline="true" :slug="$checkForm->slug" />
        @endif
    @endif

    @push('styles')
        @filamentStyles
    @endpush
</div>
