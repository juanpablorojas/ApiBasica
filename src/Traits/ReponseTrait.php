<?php

namespace ApiExperimental\src\Traits;

/**
 * Trait ReponseTrait
 * @package ApiExperimental\src\Traits
 */
trait ReponseTrait
{
    public $succesDefault = ['message' => "La operación se realizó Correctamente",
        'data' =>
        ['code' => 'Success'],
        'code' => 200];
    public $success = ['message' => "La operación se realizó Correctamente", 'data' => ['id'=> 0], 'code' => 200];
}
