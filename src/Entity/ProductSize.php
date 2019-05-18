<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductSizeRepository")
 */
class ProductSize
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productInterlanSizeId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductSize(): ?string
    {
        return $this->productSize;
    }

    public function setProductSize(?string $productSize): self
    {
        $this->productSize = $productSize;
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
     * @return ProductSize
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductStatus()
    {
        return $this->productStatus;
    }

    /**
     * @param mixed $productStatus
     * @return ProductSize
     */
    public function setProductStatus($productStatus)
    {
        $this->productStatus = $productStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductInterlanSizeId()
    {
        return $this->productInterlanSizeId;
    }

    /**
     * @param mixed $productInterlanSizeId
     * @return ProductSize
     */
    public function setProductInterlanSizeId($productInterlanSizeId)
    {
        $this->productInterlanSizeId = $productInterlanSizeId;
        return $this;
    }



}
