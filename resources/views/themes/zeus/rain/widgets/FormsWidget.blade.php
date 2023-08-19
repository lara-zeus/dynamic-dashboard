<div>
    @if($data['form_slug'] !== null)
        <livewire:bolt.fill-form :inline="true" :slug="$data['form_slug']" />
    @endif
</div>
