<?php

namespace ApiExperimental\src\Dictionaries;

/**
 * Class ApiResponsesDictionary
 * @package ApiExperimental\src\Dictionaries
 */
final class ApiResponsesDictionary
{
    const SUCCESS = ['message' => "La operación se realizó Correctamente", 'code' => 200];
    const SUCCESS_DEFAULT = ['message' => "La operación se realizó Correctamente",
        'data' =>
            ['code' => 'Success'],
        'code' => 200];
    const ERROR_REGISTER_NOT_FOUND = [
        'message' => 'Valores de búsqueda incorrectos o registro Inexistente',
        'code' => 404,
        'status' => 'error Registry Not Found'
    ];
    const BAD_REQUEST = [
        'message' => 'Bad Request',
        'code' => 400,
        'status' => 'error'
    ];
    const INTERNAL_SERVER_ERROR = [
        'message' => 'Ocurrió un error en el servidor',
        'code' => 500,
        'status' => 'error'
    ];
    const FIELDS_TO_MODIFY_UNSUPPORTED = [
        'message' => 'Campos para Modificación son inválidos / Bad Request',
        'code' => 500,
        'status' => 'error'
    ];
    const CANT_UPDATE_RECORD = [
        'message' => 'No se pudo completar la solicitud',
        'code' => 500,
        'status' => 'error'
    ];
    const CANT_DELETE_RECORD = [
        'message' => 'No se pudo eliminar el registro',
        'code' => 500,
        'status' => 'error'
        ];
    const DELETED_SUCCESS = [
        'message' => 'Se eliminó correctamente el registro',
        'code' => 200
    ];
}
