<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 15/09/16
 * Time: 10:22
 */

namespace SlimpayBundle\Entity;


class BankAccount
{

    protected $bic;

    protected $iban;

    public function __construct($bic, $iban)
    {
        $this->bic = $bic;
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param mixed $bic
     * @return BankAccount
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     * @return BankAccount
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
    }

}