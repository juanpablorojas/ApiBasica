<?php

namespace ApiExperimental\src\Builders;

use ApiExperimental\src\Dtos\ProductDto;
use ApiExperimental\src\Interfaces\Builders\BuilderInterface;
use ApiExperimental\src\Dictionaries\ProductDtoDictionary;
use ApiExperimental\src\Interfaces\Capabilities\BuiltableInterface;
use ApiExperimental\src\Traits\StringHelperTrait;
include_once '../Dtos/ProductDto.php';
include_once  '../Dictionary/ProductDtoDictionary.php';
include_once  '../Interfaces/Capabilities/BuiltableInterface.php';
include_once  '../Traits/StringHelperTrait.php';
include_once  '../Interfaces/Builders/BuilderInterface.php';

/**
 * Class ProductDtoBuilder
 * @package ApiExperimental\src\Interfaces\Builders
 */
class ProductDtoBuilder implements BuilderInterface
{
    use StringHelperTrait;

    /**
     * @var BuiltableInterface
     */
    protected $builtable;

    /**
     * @var BuiltableInterface
     */
    protected $raw;

    /**
     * ProductDtoBuilder constructor.
     * @param array $raw
     */
    public function __construct(array $raw)
    {
        $this->getStringHelper();
        $this->raw = $raw;
    }

    /**
     * @return BuiltableInterface
     */
    public function build()
    {
        $this->builtable = new ProductDto();
        if (array_key_exists(ProductDtoDictionary::ID, $this->raw) == false) {
            $this->builtable->id = null;
        } else {
            $this->builtable->id = $this->raw[ProductDtoDictionary::ID];
        }
        if (array_key_exists(ProductDtoDictionary::PRICE, $this->raw) == false) {
            $this->builtable->price = null;
        } else {
            $this->builtable->price = $this->stringHelper->stringToNumber($this->raw[ProductDtoDictionary::PRICE]);
        }
        if (array_key_exists(ProductDtoDictionary::NAME, $this->raw) == false) {
            $this->builtable->name = null;
        } else {
            $this->builtable->name = $this->raw[ProductDtoDictionary::NAME];
        }
        if (array_key_exists(ProductDtoDictionary::CATEGORY_ID, $this->raw) == false) {
            $this->builtable->categoryId = null;
        } else {
            $this->builtable->categoryId = $this->stringHelper->stringToInt(
                $this->raw[ProductDtoDictionary::CATEGORY_ID]
            );
        }
        if (array_key_exists(ProductDtoDictionary::CATEGORY_NAME, $this->raw) == false) {
            $this->builtable->categoryName = null;
        } else {
            $this->builtable->categoryName = $this->raw[ProductDtoDictionary::CATEGORY_NAME];
        }
        if (array_key_exists(ProductDtoDictionary::CREATED, $this->raw) == false) {
            $this->builtable->created = null;
        } else {
            $this->builtable->created = $this->stringHelper->stringToDateTime(
                $this->raw[ProductDtoDictionary::CREATED]
            );
        }
        if (array_key_exists(ProductDtoDictionary::DESCRIPTION, $this->raw) == false) {
            $this->builtable->description = null;
        } else {
            $this->builtable->description = $this->raw[ProductDtoDictionary::DESCRIPTION];
        }
        return $this->builtable;
    }
}
