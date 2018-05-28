<?php

use ApiExperimental\src\Repositories\DbRepository;
use ApiExperimental\src\Builders\ProductDtoBuilder;
use ApiExperimental\src\Dictionaries\ApiResponsesDictionary;

// required headers
header("Access-Control-Allow-Origin: *"); //Seguridad
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/dbConfig.php';

include_once '../Builders/ProductDtoBuilder.php';

include_once '../Repositories/DbRepository.php';

include_once '../Dictionaries/ApiResponseDictionary.php';

include_once '../Builders/ApiResponseSuccessBuilder.php';

/**
 * @return array
 */
function getData()
{
    $data = json_decode(file_get_contents("php://input"), true);
    //var_dump($data);
    return $data;
}

$repository = new DbRepository();
$data = getData();
if ($data == null) {
    echo 'Insufficient Data';
    die();
}
$builder = new ProductDtoBuilder($data);
/** @var \ApiExperimental\src\Dtos\ProductDto $product */
$product = $builder->build();
//var_dump($product);
$result = $repository->create($product);
if ($result != false) {
    $info = [
        'InsertedId' => $result
    ];
    echo json_encode(ApiResponsesDictionary::SUCCESS);
    echo json_encode($info);

} else {
    echo json_encode(ApiResponsesDictionary::SUCCESS_DEFAULT);
}
