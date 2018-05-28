<?php

namespace ApiBasica\Traits;

use ApiBasica\Helpers\StringHelper;

include_once '../Helpers/StringHelper.php';

/**
 * Trait StringHelperTrait
 */
trait StringHelperTrait
{
    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @return StringHelper
     */
    protected function getStringHelper()
    {
        if ($this->stringHelper === null) {
            $this->stringHelper = new StringHelper();
        }
        return $this->stringHelper;
    }
}
