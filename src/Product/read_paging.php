<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../vendor/autoload.php';

use ApiBasica\Repositories\DbRepository;

$repo = new DbRepository();

$initialRecord = getId();

$stmt = $repo->readPaging();

var_dump($stmt);

/**
 * @return null | int
 */
function getId()
{
    isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
    return $id;
}
