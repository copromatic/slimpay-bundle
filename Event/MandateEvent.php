<?php

namespace SlimpayBundle\Event;


use SlimpayBundle\Entity\Mandate;
use SlimpayBundle\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class MandateEvent extends Event
{

    const MANDATE_CREATED = 'slimpay.mandate.created';

    /**
     * @var Mandate
     */
    protected $mandate;

    /**
     * @var Order
     */
    protected $order;

    public function __construct(Mandate $mandate, Order $order = null)
    {
        $this->mandate = $mandate;
        $this->order = $order;
    }

    /**
     * @return Mandate
     */
    public function getMandate()
    {
        return $this->mandate;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

}