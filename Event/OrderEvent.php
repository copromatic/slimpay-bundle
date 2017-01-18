<?php

namespace SlimpayBundle\Event;


use SlimpayBundle\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{

    const ORDER_CREATED = 'slimpay.order.created';
    const ORDER_CLOSED = 'slimpay.order.closed';

    /**
     * @var Order
     */
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

}