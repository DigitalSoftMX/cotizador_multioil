@csrf
<div class="card ">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('users.index') }}" title="Volver a la lista de usuarios">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar usuario') }}
        </h4>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                        id="input-name" type="text" placeholder="{{ __('Escribe el nombre') }}"
                        value="{{ old('name', $user->name ?? '') }}" required="true" aria-required="true" />
                    @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger"
                            for="input-name">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label">{{ __('Apellido Paterno') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('app_name') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('app_name') ? ' is-invalid' : '' }}" name="app_name"
                        id="input-app_name" type="text" placeholder="{{ __('Escribe el apellido paterno') }}"
                        value="{{ old('app_name', $user->app_name ?? '') }}" required="true" aria-required="true" />
                    @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger"
                            for="input-app_name">{{ $errors->first('app_name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label">{{ __('Apellido Materno') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('apm_name') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('apm_name') ? ' is-invalid' : '' }}" name="apm_name"
                        id="input-apm_name" type="text" placeholder="{{ __('Escribe el apellido materno') }}"
                        value="{{ old('apm_name', $user->apm_name ?? '') }}" required="true" aria-required="true" />
                    @if ($errors->has('apm_name'))
                        <span id="name-error" class="error text-danger"
                            for="input-apm_name">{{ $errors->first('apm_name') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        id="input-email" type="email" placeholder="{{ __('Escribe el correo electrónico') }}"
                        value="{{ old('email', $user->email ?? '') }}" required />
                    @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger"
                            for="input-email">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label" for="input-password">{{ __(' Contraseña') }}</label>
            <div class="col-sm-7">
                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input
                        type="password" name="password" id="input-password"
                        placeholder="{{ __('Escribe la contraseña') }}" />
                    @if ($errors->has('password'))
                        <span id="name-error" class="error text-danger"
                            for="input-name">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <label class="col-sm-2 col-form-label"
                for="input-password-confirmation">{{ __('Confirmar Contraseña') }}</label>
            <div class="col-sm-7">
                <div class="form-group">
                    <input class="form-control" name="password_confirmation" id="input-password-confirmation"
                        type="password" placeholder="{{ __('Confirmar la Contraseña') }}" />
                </div>
            </div>
        </div>
        <div class="row justify-content-md-start">
            <div class="form-group{{ $errors->has('rol') ? ' has-danger' : '' }} col-sm-3">
                <select id="input-rol_id" name="rol"
                    class="selectpicker show-menu-arrow {{ $errors->has('rol') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija un rol') }}</option>
                    @foreach ($roles as $rol)
                        @if (isset($user))
                            <option id="r_{{ $rol->id }}" value="{{ $rol->id }}" @if (($u = $user->roles->first()->id ?? '') == $rol->id) selected @endif>{{ $rol->name }}</option>
                        @else
                            <option id="r_{{ $rol->id }}" value="{{ $rol->id }}">{{ $rol->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @if ($errors->has('rol'))
                    <span id="name-rol" class="error text-danger"
                        for="input-rol_id">{{ $errors->first('rol') }}</span>
                @endif
            </div>
            <div id="companies" class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
                <select id="input-company_id" name="company_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija un empresa') }}</option>
                    @foreach ($companies as $company)
                        @if (isset($user))
                            <option value="{{ $company->id }}" @if (($u = $user->company_id) == $company->id) selected @endif>{{ $company->name }}</option>
                        @else
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endif
                    @endforeach
                </select>
                @if ($errors->has('company_id'))
                    <span id="name-company_id" class="error text-danger"
                        for="input-company_id">{{ $errors->first('company_id') }}</span>
                @endif
            </div>
            <div id="companiescheck"
                class="form-group{{ $errors->has('companies') ? ' has-danger' : '' }} col-sm-4 checkbox-radios">
                <label for="companies">{{ __('Elije las empresas del vendedor') }}</label>
                @foreach ($companies as $company)
                    <div class="form-check mt-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="{{ $company->id }}"
                                name="companies[]" @if ($company->users->contains($user->id ?? '')) checked @endif>
                            {{ $company->name }}
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                @endforeach
                @if ($errors->has('companies'))
                    <span id="companies-error" class="error text-danger" for="input-companies">
                        {{ $errors->first('companies') }}
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
        let user = "{{ isset($user) ? $user->roles->first()->id : '' }}"
        if (user != '') {
            display(user);
        } else {
            document.getElementById('companies').style.display = 'none';
            document.getElementById('companiescheck').style.display = 'none';
        }
        $(".selectpicker").change(function() {
            let rol_id = document.getElementById('input-rol_id').value;
        });
        $('#input-rol_id').change(function() {
            let rol_id = document.getElementById('input-rol_id').value;
            console.log(rol_id);
            display(rol_id);
        });

        function display(rol_id) {
            switch (rol_id) {
                case '1':
                    document.getElementById('companies').style.display = 'none';
                    document.getElementById('companiescheck').style.display = 'none';
                    break;
                case '2':
                    document.getElementById('companies').style.display = 'block';
                    document.getElementById('companiescheck').style.display = 'none';
                    break;
                case '3':
                    document.getElementById('companies').style.display = 'none';
                    document.getElementById('companiescheck').style.display = 'block';
                    break;
            }
        }

    </script>
@endpush
