{{-- header --}}
@include('partials.header')
{{--['rubricGroups' => isset($regions) ? $regions: null, 'regions' => isset($rubricGroups) ? $rubricGroups: null])--}}

{{-- filter --}}

{{-- content--}}
@yield('content')


{{-- footer --}}
@include('partials.footer')
