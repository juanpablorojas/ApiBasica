<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../Repositories/DbRepository.php';
include_once '../Dtos/ProductDto.php';
include_once '../Builders/ProductDtoBuilder.php';
include '../Dictionaries/ApiResponseDictionary.php';

use ApiExperimental\src\Repositories\DbRepository;
use ApiExperimental\src\Builders\ProductDtoBuilder;
use ApiExperimental\src\Dtos\ProductDto;
use ApiExperimental\src\Dictionaries\ApiResponsesDictionary;

/**
 * Repositorio para ejecutar consultas
 */
$repository = new DbRepository();
$id = getClient();
if ($id == null) {
    echo json_encode(ApiResponsesDictionary::BAD_REQUEST);
    //echo "id";
    die();
}
$clientData = getData();
if ($clientData == null) {
    //echo "no hay data";
    echo json_encode(ApiResponsesDictionary::BAD_REQUEST);
    die();
}

if (haveOnlyAllowedFields($repository, $clientData) == false) {
    echo json_encode(ApiResponsesDictionary::FIELDS_TO_MODIFY_UNSUPPORTED);
    //echo "campos inválidos";
    die();
}
$builder = new ProductDtoBuilder((array)$clientData);
$dto = $builder->build();
$result = $repository->update($id, 'products', $dto);
if ($result == false) {
    echo json_encode(ApiResponsesDictionary::CANT_UPDATE_RECORD);
}
echo json_encode(ApiResponsesDictionary::SUCCESS);

/**
 * @return array | null
 */
function getData()
{
    $array = json_decode(file_get_contents("php://input"));
    if ($array != null) {
        return $array;
    }
    return null;
}

/**
 * @return null | int
 */
function getClient()
{
    if (isset($_GET['id'])) {
        return $_GET['id'];
    }
        return null;
}

/**
 * Verifica si los campos a modificar enviados por el cliente,
 * están incluidos en el arreglo de campos permitidos.
 *
 * @param  DbRepository $dbRepository
 * @param array $clientData
 */
function haveOnlyAllowedFields($dbRepository, $clientData)
{
    $allowedArray = $dbRepository->productsDictionary->allowed;
    foreach ($clientData as $key => $value) {
        if (in_array($key, $allowedArray) == false) {
            return false;
        };
    }
    return true;
}
