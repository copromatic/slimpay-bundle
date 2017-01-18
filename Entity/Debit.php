<?php

namespace SlimpayBundle\Entity;

/**
 * Debit
 *
 * @ORM\Table(name="slimpay_debit")
 * @ORM\Entity
 */
class Debit
{

    protected $id;
    protected $paymentReference;
    protected $amount;
    protected $label;
    protected $sequenceType;
    protected $executionStatus;
    protected $executionDate;
    protected $dateCreated;
    protected $currency;
    protected $replayCount;
    protected $subscriber;
    
    public function __construct($id, $paymentReference, $amount, $label, $sequenceType, $executionStatus, $executionDate, $dateCreated, $currency, $replayCount, Subscriber $subscriber = null)
    {
        $this->id = $id;
        $this->paymentReference = $paymentReference;
        $this->amount = $amount;
        $this->label = $label;
        $this->sequenceType = $sequenceType;
        $this->executionStatus = $executionStatus;
        $this->executionDate = $executionDate;
        $this->dateCreated = $dateCreated;
        $this->currency = $currency;
        $this->replayCount = $replayCount;
        $this->subscriber = $subscriber;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPaymentReference()
    {
        return $this->paymentReference;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getSequenceType()
    {
        return $this->sequenceType;
    }

    /**
     * @return mixed
     */
    public function getExecutionStatus()
    {
        return $this->executionStatus;
    }

    /**
     * @return mixed
     */
    public function getExecutionDate()
    {
        return $this->executionDate;
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
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return mixed
     */
    public function getReplayCount()
    {
        return $this->replayCount;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * @param Subscriber $subscriber
     * @return Mandate
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;
        return $this;
    }
}