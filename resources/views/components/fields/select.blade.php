<div class="form-group">
    <label>{{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select class="form-control" id="{{ $isMultiple ? 'choices-tags' : 'the-select' }}" name="{{ $name }}"
        placeholder="Pilih {{ $label }}" {{ $isRequired ? 'required' : '' }} data-color="dark"
        {{ $isMultiple ? 'multiple' : '' }} value="{{ $value ?? old($name) }}   " {{ !$isEnabled ? 'disabled' : '' }}>
        <option value="">Pilih {{ $label }}</option>
        @foreach ($choices as $key => $choice)
            <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}
                {{ $isMultiple && in_array($key, explode(',', $value)) ? 'selected' : '' }}>
                {{ Illuminate\Support\Str::title($choice) }}</option>
        @endforeach

        @if ($isTuition)
            <option value="Lainnya">Lainnya</option>
        @endif
    </select>

</div>

@if ($isTuition)
    <div id="additional-input" style="display: none;" class="form-group">
        <label for="other-input">Please specify:</label>
        <input type="text" id="other-input" name="student_name" class="form-control">
    </div>
@endif
<script>
    var selectRef = document.querySelector("#the-select");
    var additionalInput = document.querySelector("#additional-input");

    selectRef.onchange = function() {
        if (selectRef.value === "Lainnya") {
            additionalInput.style.display = "block";
        } else {
            additionalInput.style.display = "none";
        }
    };
</script>
