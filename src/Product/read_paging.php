<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


$repository = new DbRepository();

$initialRecord = getId();


$stmt = $repository->readPaging(
    $from_record_num,
    $records_per_page
);

var_dump($stmt);

/**
 * @return null | int
 */
function getId()
{
    isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
    return $id;
}

