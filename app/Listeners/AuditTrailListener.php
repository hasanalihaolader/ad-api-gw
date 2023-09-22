<?php

namespace App\Listeners;

use App\Events\AuditTrailEvent;
use App\Services\AuditTrailService;

class AuditTrailListener
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
     * @param  \App\Events\AuditTrailEvent  $event
     * @return void
     */
    public function handle(AuditTrailEvent $event)
    {
        AuditTrailService::track(
            $event->user->id,
            $event->event,
            $event->feature,
            $event->data
        );
    }
}
