<thead class=" text-primary">
    <th class="text-center">{{ __('Empresa') }}</th>
    <th class="text-center">{{ __('Datos del pedido') }}</th>
    <th class="text-center">{{ __('Fecha de solicitud') }}</th>
    <th class="text-center">{{ __('Fecha de entrega') }}</th>
    <th class="text-right">{{ __('Acciones') }}</th>
</thead>
<tbody>
    @foreach ($orders as $order)
        @if ($status == $order->status_id)
            <tr>
                <td class="text-center">{{ $order->company->name }}</td>
                <td class="text-center">
                    <table style="width:100%" class="table table-sm">
                        <tr>
                            <td>{{ $order->product }}</td>
                            <td> {{ number_format($order->liters, 0) }} LTS</td>
                            <td>{{ '$ ' . number_format($order->total, 2) }}</td>
                        </tr>
                    </table>
                </td>
                <td class="text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td class="text-center">{{ date('Y-m-d', strtotime($order->date)) }}</td>
                <td class="td-actions justify-content-end">
                    <a rel="tooltip" class="btn btn-link" 
                        data-toggle="modal" data-target="#exampleModalLong{{ $order->id }}see">
                        <i class="material-icons">visibility</i>
                        <div class="ripple-container"></div>
                    </a>
                    @if ($status == 2)
                        <a rel="tooltip" class="btn btn-sm btn-link"
                            href="{{ route('invoices.edit', $order) }}">
                            <i class="material-icons">fact_check</i>
                            <div class="ripple-container"></div>
                        </a>
                    @endif
                    {{-- modal --}}
                    @include('partials._modal',[$id=$order->id.'see',$see=true])
                    @if (auth()->user()->roles->first()->id == 1)
                        @if ($status == 1 || $status == 3)
                            <form id="auth{{ $order->id }}" action="{{ route('accept', $order) }}" method="post">
                                @csrf
                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <select id="input-type{{ $order->id }}" name="type"
                                        class="selectpicker show-menu-arrow {{ $errors->has('type') ? ' has-danger' : '' }}"
                                        data-style="btn-primary"
                                        onchange="confirm('{{ __('¿Estás seguro de que deseas autorizar este pedido?') }}') ? autorizar(`input-type{{ $order->id }}`,`auth{{ $order->id }}`,`input{{ $order->id }}`) : ''">
                                        <option selected disabled>{{ __('Autorizar') }}</option>
                                        <option value="prepago">{{ __('Prepago') }}</option>
                                        <option value="credito">{{ __('Crédito') }}</option>
                                        <option value="itzel">{{ __('Itzel') }}</option>
                                    </select>
                                </div>
                                @if ($errors->has('type'))
                                    <span id="name-type" class="error text-danger"
                                        for="input-type">{{ $errors->first('type') }}</span>
                                @endif
                                <input id="input{{ $order->id }}" type="hidden" name="type" value="">
                                {{-- <button type="button" class="btn btn-success btn-link" title="Autorizar el pedido"
                                    onclick="confirm('{{ __('¿Estás seguro de que deseas autorizar este pedido?') }}') ? this.parentElement.submit() : ''">
                                    <i class="material-icons">done</i>
                                    <div class="ripple-container"></div>
                                </button> --}}
                            </form>
                        @endif
                        @if ($status == 1)
                            <form action="{{ route('deny', $order) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger btn-link" title="Denegar el pedido"
                                    data-toggle="modal" data-target="#exampleModalLong{{ $order->id }}">
                                    <i class=" material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                                {{-- modal --}}
                                @include('partials._modal',[$id=$order->id,$see=false])
                            </form>
                        @endif
                        @if ($status == 2)
                            <form action="{{ route('restore', $order) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger btn-link" title="Deshacer autorización"
                                    data-toggle="modal" data-target="#exampleModalLong{{ $order->id }}">
                                    <i class="material-icons">replay</i>
                                    <div class="ripple-container"></div>
                                </button>
                                {{-- modal --}}
                                @include('partials._modal',[$id=$order->id,$see=false])
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
</tbody>
@push('js')
    <script>
        function autorizar(button, form, input) {
            document.getElementById(button).disabled = true;
            $(`#${button}`).selectpicker('refresh');
            document.getElementById(input).value = document.getElementById(button).value;
            document.getElementById(form).submit();
        }
    </script>
@endpush
