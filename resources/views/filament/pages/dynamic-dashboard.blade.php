<x-filament::page>
    @if($rainLayout->widgets !== null)
        <div class="grid grid-cols-12 gap-2 w-full px-2">
            @foreach (\LaraZeus\Rain\RainPlugin::get()->getModel('Columns')::all() as $column)
                @if(isset($rainLayout->widgets[$column->key]))
                    @php
                        $widgetsItems = collect($rainLayout->widgets[$column->key])->sortBy('data.sort')->toArray();
                    @endphp
                    <div class="{{ $column->class }}">
                        @if(count($widgetsItems) !== 0)
                            @foreach($widgetsItems as $data)
                                @if(class_exists($data['data']['widget']))
                                    @php
                                        $getWidget = new $data['data']['widget'];
                                    @endphp
                                    <div class="bg-white dark:bg-black shadow my-10 py-3 px-4 hover:shadow-lg transition-all ease-in-out duration-500 ltr:rounded-tr-none rtl:rounded-tl-none rounded-3xl border border-primary-100 dark:border-primary-700/50">
                                        @if($data['data']['title'])
                                            <h5 class="mb-2 bg-gray-100 dark:bg-gray-900 border border-primary-200 dark:border-primary-900/50 rounded-3xl ltr:rounded-tl-none rtl:rounded-tr-none absolute -mt-8 px-4 py-2 shadow font-bold text-sm lg:text-lg text-primary-600 dark:text-primary-100">
                                                {{ $data['data']['title'] }}
                                            </h5>
                                        @endif
                                        <div class="@if($data['data']['title']) pt-4 @endif">
                                            {!! $getWidget->renderWidget($data['data']) !!}
                                        </div>
                                    </div>
                                @endif
                          @endforeach
                       @endif
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</x-filament::page>
