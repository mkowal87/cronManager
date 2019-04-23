#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silly\Edition\PhpDi\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Command\HmCommand;

$app = new Application('cron - Main cron for getting product availabilities.');

$app->command(
    'getsizehm product',
    function (ConsoleOutput $output, $product) {


        $command = new HmCommand();

        $command->getProductListSizes($product);


        $output->writeln('Done.');
    }
)->descriptions('Get all possible sizes of product', [
    'product' => 'product ID',
]);
$app->run();
