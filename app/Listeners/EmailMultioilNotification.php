<?php

namespace App\Listeners;

use App\Events\EmailMultioil;
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
                Mail::send('emails.order', ['order' => $order], function ($o) use ($order) {
                    $o->from($order->company->user->email, '')
                        ->to('mesadecontrol@grupomultioil.com')
                        ->subject('Orden de pedido');
                });
                break;
            case 2:
                Mail::send('emails.notify', ['order' => $order], function ($o) use ($order) {
                    $o->to($order->company->user->email)
                        ->subject('Status orden de pedido');
                });
                break;
            case 3:
                $m = $event->getMessage();
                Mail::send('emails.notify', ['order' => $order, 'm' => $m], function ($o) use ($order, $m) {
                    $o->to($order->company->user->email)
                        ->subject('Status orden de pedido');
                });
                break;
            case 4:
                Mail::send('emails.pedido', ['order' => $order], function ($o) use ($order) {
                    $o->from($order->company->user->email, '')
                        ->to('mesadecontrol@grupomultioil.com')
                        ->subject('Orden de pedido Semanal');
                });
                break;
        }
    }
}
