<?php

namespace SlimpayBundle\Entity;


class Mandate
{

    protected $id;
    protected $reference;
    protected $rum;
    protected $state;
    protected $standard;
    protected $initialScore;
    protected $dateCreated;
    protected $dateSigned;
    protected $paymentScheme;
    protected $document;
    protected $bankAccount;

    public function __construct($id, $reference, $rum, $state, $standard, $initialScore, $dateCreated, $dateSigned, $paymentScheme, Document $document = null)
    {
        $this->id = $id;
        $this->reference = $reference;
        $this->rum = $rum;
        $this->state = $state;
        $this->standard = $standard;
        $this->initialScore = $initialScore;
        $this->dateCreated = $dateCreated;
        $this->dateSigned = $dateSigned;
        $this->paymentScheme = $paymentScheme;
        $this->document = $document;
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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return mixed
     */
    public function getRum()
    {
        return $this->rum;
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
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * @return mixed
     */
    public function getInitialScore()
    {
        return $this->initialScore;
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
    public function getDateSigned()
    {
        return $this->dateSigned;
    }

    /**
     * @return mixed
     */
    public function getPaymentScheme()
    {
        return $this->paymentScheme;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param Document $document
     * @return Mandate
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param mixed $bankAccount
     * @return Mandate
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

}