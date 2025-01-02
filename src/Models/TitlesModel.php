<?php 

namespace Src\Models;

use Src\Models\BaseModel;
use Src\Helpers\Wrapper;


class TitlesModel extends BaseModel
{
    protected string $table = "nintendo_games";

    public function getAll()
    {
        $results = $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table);
        $structure = $this->createGameStructure($results);

        return new Wrapper(data: $structure);
    }

    public function getConsoles()
    {
        $results = $this->read(select: "DISTINCT(platform) as Console", from: $this->table)
        $structure = $this->createConsolesStructure($results);
        
        return new Wrapper(data: $structure);
    }

    public function searchByConsole($console)
    {
        return $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table, where: ['platform LIKE' => $console['console']]);
    }

    private function createGameStructure(array $results)
    {
        $structure = [];

        foreach ($results as $values)
        {
            $structure[] = [
                'Game Title' => $values['Game_Name'],
                'Year' => $values['Year'],
                'Console' => $values['Console'],
            ];
        };

        return $structure;
    }

    private function createConsolesStructure(array $results)
    {
        $consoles = [];
        foreach($results as $item)
        {
            $consoles[] = $item['Console'];
        }

        $structure = implode(", ", $consoles);
        
        return $structure;
    }
}