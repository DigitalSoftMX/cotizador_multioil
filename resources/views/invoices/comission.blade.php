@if (auth()->user()->roles->first()->id == 1)
    <div class="row">
        <div class="col-12 text-right">
            <button type="button" class="btn btn-sm btn-dark" data-toggle="modal"
                data-target=".bd-example-modal-lg-commission">{{ ($invoice->commission ? 'Actualizar' : 'Agregar') . __(' comisión') }}
            </button>
            <div class="modal fade bd-example-modal-lg-commission" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="post" action="{{ route('orders.update', $invoice) }}" autocomplete="off"
                            class="form-horizontal">
                            @method('put')
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">
                                    <strong>{{ ($invoice->commission ? 'Actualización' : 'Registro') . __(' de comisión') }}</strong>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <div
                                        class="form-group{{ $errors->has('commission') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                        <label for="commission">{{ __('Comisión del comisionista') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}"
                                            id="input-commission" aria-describedby="commissionHelp"
                                            placeholder="Escribe la cantidad del pago"
                                            value="{{ old('commission', $invoice->commission) }}" aria-required="true"
                                            name="commission" step="any">
                                        @include('partials.errorsession',[$field='commission'])
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                        <select id="input-user_id" name="user_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('user_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">
                                                {{ __('Elija un comisionista') }}
                                            </option>
                                            @foreach ($sales as $sale)
                                                <option value="{{ $sale->id }}" @if ($invoice->user_id == $sale->id) selected @endif>
                                                    {{ $sale->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @include('partials.errorsession',[$field='user_id'])
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div
                                        class="form-group{{ $errors->has('commission_two') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                        <label
                                            for="commission_two">{{ __('Comisión del segundo comisionista') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('commission_two') ? ' is-invalid' : '' }}"
                                            id="input-commission_two" aria-describedby="commission_twoHelp"
                                            placeholder="Escribe la cantidad del pago"
                                            value="{{ old('commission_two', $invoice->commission_two) }}"
                                            aria-required="true" name="commission_two" step="any">
                                        @include('partials.errorsession',[$field='commission_two'])
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('middleman_id') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                        <select id="input-middleman_id" name="middleman_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('middleman_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">
                                                {{ __('Elija un comisionista') }}
                                            </option>
                                            @foreach ($sales as $sale)
                                                <option value="{{ $sale->id }}" @if ($invoice->middleman_id == $sale->id) selected @endif>
                                                    {{ $sale->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @include('partials.errorsession',[$field='middleman_id'])
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ 'Actualizar' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
