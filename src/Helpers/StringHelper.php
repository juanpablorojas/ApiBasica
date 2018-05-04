<?php

namespace ApiExperimental\src\Helpers;

/**
 * Class StringHelper
 */
class StringHelper
{
    /**
     * @param $string
     * @return float|null
     */
    public function stringToNumber($string)
    {
        if ($this->isNull($string))
        {
            return null;
        }
        return floatval($string);
    }

    /**
     * @param $string
     * @return int|null
     */
    public function stringToInt($string)
    {
        if ($this->isNull($string))
        {
            return null;
        }
        return intval($string);
    }

    /**
     * @param $string
     * @return false|null|string
     */
    public function stringToDateTime($string)
    {
        if ($this->isNull($string))
        {
            return null;
        }
        if ($string == '--') {
            return null;
        }
        try {
            return date("Y-m-d H:i:s", strtotime($string));
        } catch (\Exception $e) {

        }
        return null;
    }

    /**
     * @param $string
     */
    protected function isNull($string)
    {
        if ($string == null) {
            true;
        }
        false;
    }
}
