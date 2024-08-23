<!doctype html>
<html lang="en">
@include('layouts.partials.head')

<body class="g-sidenav-show bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            @yield('content')
            @include('layouts.partials.footer')
        </div>
    </main>
    @include('layouts.partials.scripts')
    @yield('customScripts')
</body>

</html>
