<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\HmScraper;
use App\Controller\ProductController;
use App\Controller\ProductAvailabilityController;
use Psr\Container\ContainerInterface;

class HmCommand extends Command
{

    protected static $defaultName = 'app:get-product-info-hm';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Get all possible sizes of product.')
            ->setHelp('This command allows you to obtain all info about product availability')
            ->addArgument('productid', InputArgument::REQUIRED, 'ID of product to check')
            ->addArgument('csv', InputArgument::OPTIONAL, 'indicator to store in CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Getting info about product: '.$input->getArgument('productid'),
            '===============================================',
            '',
        ]);
        $em = $this->container->get('doctrine')->getManager();
        $productController = new ProductController($em);
        $productAvailabilityController = new ProductAvailabilityController($em);
        $scraper = new HmScraper($input->getArgument('csv'), $productController, $productAvailabilityController);
        $scraper->getProductListSizes($input->getArgument('productid'));

    }



}