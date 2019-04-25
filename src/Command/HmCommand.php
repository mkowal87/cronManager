<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\HmScraper;

class HmCommand extends Command
{

    protected static $defaultName = 'app:get-product-info-hm';

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

        $scraper = new HmScraper($input->getArgument('csv'));
        $scraper->getProductListSizes($input->getArgument('productid'));

    }



}