<?php

namespace ApiBasica\Interfaces\Builders;

use ApiBasica\Dictionaries\ApiResponsesDictionary;
use ApiBasica\Dtos\ApiResponseSuccessDto;
use ApiBasica\Interfaces\Capabilities\BuiltableInterface;
use ApiBasica\Traits\ReponseTrait;

/**
 * Class ApiResponseSuccessBuilder
 * @package ApiExperimental\src\Interfaces\Builders
 */
class ApiResponseSuccessBuilder implements BuilderInterface
{

    /**
     * @var ApiResponseSuccessDto
     */
    protected $builtable;

    /**
     * @var
     */
    protected $raw;

    /**
     * ApiResponseSuccessBuilder constructor.
     * @param $raw
     * @param ApiResponsesDictionary $response
     */
    public function __construct($raw)
    {
        $this->builtable = new ApiResponseSuccessDto();
        $this->raw = $raw;
    }

    /**
     * @return BuiltableInterface
     */
    public function build()
    {/**
        foreach ($this->raw as $key => $value) {
            if (array_key_exists($key, $this->success['data']) == false) {
                //Cannot create response message with data,
                //Sending default response
                $this->builtable->success = $this->succesDefault;
                return $this->builtable;
            }
            $this->success[$key] = $this->raw[$key];
        }
        return $this->builtable;
    **/
    }
}
