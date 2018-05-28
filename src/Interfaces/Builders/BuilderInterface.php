<?php

namespace ApiBasica\Interfaces\Builders;

use ApiBasica\Interfaces\Capabilities\BuiltableInterface;

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
