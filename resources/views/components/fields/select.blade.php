<div class="form-group">
    <label>{{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select class="form-control" name="{{ $name }}" jlaceholder="Pilih {{ $label }}"
        required="{{ $isRequired }}">
        @foreach ($choices as $key => $value)
            <option value="{{ $key }}">{{ Illuminate\Support\Str::title($value) }}</option>
        @endforeach
    </select>
</div>
