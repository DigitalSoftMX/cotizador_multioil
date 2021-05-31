<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terminal;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Invitado', 'Vendedor', 'Ventas']);

        $day = date("d", mktime(0, 0, 0, date('m') + 1, 0, date('m')));
        $firstDay = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $terminales = array();

        /* Precios Multioil */
        $precios_aar_multioil = array();

        $meses_espaniol = array();
        $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        for ($i = 1; $i <= date('m'); $i++) {
            $monthNumber = date("m", mktime(0, 0, 0, $i, 1, 2000));
            array_push($meses_espaniol, array(
                'numerMonth' => $monthNumber,
                'nameMonth' => $mes[$i - 1]
            ));
        }

        foreach (Terminal::all() as $terminal) {
            $datos = array();
            array_push($datos, $terminal->razon_social);

            $fechas = array();
            $fechas1 = array();
            $fechas2 = array();
            $fechas3 = array();
            $fechas4 = array();
            $fechas5 = array();
            $fechas6 = array();
            $fechas7 = array();

            $precios_valero_regular = array();
            $precios_valero_premium = array();
            $precios_valero_diesel = array();

            $precios_pemex_regular = array();
            $precios_pemex_premium = array();
            $precios_pemex_diesel = array();

            $precios_policon_regular = array();
            $precios_policon_premium = array();
            $precios_policon_diesel = array();

            $precios_impulsa_regular = array();
            $precios_impulsa_premium = array();
            $precios_impulsa_diesel = array();

            $precios_hamse_regular = array();
            $precios_hamse_premium = array();
            $precios_hamse_diesel = array();

            $precios_potesta_regular = array();
            $precios_potesta_premium = array();
            $precios_potesta_diesel = array();

            $precios_energo_regular = array();
            $precios_energo_premium = array();
            $precios_energo_diesel = array();

            $precios_aar_regular = array();
            $precios_aar_premium = array();
            $precios_aar_diesel = array();


            foreach ($terminal->valeros()->whereDate('created_at', '>=', $firstDay)->get()->sortBy('created_at') as $valero) {
                array_push($fechas1, $valero->created_at->format('j - m'));
                array_push($precios_valero_regular, ($valero->precio_regular - $terminal->fits->last()->regular_fit));
                array_push($precios_valero_premium, ($valero->precio_premium - $terminal->fits->last()->premium_fit));
                array_push($precios_valero_diesel, ($valero->precio_disel - $terminal->fits->last()->disel_fit));
            }

            foreach ($terminal->competitions()->orderBy('created_at')->get() as $competition) {
               // return $terminal->competitions()->orderBy('created_at')->get();
                foreach ($competition->prices()->orderBy('created_at')->get() as $price) {
                    if ($price->created_at >= $firstDay) {
                        array_push($fechas2, $price->created_at->format('j - m'));
                        array_push($precios_pemex_regular, $price->precio_regular);
                        array_push($precios_pemex_premium, $price->precio_premium);
                        array_push($precios_pemex_diesel, $price->precio_disel);

                        /* Obtenemos los precios de AAR */
                        array_push($precios_aar_regular, floatval($price->precio_regular) - 0.90);
                        array_push($precios_aar_premium, floatval($price->precio_premium) - 0.90);
                        array_push($precios_aar_diesel, floatval($price->precio_disel) - 1.70);
                    }
                }

                array_push($precios_aar_multioil, $precios_aar_regular, $precios_aar_premium, $precios_aar_diesel);
            }

            foreach ($terminal->policons()->orderBy('created_at')->get() as $policons) {
                foreach ($policons->price_policon()->orderBy('created_at')->get() as $price1) {
                    if ($price1->created_at >= $firstDay) {
                        array_push($fechas3, $price1->created_at->format('j - m'));
                        array_push($precios_policon_regular, $price1->precio_regular);
                        array_push($precios_policon_premium, $price1->precio_premium);
                        array_push($precios_policon_diesel, $price1->precio_disel);
                    }
                }
            }


            foreach ($terminal->impulsas()->orderBy('created_at')->get() as $impulsas) {
                foreach ($impulsas->price_impulsa()->orderBy('created_at')->get() as $price2) {
                    if ($price2->created_at >= $firstDay) {
                        array_push($fechas4, $price2->created_at->format('j - m'));
                        array_push($precios_impulsa_regular, $price2->precio_regular);
                        array_push($precios_impulsa_premium, $price2->precio_premium);
                        array_push($precios_impulsa_diesel, $price2->precio_disel);
                    }
                }
            }

            foreach ($terminal->hamses()->orderBy('created_at')->get() as $hamses) {
                foreach ($hamses->price_hamse()->orderBy('created_at')->get() as $price3) {
                    if ($price3->created_at >= $firstDay) {
                        $precio_descuesto_regular = floatval($price3->precio_regular) - floatval(0.65);
                        $precio_descuesto_premium = floatval($price3->precio_premium) - floatval(0.62);
                        $precio_descuesto_diesel = floatval($price3->precio_disel) - (0.75);

                        array_push($fechas5, $price3->created_at->format('j - m'));
                        array_push($precios_hamse_regular, $precio_descuesto_regular);
                        array_push($precios_hamse_premium, $precio_descuesto_premium);
                        array_push($precios_hamse_diesel, $precio_descuesto_diesel);
                    }
                }
            }

            foreach ($terminal->potestas()->orderBy('created_at')->get() as $potestas) {
                foreach ($potestas->price_potesta()->orderBy('created_at')->get() as $price4) {
                    if ($price4->created_at >= $firstDay) {

                        if ($price4->potesta_id == 3) {
                            // Puebla
                            $precio_descuesto_regular = floatval($price4->precio_regular) - floatval(0.55);
                            $precio_descuesto_premium = floatval($price4->precio_premium) - floatval(0.20);
                            $precio_descuesto_diesel = floatval($price4->precio_disel) - floatval(0.74);
                        } elseif ($price4->potesta_id == 6) {
                            // Veracruz

                            $precio_descuesto_regular = floatval($price4->precio_regular) - floatval(0.1);
                            $precio_descuesto_premium = floatval($price4->precio_premium);
                            $precio_descuesto_diesel = floatval($price4->precio_disel) - floatval(0.1);
                        } elseif ($price4->potesta_id == 7) {
                            // Queretaro
                            $precio_descuesto_regular = floatval($price4->precio_regular) - floatval(0.55);
                            $precio_descuesto_premium = floatval($price4->precio_premium) - floatval(0.20);
                            $precio_descuesto_diesel = floatval($price4->precio_disel) - floatval(0.74);
                        } elseif ($price4->potesta_id == 4) {
                            // Mexico
                            $precio_descuesto_regular = floatval($price4->precio_regular) - floatval(0.50);
                            $precio_descuesto_premium = floatval($price4->precio_premium) - floatval(0.30);
                            $precio_descuesto_diesel = floatval($price4->precio_disel) - floatval(0.80);
                        }

                        array_push($fechas6, $price4->created_at->format('j - m'));
                        array_push($precios_potesta_regular, $precio_descuesto_regular);
                        array_push($precios_potesta_premium, $precio_descuesto_premium);
                        array_push($precios_potesta_diesel, $precio_descuesto_diesel);
                    }
                }
            }

            foreach ($terminal->energos()->orderBy('created_at')->get() as $energos) {
                foreach ($energos->price_energo()->orderBy('created_at')->get() as $price5) {
                    if ($price5->created_at >= $firstDay) {

                        if ($price5->energo_id == 4) {
                            // Añil
                            $precio_descuesto_regular = floatval($price5->precio_regular);
                            $precio_descuesto_premium = floatval($price5->precio_premium);
                            $precio_descuesto_diesel = floatval($price5->precio_disel) - floatval(0.75);
                        } elseif ($price5->energo_id == 7) {
                            // Queretaro
                            $precio_descuesto_regular = $price5->precio_regular;
                            $precio_descuesto_premium = $price5->precio_premium;
                            $precio_descuesto_diesel = floatval($price5->precio_disel) - floatval(0.80);
                        }

                        array_push($fechas7, $price5->created_at->format('j - m'));
                        array_push($precios_energo_regular, $precio_descuesto_regular);
                        array_push($precios_energo_premium, $precio_descuesto_premium);
                        array_push($precios_energo_diesel, $precio_descuesto_diesel);
                    }
                }
            }

            $contador1 = count($fechas1);
            $contador2 = count($fechas2);
            $contador3 = count($fechas3);
            $contador4 = count($fechas4);
            $contador5 = count($fechas5);
            $contador6 = count($fechas6);
            $contador7 = count($fechas7);

            if ($contador1 >= $contador2 & $contador1 >= $contador3 & $contador1 >= $contador4 & $contador1 >= $contador5 & $contador1 >= $contador6 & $contador1 >= $contador7) {
                foreach ($terminal->valeros()->orderBy('created_at')->get() as $valero) {
                    if ($valero->created_at >= $firstDay) {

                        $number_mont = $valero->created_at->format('m');
                        array_push($fechas, $valero->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                    }
                }
            } elseif ($contador2 >= $contador1 & $contador2 >= $contador3 & $contador2 >= $contador4 & $contador2 >= $contador5 & $contador2 >= $contador6 & $contador2 >= $contador7) {

                foreach ($terminal->competitions()->orderBy('created_at')->get() as $competition) {
                    foreach ($competition->prices()->orderBy('created_at')->get() as $price) {
                        if ($price->created_at >= $firstDay) {
                            $number_mont = $price->created_at->format('m');
                            array_push($fechas, $price->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } elseif ($contador3 >= $contador1 & $contador3 >= $contador2 & $contador3 >= $contador4 & $contador3 >= $contador5 & $contador3 >= $contador6 & $contador3 >= $contador7) {

                foreach ($terminal->policons()->orderBy('created_at')->get() as $policons) {
                    foreach ($policons->price_policon()->orderBy('created_at')->get() as $price1) {
                        if ($price1->created_at >= $firstDay) {
                            $number_mont = $price1->created_at->format('m');
                            array_push($fechas, $price1->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } elseif ($contador4 >= $contador1 & $contador4 >= $contador2 & $contador4 >= $contador3 & $contador4 >= $contador5 & $contador4 >= $contador6 & $contador4 >= $contador7) {

                foreach ($terminal->impulsas()->orderBy('created_at')->get() as $impulsas) {
                    foreach ($impulsas->price_impulsa()->orderBy('created_at')->get() as $price2) {
                        if ($price2->created_at >= $firstDay) {
                            $number_mont = $price2->created_at->format('m');
                            array_push($fechas, $price2->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } elseif ($contador5 >= $contador1 & $contador5 >= $contador2 & $contador5 >= $contador3 & $contador5 >= $contador4 & $contador5 >= $contador6 & $contador5 >= $contador7) {

                foreach ($terminal->hamses()->orderBy('created_at')->get() as $hamses) {
                    foreach ($hamses->price_hamse()->orderBy('created_at')->get() as $price3) {
                        if ($price3->created_at >= $firstDay) {
                            $number_mont = $price3->created_at->format('m');
                            array_push($fechas, $price3->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } elseif ($contador6 >= $contador1 & $contador6 >= $contador2 & $contador6 >= $contador3 & $contador6 >= $contador4 & $contador6 >= $contador5 & $contador6 >= $contador7) {

                foreach ($terminal->potestas()->orderBy('created_at')->get() as $potestas) {
                    foreach ($potestas->price_potesta()->orderBy('created_at')->get() as $price4) {
                        if ($price4->created_at >= $firstDay) {
                            $number_mont = $price4->created_at->format('m');
                            array_push($fechas, $price4->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } elseif ($contador7 >= $contador1 & $contador7 >= $contador2 & $contador7 >= $contador3 & $contador7 >= $contador4 & $contador7 >= $contador5 & $contador7 >= $contador6) {

                foreach ($terminal->energos()->orderBy('created_at')->get() as $energos) {
                    foreach ($energos->price_energo()->orderBy('created_at')->get() as $price5) {
                        if ($price5->created_at >= $firstDay) {
                            $number_mont = $price5->created_at->format('m');
                            array_push($fechas, $price5->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));
                        }
                    }
                }
            } else {
                echo "Error no hay valores";
            }

            array_push(
                $datos,
                $fechas,
                $precios_valero_regular,
                $precios_pemex_regular,
                $precios_policon_regular,
                $precios_impulsa_regular,
                $precios_hamse_regular,
                $precios_potesta_regular,
                $precios_energo_regular,
                $precios_valero_premium,
                $precios_pemex_premium,
                $precios_policon_premium,
                $precios_impulsa_premium,
                $precios_hamse_premium,
                $precios_potesta_premium,
                $precios_energo_premium,
                $precios_valero_diesel,
                $precios_pemex_diesel,
                $precios_policon_diesel,
                $precios_impulsa_diesel,
                $precios_hamse_diesel,
                $precios_potesta_diesel,
                $precios_energo_diesel
            );

            array_push($terminales, $datos);
        }
        return view('dashboard', compact('fechas', 'terminales', 'precios_aar_multioil', 'meses_espaniol'));
    }

    public function fechas(Request $request, Terminal $terminal)
    {
        $request->user()->authorizeRoles(['Administrador', 'Invitado', 'Vendedor', 'Ventas']);

        // creamos la fecha a buscar
        $fech = date("Y") . '-' . $request->fecha;

        // obtenemos la terminal
        $terminal_uni = $terminal::find($request->id_terminal);

        $fechas = array();
        $precios_valero = array();
        $precios_pemex = array();
        $precios_policon = array();
        $precios_impulsa = array();
        $precios_hamse = array();
        $precios_potesta = array();
        $precios_energo = array();
        $precios_aar = array();

        $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        foreach ($terminal_uni->valeros()->where('terminal_id', $request->id_terminal)->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $valero) {


            $number_mont = $valero->created_at->format('m');
            array_push($fechas, $valero->created_at->format('j') . " - " . substr($mes[$number_mont - 1], 0, 3));

            if ($request->combustible == 'Regular') {
                array_push($precios_valero, $valero->precio_regular - $terminal_uni->fits[count($terminal_uni->fits) - 1]->regular_fit);
            } elseif ($request->combustible == 'Supreme 93') {
                array_push($precios_valero, $valero->precio_premium - $terminal_uni->fits[count($terminal_uni->fits) - 1]->disel_fit);
            } else {
                array_push($precios_valero, $valero->precio_disel - $terminal_uni->fits[count($terminal_uni->fits) - 1]->regular_fit);
            }
        }

        foreach ($terminal_uni->competitions as $competition) {
            foreach ($competition->prices()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_pemex, $price->precio_regular);
                    array_push($precios_aar, floatval($price->precio_regular) - 0.90);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_pemex, $price->precio_premium);
                    array_push($precios_aar, floatval($price->precio_premium) - 0.90);
                } else {
                    array_push($precios_pemex, $price->precio_disel);
                    array_push($precios_aar, floatval($price->precio_disel) - 1.70);
                }
            }
        }

        foreach ($terminal_uni->policons as $policons) {
            foreach ($policons->price_policon()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price_poli) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_policon, $price_poli->precio_regular);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_policon, $price_poli->precio_premium);
                } else {
                    array_push($precios_policon, $price_poli->precio_disel);
                }
            }
        }

        foreach ($terminal_uni->impulsas as $impulsas) {
            foreach ($impulsas->price_impulsa()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price_impu) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_impulsa, $price_impu->precio_regular);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_impulsa, $price_impu->precio_premium);
                } else {
                    array_push($precios_impulsa, $price_impu->precio_disel);
                }
            }
        }

        foreach ($terminal_uni->hamses as $hamses) {
            foreach ($hamses->price_hamse()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price_ham) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_hamse, $price_ham->precio_regular);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_hamse, $price_ham->precio_premium);
                } else {
                    array_push($precios_hamse, $price_ham->precio_disel);
                }
            }
        }

        foreach ($terminal_uni->potestas as $potestas) {
            foreach ($potestas->price_potesta()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price_impu) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_potesta, $price_impu->precio_regular);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_potesta, $price_impu->precio_premium);
                } else {
                    array_push($precios_potesta, $price_impu->precio_disel);
                }
            }
        }

        foreach ($terminal_uni->energos as $energos) {
            foreach ($energos->price_energo()->where('created_at', 'LIKE', '%' . $fech . '%')->orderBy('created_at')->get() as $price_ener) {
                if ($request->combustible == 'Regular') {
                    array_push($precios_potesta, $price_impu->precio_regular);
                } elseif ($request->combustible == 'Supreme 93') {
                    array_push($precios_potesta, $price_impu->precio_premium);
                } else {
                    array_push($precios_potesta, $price_impu->precio_disel);
                }
            }
        }

        $selecion = array(
            'fechas' => $fechas,
            'precios_valero' => $precios_valero,
            'precios_pemex' => $precios_pemex,
            'precios_policon' => $precios_policon,
            'precios_impulsa' => $precios_impulsa,
            'precios_hamse' => $precios_hamse,
            'precios_potesta' => $precios_potesta,
            'precios_energo' => $precios_energo,
            'precios_aar' => $precios_aar
        );
        return json_encode($selecion);
    }
}
