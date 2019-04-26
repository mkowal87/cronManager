<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */

    private $productId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productURL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productSize;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productCurrency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $productColor;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductURL()
    {
        return $this->productURL;
    }

    /**
     * @param mixed $productURL
     * @return Products
     */
    public function setProductURL($productURL)
    {
        $this->productURL = $productURL;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * @param mixed $productImage
     * @return Products
     */
    public function setProductImage($productImage)
    {
        $this->productImage = $productImage;
        return $this;
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
     * @return Product
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductSize()
    {
        return $this->productSize;
    }

    /**
     * @param mixed $productSize
     * @return Product
     */
    public function setProductSize($productSize)
    {
        $this->productSize = $productSize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * @param mixed $productPrice
     * @return Product
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductCurrency()
    {
        return $this->productCurrency;
    }

    /**
     * @param mixed $productCurrency
     * @return Product
     */
    public function setProductCurrency($productCurrency)
    {
        $this->productCurrency = $productCurrency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * @param mixed $productDescription
     * @return Product
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductColor()
    {
        return $this->productColor;
    }

    /**
     * @param mixed $productColor
     * @return Product
     */
    public function setProductColor($productColor)
    {
        $this->productColor = $productColor;
        return $this;
    }



}
