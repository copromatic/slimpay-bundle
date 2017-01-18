<?php


namespace SlimpayBundle\Controller;

use SlimpayBundle\Services\EntityFactory;
use SlimpayBundle\Services\SlimpayClient;
use SlimpayBundle\Entity\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{

    public function testEntryPointResourceAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');
        /** @var \HapiClient\Hal\Resource $resource */
        $resource = $client->getEntryPointResource();

        dump($resource->getState(), $resource->getAllLinks());
        die;
    }

    public function testCreateMandateAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');

        $content = [
            'started' => true,
            'creditor' => [
                'reference' => $this->getParameter('slimpay.oauth_user_id')
            ],
            'subscriber' => [
                'reference' => 'test'
            ],
            'items' => [
                [
                    'type' => 'signMandate',
                    'mandate' => [
                        'signatory' => [
                            'honorificPrefix' => 'Mr',
                            'familyName' => 'Doe',
                            'givenName' => 'John',
                            'billingAddress' => [
                                "street1" => "27 rue des fleurs",
                                "postalCode" => "75008",
                                "city" => "Paris",
                                "country" => "FR"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        /** @var SlimpayResource $resource */
        $resource = $client->createOrders($content);

        dump($resource->getUserApprovalUrl(), $resource->getState(), $resource->getAllLinks());
        die;
    }

    public function testGetMandatesAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');

        $params = [
            'creditorReference' => $this->getParameter('slimpay.oauth_user_id')
        ];

        /** @var Resource $resource */
        $resource = $client->searchMandates($params);

        dump($resource->getState(), $resource->getAllLinks(), $resource->getAllEmbeddedResources());
        die;
    }

    public function testCreateDirectOrderAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');

        $params = [
            'creditorReference' => $this->getParameter('slimpay.oauth_user_id')
        ];

        /** @var SlimpayResource $resource */
        $resource = $client->searchMandates($params);
        $mandates = $resource->getEmbeddedResources('mandates');

        /** @var SlimpayResource $mandate */
        $mandate = $mandates[0];

        $content = [

            'amount' => 121.00,
            'currency' => null,
            'label' => 'Virement test',
            'creditor' => [
                'reference' => $this->getParameter('slimpay.oauth_user_id')
            ],
            'mandate' => [
                'reference' => $mandate->getState()['reference']
            ],
            'subscriber' => [
                'reference' => 'test'
            ]
        ];

        /** @var SlimpayResource $resource */
        $resource = $client->createDirectDebits($content);

        /** @var EntityFactory $factory */
        $factory = $this->get('slimpay.entity_factory');


        dump($factory->createDebitFromResource($resource), $resource->getState(), $resource->getAllLinks());
        die;
    }

    public function testGetDirectDebitsAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');

        $params = [
            'id' => 'fea4b20c-74f3-11e6-a625-000000000000'
        ];

        /** @var SlimpayResource $resource */
        $resource = $client->getDirectDebits($params);

        /** @var EntityFactory $factory */
        $factory = $this->get('slimpay.entity_factory');

        dump($factory->createDebitFromResource($resource), $resource->getAllLinks(), $resource->getAllEmbeddedResources());
        die;
    }

    public function testGetOrdersAction()
    {
        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');

        $params = [
            'creditorReference' => $this->getParameter('slimpay.oauth_user_id'),
            'reference' => '3624cf7c-7426-11e6-9e62-000000000000'

        ];

        /** @var Resource $resource */
        $resource = $client->getOrders($params);
        /** @var EntityFactory $factory */
        $factory = $this->get('slimpay.entity_factory');
        dump($factory->createOrderFromResource($resource), $resource->getAllLinks(), $resource->getAllEmbeddedResources());
        die;
    }
}