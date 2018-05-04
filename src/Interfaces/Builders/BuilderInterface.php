<?php

namespace ApiExperimental\src\Interfaces\Builders;

use ApiExperimental\src\Interfaces\Capabilities\BuiltableInterface;

/**
 * Interface BuilderInterface
 */
interface BuilderInterface
{
    /**
     * @return BuiltableInterface
     */
    public function build();
}
