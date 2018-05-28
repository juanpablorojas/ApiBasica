<?php

namespace ApiBasica\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductModel
 * @package ApiExperimental\src\Models
 */
class ProductModel extends Model
{
    /**
     * @inheritdoc
     */
    protected $table = 'products';

    /**
     * @inheritdoc
     */
    public $timestamps = false;
}
