<div class="form-group">
    @if ($type != 'hidden')
        <label>{{ $label }}
            @if ($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div class="mb-3">
        @if ($isMoney)
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Rp</span>
                <input type="text" class="form-control" placeholder="Masukan {{ $label }}"
                    {{ $isRequired ? 'required' : '' }} value="{{ $value ?? old($name) }}"
                    id="money-{{ $name }}" />
            </div>
        @endif
        <input type="{{ $isMoney ? 'hidden' : $type }}" class="form-control" placeholder="Masukan {{ $label }}"
            {{ $isRequired ? 'required' : '' }} name="{{ $name }}" id="{{ $name }}"
            value="{{ $value ?? old($name) }}" />
    </div>
</div>

@if ($isMoney)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let input = document.getElementById('money-{{ $name }}');
            let actualInput = document.getElementById('{{ $name }}');

            input.addEventListener('input', function() {
                actualInput.value = input.value.split(".").join("");
                var value = input.value.replace(/\D/g, '');
                value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(value);

                value = value.replace(/Rp/, '').trim();
                input.value = value;
            });
        });
    </script>
@endif
