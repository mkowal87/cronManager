<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 */
class Products
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

    private $productid;

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


}
