<?php

namespace Src\Controllers;

class IndexController
{
    public function info()
    {
        echo json_encode([
            'name:' => 'nintendo_titles',
            'author:' => 'Dave G.Farias',
            'version:' => 1.0,
            'description:' => 'Access a database of Nintendo-only titles from different consoles. Using Andrii Samoshyn\'s Kaggle database, updated 4 years ago.',
            'status:' => 'operational',
            'supported_methods:' => 'GET'
        ]);
    }
}