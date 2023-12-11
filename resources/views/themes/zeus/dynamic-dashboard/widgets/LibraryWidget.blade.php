<div>
    @if($data['library'] !== null)
        @foreach($data['library'] as $library)
            <a href="{{ route('library.item', ['slug' => $library->slug]) }}" class="flex flex-col py-2 px-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md transition ease-in-out duration-500 block cursor-pointer">
                <div x-data class="flex items-center justify-between text-primary-600 dark:text-primary-400 hover:dark:text-primary-300">
                    <h3>{{ $library->title ?? '' }}</h3>
                    @if($library->type === 'IMAGE')
                        <span x-tooltip.raw="{{ __('Image') }}">
                            @svg('heroicon-o-photo','w-4 h-4 text-gray-400 dark:text-gray-500')
                        </span>
                    @endif

                    @if($library->type === 'FILE')
                        <span x-tooltip.raw="{{ __('File') }}">
                            @svg('heroicon-o-document','w-4 h-4 text-gray-400 dark:text-gray-500')
                        </span>
                    @endif

                    @if($library->type === 'VIDEO')
                        <span x-tooltip.raw="{{ __('Video') }}">
                            @svg('heroicon-o-film','w-4 h-4 text-gray-400 dark:text-gray-500')
                        </span>
                    @endif
                </div>
                <cite class="text-sm text-primary-600 dark:text-primary-500 hover:dark:text-primary-300">
                    {{ $library->description }}
                </cite>
            </a>
        @endforeach
    @endif
</div>
