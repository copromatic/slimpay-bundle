<?php

namespace SlimpayBundle\Entity;


class Order
{

    protected $reference;
    protected $state;
    protected $started;
    protected $dateCreated;
    protected $dateModified;
    protected $dateClosed;
    protected $paymentScheme;
    protected $mandateReused;

    public function __construct($reference, $state, $started, $dateCreated, $dateModified, $dateClosed, $paymentScheme, $mandateReused)
    {
        $this->reference = $reference;
        $this->state = $state;
        $this->started = $started;
        $this->dateCreated = $dateCreated;
        $this->dateModified = $dateModified;
        $this->dateClosed = $dateClosed;
        $this->paymentScheme = $paymentScheme;
        $this->mandateReused = $mandateReused;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @return mixed
     */
    public function getDateClosed()
    {
        return $this->dateClosed;
    }

    /**
     * @return mixed
     */
    public function getPaymentScheme()
    {
        return $this->paymentScheme;
    }

    /**
     * @return mixed
     */
    public function getMandateReused()
    {
        return $this->mandateReused;
    }

}