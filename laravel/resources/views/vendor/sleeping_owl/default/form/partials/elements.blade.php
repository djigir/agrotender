@if($items instanceof \SleepingOwl\Admin\Form\Element\Columns)
    <div class="form-elements w-100">
        {!! $items->render() !!}
    </div>
@else
    <div class="form-elements w-100">
        @foreach ($items as $item)
            @if($item instanceof \Illuminate\Contracts\Support\Renderable)
                @if(method_exists($item, 'getName'))
                    @yield('before.'. $item->getName())
                @endif
                {!! $item->render() !!}
                @if(method_exists($item, 'getName'))
                    @yield('after.'. $item->getName())
                @endif
            @else
                {!! $item !!}
            @endif
        @endforeach
    </div>
@endif

@if(\Request::segment(4) == 'edit' && (\Request::segment(2) == 'comp_items_traders' || \Request::segment(2) == 'comp_items'))
    <script src="../../../../../../../../app/assets/my_js/admin.js"></script>
@endif

