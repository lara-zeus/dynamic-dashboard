@php
    $styles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables('pink', shades: [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]),
    ]);
@endphp

<div style="{{ $styles }}" class="p-4 prose lg:prose-xl prose-custom dark:prose-invert">
    {!! str($data['content'])->markdown() !!}
</div>
