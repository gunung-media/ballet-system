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

        @if ($isPercentage)
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Masukan {{ $label }}"
                    {{ $isRequired ? 'required' : '' }} value="{{ $value ?? old($name) }}"
                    id="percentage-{{ $name }}" name="{{ $name }}" />
                <span class="input-group-text" id="basic-addon1">%</span>
            </div>
        @endif
        <input type="{{ $isMoney || $isPercentage ? 'hidden' : $type }}" class="form-control"
            placeholder="Masukan {{ $label }}" {{ $isRequired ? 'required' : '' }} name="{{ $name }}"
            id="{{ $name }}" value="{{ $value ?? old($name) }}" />

        @if (!is_null($hintText))
            <label class="text-xs " style="font-weight: 100">{{ $hintText }}</label>
        @endif
    </div>
</div>

@if ($isPercentage)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const percentageInput = document.querySelector('#percentage-{{ $name }}');

            percentageInput.addEventListener('input', function() {
                let value = parseInt(this.value, 10);

                if (value > 100) {
                    this.value = 100;
                } else if (value < 0) {
                    this.value = 0;
                }
            });
        });
    </script>
@endif

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
