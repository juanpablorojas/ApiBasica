<?php

namespace ApiBasica\Dictionaries;

use ApiBasica\Dictionaries\ProductDtoDictionary;

/**
 * Class DbRepositoryDictionary
 * @package ApiExperimental\src\Dictionaries
 */
final class DbRepositoryDictionary
{
    public $allowed = [
        ProductDtoDictionary::NAME,
        ProductDtoDictionary::PRICE,
        ProductDtoDictionary::DESCRIPTION,
        ProductDtoDictionary::CATEGORY_ID,
    ];
}
