<div class="form-group">
    <label>{{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select class="form-control" name="{{ $name }}" placeholder="Pilih {{ $label }}"
        required="{{ $isRequired }}">
        @foreach ($choices as $key => $choice)
            <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>
                {{ Illuminate\Support\Str::title($choice) }}</option>
        @endforeach
    </select>
</div>
