<?php

namespace ApiBasica\Dtos;

use ApiBasica\Interfaces\Capabilities\BuiltableInterface;

/**
 * Class ApiResponseSuccessDto
 * @package ApiExperimental\src\Dtos
 */
class ApiResponseSuccessDto implements BuiltableInterface
{
    /**
     * @var string
     */
    protected $lastInsertedId;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var array
     */
    protected $response;
}
