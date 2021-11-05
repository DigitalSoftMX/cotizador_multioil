<label class="color1">Regular:</label>
<div class="form-group{{ $errors->has("regular$day") ? ' has-danger' : '' }}">
    <select id="input-regular{{ $day }}" name="regular{{ $day }}" onchange="Suma()"
        class="selectpicker show-menu-arrow {{ $errors->has("regular$day") ? ' has-danger' : '' }}"
        data-style="btn-primary" data-width="100%">
        <option value="0" selected>{{ __('Elija una opción') }}</option>
        <option value="20000">{{ __('20,000 Lts') }}</option>
        <option value="31000">{{ __('31,000 Lts') }}</option>
        <option value="40000">{{ __('40,000 Lts') }}</option>
        <option value="62000">{{ __('62,000 Lts') }}</option>
    </select>
    @if ($errors->has(" regular$day"))
        <span id="name-regular{{ $day }}" class="error text-danger"
            for="input-regular{{ $day }}">{{ $errors->first("regular$day") }}</span>
    @endif
</div>

<label class="color2">Premium:</label>
<div class="form-group{{ $errors->has("premium$day") ? ' has-danger' : '' }}">
    <select id="input-premium{{ $day }}" name="premium{{ $day }}" onchange="Suma()"
        class="selectpicker show-menu-arrow {{ $errors->has("premium$day") ? ' has-danger' : '' }}"
        data-style="btn-primary" data-width="100%">
        <option value="0" selected>{{ __('Elija una opción') }}</option>
        <option value="20000">{{ __('20,000 Lts') }}</option>
        <option value="31000">{{ __('31,000 Lts') }}</option>
        <option value="40000">{{ __('40,000 Lts') }}</option>
        <option value="62000">{{ __('62,000 Lts') }}</option>
    </select>
    @if ($errors->has(" premium$day"))
        <span id="name-premium{{ $day }}" class="error text-danger"
            for="input-premium{{ $day }}">{{ $errors->first("premium$day") }}</span>
    @endif
</div>

<label class="color3">Diésel:</label>
<div class="form-group{{ $errors->has("diesel$day") ? ' has-danger' : '' }}">
    <select id="input-diesel{{ $day }}" name="diesel{{ $day }}" onchange="Suma()"
        class="selectpicker show-menu-arrow {{ $errors->has("diesel$day") ? ' has-danger' : '' }}"
        data-style="btn-primary" data-width="100%">
        <option value="0" selected>{{ __('Elija una opción') }}</option>
        <option value="20000">{{ __('20,000 Lts') }}</option>
        <option value="31000">{{ __('31,000 Lts') }}</option>
        <option value="40000">{{ __('40,000 Lts') }}</option>
        <option value="62000">{{ __('62,000 Lts') }}</option>
    </select>
    @if ($errors->has(" diesel$day"))
        <span id="name-diesel{{ $day }}" class="error text-danger"
            for="input-diesel{{ $day }}">{{ $errors->first("diesel$day") }}</span>
    @endif
</div>
