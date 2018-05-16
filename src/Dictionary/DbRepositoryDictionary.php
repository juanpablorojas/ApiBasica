<?php

namespace ApiExperimental\src\Dictionary;

include_once 'ProductDtoDictionary.php';

use ApiExperimental\src\Dictionaries\ProductDtoDictionary;

/**
 * Class DbRepositoryDictionary
 * @package ApiExperimental\src\Dictionary
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
