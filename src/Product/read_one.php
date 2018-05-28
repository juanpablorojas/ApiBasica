<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../../vendor/autoload.php';

use ApiBasica\Repositories\DbRepository;
use ApiBasica\Builders\ProductDtoBuilder;
use ApiBasica\Dictionaries\ApiResponseDictionary;

$searchedId = getId();
if ($searchedId == null) {
    echo json_encode(ApiResponseDictionary::BAD_REQUEST);
    die();
}

$repository = new DbRepository();
$repository->getConnection();
$raw = $repository->readOne($searchedId, 'products');
if ($raw == null) {
    echo json_encode(ApiResponseDictionary::ERROR_REGISTER_NOT_FOUND);
    die();
}
$builder = new ProductDtoBuilder($raw);
$product = $builder->build();
echo json_encode($product);

/**
 * @return null | int
 */
function getId()
{
    $id = null;
    //$id = isset($_GET['id']) ? $_GET['id'] : die();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    return $id;
}
