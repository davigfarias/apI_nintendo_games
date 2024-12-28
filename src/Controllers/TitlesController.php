<?php

namespace Src\Controllers;

use Src\Model\TitlesModel;

class TitlesController
{
    public function titles()
    {
       $model = new TitlesModel();

        $results = $model->getAll();

        $resultsGames = [];

        foreach($results as $value)
        {
            $resultsGames[] = [
                'Game Title:' => $value['Game_Name'],
                'Year:' => $value['Year'],
                'Console' => $value['Console']
            ];
        }

       echo json_encode($resultsGames);
    }

    public function consoles()
    {
        $model = new TitlesModel();
        $results = $model->getConsoles();

        $consoles = [];
        foreach ($results as $item) 
        {
            $consoles[] = $item['Console']; 
        }

        $consoleString = implode(", ", $consoles);

        echo json_encode(['consoles' => $consoleString]);
     }
}