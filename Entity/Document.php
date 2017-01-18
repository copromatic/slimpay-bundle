<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 09/09/16
 * Time: 16:25
 */

namespace SlimpayBundle\Entity;


class Document
{

    /**
     * @var String
     */
    protected $contentEncoding;

    /**
     * @var String
     */
    protected $contentType;

    /**
     * @var String
     */
    protected $content;

    public function __construct($content, $contentType, $contentEncoding)
    {
        $this->content = $content;
        $this->contentType = $contentType;
        $this->contentEncoding = $contentEncoding;
    }

    /**
     * @return String
     */
    public function getContentEncoding()
    {
        return $this->contentEncoding;
    }

    /**
     * @param String $contentEncoding
     * @return Document
     */
    public function setContentEncoding($contentEncoding)
    {
        $this->contentEncoding = $contentEncoding;
        return $this;
    }

    /**
     * @return String
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param String $contentType
     * @return Document
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return String
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param String $content
     * @return Document
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

}