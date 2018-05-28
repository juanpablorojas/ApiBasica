<?php

namespace ApiBasica\Dtos;

use ApiBasica\Interfaces\Capabilities\BuiltableInterface;

include_once '../Interfaces/Capabilities/BuiltableInterface.php';

/**
 * Class ProductDto
 */
class ProductDto implements BuiltableInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var float
     */
    public $price;

    /**
     * @var int
     */
    public $categoryId;

    /**
     * @var string
     */
    public $categoryName;

    /**
     * @var \DateTime
     */
    public $created;
}
