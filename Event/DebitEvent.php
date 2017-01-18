<?php

namespace SlimpayBundle\Event;


use SlimpayBundle\Entity\Debit;
use Symfony\Component\EventDispatcher\Event;

class DebitEvent extends Event
{

    const DEBIT_CREATED = 'slimpay.debit.created';

    /**
     * @var Debit
     */
    protected $debit;

    public function __construct(Debit $debit)
    {
        $this->debit = $debit;
    }

    /**
     * @return Debit
     */
    public function getDebit()
    {
        return $this->debit;
    }

}