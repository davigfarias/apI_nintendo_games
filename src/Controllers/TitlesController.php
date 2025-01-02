<?php

namespace Src\Controllers;

use Src\Models\TitlesModel;
use Src\Controllers\Controller;

class TitlesController extends Controller
{
    public function __constructor(){
        parent::__constructor();
    }

    public function titles(): Response
    {
       $model = new TitlesModel();
       $this->answer->setHeader('Content-Type', 'application/json');
       
       $this->answer($model->getAll());
    }

    public function consolesOnly(): Response
    {
        $model = new TitlesModel();
        $this->answer->setHeader('Content-Type', 'application/json');

        $this->answer($model->getConsoles());
     }

    public function searchByConsole($console): Response
    {
        $model = new TitlesModel();
        $this->answer->setHeader('Content-Type', 'application/json');

        $this->answer($model->searchByConsole($console));
     }

     private function errorConsole($console): Response
     {
        $this->answer->setHeader('Content-Type', 'application/json');
        return $this->answer(['error' => "There is no database for the console '{$console['console']}'"]) 
     }
}