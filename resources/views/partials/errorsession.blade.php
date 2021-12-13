@if ($errors->has($field))
    <span id="{{ $field }}-error" class="error text-danger" for="input-{{ $field }}">
        {{ $errors->first($field) }}
    </span>
@endif
