<div {{ $attributes->merge(['class' => 'table-responsive p-0']) }}>
    <table class="table align-items-center mb-0" id="datatable">
        <thead>
            <tr>
                @foreach ($tableColumns as $header)
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        {{ $header }}</th>
                @endforeach
                @if ($hasActions)
                    <th class="text-secondary opacity-7"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($isEmpty)
                <tr>
                    <td colspan="{{ count($tableColumns) }}" class="text-center font-weight-bold mb-0">
                        Tidak ada data
                    </td>
                </tr>
            @else
                {{ $slot }}
            @endif
        </tbody>
    </table>

    <script src="../assets/js/plugins/datatables.js"></script>
    <script type="text/javascript">
        const dataTableBasic = new simpleDatatables.DataTable("#datatable", {
            searchable: true,
        });
    </script>
</div>
