<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<!-- Nucleo Icons -->
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<!-- CSS Files -->
<link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
<style>
    .sticky-col {
        position: -webkit-sticky !important;
        position: sticky !important;
        background-color: #fff !important;
        z-index: 100 !important;
    }

    .first-col {
        width: 100px;
        min-width: 100px;
        max-width: 100px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 100px;
    }
</style>
@yield('customStyles')
