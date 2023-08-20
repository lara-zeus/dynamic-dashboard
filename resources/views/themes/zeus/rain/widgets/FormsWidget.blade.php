<div>
    @if($data['form_slug'] !== null)
        @php
            $checkForm = \LaraZeus\Bolt\BoltPlugin::getModel('Form')::whereSlug($data['form_slug'])->first();
        @endphp
        @if($checkForm !== null)
            <livewire:bolt.fill-form :inline="true" :slug="$checkForm->slug" />
        @endif
    @endif
</div>
