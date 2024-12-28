<?php

namespace Src\Model;

use Src\Model\BaseModel;

class TitlesModel extends BaseModel
{
    protected string $table = "nintendo_games";

    public function getAll()
    {
       $results = $this->read(select: "title as Game_Name, platform as Console, date as Year", from: $this->table);

       echo json_encode(['data' => $results]);
    }
}