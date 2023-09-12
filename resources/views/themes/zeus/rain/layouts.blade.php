<div class="container mx-auto">
    @if($layout->widgets !== null)
        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 w-full px-2">
            @foreach (\LaraZeus\Rain\RainPlugin::get()->getModel('Columns')::all() as $column)
                <div class="w-full {{ $column->class }}">
                    @if(isset($layout->widgets[$column->key]))
                        @php
                            $widgetsItems = collect($layout->widgets[$column->key])->sortBy('data.sort')->toArray();
                        @endphp
                        @foreach($widgetsItems as $key => $data)
                            @if(class_exists($data['data']['widget']))
                                @php
                                    $data['data']['key'] = $key;
                                    $getWidget = new $data['data']['widget'];
                                @endphp
                                <div class="bg-white dark:bg-black shadow my-10 py-3 px-4 hover:shadow-lg transition-all ease-in-out duration-500 ltr:rounded-tr-none rtl:rounded-tl-none rounded-3xl border border-custom-100 dark:border-custom-700/50">
                                    @if($data['data']['title'])
                                        <h5 class="mb-2 bg-gray-100 dark:bg-gray-900 border border-custom-200 dark:border-custom-900/50 rounded-3xl ltr:rounded-tl-none rtl:rounded-tr-none absolute -mt-8 px-4 py-2 shadow font-bold text-sm lg:text-lg text-primary-600 dark:text-primary-100">
                                            {{ $data['data']['title'] }}
                                        </h5>
                                    @endif
                                    <div class="@if($data['data']['title']) pt-4 @endif">
                                        {!! $getWidget->render($data['data']) !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
