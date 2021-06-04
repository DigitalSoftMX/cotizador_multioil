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
