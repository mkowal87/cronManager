<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductAvailabilityRepository")
 */
class ProductAvailability
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
    private $productId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productInternalSizeId;

    public function getId(): ?int
    {
        return $this->id;
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
     * @return ProductAvailability
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
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
    public function getProductStatus()
    {
        return $this->productStatus;
    }

    /**
     * @param mixed $productStatus
     * @return ProductAvailability
     */
    public function setProductStatus($productStatus)
    {
        $this->productStatus = $productStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductInternalSizeId()
    {
        return $this->productInternalSizeId;
    }

    /**
     * @param mixed $productInternalSizeId
     * @return ProductAvailability
     */
    public function setProductInternalSizeId($productInternalSizeId)
    {
        $this->productInternalSizeId = $productInternalSizeId;
        return $this;
    }

}
