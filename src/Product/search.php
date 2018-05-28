<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Builders/ProductDtoBuilder.php';
include_once '../Dictionary/ApiResponsesDictionary.php';
include_once '../Repositories/DbRepository.php';

use ApiExperimental\src\Builders\ProductDtoBuilder;

use ApiExperimental\src\Dictionaries\ApiResponsesDictionary;
use ApiExperimental\src\Repositories\DbRepository;

$keyWords = getKeyWords();
if ($keyWords == false) {
    echo json_encode(ApiResponsesDictionary::BAD_REQUEST);
    die();
}
$repository = new DbRepository();
$raw = $repository->search($keyWords);

if (count($raw) == 0) {
    echo json_encode(ApiResponsesDictionary::COINCIDENCE_NOT_FOUND);
    die();
}
$dtos = [];
foreach ($raw as $data) {
    $builder = new ProductDtoBuilder($data);
    $dto = $builder->build();
    array_push($dtos, $dto);
}
echo json_encode($dtos);
die();

/**
 * @return bool | array
 */
function getKeyWords()
{
    if (isset($_GET['s']) == false) {
        return false;
    }
    return $_GET['s'];
}
