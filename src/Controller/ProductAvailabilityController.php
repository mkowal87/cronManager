<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ProductAvailability;

class ProductAvailabilityController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
    }


    public function getAvailabilityByInternalId($internalId){
        $availability = $this->getEntityManager()
            ->getRepository(ProductAvailability::class)
            ->findByInternalId($internalId);

        if (!$availability) {
            return false;
        }
        return $availability;
    }

    public function updateProductAvailability($internalId, $size, $status){

        $entityManager = $this->getEntityManager();
        $availability = $entityManager->getRepository(ProductAvailability::class)->findByInternalId($internalId);

        if (!$availability) {
            throw $this->createNotFoundException(
                'No product found for id '.$internalId
            );
        }
        $availability->setProductSize($size);
        $availability->setProductStatus($status);

        $entityManager->flush();

        return $this;
    }

    public function saveDataToDB(ProductAvailability $productAvailability){

        $entityManager = $this->getEntityManager();

        $entityManager->persist($productAvailability);
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
