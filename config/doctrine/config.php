<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

$connectionParams = [
    'driver' => $_ENV['DB_DRIVER'],
    'path' => __DIR__.'/../../storage/nintendo_games.db'
];

$dbConnection = DriverManager::getConnection($connectionParams);

return $dbConnection;