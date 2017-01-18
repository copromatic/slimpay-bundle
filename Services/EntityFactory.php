<?php

namespace SlimpayBundle\Services;


use SlimpayBundle\Entity\BankAccount;
use SlimpayBundle\Entity\Debit;
use SlimpayBundle\Entity\Document;
use SlimpayBundle\Entity\Mandate;
use SlimpayBundle\Entity\Order;
use SlimpayBundle\Entity\Resource;
use SlimpayBundle\Entity\Subscriber;

/**
 * Class EntityFactory
 * @package SlimpayBundle\Services
 */
class EntityFactory
{

    /**
     * @param Resource $resource
     * @return null|Order
     */
    public function createOrderFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('reference', $state)){

            $reference = $state['reference'];
            $stateResource = $state['state'];
            $started = $state['started'];
            $dateCreated = $state['dateCreated'];
            $dateModified = $state['dateModified'];
            $dateClosed = empty($state['dateClosed']) ? null : $state['dateClosed'];
            $paymentScheme = $state['paymentScheme'];
            $mandateReused = array_key_exists('mandateReused', $state) ? $state['mandateReused'] : null;

            return new Order($reference, $stateResource, $started, $dateCreated, $dateModified, $dateClosed, $paymentScheme, $mandateReused);
        }
        return null;

    }

    /**
     * @param Resource $resource
     * @return null|Debit
     */
    public function createDebitFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('amount', $state)){

            $id = $state['id'];
            $paymentReference = $state['paymentReference'];
            $amount = $state['amount'];
            $label = $state['label'];
            $sequenceType = $state['sequenceType'];
            $executionStatus = $state['executionStatus'];
            $executionDate = $state['executionDate'];
            $dateCreated = $state['dateCreated'];
            $currency = $state['currency'];
            $replayCount = $state['replayCount'];

            return new Debit($id, $paymentReference, $amount, $label, $sequenceType, $executionStatus, $executionDate, $dateCreated, $currency, $replayCount);
        }
        return null;
    }

    /**
     * @param Resource $resource
     * @return null|Mandate
     */
    public function createMandateFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('standard', $state)){
            $id = $state['id'];
            $reference = $state['reference'];
            $rum = $state['rum'];
            $stateResource = $state['state'];
            $standard = $state['standard'];
            $initialScore = $state['initialScore'];
            $dateCreated = $state['dateCreated'];
            $dateSigned = $state['dateSigned'];
            $paymentScheme = $state['paymentScheme'];

            return new Mandate($id, $reference, $rum, $stateResource, $standard, $initialScore, $dateCreated, $dateSigned, $paymentScheme);
        }
        return null;
    }

    /**
     * @param Resource $resource
     * @return null|Document
     */
    public function createDocumentFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('content', $state)){
            $content = $state['content'];
            $contentEncoding = $state['contentEncoding'];
            $contentType = $state['contentType'];

            return new Document($content, $contentType, $contentEncoding);
        }
        return null;
    }

    /**
     * @param Resource $resource
     * @return null|Subscriber
     */
    public function createSubscriberFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('reference', $state)){
            $reference = $state['reference'];

            return new Subscriber($reference);
        }
        return null;
    }

    /**
     * @param Resource $resource
     * @return null|BankAccount
     */
    public function createBankAccountFromResource(Resource $resource)
    {
        $state = $resource->getState();
        if(array_key_exists('iban', $state)){
            $iban = $state['iban'];
            $bic = $state['bic'];

            return new BankAccount($bic, $iban);
        }
        return null;
    }

}