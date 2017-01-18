<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 13/09/16
 * Time: 14:40
 */

namespace SlimpayBundle\Entity;


class Subscriber
{

    protected $reference;

    public function __construct($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return Subscriber
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }



}