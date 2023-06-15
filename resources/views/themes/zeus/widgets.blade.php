<div class="max-w-4xl mx-auto my-4">
    @if($widget->widgets !== null)
        <div class="grid grid-cols-1 md:grid-cols-12 gap-2 w-full">
            @foreach (\LaraZeus\Rain\Models\Columns::all() as $layout)
                <div class="w-full {{ $layout->class }}">
                    @if(isset($widget->widgets[$layout->key]))
                        @php
                            $widgetsItems = collect($widget->widgets[$layout->key])->sortBy('data.sort')->toArray();
                        @endphp
                        @foreach($widgetsItems as $key => $data)
                            @if(class_exists($data['data']['widget']))
                                @php
                                    $getWidget = new $data['data']['widget'];
                                @endphp
                                <div class="bg-white shadow mb-2 md:mb-6 mt-14 mx-1 py-3 px-4 hover:shadow-lg transition-all ease-in-out duration-500 rounded-3xl border border-primary-100">
                                    @if($data['data']['title'])
                                        <h5 class="mb-2 bg-gray-200 rounded-3xl absolute -mt-8 px-4 py-2 shadow font-bold text-sm lg:text-lg text-primary-800">{{ $data['data']['title'] }}</h5>
                                    @endif
                                    <div class="@if($data['data']['title']) pt-10 @endif">
                                        {!! $getWidget->render($data) !!}
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
