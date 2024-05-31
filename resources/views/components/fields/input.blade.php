<div class="form-group">
    <label>{{ $label }}
        @if ($isRequired)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="mb-3">
        <input type="{{ $type }}" class="form-control" placeholder="Masukan {{ $label }}"
            required="{{ $isRequired }}" name="email" value="{{ $value }}" />
    </div>
</div>
