<?php

namespace App\Listeners;

use App\Company;
use App\Events\EmailMultioil;
use App\Terminal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailMultioilNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EmailMultioil $event)
    {
        $state = $event->getState();
        $order = $event->getOrder();
        switch ($state) {
            case 1:
                Mail::send('emails.order', [
                    'order' => $order,
                    'company' => ($company = Company::find($order->company_id)),
                    'terminal' => ($terminal = Terminal::find($order->terminal_id))
                ], function ($o) use ($order, $company, $terminal) {
                    $o->from($company->email, '')
                        ->to('mesadecontrol@grupomultioil.com')
                        ->subject('Orden de pedido');
                });
                break;
            case 2:
                Mail::send('emails.notify', ['order' => $order], function ($o) use ($order) {
                    $o->to($order->company->email)
                        ->subject('Status orden de pedido');
                });
                break;
            case 3:
                $m = $event->getMessage();
                Mail::send('emails.notify', ['order' => $order, 'm' => $m], function ($o) use ($order, $m) {
                    $o->to($order->company->email)
                        ->subject('Status orden de pedido');
                });
                break;
            case 4:
                Mail::send('emails.pedido', ['order' => $order], function ($o) use ($order) {
                    $o->from($order->company->email, '')
                        ->to('mesadecontrol@grupomultioil.com')
                        ->subject('Orden de pedido Semanal');
                });
                break;
            case 5:
                Mail::send('emails.notifyS', ['order' => $order], function ($o) use ($order) {
                    $o->to($order->company->email)
                        ->subject('Status orden de pedido semanal');
                });
                break;
            case 6:
                $m = $event->getMessage();
                Mail::send('emails.notifyS', ['order' => $order, 'm' => $m], function ($o) use ($order, $m) {
                    $o->to($order->company->email)
                        ->subject('Status orden de pedido Semanal');
                });
                break;
            case 7:
                $m = $event->getMessage();
                Mail::send('emails.notify', ['order' => $order, 'm' => $m], function ($o) use ($order, $m) {
                    $o->to($order->company->email)
                        ->subject('Status orden de pedido');
                });
                break;
        }
    }
}
