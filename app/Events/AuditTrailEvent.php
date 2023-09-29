<?php

namespace App\Events;

class AuditTrailEvent extends Event
{
    public $event;
    public $feature;
    public $data;
    public $user;

    /**
     * Create a GetToken event instance.
     *
     * @return void
     */
    public function __construct(
        $event,
        $feature,
        $data,
        $user
    ) {
        $this->event = $event;
        $this->feature = $feature;
        $this->data = $data;
        $this->user = $user;
    }
}
