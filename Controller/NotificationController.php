<?php

namespace SlimpayBundle\Controller;

use SlimpayBundle\Services\SlimpayClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{

    public function slimpayNotificationAction(Request $request)
    {

        /** @var SlimpayClient $client */
        $client = $this->get('slimpay.client');
        /** @var \HapiClient\Hal\Resource $resource */
        $client->notification($request->getContent());

        return new JsonResponse('ok');
    }

}