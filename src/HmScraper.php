<?php

namespace App;

/**
 * Created by PhpStorm.
 * User: mkowal
 * Date: 23.04.2019
 * Time: 00:00
 */

use Unirest\Request;
use CsvWriter\CsvWriter;
use App\Entity\Products;
use App\Entity\ProductsSizes;
use Doctrine;

class HmScraper extends Scraper
{

    const BASE_URL = 'https://www2.hm.com';
    const AVAILABILITY_URL = 'https://www2.hm.com/pl_pl/getAvailability?variants={product}';
    const PRODUCT_URL = 'https://www2.hm.com/pl_pl/productpage.{product}.html';
    //TODO:: temp path for deving
    const PATH = 'X:\Github\cronMenager/hm.csv';

    const STORE_POINTER = 'CSV';

    private $userSession;

    private $sizeCodes = array(
        '001' => '32/XXS',
        '002' => '34/XS',
        '003' => '36/S',
        '004' => '38/M',
        '005' => '40/L',
        '006' => '42/XL',
        '007' => '44/XXL',
        '008' => '46/XXS/P',
        '009' => '48/XS/P',
        '010' => '50/S/P',
        '011' => '52/M/P',
        '012' => '54/L/P',
        '013' => '56/XL/P',
        '014' => '58/XXL/P',
    );

    private $storeInCSV = false;

    private $availableSizes = array();
    /**
     * HmCommand constructor.
     */
    public function __construct($store)
    {
        if ($store === self::STORE_POINTER){
            $this->setStoreInCSV(true);
        }

        return parent::__construct();
    }

    /**
     * @param $productId
     * @return mixed
     */
    protected function getProductUrl($productId)
    {
        return str_replace('{product}', urlencode($productId), static::AVAILABILITY_URL);
    }

    /**
     * @param $productId
     */
    public function getProductListSizes($productId){

        $this->setProductId($productId);
        $this->getAvailabilitiesRecord($productId);
        $this->writeToDB();
        if ($this->getStoreInCSV()) {
            $this->writeToCSV();
        }

        return $this;

    }

    private function getAvailabilitiesRecord($productId){

        $response = Request::get($this->getProductUrl($productId),
            $this->generateHeaders($this->userSession));

        if ($this->checkStatus($response)) {

            $availableSizes = array();
            $availabilities = $response->body->availability;

            if (isset($response->body->availability)) {
                if (isset($response->body->fewPieceLeft)) {
                    foreach ($response->body->fewPieceLeft as $id => $fewPieceLeft) {
                        if (in_array($fewPieceLeft, $availabilities)) {
                            $decodedName = $this->decodeSize($fewPieceLeft);
                            $availableSizes[$fewPieceLeft] = $decodedName . '$' . 'few pieces left';
                            unset($availabilities[$id]);
                        }
                    }
                }
            }
            foreach ($availabilities as $id =>$availability) {
                $decodedName = $this->decodeSize($availability);
                $availableSizes[$availability] = $decodedName . '$' . 'lots in stock';
                unset($availabilities[$id]);
            }

            $this->setAvailableSizes($availableSizes);
        }
        return $this;
    }


    private function writeToCSV(){

        $availableSizes = $this->getAvailableSizes();

        $writer = (new CsvWriter())
            ->open(self::PATH);

        foreach ($availableSizes as $productKey => $availableSize) {
            $size = explode('$', $availableSize);
            $writer->write([$productKey, $size[0], $size[1]]);
        }


        return $this;
    }

    private function writeToDB(){

        $entityManager = $this->getDoctrine()->getEntityManager();
        var_dump($entityManager);die();
        $product = new Products();
        $product->setProductName()
            ->setProductURL(str_replace('{product}', urlencode($this->getProductId()), static::PRODUCT_URL))
            ->setProductImage();

        $availableSizes = $this->getAvailableSizes();

        return $this;
    }

    /**
     * @param $sizeCode
     * @return string
     */
    protected function decodeSize($sizeCode){
        $code = str_replace($this->getProductId(), '', $sizeCode);

        if (!isset($this->sizeCodes[$code])){
            return 'no size found '. $code;
        }
        return $this->sizeCodes[$code];
    }

    /**
     * @param $session
     *
     * @return array
     */
    private function generateHeaders($session)
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

        }

        return $headers;
    }

    /**
     * @return bool
     */
    public function getStoreInCSV()
    {
        return $this->storeInCSV;
    }

    /**
     * @param bool $storeInCSV
     * @return HmCommand
     */
    public function setStoreInCSV($storeInCSV)
    {
        $this->storeInCSV = $storeInCSV;
        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableSizes()
    {
        return $this->availableSizes;
    }

    /**
     * @param array $availableSizes
     * @return HmCommand
     */
    public function setAvailableSizes($availableSizes)
    {
        $this->availableSizes = $availableSizes;
        return $this;
    }





}