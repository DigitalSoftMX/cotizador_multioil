<thead class=" text-primary">
    <th class="text-center">{{ __('Empresa') }}</th>
    <th class="text-center">{{ __('Datos del pedido') }}</th>
    <th class="text-center">{{ __('Fechas de entrega') }}</th>
    <th class="text-right">{{ __('Acciones') }}</th>
</thead>
<tbody>
    @foreach ($pedidos as $pedido)
        @if ($status == $pedido->status_id)
            <tr>
                <td class="text-center">{{ $pedido->company->name }}</td>
                <td class="text-center">
                    <table style="width:100%" class="table table-sm">

                        <tr>
                            <td>Total de litros Regular</td>
                            <td> {{ number_format($pedido->totalR, 0) }} LTS</td>

                        </tr>


                        <tr>
                            <td>Total de litros Premium</td>
                            <td> {{ number_format($pedido->totalP, 0) }} LTS</td>

                        </tr>


                        <tr>
                            <td>Total de litros Diesel</td>
                            <td> {{ number_format($pedido->totalD, 0) }} LTS</td>

                        </tr>

                    </table>
                </td>
                <td class="text-center">Lunes: {{ date('Y-m-d', strtotime($pedido->monday)) }} al Sábado:
                    {{ date('Y-m-d', strtotime($pedido->saturday)) }}</td>
                <td class="td-actions justify-content-end">
                    <a rel="tooltip" class="btn btn-dark btn-link" href="" data-original-title="" title=""
                        data-toggle="modal" data-target="#exampleModalLong{{ $pedido->id }}see">
                        <i class="material-icons">visibility</i>
                        <div class="ripple-container"></div>
                    </a>
                    {{-- modal --}}
                    @include('partials._modalS',[$id=$pedido->id.'see',$see=true])
                    @if (auth()->user()->roles->first()->id == 1)
                        @if ($status == 1 || $status == 3)
                            <form action="{{ route('accept', $pedido) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-success btn-link" data-original-title="" title=""
                                    onclick="confirm('{{ __('¿Estás seguro de que deseas autorizar este pedido?') }}') ? this.parentElement.submit() : ''">
                                    <i class="material-icons">done</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </form>
                        @endif
                        @if ($status == 1)
                            <form action="{{ route('deny', $pedido) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger btn-link" data-original-title="" title=""
                                    data-toggle="modal" data-target="#exampleModalLong{{ $pedido->id }}">
                                    <i class=" material-icons">close</i>
                                    <div class="ripple-container"></div>
                                </button>
                                {{-- modal --}}
                                @include('partials._modalS',[$id=$pedido->id,$see=false])
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
</tbody>
