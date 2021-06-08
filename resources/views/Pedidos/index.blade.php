@extends('layouts.app', ['activePage' => 'Ejemplo1', 'titlePage' => __('Ejemplo1')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="container-fluid mt-3">
            <div class="row">

                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col mt-3">Pedidos  </div>
                            
                        </div>
                    </div>
                   
                    <div class="card-body">

                        <h4 class="newstyle"> LA GUERRERA & OIL ENERGY S.A. DE C.V. </h4>
                        <h4 class="newstyle">Ship to 6002936</h4>
                        <br>
                      <form name= "calculadora">  
                        <h5 class="newstyle2">Lunes </h5>
                        <div class="row " id="content">
                            
                         <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularL" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                            <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumL" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselL" id="dieselL" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                          
                        </div>
                        <h5 class="newstyle2">Martes</h5>
                        <div class="row " id="content">
                            
                         <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularMa" id="input-name" onKeyUp="Suma()" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                            <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumMa" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselMa" id="dieselMa" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                          
                        </div>

                        <h5 class="newstyle2">Miércoles</h5>
                        <div class="row " id="content">
                            
                         <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularMi" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                            <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumMi" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselMi" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                          
                        </div>

                        <h5 class="newstyle2">Jueves</h5>
                        <div class="row " id="content">
                            
                         <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularJ" onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                            <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumJ"  onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselJ" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                          
                        </div>
                        <h5 class="newstyle2">Viernes</h5>
                        <div class="row " id="content">
                            
                         <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularV" onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                            <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumV" onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselV" id="input-name" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                </div>
                          
                        </div>
                        <h5 class="newstyle2">Sábado</h5>
                        <div class="row " id="content">
                            
                                <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="regularS" onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                           
                                <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="premiumS" onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="dieselS"  onKeyUp="Suma()" id="input-name" type="text" placeholder="Cantidad en litros." value required="true">
                                </div>
                                
                        </div>
                        <h5 class="newstyle2">Total semanal de litros por producto</h5>
                        <div class="row " id="content">
                            
                                <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="resultado"  id="resultado" type="text" placeholder="Total de Litros." disabled>
                                </div>
                           
                                <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="resultado2" id="resultado2" type="text" placeholder="Total de litros." disabled>
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="resultado3" id="resultado3" onKeyUp="Suma()" type="text" placeholder="Total de litros." disabled>
                                </div>
                                
                        </div>
                        
                        <div class="row justify-content-center" id="content">
                         <label class="col-sm-2 col-form-label">Fecha de entrega</label>
                            <div class="col-sm-7">
                                <div class="form-group bmd-form-group">
                                <script>
                                 $(function(){
                                 $("#datepicker").datepicker({
                                    dateFormat: "dd-mm-yy"
                                                        });
                                                        });
                        
                                   </script>
                                    <input   class="form-control" type="text" id="datepicker" placeholder="00/00/0000">
                                </div>
                                
                            </div>
                        
                        </div>

                        
                        
                            </div>
                                    <div class="card-footer ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary">{{ $button ?? __('Realizar Pedido') }}</button>
                                     </div>
                                                    </form>
                        </div>
                
            </div>
            
        </div>
    </div>
</div>

@endsection
