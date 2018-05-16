<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include '../Repositories/DbRepository.php';

use ApiExperimental\src\Repositories\DbRepository;

$utilities = new Utilities();
$repository = new DbRepository();

$stmt = $repository->readPaging(
    $from_record_num,
    $records_per_page
);

$num = $stmt->rowCount();


