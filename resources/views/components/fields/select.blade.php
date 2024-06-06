<div class="form-group">
    <label>{{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select class="form-control" id="{{ $isMultiple ? 'choices-tags' : '' }}" name="{{ $name }}"
        placeholder="Pilih {{ $label }}" required="{{ $isRequired }}" data-color="dark"
        {{ $isMultiple ? 'multiple' : '' }} value="{{ $value ?? old($name) }}   ">
        @foreach ($choices as $key => $choice)
            <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}
                {{ $isMultiple && in_array($key, explode(',', $value)) ? 'selected' : '' }}>
                {{ Illuminate\Support\Str::title($choice) }}</option>
        @endforeach
    </select>
</div>
