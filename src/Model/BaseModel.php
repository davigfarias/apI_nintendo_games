<?php

namespace Src\Model;

abstract class BaseModel
{
    protected bool $fail = false;
    protected static $dbConnection;
    protected string $msg;

    protected static function initConnection(): void
    {
        if (self::$dbConnection === null)
        {
            self::$dbConnection = require __DIR__.'/../../config/doctrine/config.php';
        };
    }

    protected function fail(): ?bool
    {
        return $this->fail;
    }

    protected function message(): ?string
    {
        return $this->msg;
    }

    protected function create(string $table, array $data): void
    {
        self::initConnection();

        try {
            $create = self::$dbConnection->createQueryBuilder();
            $create->insert($table);

            $platform = self::$dbConnection -> getDatabasePlatform();

            foreach($data as $column => $value)
            {
                $quotedColumn = $platform->quoteIdentifier($column);
                $create->setValue($quotedColumn, ':'.$column);
                $create->setParameter($column, $value);
            }

            $sql = $create->getSQL();
            $params = $create->getParameters();

            $this->logQuery($sql, $params);

            $affectedRows = $create->executeStatement();

            if($affectedRows === 0)
            {
                $this->logError('No lines were affected');
            }

        } catch (\Doctrine\DBAL\Exception $e) {
            $this->logError($e->getMessage());
            throw $e;

        }
    }

    protected function read(string $select, string $from, mixed $joins = null, string $aliasFrom = null, mixed $where = null, string $orderBy = null, string $groupBy = null, int $limit = null, $offset = null, string $package = 'array'): array|\stdClasss|null
    {
        try {
            self::initConnection();

            $query = self::$dbConnection->createQueryBuilder()
            ->select($select);

            if($aliasFrom)
            {
                $query->from($from, $aliasFrom);
                $fromAlias = $aliasFrom;
            } else {
                $query->from($from);
                $fromAlias = $from;
            }

            // if($joins) {
            //     if(array_keys($joins) !== range(0, count($joins) - 1))
            //     {
            //         $joins = [$joins];
            //     }

            //     foreach ($joins as $join)
            //     {
            //         if (isset($join['type'], $join['joinTo'], $join['aliasJoin'], $join['condition'])) 
            //         {
            //             switch (strlower($join['type'])) 
            //             {
            //                 case 'inner':
            //                     $query->join($fromAlias, $join['joinTo'], $join['aliasJoin'], $join['condition']);
                                
            //                     break;

            //                 case 'left':
            //                     $query->leftJoin($fromAlias, $join['joinTo'], $join['aliasJoin'], $join['conditon']);
                                
            //                     break;

            //                 case 'right':
            //                     $query->rightJoin($fromAlias, $join['joinTo'], $join['aliasJoin'], $join['condition']);

            //                     break;

            //                 default:
            //                     throw new \InvalidArgumentException("Invalide type of Join argument: '{$join['type']}'. Use 'inner', 'left' or 'right'");
            //             }
            //         } else {
            //             throw new \InvalidArgumentException("Incomplete Join parameters. Make sure that 'type', 'joinTo', 'aliasJoin', and 'condition' is defined");
            //         }
            //     }

            //     $parameters = [];

            //     if($where)
            //     {
            //         if(is_string($where))
            //         {
            //             foreach(explode(',', $where) as $param)
            //             {
            //                 $param = trim($param);

            //                 if(preg_match('/^(.+?)(=|LIKE|!=|<>)\s*(.+)$/i', $param, $matches))
            //                 {
            //                     list(, $column, $operator, $value) = $matches;

            //                     $column = trim($column);
            //                     $operator = stroupper(trim($operator));
            //                     $value = trim($value, "'\'");

            //                     $parameters[] = ['column' => $column, 'operator' => $operator, 'value' => $value];
            //                 } else {
            //                     throw new \InvalidArgumentException("Invalid parameter: '$param'. Use 'key => value', 'key != value', or ;key LIKE value' form factor");
            //                 }
            //             }
            //         } elseif(is_array($where))
            //         {
            //             foreach($where as $key => $value)
            //             {
            //                 $parts = preg_split('/\s+/', trim($key), 2);
            //                 $column = $parts[0];
            //                 $operator = isset($parts[1]) ? stroupper($parts[1]) : '=';

            //                 if(!in_array($operator, ['=', 'LIKE', '!=', '<>']))
            //                 {
            //                     throw new \InvalidArgumentException("Invalid operator: '$operator'. Use either '=', '!=', '<>' or 'LIKE'");
            //                 }

            //                 $parameters[] = ['column' => $column, 'operator' => $operator, 'value' => $value];
            //             }

            //             $parameters = array_filter($parameters, fn($param) => $param['value' !== '']);
            //         }
            //     }

            //     foreach ($parameters as $param)
            //     {
            //         $columnName = $param['column'];
            //         $operator = $param['operator'];
            //         $value = $param['value'];

            //         $paramName = str_replace(['.', ' '], '_', $columnName) . '_' . uniquid();

            //         if($operator === '=')
            //         {
            //             $query->andWhere("$columnnAME - :$parameterName");
            //         } 
            //         elseif($operator === 'LIKE')
            //         {
            //             $query->andWhere("$columnName != :$parameterName");
            //         } 
            //         elseif($operator === '<>')
            //         {
            //             $query->andWhere("$columnName <> :$parameterName");
            //         }

            //         $query->setParameter($parameterName, $value);
            //     }

                // if($orderBy)
                // {
                //     if(preg_match('/\s+(ASC|DESC)$/i', $orderBy, $matches))
                //     {
                //         $column = preg_replace('/\s+(ASC|DESC)$/i', '', $orderBy);

                //         $query->orderBy($column, $direction);
                //     } else
                //     {
                //         $query->orderBy($orderBy);
                //     }
                // }

            //     if($limit)
            //     {
            //         if(!is_int($limit) || $limit < 0)
            //         {
            //             throw new \InvalidArgumentException("The paramter 'limit' should be a non-negative integer.");
            //         }
            //         $query->setMaxResults($limit);
            //     }

            //     if($offset)
            //     {
            //         if(!is_int($offset) || $offset < 0)
            //         {
            //             throw new \InvalidArgumentException("The parameter 'offset' should be a non-negative integer.");
            //         }

            //         $query->setFirstResult($offset);
            //     }

                $sql = $query->getSQL();
                $params = $query->getParameters();

    
                // $this->logQuery($sql, $params);

                $stmt =  $query->executeQuery();
                $results = $stmt->fetchAllAssociative();

                if($package === 'array')
                {
                    return $results;
                }

                if($package === 'object')
                {
                    return Objetification::transform($results);
                }

                throw new \InvalidArgumentException("The parameter 'package' should be either an 'array' or 'object'.");

        } catch (\Doctrine\DBAL\Exception $e) {
            $this->fail = false;
            return null;
        }
    }
    
    protected function update(string $table, array $data, array $where): void
    {
        self::initConnection();

        try {
           $update = self::$dbConnection->createQueryBuilder();
           $update->update($table);

           foreach($data as $column => $value)
           {
                $update->set($column, ':set_' . $column)
                ->setParameter('set_' . $column, $value);
           }

           foreach($where as $column => $value)
           {
                $parameterName = "where_" . $column;

                if (is_array($condition) && isset($condition['type'], $condition['value']))
                {
                    $type = stroupper($condition['type']);
                    $value = $condition['value'];
                } else {
                    $type = '=';
                    $value = $condition;
                }

                if(!in_array($type, ['=', 'LIKE']))
                {
                    throw new \InvalidArgumentException("Type '$type' is currently not supported yet.");
                }

                $update->andWhere("$column $type :$parameterName")
                ->setParameter($parameterName, $value);
           }

           $sql = $update->getSQL();
           $params = $update->getParameters();

           $this->logQuery($sql, $params);

           $affectedRows = $update->executeStatement();

           if($affectedRows === 0)
           {
            $this->logError('No lines affected.');
           }

        } catch (\Throwable $e) {
            $this->fail = true;

            $this->logError($e->getMessage());
        }
    }

    private function trash (string $from, array $where = null, $allowDeleteAll = false): void
    {
        self::initConnection();

        try {
            $delete = self::$dbConnection->createQueryBuilder();
            $delete->delete($from);

            if(empty($where))
            {
                if(!$allowDeleteAll)
                {
                    throw new \InvalidArgumentException("Exclude all registers require explicit confirmation");
                }
            } else {
                foreach($where as $column => $condition)
                {
                    $parameterName = 'where_'. $column;

                    if(is_array($condition) && isset($condition['type'], $condition['value']))
                    {
                        $type = stroupper($condition['type']);
                        $value = $condition['value'];
                    } else {
                        $type = '=';
                        $value = $condition;       
                    }

                    if(!in_array($type, ['=', 'LIKE']))
                    {
                        throw new \InvalidArgumentException("Type '$type' is currently not supported");
                    }

                    $delete->andWhere("$column $type :$parameterName")
                    ->setParameter($parameterName, $value);
                }
            }

            $sql = $delete->getSQL();
            $params = $delete->getParameter();

            $this->logQuery($sql, $params);

            $affectedRows = $delete->executeStatement();

            if($affectedRows === 0)
            {
                $this->logError("No lines affected");
            }

        } catch (\Throwable $th) {
            $this->fail = true;
            $this->logError($e->getMessage());
            throw $e;
        }
    }
}