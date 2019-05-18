<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function getDataFromDBbyProductID($productId){
        $product = $this->getEntityManager()
            ->getRepository(Product::class)
            ->findByProductId($productId);


        if (!$product) {
            return false;
        }
        return $product;
    }

    public function updateProductPrice(Product $product, $newPrice){
        $entityManager = $this->getEntityManager();
        $product->setProductPrice($newPrice);
        $entityManager->flush();
        return $this;
    }

    public function saveDataToDB(Product $product){

        $entityManager = $this->getEntityManager();

        $entityManager->persist($product);
        $entityManager->flush();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }


}
