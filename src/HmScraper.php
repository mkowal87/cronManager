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
use App\Entity\Product;
use App\Entity\ProductSize;
use Doctrine;
use App\Controller\ProductController;

class HmScraper extends Scraper
{

    protected $baseUrl = 'https://www2.hm.com';
    const AVAILABILITY_URL = 'https://www2.hm.com/pl_pl/getAvailability?variants={product}';
    const PRODUCT_URL = 'https://www2.hm.com/pl_pl/productpage.{product}.html';
    //TODO:: temp path for deving
    const CSV_PATH = 'X:\Github\cronMenager/{productId}hm.csv';

    const STORE_POINTER = 'CSV';

    const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36';

    private $userSession;

    const SIZE_CODE = [
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
    ];

    private $storeInCSV = false;

    private $availableSizes = array();

    private $productController;

    private $productAvailabilityController;

    /**
     * HmCommand constructor.
     */
    public function __construct($store, $productController, $productAvailabilityController)
    {
        if ($store === self::STORE_POINTER) {
            $this->setStoreInCSV(true);
        }

        $this->setProductController($productController);
        $this->setProductAvailabilityController($productAvailabilityController);
        return parent::__construct();
    }

    /**
     * @param $productId
     */
    public function getProductListSizes($productId)
    {

        $this->setUserAgent(self::USER_AGENT);
        $this->setProductId($productId);
        $this->getProductInfo($productId);
        $this->getAvailabilitiesRecord($productId);
        if ($this->getStoreInCSV()) {
            $this->writeToCSV();
        }

        return $this;

    }

    /**
     * Method to get main information about product
     *
     * @param $productId
     * @return $this
     */
    private function getProductInfo($productId)
    {

        //Scraping page from url
        $response = Request::get(str_replace('{product}', urlencode($productId), static::PRODUCT_URL));

        if ($this->checkStatus($response)) {

            $this->setHeaders($response->headers);

            //where to find needed information about product
            $basicData = $this->getBetween($response->body, '<script type="application/ld+json">', '</script>');
            $data = json_decode($basicData);

            // Checking if we already have a product in DB
            if ($product = $this->productController->getDataFromDBbyProductID($productId)) {
                if ($product->getProductPrice() != $data->offers[0]->price && $data->offers[0]->price > 0) {
                    // If there is a new price store it
                    $this->productController->updateProductPrice($product, $data->offers[0]->price);
                }
            } else {
                $product = new Product();
                $product
                    ->setProductName($data->name)
                    ->setProductURL(str_replace('{product}', urlencode($this->getProductId()), static::PRODUCT_URL))
                    ->setProductImage($data->image)
                    ->setProductColor($data->color)
                    ->setProductPrice($data->offers[0]->price)
                    ->setProductCurrency($data->offers[0]->priceCurrency)
                    ->setProductId($productId)
                    ->setProductDescription($data->description);


                $this->productController->saveDataToDB($product);
            }
        }
        return $this;
    }

    /**
     * Getting availability status for product
     *
     * @param $productId
     * @return $this
     */
    private function getAvailabilitiesRecord($productId)
    {

        $response = Request::get($this->getAvailabilityUrl($productId),
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
            foreach ($availabilities as $id => $availability) {
                $decodedName = $this->decodeSize($availability);
                $availableSizes[$availability] = $decodedName . '$' . 'lots in stock';
                unset($availabilities[$id]);
            }

            $this->setAvailableSizes($availableSizes);
            $this->writeAvailabilityToDB();
        }

        return $this;
    }

    /**
     * @param $productId
     * @return mixed
     */
    protected function getAvailabilityUrl($productId)
    {
        return str_replace('{product}', urlencode($productId), static::AVAILABILITY_URL);
    }



    /**
     * @param $sizeCode
     * @return string
     */
    protected function decodeSize($sizeCode)
    {
        $code = str_replace($this->getProductId(), '', $sizeCode);

        if (!isset($this->sizeCodes[$code])) {
            return 'no size found ' . $code;
        }
        return self::SIZE_CODE[$code];
    }

    private function writeAvailabilityToDB()
    {

        $availableSizes = $this->getAvailableSizes();
        foreach ($availableSizes as $availableSize) {
            $avails = explode('$', $availableSize);
            $size = $avails[0];
            $status = $avails[1];
            //var_dump($availableSizes);die();
            $productSize = new ProductSize();
            $productSize->setProductId($this->getProductId())
                ->setProductSize($size)
                ->setProductStatus($status);
        }
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
     * @return ProductController
     */
    public function getProductController()
    {
        return $this->productController;
    }

    /**
     * @param ProductController $productController
     * @return HmScraper
     */
    public function setProductController($productController)
    {
        $this->productController = $productController;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductAvailabilityController()
    {
        return $this->productAvailabilityController;
    }

    /**
     * @param mixed $productAvailabilityController
     * @return HmScraper
     */
    public function setProductAvailabilityController($productAvailabilityController)
    {
        $this->productAvailabilityController = $productAvailabilityController;
        return $this;
    }



}