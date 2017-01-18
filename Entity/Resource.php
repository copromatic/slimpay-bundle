<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 06/09/16
 * Time: 10:20
 */

namespace SlimpayBundle\Entity;


use HapiClient\Hal\Resource as SlimpayResource;
use SlimpayBundle\Services\SlimpayClient;

class Resource
{

    protected $resource = null;

    protected $relNamespace = null;

    public function __construct(SlimpayResource $resource, $relNamespace)
    {
        $this->resource = $resource;
        $this->relNamespace = $relNamespace;
    }

    public function getLink($relation)
    {
        return $this->resource->getLink($relation);
    }

    public function getAllLinks()
    {
        return $this->resource->getAllLinks();
    }

    public function getEmbeddedResource($relation)
    {
        $resource = $this->resource->getEmbeddedResource($relation);
        return new Resource($resource, $this->relNamespace);
    }

    public function getEmbeddedResources($relation)
    {
        $resources = $this->resource->getEmbeddedResources($relation);

        $toReturn = [];
        foreach($resources as $resource){
            $toReturn[] = new Resource($resource, $this->relNamespace);
        }

        return $toReturn;
    }

    public function getAllEmbeddedResources()
    {
        $resources = $this->resource->getAllEmbeddedResources();

        $toReturn = [];
        foreach($resources as $key=>$resource){
            if(is_array($resource)){
                $arrayResource = [];
                foreach($resource as $item){
                    $arrayResource[] = new Resource($item, $this->relNamespace);
                }
                $toReturn[$key] = $arrayResource;
            } else {
                $toReturn[$key] = new Resource($resource, $this->relNamespace);
            }

        }

        return $toReturn;
    }

    public function getState()
    {
        return $this->resource->getState();
    }

    public function getUserApprovalUrl()
    {
        return $this->getLink($this->relNamespace . SlimpayClient::USER_APPROVAL)->getHref();
    }

    public function getSlimpayResource()
    {
        return $this->resource;
    }

}