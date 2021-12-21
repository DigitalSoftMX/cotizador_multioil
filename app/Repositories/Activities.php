<?php

namespace App\Repositories;

use App\Company;
use App\CompetitionPrice;
use App\Order;
use App\Terminal;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Activities
{
    // obteniendo los fees dependiendo la empresa
    public function getFees($company_id = null)
    {
        $fees = array();
        foreach (Terminal::all() as $terminal) {
            if ($company_id == null) {
                foreach (Company::all() as $company) {
                    $fee = $terminal->fits->where('company_id', $company->id)->where('active', 1)->last();
                    $fees = $fee != null ? $this->dataFees($fee, $fees) : $fees;
                }
            } else {
                $fee = $terminal->fits->where('company_id', $company_id)->where('active', 1)->last();
                $fees = $fee != null ? $this->dataFees($fee, $fees) : $fees;
            }
        }
        return $fees;
    }
    // llenado de fees
    private function dataFees($fee, $fees)
    {
        $data['id'] = $fee->id;
        $data['terminal'] = $fee->terminals->name;
        $data['company'] = $fee->companies->name;
        $data['base'] = $fee->base_id != null ? $fee->base->name : '';
        $data['regular_fit'] = '$ ' . $fee->regular_fit;
        $data['premium_fit'] = '$ ' . $fee->premium_fit;
        $data['diesel_fit'] = '$ ' . $fee->diesel_fit;
        $data['created_at'] = $fee->created_at->format('Y/m/d');
        array_push($fees, $data);
        return $fees;
    }
    // obteniendo los rpecios por empresa y fecha
    public function getPrices($company_id, $date)
    {
        $prices = array();
        foreach (Terminal::all() as $terminal) {
            if ($company_id == 0) {
                foreach (Company::all() as $company) {
                    $price = $date == 0 ?
                        $terminal->prices->where('company_id', $company->id)->last() :
                        CompetitionPrice::where([['company_id', $company->id], ['terminal_id', $terminal->id]])->whereDate('created_at', $date)->first();
                    $prices = $price != null ? $this->dataPrices($price, $prices) : $prices;
                }
            } else {
                $price = $date == 0 ?
                    $terminal->prices->where('company_id', $company_id)->last() :
                    CompetitionPrice::where([['company_id', $company_id], ['terminal_id', $terminal->id]])->whereDate('created_at', $date)->first();
                $prices = $price != null ? $this->dataPrices($price, $prices) : $prices;
            }
        }
        return $prices;
    }
    // Registro de pedidos
    public function register($request, $product)
    {
        $data = [
            'company_id' => $request['company_id'],
            'terminal_id'  => $request['terminal_id'],
            'freight' => $request['freight'],
            'price' => $request["price_$product"],
            'liters' => $request["liters_$product"],
            'total' => $request["total_$product"],
            'date' => $request['date'],
            'statud_id' => 1,
        ];
        if ($product == 'r')
            $data['product'] = 'regular';
        if ($product == 'p')
            $data['product'] = 'premium';
        if ($product == 'd')
            $data['product'] = 'diesel';
        if (isset($request['secure']))
            $data['secure'] = $request['secure'] == 0 ? 0 : 1;
        $order = Order::create($data);
        if (strtotime($request['date']) < strtotime(date("Y-m-d", time())))
            $order->update(['created_at' => $request['date']]);
    }
    // Metodo para guardar pdf y xml
    public function saveFile($request, $model, $file, $path = null)
    {
        if ($request->file("file_$file")) {
            if (File::exists(public_path() . $model->$file))
                File::delete(public_path() . $model->$file);
            $save = $path ? $request->file("file_$file")->store("public/orders/{$model->order_id}/{$path}") :
                $request->file("file_$file")->store("public/orders/{$model->id}");
            $model->update([$file => Storage::url($save)]);
        }
    }
    // lista de meses en español
    public function getMonths($date = null)
    {
        $months = [
            ['name' => 'Enero', 'id' => '01'],
            ['name' => 'Febrero', 'id' => '02'],
            ['name' => 'Marzo', 'id' => '03'],
            ['name' => 'Abril', 'id' => '04'],
            ['name' => 'Mayo', 'id' => '05'],
            ['name' => 'Junio', 'id' => '06'],
            ['name' => 'Julio', 'id' => '07'],
            ['name' => 'Agosto', 'id' => '08'],
            ['name' => 'Septiembre', 'id' => '09'],
            ['name' => 'Octubre', 'id' => '10'],
            ['name' => 'Noviembre', 'id' => '11'],
            ['name' => 'Diciembre', 'id' => '12'],
        ];
        if ($date) {
            $date = explode("-", $date);
            return $months[((int)$date[1]) - 1]['name'];
        }
        return $months;
    }
    // Leyendo archivo XML Total y folio
    public function xmlTotalFolioUUID($file)
    {
        try {
            $data = [];
            $xml = simplexml_load_file($file);
            $ns = $xml->getNamespaces(true);
            $xml->registerXPathNamespace('cfdi', $ns['cfdi']);
            $xml->registerXPathNamespace('t', $ns['tfd']);
            foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
                $data['total'] = $cfdiComprobante['Total'];
            }
            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor) {
                $data['shipper'] = $Emisor['Nombre'];
            }
            foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
                $data['folio'] = $tfd['UUID'];
            }
            return $data;
        } catch (Exception $e) {
            return null;
        }
    }
    // Guarda o actualiza los pagos de un pedido
    public function saveOrUpdatePayments(Request $request, $payment)
    {
        if ($request->file_voucherguerrera) {
            request()->validate(['file_voucherguerrera' => 'file']);
            $this->saveFile($request, $payment, 'voucherguerrera', 'payments');
        }
        if ($request->file_vouchervalero) {
            request()->validate(['file_vouchervalero' => 'file']);
            $this->saveFile($request, $payment, 'vouchervalero', 'payments');
        }
        if ($request->file_voucherfreight) {
            request()->validate(['file_voucherfreight' => 'file']);
            $this->saveFile($request, $payment, 'voucherfreight', 'payments');
        }
        if (!$request->payment_guerrera) {
            if (File::exists(public_path() . $payment->voucherguerrera))
                File::delete(public_path() . $payment->voucherguerrera);
            $payment->update(['voucherguerrera' => null]);
        }
        if (!$request->payment_g_valero) {
            if (File::exists(public_path() . $payment->vouchervalero))
                File::delete(public_path() . $payment->vouchervalero);
            $payment->update(['vouchervalero' => null]);
        }
        if (!$request->payment_freight) {
            if (File::exists(public_path() . $payment->voucherfreight))
                File::delete(public_path() . $payment->voucherfreight);
            $payment->update(['voucherfreight' => null]);
        }
    }
    // llenado de precios
    private function dataPrices($price, $prices)
    {
        $data['id'] = $price->id;
        $data['terminal'] = $price->terminal->name;
        $data['company'] = $price->company->name;
        $data['regular'] = '$ ' . $price->regular;
        $data['premium'] = '$ ' . $price->premium;
        $data['diesel'] = '$ ' . $price->diesel;
        $data['created_at'] = $price->created_at->format('Y/m/d');
        array_push($prices, $data);
        return $prices;
    }
}
