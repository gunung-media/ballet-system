<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.head')

<body class="">
    <main class="main-content  mt-0">
        <section>
            @yield('content')
        </section>
    </main>

    @include('layouts.partials.auth-footer')
    @include('layouts.partials.scripts')
</body>

</html>
