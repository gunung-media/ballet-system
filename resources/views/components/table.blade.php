<div {{ $attributes->merge(['class' => 'table-responsive p-0']) }}>
    <table class="table align-items-center mb-0" id="{{ $id }}">
        <thead>
            <tr>
                @if ($isSortable)
                    <th></th>
                @endif
                @foreach ($tableColumns as $key => $header)
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ in_array($header, $freezeColumns) ? 'sticky-col ' . ($key == 0 ? 'first-col' : 'second-col') : ' ?>' }}">
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
        new simpleDatatables.DataTable("#{{ $id }}", {
            searchable: true,
            sortable: {{ $isSortable ? 'true' : 'false' }},
        });
    </script>
</div>
