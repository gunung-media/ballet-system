<div class="form-group">
    @if ($type != 'hidden')
        <label>{{ $label }}
            @if ($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div class="mb-3">
        <input type="{{ $type }}" class="form-control" placeholder="Masukan {{ $label }}"
            {{ $isRequired ? 'required' : '' }} name="{{ $name }}" value="{{ $value ?? old($name) }}" />
    </div>
</div>
