<?php

namespace Src\Controllers;



use Src\Model\TitlesModel;

class TitlesController
{
    public function titles(){
       $model = new TitlesModel();

        return $model->getAll();
    }
}