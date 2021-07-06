@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('fits.index') }}" title="Volver a la lista de FEE">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Registrar FEE') }}
        </h4>
    </div>
    <div class="card-body mt-5">
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-sm-3">
                <select id="input-terminal_id" name="terminal_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una terminal') }}</option>
                    @foreach ($terminals as $terminal)
                        <option value="{{ $terminal->id }}" @if (($f = $fit->terminal_id ?? '') == $terminal->id) selected @endif>{{ $terminal->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('terminal_id'))
                    <span id="name-terminal_id" class="error text-danger"
                        for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
                <select id="input-company_id" name="company_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una empresa') }}</option>
                </select>
                @if ($errors->has('company_id'))
                    <span id="name-company_id" class="error text-danger"
                        for="input-company_id">{{ $errors->first('company_id') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('base_id') ? ' has-danger' : '' }} col-sm-3">
                <select id="input-base_id" name="base_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('base_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Precio base') }}</option>
                    @foreach ($bases as $base)
                        <option value="{{ $base->id }}" @if (($f = $fit->base_id ?? '') == $base->id) selected @endif>
                            {{ $base->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('base_id'))
                    <span id="name-base_id" class="error text-danger"
                        for="input-base_id">{{ $errors->first('base_id') }}</span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('regular_fit') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                <label for="regular_fit">{{ __('Regular FEE') }}</label>
                <input type="number" step="0.01"
                    class="form-control{{ $errors->has('regular_fit') ? ' is-invalid' : '' }}" id="input-regular_fit"
                    placeholder="0" aria-describedby="regular_fitHelp"
                    value="{{ old('regular_fit', $fit->regular_fit ?? '') }}" required="true" name="regular_fit">
                @if ($errors->has('regular_fit'))
                    <span id="regular_fit-error" class="error text-danger" for="input-regular_fit">
                        {{ $errors->first('regular_fit') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('premium_fit') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                <label for="premium_fit">{{ __('Premium FEE') }}</label>
                <input type="number" step="0.01"
                    class="form-control{{ $errors->has('premium_fit') ? ' is-invalid' : '' }}" id="input-premium_fit"
                    placeholder="0" aria-describedby="premium_fitHelp"
                    value="{{ old('premium_fit', $fit->premium_fit ?? '') }}" required="true" name="premium_fit">
                @if ($errors->has('premium_fit'))
                    <span id="premium_fit-error" class="error text-danger" for="input-premium_fit">
                        {{ $errors->first('premium_fit') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('diesel_fit') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                <label for="diesel_fit">{{ __('Diésel FEE') }}</label>
                <input type="number" step="0.01"
                    class="form-control{{ $errors->has('diesel_fit') ? ' is-invalid' : '' }}" id="input-diesel_fit"
                    placeholder="0" aria-describedby="diesel_fitHelp"
                    value="{{ old('diesel_fit', $fit->diesel_fit ?? '') }}" required="true" name="diesel_fit">
                @if ($errors->has('diesel_fit'))
                    <span id="diesel_fit-error" class="error text-danger" for="input-diesel_fit">
                        {{ $errors->first('diesel_fit') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
@push('js')
    <script>
        let terminal = "{{ $fit->terminal_id ?? '' }}"
        if (terminal != '') {
            getCompanies(terminal);
        }
        $(".selectpicker").change(function() {
            let terminal = document.getElementById('input-terminal_id').value;
        });
        $('#input-terminal_id').change(function() {
            let terminal = document.getElementById('input-terminal_id').value;
            getCompanies(terminal);
        });
        // lista de empresas relacionadas con la terminal
        async function getCompanies(terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getcompanies/' + terminal_id);
                const companies = await resp.json();
                $('#input-company_id').children('option').remove();
                $('#input-company_id').append(`<option value="">Elija un empresa</option>`);
                companies.companies.forEach(company => {
                    if ("{{ $fit->company_id ?? '' }}" == company.id) {
                        $('#input-company_id').append(
                            `<option id="c_${company.id}" value="${company.id}" selected>${company.name}</option>`
                        );
                    } else {
                        $('#input-company_id').append(
                            `<option id="c_${company.id}" value="${company.id}">${company.name}</option>`);
                    }
                });
                $('#input-company_id').selectpicker('refresh');
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
