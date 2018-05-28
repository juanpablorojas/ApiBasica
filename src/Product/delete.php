<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once ('../Repositories/DbRepository.php');
include_once('../Dictionaries/ApiResponseDictionary.php');

use ApiExperimental\src\Dictionaries\ApiResponsesDictionary;
use ApiExperimental\src\Repositories\DbRepository;

$id = getId();

if ($id == false) {
    echo json_encode(ApiResponsesDictionary::BAD_REQUEST);
    die();
}
$isValidId = validId($id);

if ($isValidId == false) {
    echo json_encode(ApiResponsesDictionary::BAD_REQUEST);
    die();
}

$repository = new DbRepository();

$response = $repository->delete($id, 'products');
var_dump($response);

if ($response == false) {
    echo json_encode(ApiResponsesDictionary::CANT_DELETE_RECORD);
    die();
}
echo json_encode(ApiResponsesDictionary::DELETED_SUCCESS);

/**
 * @return null | int
 */
function getId()
{
    if (isset($_GET['id']) == false) {
        return false;
    }
    return $_GET['id'];
}

/**
 * @param $id
 * @return bool
 */
function validId($id)
{
    $number  = (float)$id;
    if ($number == 0) {
        return false;
    }
    $entero = floor($number);
    $diff = $number - $entero;
    if ($diff != 0) {
        return false;
    }
    return true;
}

