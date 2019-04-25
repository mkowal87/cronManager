<?php
/**
 * Created by PhpStorm.
 * User: mkowal
 * Date: 23.04.2019
 * Time: 14:12
 */

namespace App;


use Unirest\Exception;
use Unirest\Request;

class Scraper
{
    const HTTP_NOT_FOUND = 404;
    const HTTP_OK = 200;
    const HTTP_FORBIDDEN = 403;
    const HTTP_BAD_REQUEST = 400;


    private $userAgent;
    private $productId;


    public function __construct()
    {
        Request::verifyPeer(false);
    }


    public function checkStatus($response){

        if ($response->code !== static::HTTP_OK) {
            throw new Exception('Response code is ' . $response->code . '. Body: ' . static::getErrorBody($response->body) . ' Something went wrong. Please report issue.', $response->code);
        }

        return true;
    }

    /**
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param $userAgent
     *
     * @return string
     */
    public function setUserAgent($userAgent)
    {
        return $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     * @return HmCommand
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    private static function getErrorBody($body){

        return substr(serialize($body), 0, 100);
    }
}