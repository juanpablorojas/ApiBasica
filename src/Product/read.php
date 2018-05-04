<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use ApiExperimental\src\Repositories\DbRepository;
use ApiExperimental\src\Builders\ProductDtoBuilder;

include_once '../Repositories/DbRepository.php';
include_once '../Dtos/ProductDto.php';
include_once '../Builders/ProductDtoBuilder.php';

/**
 * @var \ApiExperimental\src\Repositories\DbRepository
 */
$database = new DbRepository();
$database->getConnection();

/**
 *
 */
$resultadoConsulta = $database->read('products');
$count = $resultadoConsulta->rowCount();
if ($count > 0) {
    // products array
    $products_arr = array();
    $products_arr["records"] = array();
    while ($row = $resultadoConsulta->fetch(PDO::FETCH_ASSOC)) {
        $builder = new ProductDtoBuilder($row);
        $dto = $builder->build();
        array_push($products_arr["records"], $dto);
    }
    echo json_encode($products_arr);
}else {
    echo json_encode(
        array("message" => "No products found.")
    );
}

