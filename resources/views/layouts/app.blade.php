@extends('layouts.base')
@section('app')
    @if(in_array(request()->route()->getName(), ['login']))
        @yield('content')
    @else
        @include('layouts.nav')
        @include('layouts.sidenav')
        <main class="content">
{{--            @if(in_array(request()->route()->getName(), ['dashboard']))--}}
{{--                @include('layouts.topbar')--}}
{{--            @endif--}}
            @include('layouts.topbar')
            @yield('content')
{{--            @include('layouts.footer')--}}
        </main>
    @endif
@endsection
