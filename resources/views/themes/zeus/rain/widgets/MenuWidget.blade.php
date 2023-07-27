<div>
    @if($data['menu'] !== null)
        @php
            $nav = $data['menu']->items;
        @endphp
        @if($nav !== null)
            @if($data['menu_dir'] === 'vertical')
                <nav class="px-2 flex flex-1 flex-col" aria-label="Sidebar">
                    <ul role="list" class="-mx-2 space-y-1">
                        @foreach($nav as $item)
                            <li>
                                {!! \LaraZeus\Sky\Classes\RenderNavItem::render($item,'text-gray-700 hover:text-custom-600 hover:bg-custom-50 group flex gap-x-3 rounded-3xl p-2 pl-3 text-sm transition-all ease-in-out duration-300') !!}
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @else
                <div class="container mx-auto flex items-center justify-center">
                    @foreach($nav as $item)
                        @if(!empty($item['children']))
                            <button class="flex items-center justify-center gap-1 text-sm text-primary-500 focus:outline-none transition-all ease-in-out duration-300">
                                {{ $item['label'] }}
                            </button>
                            @foreach($item['children'] as $children)
                                {!! \LaraZeus\Sky\Classes\RenderNavItem::render($children,'block px-4 py-2 text-sm leading-5 text-primary-500 hover:bg-custom-100 focus:outline-none focus:bg-gray-100 transition-all ease-in-out duration-300') !!}
                            @endforeach
                        @else
                            {!! \LaraZeus\Sky\Classes\RenderNavItem::render($item,'px-5 py-2 text-base font-medium text-primary-500 hover:text-custom-800 transition-all ease-in-out duration-300') !!}
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    @endif
</div>
