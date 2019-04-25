<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsSizesRepository")
 */
class ProductsSizes
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
}
