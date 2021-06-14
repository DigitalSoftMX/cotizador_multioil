@extends('layouts.app', ['activePage' => 'Ejemplo1', 'titlePage' => __('Ejemplo1')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="container-fluid mt-3">
            <div class="row">

                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col mt-3">Pedido Semanal </div>
                            
                        </div>
                    </div>
                   
                    <div class="card-body">

                 <form action="{{url('/pedidos')}}" method="post" name= "calculadora" >  
                 {{csrf_field()}}


                    <div class="row">
                        <div
                                        class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col">
                                        <select id="input-terminal_id" name="terminal_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">{{ __('Elija una terminal') }}</option>
                                            @foreach ($terminals as $terminal)
                                                <option value="{{ $terminal->id }}">{{ $terminal->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('terminal_id'))
                                            <span id="name-terminal_id" class="error text-danger"
                                                for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                                        @endif
                         </div>
                                  <div
                                        class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col">
                                        <select id="input-company_id" name="company_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">{{ __('Compañia') }}</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('company_id'))
                                            <span id="name-company_id" class="error text-danger"
                                                for="input-company_id">{{ $errors->first('company_id') }}</span>
                                        @endif
                                    </div>
                            <div class="col"  >
                            <label class="alineacion">¿Necesita flete?</label></br>
                             <div class="form-check-inline alineacion">
                                 <label class="form-check-label" for="radio1">
                                 <input type="radio" class="form-check-input" id="nflete" name="nflete" value="Si" checked>SI
                                 </label>
                              </div>
                              <div class="form-check-inline alineacion">
                                  <label class="form-check-label" for="radio2">
                                  <input type="radio" class="form-check-input" id="nflete" name="nflete" value="No">NO
                                  </label>
                              </div>
                            
                            </div>
                         <div class="col"  >
                         
                              <label>¿Necesita un seguro?</label><br>
                             <div class="form-check-inline">
                                 <label class="form-check-label" for="radio3">
                                 <input type="radio" class="form-check-input" id="nseguro" name="nseguro" value="Si" checked>SI
                                 </label>
                              </div>
                              <div class="form-check-inline">
                                  <label class="form-check-label" for="radio4">
                                  <input type="radio" class="form-check-input" id="nseguro" name="nseguro" value="No">NO
                                  </label>
                              </div>
                         </div>
                        </div>
                        
                        
                        

                        <div class="row">
                            <div class="col">
                        <div class="card" style="width:230px">
                        <div class="card-body">
                        <h5 class="newstyle2">Lunes:
                        <input class=form-control name="monday" type="text"class="newstyle7" id="monday" style="width:150px"> </input></h5>
                   
                            
                         <label class="color1">Regular: &nbsp &nbsp</label>
                            
                              
                                    <input class="form-control" name="regularL" id="regularL" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                              
                           
                            <label class="color2">Premium: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="premiumL" id="premiumL" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                
                                <label class="color3">Diésel: &nbsp &nbsp</label>
                          
                                
                                    <input class="form-control" name="dieselL" id="dieselL" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                
                        </div>
                        </div>
                        </div>
                            <div class="col">
                        <div class="card" style="width:230px">
                        <div class="card-body">
                        
                        <h5 class="newstyle2">Martes:
                        <input class=form-control name="tuesday" type="text"class="newstyle7" id="tuesday" style="width:150px"> </input>
                        </h5>
                        
                            
                         <label class="color1">Regular: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="regularMa" id="regularMa" onKeyUp="Suma()" type="text" placeholder="Cantidad en litros." value required="true">
                                
                            <label class="color2">Premium: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="premiumMa" id="premiumMa" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                
                                <label class="color3">Diésel: &nbsp &nbsp</label>
                          
                              
                                    <input class="form-control" name="dieselMa" id="dieselMa" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                               

                        </div>
                        </div>
                        </div>
                        <div class="col">
                        <div class="card" style="width:230px">
                        <div class="card-body">
                        <h5 class="newstyle2">Miércoles:
                        <input class=form-control name="wednesday" type="text"class="newstyle7" id="wednesday" style="width:150px"> </input>
                        </h5>
                       
                            
                         <label class="color1">Regular: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="regularMi" id="regularMi" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                               
                           
                            <label class="color2">Premium: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="premiumMi" id="premiumMi" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                               
                                <label class="color3" >Diésel: &nbsp &nbsp</label>
                          
                                
                                    <input class="form-control" name="dieselMi" id="dieselMi" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                                
                          
                  
                        </div>
                        </div>
                        </div>

                       
                        </div>




                        
                        <div class="row">
                            <div class="col">
                        <div class="card" style="width:230px">
                        <div class="card-body">
                        <h5 class="newstyle2">Jueves:
                        <input class=form-control name="thursday" type="text"class="newstyle7" id="thursday" style="width:150px"> </input>
                        </h5>
                        
                            
                         <label class="color1" >Regular: &nbsp &nbsp</label>
                            
                               
                                    <input class="form-control" name="regularJ" onKeyUp="Suma()" id="regularJ" type="text" placeholder="Cantidad en litros." value required="true">
                             
                           
                            <label class="color2">Premium: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="premiumJ"  onKeyUp="Suma()" id="premiumJ" type="text" placeholder="Cantidad en litros." value required="true">
                              
                                <label class="color3" >Diésel: &nbsp &nbsp</label>
                          
                               
                                    <input class="form-control" name="dieselJ" id="dieselJ" type="text" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                               
                  
                        </div>
                        </div>
                        </div>
                            <div class="col">
                        <div class="card" style="width:230px">
                        <div class="card-body">
                        <h5 class="newstyle2">Viernes:
                        <input class=form-control name="friday" type="text"class="newstyle7" id="friday" style="width:150px"> </input>
                        </h5>
                       
                            
                         <label class="color1"> Regular: &nbsp &nbsp</label>
                            
                               
                                    <input class="form-control" name="regularV" onKeyUp="Suma()" id="regullarV" type="text" placeholder="Cantidad en litros." value required="true">
                                
                           
                            <label class="color2"> Premium: &nbsp &nbsp</label>
                            
                              
                                    <input class="form-control" name="premiumV" onKeyUp="Suma()" id="premiumV" type="text" placeholder="Cantidad en litros." value required="true">
                               
                                <label class="color3">Diésel: &nbsp &nbsp</label>
                          
                                
                                    <input class="form-control" name="dieselV" id="input-name" type="dieselV" onKeyUp="Suma()" placeholder="Cantidad en litros." value required="true">
                               
                          
                       
                  
                        </div>
                        </div>
                        </div>
                        <div class="col">
                        <div class="card borders" style="width:230px">
                        <div class="card-body borders">
                        <h5 class="newstyle2">Sábado:
                        <input class=form-control name="saturday" type="text"class="newstyle7" id="saturday" style="width:150px"> </input>
                        </h5>
                        
                            
                                <label class="color1">Regular: &nbsp &nbsp</label>
                            
                               
                                    <input class="form-control" name="regularS" onKeyUp="Suma()" id="regularS" type="text" placeholder="Cantidad en litros." value required="true">
                               
                           
                                <label class="color2" >Premium: &nbsp &nbsp</label>
                            
                                
                                    <input class="form-control" name="premiumS" onKeyUp="Suma()" id="premiumS" type="text" placeholder="Cantidad en litros." value required="true">
                               
                                <label class="color3" >Diésel: &nbsp &nbsp</label>
                          
                                
                                    <input class="form-control" name="dieselS"  onKeyUp="Suma()" id="dieselS" type="text" placeholder="Cantidad en litros." value required="true">
                               
                  
                        </div>
                        </div>
                        </div>

                       
                        </div>


                      
                        <h5 class="newstyle8">Total semanal de litros por producto</h5>
                        <div class="row " id="content">
                            
                                <label class="col-sm-2 col-form-label">Regular &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="totalR"  id="totalR" type="text" placeholder="Total de Litros." readonly>
                                </div>
                           
                                <label class="col-sm-2 col-form-label">Premium &nbsp &nbsp</label>
                            
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="totalP" id="totalP" type="text" placeholder="Total de litros." readonly>
                                </div>
                                <label class="col-sm-2 col-form-label">Diésel &nbsp &nbsp</label>
                          
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="totalD" id="totalD" onKeyUp="Suma()" type="text" placeholder="Total de litros." readonly>
                                </div>
                                
                        </div>
                        <h5 class="newstyle9">Total de Litros &nbsp &nbsp</h5>
                          
                          <div class="form-group bmd-form-group">
                              <input class="form-control" name="grantotal" id="grantotal" onKeyUp="Suma()" type="text" placeholder="Total de litros." readonly>
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
@push('js')
    <script>
        let date = new Date();
        let actualOrder = `${date.getMonth() + 1}-${date.getDate() + 1}-${date.getFullYear()}`;
        let dayofweek=`${date.getDay()}`;
        if(dayofweek<=3){
            init_calendar('calendar_first', moment().startOf('isoWeek').add(1, 'week'),moment().startOf('isoWeek').add(1, 'week'));

            init_calendar('monday', moment().startOf('isoWeek').add(1, 'week'),moment().startOf('isoWeek').add(1, 'week'));
            init_calendar('tuesday', moment().day(1 + 1).add(1, 'week'),moment().day(1 + 1).add(1, 'week')); 
            init_calendar('wednesday', moment().day(1 + 2).add(1, 'week'),moment().day(1 + 2).add(1, 'week')); 
            init_calendar('thursday', moment().day(1 + 3).add(1, 'week'),moment().day(1 + 3).add(1, 'week')); 
            init_calendar('friday', moment().day(1 + 4).add(1, 'week'),moment().day(1 + 4).add(1, 'week')); 
            init_calendar('saturday', moment().day(1 + 5).add(1, 'week'),moment().day(1 + 5).add(1, 'week')); 
           
        }
        else{
            init_calendar('calendar_first', moment().startOf('isoWeek').add(2, 'week'),moment().day(1 + 5).add(2, 'week'));
           
            init_calendar('monday', moment().startOf('isoWeek').add(2, 'week'),moment().startOf('isoWeek').add(2, 'week'));
            init_calendar('tuesday', moment().day(1 + 1).add(2, 'week'),moment().day(1 + 1).add(2, 'week')); 
            init_calendar('wednesday', moment().day(1 + 2).add(2, 'week'),moment().day(1 + 2).add(2, 'week')); 
            init_calendar('thursday', moment().day(1 + 3).add(2, 'week'),moment().day(1 + 3).add(2, 'week')); 
            init_calendar('friday', moment().day(1 + 4).add(2, 'week'),moment().day(1 + 4).add(2, 'week')); 
            init_calendar('saturday', moment().day(1 + 5).add(2, 'week'),moment().day(1 + 5).add(2, 'week')); 
        }
        
        // calculo de precio total pedido
        $(document).on("keyup", "#liters_r", function() {
            let litersR = document.getElementById('liters_r').value;
            let priceR = document.getElementById('price_r').value;
            priceR != '' ? document.getElementById('total_r').value = litersR * priceR : '';
        });
        $(document).on("keyup", "#liters_p", function() {
            let litersR = document.getElementById('liters_p').value;
            let priceR = document.getElementById('price_p').value;
            priceR != '' ? document.getElementById('total_p').value = litersR * priceR : '';
        });
        $(document).on("keyup", "#liters_d", function() {
            let litersR = document.getElementById('liters_d').value;
            let priceR = document.getElementById('price_d').value;
            priceR != '' ? document.getElementById('total_d').value = litersR * priceR : '';
        });
        // select de terminales
        $(".selectpicker").change(function() {
            let terminal = document.getElementById('input-terminal').value;
            let company = document.getElementById('input-company_id').value;
        });
        $('#input-terminal').change(function() {
            let terminal = document.getElementById('input-terminal').value;
            getTerminals(terminal);
        });
        // select de empresas o clientes
        $('#input-company_id').change(function() {
            let company = document.getElementById('input-company_id').value;
            let terminal = document.getElementById('input-terminal').value;
            company != '' ? getPrices(company, terminal) : '';
        });
        // funcion para listar las empresas correspondientes a la terminal
        async function getTerminals(terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getcompanies/' + terminal_id);
                const companies = await resp.json();
                $('#input-company_id').children('option').remove();
                $('#input-company_id').append( /* html */ `
                            <option value="">Elija un empresa</option>
                        `);
                companies.companies.forEach(company => {
                    $('#input-company_id').append( /* html */ `
                                <option value="${company.id}">${company.name}</option>
                            `);
                });
                $('#input-company_id').selectpicker('refresh');
            } catch (error) {
                console.log(error)
            }
        }
        // funcion para obtener los ultimos precios de la empresa y terminal
        async function getPrices(company_id, terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getlastprice/' + `${company_id}/${terminal_id}`);
                const prices = await resp.json();
                document.getElementById('price_r').value = prices.prices.regular + prices.fees.regular_fit;
                document.getElementById('price_p').value = prices.prices.premium + prices.fees.premium_fit;
                document.getElementById('price_d').value = prices.prices.diesel + prices.fees.diesel.fit;
            } catch (error) {
                console.log(error)
            }
        }

    </script>
@endpush

