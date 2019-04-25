#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Command\HmCommand;


$app = new Application('cron - Main cron for getting product availabilities.');
$app->add(new HmCommand());
$app->run();
