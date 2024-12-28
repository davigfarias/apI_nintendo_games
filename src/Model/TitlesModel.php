<?php

namespace Src\Model;

use Src\Model\BaseModel;

class TitlesModel extends BaseModel
{
    protected string $table = "nintendo_games";

    public function getAll()
    {
       return $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table);
    }

    public function getConsoles()
    {
        return $this->read(select: "DISTINCT(platform) as Console", from: $this->table);
    }

    public function searchByConsole($console)
    {
        return $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table, where: ['platform LIKE' => $console['console']]);
    }
}