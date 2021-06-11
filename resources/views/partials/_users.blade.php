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
                <select id="input-rol" name="rol"
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
                    <span id="name-rol" class="error text-danger" for="input-rol">{{ $errors->first('rol') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
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
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
