<?php

namespace ApiExperimental\src\Repositories;

use ApiExperimental\src\config\dbConfig;
use ApiExperimental\src\Dictionaries\DbRepositoryDictionary;
use ApiExperimental\src\Dtos\ProductDto;
use ApiExperimental\src\Interfaces\Repositories\DbRepositoryInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

include_once '../Interfaces/Repositories/DbRepositoryInterface.php';
include_once '../config/dbConfig.php';
include '../Dictionary/DbRepositoryDictionary.php';

/**
 * Clase encargada de realizar la conexión a base de datos
 * Class DbRepository
 * @package ApiExperimental\src\Repositories
 */
class DbRepository extends dbConfig implements DbRepositoryInterface
{
    /**
     * @var
     */
    public $conn;

    /**
     * @var string
     */
    public $query;

    /**
     * @var array
     */
    public $productsDictionary;


    public function __construct()
    {
        $this->productsDictionary = new DbRepositoryDictionary();
        $this->conn = $this->getConnection();
    }

    /**
     * Se encargará de realizar la conexión y devolver una conexión viva.
     * @return \PDO
     */
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new \PDO(
                "mysql:host=".
                $this::HOST.";dbname=".
                $this::DATABASE_NAME,
                $this::USER_NAME,
                $this::PASSWORD
            );
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            echo "Connection error: ". $exception->getMessage();
        }
        return $this->conn;
    }

    /**
     * @param $tableName
     * @return bool
     */
    public function read($tableName)
    {
        $this->query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $tableName .  " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
        if ($this->conn == null) {
            return false;
        }
        $statement = $this->conn->prepare($this->query);
        try {
            $statement->execute();
        } catch (\Exception $e) {
            return false;
        }
        return $statement;
    }

    /**
     * @param ProductDto $productDto
     * @return int | boolean
     */
    public function create($productDto)
    {
        $this->getConnection();
        // query to insert record
        $query = "INSERT INTO
                " . 'products' . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
        $statement = $this->conn->prepare($query);

        $statement->bindParam(":name", $productDto->name);
        $statement->bindParam(":price", $productDto->price);
        $statement->bindParam(":description", $productDto->description);
        $statement->bindParam(":category_id", $productDto->categoryId);
        $createdAt= $productDto->created;
        if ($createdAt == null) {
            $createdAt = date('Y-m-d H:i:s');
        }
        $statement->bindParam(":created", $createdAt);
        try {
            $statement->execute();

        } catch (\Exception $e) {
            return false;
        }
        return $this->conn->lastInsertId();
    }

    /**
     * @inheritdoc
     * @param $id
     * @param $tableName
     * @return null | array
     */
    public function readOne($id, $tableName)
    {
        $this->query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $tableName . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";

        $statement = $this->conn->prepare($this->query);

        $statement->bindParam(1, $id);

        try {
            $statement->execute();
        } catch (Exception $e) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * @inheritdoc
     * @param int $id
     * @param string $tableName
     * @param ProductDto $dto
     * @return boolean
     */
    public function update($id, $tableName, $dto)
    {
        $arrayOfDto = (array)$dto;
        foreach ($arrayOfDto as $key => $value) {
            if ($value == null) {
                unset($arrayOfDto[$key]);
            }
        }
        $parameterString = $this->parametersStringBuilder($arrayOfDto, ':', ',');
        $this->query = "UPDATE ".$tableName." SET ".$parameterString ." WHERE id = :id ";
        $statement = $this->conn->prepare($this->query);
        $statement->bindParam(":id", $id);
        foreach ($arrayOfDto as $key => &$value) {
            if ($key === 'price') {
                $statement->bindParam(':'.$key, $value, \PDO::PARAM_INT);
                echo '->'.$key;
            } else {
                $statement->bindParam(':'.$key, $value);
            }
        }
        try {
            $statement->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $dto
     * @param $sustitution
     * @param $separator
     * @return bool|string
     */
    private function parametersStringBuilder($array, $sustitution, $separator)
    {
        $query = '';
        foreach ($array as $key => $value) {
            if ($value != null) {
                $query = $query.$key. " "."=".' '.$sustitution.$key.$separator;
            }
        }
        $long = strlen($query);
        return substr($query, 0, $long -1);
    }

    /**
     * @param $id
     * @param $tableName
     * @return bool
     */
    public function delete($id, $tableName)
    {
        $this->query = 'DELETE FROM '.$tableName." WHERE id = :id";
        $statement = $this->conn->prepare($this->query);
        $statement->bindParam(':id', $id);
        try {
            $statement->execute();
        } catch (\Exception $e) {
            return false;
        }
        $affectedRows = $statement->rowCount();
        if ($affectedRows == 0) {
            return false;
        }
        return true;
    }
}
