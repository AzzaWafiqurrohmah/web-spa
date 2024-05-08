@extends('layouts.base')
@section('app')
    @if(in_array(request()->route()->getName(), ['dashboard', 'customers.index', 'customers.create', 'customers.edit', 'customers.destroy',
            'franchises.index', 'treatmentCategories.index', 'tools.index', 'materials.index', 'treatments.index', 'treatments.create', 'treatments.edit']))

    @include('layouts.nav')
    @include('layouts.sidenav')
    <main class="content">
        @if(in_array(request()->route()->getName(), ['dashboard']))
            @include('layouts.topbar')
        @endif
        @yield('content')
        @include('layouts.footer')
    </main>

    @elseif(in_array(request()->route()->getName(), ['register', 'register-example', 'login', 'login-example',
    'forgot-password', 'forgot-password-example', 'reset-password','reset-password-example']))

    @yield('content')
{{--    @include('layouts.footer2')--}}


    @elseif(in_array(request()->route()->getName(), ['404', '500', 'lock']))

    @yield('content')

    @endif
@endsection
