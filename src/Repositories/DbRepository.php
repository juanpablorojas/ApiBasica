<?php

namespace ApiBasica\Repositories;

include_once '../../vendor/autoload.php';

use ApiBasica\Config\dbConfig;
use ApiBasica\Dictionaries\DbRepositoryDictionary;
use ApiBasica\Dtos\ProductDto;
use ApiBasica\Interfaces\Repositories\DbRepositoryInterface;
use ApiBasica\Models\ProductModel;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Capsule\Manager;

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

    /**
     * @var Manager
     */
    public $capsule;


    public function __construct()
    {
        $this->productsDictionary = new DbRepositoryDictionary();
        $this->conn = $this->getConnection();
        $this->capsule = new Capsule();
        $this->capsule->addConnection([
                'driver' => 'mysql',
                'host' => $this::HOST,
                'database' => $this::DATABASE_NAME,
                'username' => $this::USER_NAME,
                'password' => $this::PASSWORD,
                'charset' => 'utf8'
            ]);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
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
     * @param $id
     * @param $tableName
     * @return mixed
     */
    public function readOne($id, $tableName)
    {
        $row = ProductModel::find($id);
        if ($row == null) {
            return $row;
        }
        $row = ProductModel::find($id)
            ->join('categories', 'category_id', '=', 'categories.id')
            ->select('products.*','categories.name as category_name')
            ->first()
            ->toArray();
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
     * @inheritdoc
     * @param $id
     * @param $tableName
     * @return bool
     */
    public function delete($id)
    {
        $record = ProductModel::query()->find($id);
        if ($record == null) {
            return false;
        }
        return $record->delete();
    }

    /**
     * @param array $keyWords
     * @param string $tableName
     * @return bool | array
     */
    public function search($keyWords, $tableName = 'products')
    {
        /**$this->query = "SELECT
                p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                ". $tableName. " p
            WHERE
                p.name LIKE ? OR p.description LIKE ?
            ORDER BY
                p.created DESC";**/

       $this->query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $tableName . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";

        $statement = $this->conn->prepare($this->query);
        $keyWords = "%{$keyWords}%";
        $statement->bindParam(1, $keyWords);
        $statement->bindParam(2, $keyWords);
        $statement->bindParam(3, $keyWords);
        try {
            $statement->execute();
        } catch (\Exception $e) {
             return false;
        }
        $raw = [];
        while ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($raw, $result);
        }
        return $raw;
    }

    /**
     * @inheritdoc
     */
    public function readPaging($initialRecord = 0, $recordsNeeded = 1)
    {
        return ProductModel::skip($initialRecord)->take($recordsNeeded)->get()->toArray();
    }
}
