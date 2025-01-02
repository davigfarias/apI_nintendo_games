<?php

namespace Src\Controllers;

use Src\Models\TitlesModel;
use Src\Controllers\Controller;

class TitlesController extends Controller
{
    protected TitlesModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new TitlesModel();
    }

    public function titles(): Response
    {
       $this->response->setHeader('Content-Type', 'application/json');
       
       $this->answer($this->model->getAll());
    }

    public function consolesOnly(): Response
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $this->answer($this->model->getConsoles());
     }

    public function searchByConsole($console): Response
    {
        $this->response->setHeader('Content-Type', 'application/json');

        $this->answer($model->searchByConsole($console));
     }

     private function errorConsole($console): Response
     {
        $this->response->setHeader('Content-Type', 'application/json');

        return $this->answer(['error' => "There is no database for the console '{$console['console']}'"]); 
     }
}