<?php

namespace App\Command;

/**
 * Created by PhpStorm.
 * User: mkowal
 * Date: 23.04.2019
 * Time: 00:00
 */

use Unirest\Request;

class HmCommand
{

    const BASE_URL = 'https://www2.hm.com';
    const PRODUCT_URL = 'https://www2.hm.com/pl_pl/productpage.{product}.html';


    private $userAgent;
    private $userSession;


    public function __construct()
    {
        Request::verifyPeer(false);
    }

    public static function getProductUrl($productId)
    {
        return str_replace('{product}', urlencode($productId), static::PRODUCT_URL);
    }


    public function getProductListSizes($productId){

        $response = Request::get($this->getProductUrl($productId),
            $this->generateHeaders($this->userSession));

        var_dump($response);die();
    }

    /**
     * @param $session
     * @param $gisToken
     *
     * @return array
     */
    private function generateHeaders($session, $gisToken = null)
    {
        $headers = [];
        if ($session) {
            $cookies = '';
            foreach ($session as $key => $value) {
                $cookies .= "$key=$value; ";
            }

            $csrf = empty($session['csrftoken']) ? $session['x-csrftoken'] : $session['csrftoken'];

            $headers = [
                'cookie' => $cookies,
                'referer' => Self::BASE_URL . '/',
                'x-csrftoken' => $csrf,
            ];

        }

        if ($this->getUserAgent()) {
            $headers['user-agent'] = $this->getUserAgent();

            if (!is_null($gisToken)) {
                $headers['x-instagram-gis'] = $gisToken;
            }
        }

        return $headers;
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

}