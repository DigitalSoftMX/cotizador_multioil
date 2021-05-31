@csrf
<div class="card ">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('companies.index') }}" title="Volver a la lista de empresas">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar empresa') }}
        </h4>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        id="input-name" type="text" placeholder="{{ __('Escribe el nombre') }}"
                        value="{{ old('name', $company->name ?? '') }}" required="true" aria-required="true" />
                    @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger"
                            for="input-name">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
