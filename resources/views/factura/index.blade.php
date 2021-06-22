@extends('layouts.app', ['activePage' => 'Factura ', 'titlePage' => __('Solicitud de factura')])

@section('content')

<div class="content">
        <div class="container-fluid">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="card card-nav-tabs">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col mt-3">{{ __('Factura') }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href=""
                                        class="btn btn-sm btn-success">{{ __('Descargar Factura') }}</a>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <label class="col-sm-2 col-form-label">{{ __('Folio de Factura') }}</label>
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="folio"
                                        id="folio" type="text" placeholder="{{ __('Ingrese el folio de la factura') }}"
                                        required="true" aria-required="true" />
                   
                                     </div>
                                </div>
                             </div>
                             <div class="row justify-content-center">
                                 <label class="col-sm-2 col-form-label">{{ __('Cantidad Facturada') }}</label>
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                     <input class="form-control" name="cantidadF"
                                      id="cantidadF" type="text" placeholder="{{ __('Ingrese la cantidad facturada') }}"
                                      required="true" aria-required="true" />
                       
                                     </div>
                                </div>
                             </div>

                             <div class="row justify-content-center">
                                 <label class="col-sm-2 col-form-label">{{ __('Producto') }}</label>
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                     <input class="form-control" name="producto"
                                     id="producto" type="text" placeholder="{{ __('Ingrese el producto a facturar') }}"
                                     required="true" aria-required="true" 
                                    />
                                     </div>
                                 </div>
                             </div>

                             

                             <div class="row justify-content-center">
                                 <label class="col-sm-2 col-form-label">{{ __('Litros Netos') }}</label>
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                     <input class="form-control" name="litrosN"
                                     id="litosN" type="text" placeholder="{{ __('Litros Netos de productos') }}"
                                     required="true" aria-required="true" 
                                    />
                                     </div>
                                 </div>
                             </div>

                             <div class="row justify-content-center">
                                <label class="col-sm-2 col-form-label">{{ __('Factura') }}</label>
                                <div class="col-sm-7">
                                        <p>
                                            <input  class="factura" type="file" name="factura" max_file_uploads="2" accept=".pdf, .xml">
                                        </p>
                                </div>   
                             </div>
                            
                             <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">{{ __('Registrar Datos') }}</button>
                             </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="card card-nav-tabs">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col mt-3">{{ __('Pagos') }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href=""
                                        class="btn btn-sm btn-success">{{ __('Descargar Estado de Cuenta') }}</a>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <label class="col-sm-2 col-form-label">{{ __('Registrar Pago') }}</label>
                                 <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="rpago"
                                        id="rpago" type="text" placeholder="{{ __('Ingrese el monto del pago') }}"
                                        required="true" aria-required="true" />
                   
                                     </div>
                                </div>
                             </div>

                            <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">{{ __('Registrar Pago') }}</button>
                            </div> 
                           

                          

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
</div>



@endsection