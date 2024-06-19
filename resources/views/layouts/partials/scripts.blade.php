<!--   Core JS Files   -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.14/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.14/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.14/index.global.min.js"></script>
<script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>

<script type="text/javascript">
    if (document.getElementById('choices-button')) {
        var element = document.getElementById('choices-button');
        const example = new Choices(element, {});
    }
    var choicesTags = document.getElementById('choices-tags');
    if (choicesTags) {
        var color = choicesTags.dataset.color;
        const example = new Choices(choicesTags, {
            delimiter: ',',
            editItems: true,
            maxItemCount: 5,
            removeItemButton: true,
            addItems: true,
            classNames: {
                item: 'badge rounded-pill choices-' + color + ' me-2'
            }
        });
    }
</script>
<script>
    function createToast(icon, title, html = null) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            html: html,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if (session('success'))
            createToast('success', '{{ session('success') }}');
        @endif


        @if (session('error'))
            createToast('error', '{{ session('error') }}');
        @endif

        @if (session('warning'))
            createToast('warning', '{{ session('warning') }}');
        @endif

        @if ($errors->any())
            createToast('error', 'Validation Error',
                '<ul style="list-style:none;margin:0;padding:0;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>'
            );
        @endif
    })
</script>
