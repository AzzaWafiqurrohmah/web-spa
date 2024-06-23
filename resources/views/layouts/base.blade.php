<!DOCTYPE html>
<html lang="en">
    <head>

        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        />
{{--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"--}}
{{--              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="../../assets/img/favicon/apple-touch-icon.png" sizes="180x180">
        <link rel="icon" href="../../assets/img/favicon/favicon-32x32.png" sizes="32x32" type="image/png">
        <link rel="icon" href="../../assets/img/favicon/favicon-16x16.png" sizes="16x16" type="image/png">

        <link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#563d7c">
        <link rel="icon" href="../../assets/img/favicon/favicon.ico">
        <meta name="msapplication-config" content="../../assets/img/favicons/browserconfig.xml">
        <meta name="theme-color" content="#563d7c">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

        <!-- Apex Charts -->
        <link type="text/css" href="/vendor/apexcharts/apexcharts.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

        <!-- boxicon -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Fontawesome -->
        <link type="text/css" href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- Sweet Alert -->
        <link type="text/css" href="/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">


        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

        <!-- map -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
              crossorigin=""/>

        <!-- Volt CSS -->
        <link type="text/css" href="/css/volt.css" rel="stylesheet">
        @stack('style')
    </head>
    <body>
        @yield('app')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>--}}


        <!-- map -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>

        <!-- Core -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
                integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>

        <!-- Vendor JS -->
        <script src="/assets/js/on-screen.umd.min.js"></script>

        <!-- Slider -->
        <script src="/assets/js/nouislider.min.js"></script>

        <!-- Smooth scroll -->
        <script src="/assets/js/smooth-scroll.polyfills.min.js"></script>

        <!-- Apex Charts -->
        <script src="/vendor/apexcharts/apexcharts.min.js"></script>

        <!-- Charts -->
        <script src="/assets/js/chartist.min.js"></script>
        <script src="/assets/js/chartist-plugin-tooltip.min.js"></script>

        <!-- Sweet Alerts 2 -->
        <script src="/assets/js/sweetalert2.all.min.js"></script>

        <!-- Moment JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>


        <!-- Simplebar -->
        <script src="/assets/js/simplebar.min.js"></script>

        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        <!-- Volt JS -->
        <script src="/assets/js/volt.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{ asset('js/utils.js') }}"></script>

        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });

            @if(session()->has('swal_s'))
            Swal.fire({
                icon: 'success',
                text: '{{ session()->get('swal_s') }}',
                timer: 1500,
            });
            @endif
        </script>

        @stack('script')
        @include('components.vendor.sweetalert')
    </body>
</html>
