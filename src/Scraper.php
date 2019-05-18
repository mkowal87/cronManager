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

    private $headers;


    public function __construct()
    {
        Request::verifyPeer(false);
    }

    /**
     * Checking if response was correct
     *
     * @param $response
     * @return bool
     * @throws Exception
     */
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

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return Scraper
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get string between two strings
     * @param $string
     * @param $start
     * @param $end
     * @return bool|string
     */
    public function getBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @param $productId
     * @return $this
     */
    public function writeToCSV()
    {

        $availableSizes = $this->getAvailableSizes();

        $writer = (new CsvWriter())
            ->open(str_replace('{productId}', urlencode($this->getProductId()), self::CSV_PATH));

        foreach ($availableSizes as $productKey => $availableSize) {
            $size = explode('$', $availableSize);
            $writer->write([$productKey, $size[0], $size[1]]);
        }


        return $this;
    }

    /**
     * @param $session
     *
     * @return array
     */
    public function generateHeaders($session)
    {
        $session = $this->getHeaders();
        $headers = [];
        if ($session) {
            $cookies = $session['Set-Cookie'];

            $cookie = end($cookies);
            $headers = [
                'cookie' => $cookie,
                'referer' => $this->baseUrl . '/',
            ];

        }

        if ($this->getUserAgent()) {
            $headers['user-agent'] = $this->getUserAgent();

        }

        return $headers;
    }
}