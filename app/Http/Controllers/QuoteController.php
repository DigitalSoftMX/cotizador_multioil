<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terminal;
use App\Fit;
use App\Discount;
use App\Competition;
use App\Valero;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $precios_estaticos =  Competition::where('terminal_id', '3')->first()->prices->last();

        $discount_r = Discount::where([['producto', 'M'], ['vigencia_now', true], ['nombre', 'Valero']])->first();
        $discount_p = Discount::where([['producto', 'P'], ['vigencia_now', true], ['nombre', 'Valero']])->first();
        $discount_d = Discount::where([['producto', 'D'], ['vigencia_now', true], ['nombre', 'Valero']])->first();

        $discount_r_p = Discount::where([['producto', 'M'], ['vigencia_now', true], ['nombre', 'Pemex']])->first();
        $discount_p_p = Discount::where([['producto', 'P'], ['vigencia_now', true], ['nombre', 'Pemex']])->first();
        $discount_d_p = Discount::where([['producto', 'D'], ['vigencia_now', true], ['nombre', 'Pemex']])->first();

        $regular[][] = [];
        $premium[][] = [];
        $disel[][] = [];

        $regular_p[][] = [];
        $premium_p[][] = [];
        $disel_p[][] = [];

        for ($i = 1; $i < 11; $i++) {
            $indice = "nivel_" . $i;

            $discounts_arrayR = explode(",", $discount_r->$indice);
            $discounts_arrayP = explode(",", $discount_p->$indice);
            $discounts_arrayD = explode(",", $discount_d->$indice);

            $discounts_arrayR_P = explode(",", $discount_r_p->$indice);
            $discounts_arrayP_P = explode(",", $discount_p_p->$indice);
            $discounts_arrayD_P = explode(",", $discount_d_p->$indice);

            for ($j = 0; $j < 3; $j++) {
                $regular[$i - 1][$j] = $discounts_arrayR[$j];
                $premium[$i - 1][$j] = $discounts_arrayP[$j];
                $disel[$i - 1][$j] = $discounts_arrayD[$j];

                $regular_p[$i - 1][$j] = $discounts_arrayR_P[$j];
                $premium_p[$i - 1][$j] = $discounts_arrayP_P[$j];
                $disel_p[$i - 1][$j] = $discounts_arrayD_P[$j];
            }
        }

        return view('cotizador.index', ['terminals' => Terminal::where([['id', '!=', 1], ['id', '!=', 2], ['id', '!=', 5]])->get(), 'fits' => Fit::find(3), 'regular' => $regular, 'premium' => $premium, 'disel' => $disel, 'regular_pemex' => $regular_p, 'premium_pemex' => $premium_p, 'diesel_pemex' => $disel_p, 'precios_puebla' => $precios_estaticos]);
    }


    public function cotizador_sele(Request $request, Fit $fit_model)
    {
        $terminal_seleciona = $request['terminal'];
        if ($terminal_seleciona == "") {
            $terminal_seleciona = "3";
        }
        $fits = $fit_model::where('terminal_id', $request['terminal'])->get()->last();
        $competitions = Competition::where('terminal_id', $terminal_seleciona)->get()->last();
        $precios = $competitions->prices[count($competitions->prices) - 1];
        $selecion = array('precios' => $precios, 'fits' => $fits);
        return json_encode($selecion);
    }

    public function calendario_edit(Request $request, Valero $valero)
    {
        $terminal_seleciona = $request['idTerminal'];
        $fecha = $request['fecha'];
        $precio_r = $request['precio_r'];
        $precio_p = $request['precio_p'];
        $precio_d = $request['precio_d'];

        if ($terminal_seleciona == "") {
            $terminal_seleciona = "3";
        }

        if ($valero::where('terminal_id', $terminal_seleciona)->where('created_at', 'like', '' . $fecha . '%')->update(['precio_regular' => $precio_r, 'precio_premium' => $precio_p, 'precio_disel' => $precio_d])) {
            $mensaje = 'Precios actualizados correctamente.';
            $color = 'success';
        } else {
            $mensaje = 'Error al actualizar los precios.';
            $color = 'danger';
        }

        $selecion = array('mensaje' => $mensaje, 'color' => $color);
        return json_encode($selecion);
    }

    public function flete(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Invitado', 'Vendedor', 'Ventas']);
        $display = "block";
        if (auth()->user()->roles[0]->name == 'Invitado') {
            $display = "none";
        }


        /* Asignación temporal, debe llevarse a un modelo, controlador,
         migracion y guardado en la base de datos   */

        $locations = array();

        $station['name'] = 'Monterrey Cadereyta';
        $station['address'] = 'Autopista Monterrey Reynosa km. 32 s/n colonia centro municipio Cadereyta Jimenez Nuevo León, C.P. 67480';
        $station['longitude'] = -99.97349;
        $station['latitude'] = 25.60259;
        array_push($locations, $station);

        $station['name'] = 'Guadalajara Silos Tysa';
        $station['address'] = 'Camino a Industrias GOSA # 133, San Jose del Castillo entre camino al Conico y Carretera a la capilla C.P. 45679, El Salto, Jalisco, México';
        $station['longitude'] = -103.227684;
        $station['latitude'] = 20.477778;
        array_push($locations, $station);

        $station['name'] = 'Nuevo Laredo';
        $station['address'] = 'NuStar Internacional Terminal de Nuevo Laredo';
        $station['longitude'] = -99.585476;
        $station['latitude'] = 27.594878;
        array_push($locations, $station);

        $station['name'] = 'Chihuahua (Cd. Cuauhtémoc)';
        $station['address'] = 'Prologación Juarez y Gómez Mórin Campo 25 (Brecha al campo 24) 1.8 km la segunda bodega C.d Cuauhtemoc, Chihuahua';
        $station['longitude'] = -106.844421;
        $station['latitude'] = 28.449421;
        array_push($locations, $station);

        $station['name'] = 'Puebla (Huejotzingo)';
        $station['address'] = 'Kilometro 4.8 libramiento autopista Mexico - Puebla s/n camino al Aereopuerto Hermanos Serdán';
        $station['longitude'] = -98.360400;
        $station['latitude'] = 19.207747;
        array_push($locations, $station);

        $station['name'] = 'Veracruz (Nvo. Puerto de Veracruz)';
        $station['address'] = 'Terminal de refinados Veracruz. Nuevo Puerto de Veracruz';
        $station['longitude'] = -96.171805;
        $station['latitude'] = 19.245784;
        array_push($locations, $station);

        $station['name'] = 'Edo. de México (Tizayuca)';
        $station['address'] = 'Carretera Otumba - Axapusco - Temascalapa km 289 Tizayuca, Edo de México.';
        $station['longitude'] = -98.899701;
        $station['latitude'] = 19.831391;
        array_push($locations, $station);

        return view('flete.index', ['display' => $display, 'locations' => $locations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Valero $valero)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $valero->create($request->all());
        return redirect()->route('cotizador.index')->withStatus(__('Precio agregado correctamente.'));
    }


    public function calendario_selec(Request $request, Terminal $model)
    {
        $terminal_seleciona = $request['terminal'];
        $fecha = $request['fecha'];
        $precios = Valero::where('terminal_id', $terminal_seleciona)->where('created_at', 'like', '' . $fecha . '%')->get();
        $selecion = array('precios' => $precios);
        return json_encode($selecion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
