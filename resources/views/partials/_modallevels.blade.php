<form action="{{ route('levels.store') }}" method="post">
    @csrf
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if (isset($btn))
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __('Actualización de la unidad - km - precio') }}
                        </h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ __('Registro de una unidad - km - precio') }}
                        </h5>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="form-group{{ $errors->has('truck_id') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <select id="input-truck_id" name="truck_id"
                                class="selectpicker show-menu-arrow {{ $errors->has('truck_id') ? ' has-danger' : '' }}"
                                data-style="btn-primary" data-width="100%" data-live-search="true" required>
                                <option value="" disabled selected>{{ __('Elija un unidad') }}</option>
                                <option value="1">{{ __('Pipa (20,000 lts)') }}</option>
                                <option value="2">{{ __('Sencillo (31,000 lts)') }}</option>
                                <option value="3">{{ __('Full (62,000 lts)') }}</option>
                            </select>
                            @if ($errors->has('truck_id'))
                                <span id="name-truck_id" class="error text-danger"
                                    for="input-truck_id">{{ $errors->first('truck_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('kms') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <label for="kms">{{ __('Kilómetros') }}</label>
                            <input type="number" class="form-control{{ $errors->has('kms') ? ' is-invalid' : '' }}"
                                id="input-kms" aria-describedby="kmsHelp" placeholder="Escribe la cantidad de kms"
                                value="{{ old('kms', $level->kms ?? '') }}" aria-required="true" name="kms"
                                type="any" required>
                            @if ($errors->has('kms'))
                                <span id="kms-error" class="error text-danger" for="input-kms">
                                    {{ $errors->first('kms') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <label for="price">{{ __('$ Precio') }}</label>
                            <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                id="input-price" aria-describedby="priceHelp" placeholder="Escribe el precio"
                                value="{{ old('price', $level->price ?? '') }}" aria-required="true" name="price"
                                type="any" required>
                            @if ($errors->has('price'))
                                <span id="price-error" class="error text-danger" for="input-price">
                                    {{ $errors->first('price') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-primary">{{ $btn ?? 'Registrar' }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
