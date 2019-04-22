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
    /*

        // get provider Id
        $query = 'SELECT id FROM providers where shortcut = "' . $provider . '"';
        $stmt = FastPdoDatabase::getMasterInstance()->prepare($query);
        $stmt->execute();
        $providerId = $stmt->fetch(PDO::FETCH_COLUMN);
        $output->writeln('ProviderId for: ' . $provider . ' is ' . $providerId);

        // check if file exist in tmp directory
        if (!file_exists('/tmp/' . $fileName . '.csv')) {
            return 11;
        }

        $fileName = str_replace('.csv', '', $fileName);

        $file = '/tmp/' . $fileName . '.csv';
        $output->writeln('Found file: ' . $file . ' !');
        $handle = fopen($file, 'r');


        // sql statement to update objects_blacklis
        $loggingSql =
            'UPDATE objects_blacklist
                SET `original_id` = ?
                WHERE (`original_id` = ? and provider_id = ?);';
        $loggingStmt = FastPdoDatabase::getLogInstance()->prepare($loggingSql);

        // sql statement for insert new objects_ids
        $insertSql =
            'INSERT 
                INTO `objects_ids` (`id`, `original_id`, `provider`, `identifier`) 
                VALUES (?, ?, ?, ?);';
        $insertStmt = FastPdoDatabase::getMasterInstance()->prepare($insertSql);


        while (($data = fgetcsv($handle, 1000, ",")) !== false) {

            // new Casamundo Id should be always set in 1st position
            $newCasamundoId = $data[0];
            // new originalId should be always set in 2nd position
            $newOriginalId = $data[1];

            // old casamundoId should be always set in 3rd position
            $oldCasamundoId = $data[2];
            // old originalId should be always set in 4th position
            $oldOriginalId = $data[3];

            // check if both exist ID exist
            if (!$newOriginalId || !$oldOriginalId) {
                continue;
            }

            $existSql = 'select id from objects_ids where (original_id = ? or original_id = ?) and provider = ?;';
            $existStmt = FastPdoDatabase::getMasterInstance()->prepare($existSql);
            $existStmt->execute([$oldOriginalId, $newOriginalId, $provider]);
            $objectId = $existStmt->fetch(PDO::FETCH_COLUMN);

            if ($objectId === false) {
                continue;
            }

            $removeSql = 'delete from objects_ids where id in (' . $newCasamundoId . ',' . $oldCasamundoId . ');';
            $removeStmt = FastPdoDatabase::getMasterInstance()->prepare($removeSql);
            $removeStmt->execute();

            $insertStmt->execute([$oldCasamundoId, $newOriginalId, $provider, $newOriginalId]);
            $loggingStmt->execute([$newOriginalId, $oldOriginalId, $providerId]);
            $output->writeln($oldOriginalId . ' exchanged to ' . $newOriginalId);

        }

        fclose($handle);
    */

        $output->writeln('Done.');
    }
)->descriptions('Get all possible sizes of product', [
    'product' => 'product ID',
]);
$app->run();
