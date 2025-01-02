<?php 

namespace Src\Models;

use Src\Models\BaseModel;
use Src\Helpers\Wrapper;


class TitlesModel extends BaseModel
{
    protected string $table = "nintendo_games";

    public function getAll(): object
    {
        $results = $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table);
        $structure = $this->createGameStructure($results);

        return new Wrapper(data: $structure);
    }

    public function getConsoles(): object
    {
        $results = $this->read(select: "DISTINCT(platform) as Console", from: $this->table);
        $structure = $this->createConsolesStructure($results);
        
        return new Wrapper(data: $structure);
    }

    public function searchByConsole($console): object
    {
        return $this->read(select: "title AS Game_Name, platform AS Console, date AS Year", from: $this->table, where: ['platform LIKE' => $console['console']]);
    }

    private function createGameStructure(array $results): array
    {
        return array_map(
            fn($game) => [
                'Game Title' => $game['Game_Name'],
                'Year' => $game['Year'],
                'Console' => $game['Console']
            ],
            $results
        );
    }

    private function createConsolesStructure(array $results)
    {
        foreach($results as $item)
        {
            $consoles[] = $item['Console'];
        }

        $structure = implode(", ", $consoles);
        
        return $structure;
    }
}