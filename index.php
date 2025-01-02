<?php 

require_once __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$router = new Router("http://localhost/PHP%20Projects/api_nintendo");

$router->namespace('Src\Controllers');

/**
 * Modifications:
 * 1. place the name API and the Version on the routes; OK
 * 2. study a possibility to include a caching middleware system to speed things up and free up resoureces;
 * 3. place pagination over the API via limit and offset parameters
 * 4. create a response object to handle all the responses from the server;
 */

$router->get("/api/v1/", "IndexController:info");
$router->get("/api/v1/titles", "TitlesController:titles");
$router->get("/api/v1/titles/{console}", "TitlesController:searchByConsole");
$router->get("/api/v1/consoles", "TitlesController:consolesOnly");

$router->dispatch();

if($router->error())
{
    if($router->error() === 400)
    {
        echo json_encode(['error' => 'Bad Request']);
    }

    if($router->error() === 404)
    {
        echo json_encode(['error' => 'Not Found!']);
    }

    if($router->error() === 405)
    {
        echo json_encode(['error' => 'Method not yet allowed']);
    }

    if($router->error() === 501)
    {
        echo json_encode(['error' => 'Sorry, it was not implemented yet!']);
    }
}