<?php

namespace SlimpayBundle\Services;

use HapiClient\Exception\HttpClientErrorException;
use HapiClient\Hal\CustomRel;
use HapiClient\Hal\Resource as SlimpayResource;
use HapiClient\Http\Follow;
use HapiClient\Http\HapiClient;
use HapiClient\Http\JsonBody;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use SlimpayBundle\Entity\Resource;
use SlimpayBundle\Event\DebitEvent;
use SlimpayBundle\Event\MandateEvent;
use SlimpayBundle\Event\OrderEvent;

/**
 * Class SlimpayClient
 * Facade pattern for the Slimpay HapiClient Api
 * @package SlimpayBundle\Services
 */
class SlimpayClient
{

    const CREATE_ORDERS = 'create-orders';
    const GET_ORDERS = 'get-orders';

    const CREATE_MANDATES = 'create-mandates';
    const GET_MANDATE = 'get-mandate';
    const GET_MANDATES = 'get-mandates';
    const SEARCH_MANDATES = 'search-mandates';

    const CREATE_DIRECT_DEBITS = 'create-direct-debits';
    const GET_DIRECT_DEBITS = 'get-direct-debits';
    const CREATE_RECURRENT_DIRECT_DEBITS = 'create-recurrent-direct-debits';
    const GET_RECURRENT_DIRECT_DEBITS = 'get-recurrent-direct-debits';
    const GET_DIRECT_DEBIT_ISSUES = 'get-direct-debit-issues';

    const CREATE_DOCUMENTS = 'create-documents';
    const GET_DOCUMENTS = 'get-documents';
    const GET_DOCUMENT = 'get-document';

    const GET_BANK_ACCOUNT = 'get-bank-account';

    const CREATE_CARD_TRANSACTIONS = 'create-card-transactions';
    const GET_CARD_TRANSACTIONS = 'get-card-transactions';
    const GET_RECURRENT_CARD_TRANSACTIONS = 'get-recurrent-card-transactions';
    const GET_CARD_TRANSACTION_ISSUES = 'get-card-transaction-issues';
    const GET_CARD_ALIASES = 'get-card-aliases';

    const CREATE_CREDIT_TRANSFERS = 'create-credit-transfers';
    const GET_CREDIT_TRANSFERS = 'get-credit-transfers';

    const GET_CREDITORS = 'get-creditors';

    const CREATE_PAYINS = 'create-payins';

    const CREATE_PAYOUTS = 'create-payouts';

    const USER_APPROVAL = 'user-approval';

    const GET_SUBSCRIBER = 'get-subscriber';

    const DEBIT_EXECUTION_STATUS_PROCESSING = 'processing' ;
    const DEBIT_EXECUTION_STATUS_REJECTED = 'rejected' ;
    const DEBIT_EXECUTION_STATUS_PROCESSED = 'processed' ;
    const DEBIT_EXECUTION_STATUS_NOTPROCESSED = 'notprocessed' ;
    const DEBIT_EXECUTION_STATUS_TRANSFORMED = 'transformed' ;
    const DEBIT_EXECUTION_STATUS_CONTESTED = 'contested' ;
    const DEBIT_EXECUTION_STATUS_TOREPLAY = 'toreplay' ;
    const DEBIT_EXECUTION_STATUS_TOGENERATE = 'togenerate' ;
    const DEBIT_EXECUTION_STATUS_TOPROCESS = 'toprocess' ;

    /**
     * @var HapiClient
     */
    protected $hapiClient = null;

    protected $relNamespace = null;

    protected $factory;

    protected $eventDispatcher;

    protected $creditorReference = null;

    /** @var LoggerInterface */
    protected $logger = null;

    public function __construct(
        $apiUrl = null,
        $entryPointUrl = '/',
        $profile = null,
        $tokenEndPointUrl,
        $creditorReference,
        $oauthUserId,
        $oauthPassword,
        $relNamespace,
        EntityFactory $factory,
        $eventDispatcher
    )
    {
        $this->creditorReference = $creditorReference;
        $this->relNamespace = $relNamespace;
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
        $this->hapiClient = new HapiClient($apiUrl, $entryPointUrl, $profile,
            new \HapiClient\Http\Auth\Oauth2BasicAuthentication(
                $tokenEndPointUrl,
                $oauthUserId,
                $oauthPassword
            )
        );
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }



    /**
     * @param $relation
     * @param null $messageBody
     * @param array|null $headers
     * @param array|null $urlVariables
     * @return \SlimpayBundle\Entity\Resource
     */
    public function create($relation, $messageBody = null, array $headers = null, array $urlVariables = null)
    {
        $dataLog = [
            'relation' => $relation,
            'body' => $messageBody,
            'headers' => $headers,
            'vars' => $urlVariables
        ];

        try{
            $slimpayResource =  $this->send($relation, 'POST', $urlVariables, $messageBody, $headers);
            $dataLog['response'] = [
                'allEmbeddedResources' => $slimpayResource->getAllEmbeddedResources(),
                'allLinks' => $slimpayResource->getAllLinks(),
                'state' => $slimpayResource->getState(),
            ];

            $this->log(
                \Psr\Log\LogLevel::DEBUG,
                'Response Create',
                $dataLog
            );
        }catch(HttpClientErrorException $e){
            $dataLog['error'] = [
                'statusCode' => $e->getStatusCode(),
                'reasonPhrase' => $e->getReasonPhrase(),
                'message' => $e->getMessage()
            ];
            $this->log(
                \Psr\Log\LogLevel::ERROR,
                $e->getMessage(),
                $dataLog
            );
            throw $e;
        }catch(\Exception $e){
            $dataLog['error'] = [
                'message' => $e->getMessage()
            ];
            $this->log(
                \Psr\Log\LogLevel::ERROR,
                $e->getMessage(),
                $dataLog
            );
            throw $e;
        }

        return new Resource($slimpayResource, $this->relNamespace);
    }

    public function log($niveau, $message, $context){
        if(isset($this->logger)){
            $this->logger->log($niveau, $message, $context);
        }
    }

    /**
     * @param $relation
     * @param array|null $urlVariables
     * @param array|null $headers
     * @param null $messageBody
     * @return \SlimpayBundle\Entity\Resource
     */
    public function get($relation, array $urlVariables = null, array $headers = null, $messageBody = null, $resource = null)
    {
        $dataLog = [
            'relation' => $relation,
            'body' => $messageBody,
            'headers' => $headers,
            'vars' => $urlVariables
        ];

        try{
            $slimpayResource = $this->send($relation, 'GET', $urlVariables, $messageBody, $headers, $resource);
            $dataLog['response'] = [
                'allEmbeddedResources' => $slimpayResource->getAllEmbeddedResources(),
                'allLinks' => $slimpayResource->getAllLinks(),
                'state' => $slimpayResource->getState(),
            ];

            $this->log(
                \Psr\Log\LogLevel::DEBUG,
                'Response get',
                $dataLog
            );
            
        }catch(HttpClientErrorException $e){
            $dataLog['error'] = [
                'statusCode' => $e->getStatusCode(),
                'reasonPhrase' => $e->getReasonPhrase(),
                'message' => $e->getMessage()
            ];
            $this->log(
                \Psr\Log\LogLevel::ERROR,
                $e->getMessage(),
                $dataLog
            );
            throw $e;
        }catch(\Exception $e){
            $dataLog['error'] = [
                'message' => $e->getMessage()
            ];
            $this->log(
                \Psr\Log\LogLevel::ERROR,
                $e->getMessage(),
                $dataLog
            );
            throw $e;
        }
        return new Resource($slimpayResource, $this->relNamespace);
    }

    /**
     * @param $relation
     * @param $method
     * @param array|null $urlVariables
     * @param null $messageBody
     * @param array|null $headers
     * @return \HapiClient\Hal\Resource;
     */
    public function send($relation, $method, array $urlVariables = null, $messageBody = null, array $headers = null, $resource = null)
    {
        $customRel = new CustomRel($this->relNamespace . $relation);
        $body = $messageBody ? new JsonBody($messageBody) : null;
        $follow = new Follow($customRel, $method, $urlVariables, $body, $headers);
        $slimpayResource = $this->hapiClient->sendFollow($follow, $resource);

        return $slimpayResource;
    }

    /**
     * @return HapiClient
     */
    public function getSlimpayHapiClient()
    {
        return $this->hapiClient;
    }

    /**
     * @param $body
     * @return Resource
     */
    public function createMandates($body)
    {
        return $this->create(self::CREATE_MANDATES, $body);
    }

    /**
     * @param $body
     * @return Resource
     */
    public function createOrders($body)
    {
        $resource = $this->create(self::CREATE_ORDERS, $body);

        $order = $this->factory->createOrderFromResource($resource);

        $event = new OrderEvent($order);
        $this->eventDispatcher->dispatch(OrderEvent::ORDER_CREATED, $event);

        return $resource;
    }

    /**
     * @param $body
     * @return Resource
     */
    public function createDirectDebits($body)
    {
        $resource = $this->create(self::CREATE_DIRECT_DEBITS, $body);
        $debit = $this->factory->createDebitFromResource($resource);

        $resourceSubscriber = $this->getSubscriber($resource->getSlimpayResource());
        $subscriber = $this->factory->createSubscriberFromResource($resourceSubscriber);

        $debit->setSubscriber($subscriber);

        $event = new DebitEvent($debit);
        $this->eventDispatcher->dispatch(DebitEvent::DEBIT_CREATED, $event);




        return $resource;
    }

    /**
     * @param $body
     * @return Resource
     */
    public function createRecurrentDirectDebits($body)
    {
        $resource = $this->create(self::CREATE_RECURRENT_DIRECT_DEBITS, $body);

        $debit = $this->factory->createDebitFromResource($resource);
        $event = new DebitEvent($debit);
        $this->eventDispatcher->dispatch(DebitEvent::DEBIT_CREATED, $event);

        return $resource;
    }

    /**
     * @param $params
     * @return Resource
     */
    public function getMandates($params)
    {
        return $this->get(self::GET_MANDATES, $params);
    }

    /**
     * @param SlimpayResource $resource
     */
    public function getMandate(SlimpayResource $resource)
    {
        return $this->get(self::GET_MANDATE, null, null, null, $resource);
    }

    /**
     * @param $params
     * @return Resource
     */
    public function getOrders($params)
    {
        return $this->get(self::GET_ORDERS, $params);
    }

    /**
     * @param $params
     * @return Resource
     */
    public function getDirectDebits($params)
    {
        return $this->get(self::GET_DIRECT_DEBITS, $params);
    }

    /**
     * @param $params
     * @return Resource
     */
    public function getRecurrentDirectDebits($params)
    {
        return $this->get(self::GET_RECURRENT_DIRECT_DEBITS, $params);
    }

    /**
     * @return Resource
     */
    public function getEntryPointResource()
    {
        return $this->hapiClient->getEntryPointResource();
    }

    /**
     * @param SlimpayResource $resource
     * @return Resource
     */
    public function getDocument(SlimpayResource $resource)
    {
        return $this->get(self::GET_DOCUMENT, null, null, null, $resource);
    }

    /**
     * @param SlimpayResource $resource
     * @return Resource
     */
    public function getBankAccount(SlimpayResource $resource)
    {
        return $this->get(self::GET_BANK_ACCOUNT, null, null, null, $resource);
    }

    /**
     * @param $params
     * @return Resource
     */
    public function searchMandates($params)
    {
        return $this->get(self::SEARCH_MANDATES, $params);
    }

    public function getSubscriber(SlimpayResource $resource)
    {
        return $this->get(self::GET_SUBSCRIBER, null, null, null, $resource);
    }

    /**
     * @param $content
     * @return Resource
     * @throws \Exception
     */
    public function notification($content)
    {

        $resource = new Resource(SlimpayResource::fromJson($content), $this->relNamespace);
        $order = $this->factory->createOrderFromResource($resource);

        if(!$order->getMandateReused() && $resource->getLink($this->relNamespace . self::GET_MANDATE)){
            $mandateResource = $this->getMandate($resource->getSlimpayResource());
            $mandate = $this->factory->createMandateFromResource($mandateResource);

            $documentResource = $this->getDocument($mandateResource->getSlimpayResource());
            $document = $this->factory->createDocumentFromResource($documentResource);

            $bankAccountResource = $this->getBankAccount($mandateResource->getSlimpayResource());
            $bankAccount = $this->factory->createBankAccountFromResource($bankAccountResource);

            $mandate->setDocument($document);
            $mandate->setBankAccount($bankAccount);
            $event = new MandateEvent($mandate, $order);
            $this->eventDispatcher->dispatch(MandateEvent::MANDATE_CREATED, $event);
        }

        $event = new OrderEvent($order);
        $this->eventDispatcher->dispatch(OrderEvent::ORDER_CLOSED, $event);

        return $resource;
    }

    /**
     * @return null
     */
    public function getCreditorReference()
    {
        return $this->creditorReference;
    }

}