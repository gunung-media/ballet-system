<div class="table-responsive p-0">
    <table class="table align-items-center mb-0" id="datatable">
        <thead>
            <tr>
                @foreach ($tableColumns as $header)
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        {{ $header }}</th>
                @endforeach
                <th class="text-secondary opacity-7"></th>
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>

    <script src="../assets/js/plugins/datatables.js"></script>
    <script type="text/javascript">
        const dataTableBasic = new simpleDatatables.DataTable("#datatable", {
            searchable: true,
            fixedHeight: true
        });
    </script>
</div>
