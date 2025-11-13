<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo-mie-sedap.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/jquery.dataTables.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    @if (!isset($styleCss) || !$styleCss)
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    @endif
    <title>@yield('title', 'Pesanan Order')</title>
    @yield('styles')
</head>

<body>
    @if (!isset($hideNavAndFooter) || !$hideNavAndFooter)
        <header class="fixed-top">
            @include('layout.navbar')
        </header>
    @endif

    <div class="content-wrapper">
        @if (isset($showSidebar) && $showSidebar)
            <aside class="sidebar">
                <div class="sidebar-content">
                    @include('layout.sidebar')
                </div>
            </aside>
        @endif

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @if (!isset($hideNavAndFooter) || !$hideNavAndFooter)
        <footer class="mt-auto">
            @include('layout.footer')
        </footer>
    @endif

    @stack('modals')
    @yield('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
