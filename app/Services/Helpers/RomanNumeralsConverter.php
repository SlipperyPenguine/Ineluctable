<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 16/08/2015
 * Time: 17:42
 */

namespace ineluctable\Services\Helpers;


use InvalidArgumentException;

class RomanNumeralsConverter
{

    /**
     * @var array
     */
    protected static $lookup = [
        1000 => 'M',
        900  => 'CM',
        500  => 'D',
        400  => 'CD',
        100  => 'C',
        90   => 'XC',
        50   => 'L',
        40   => 'XL',
        10   => 'X',
        9    => 'IX',
        5    => 'V',
        4    => 'IV',
        1    => 'I'
    ];
    /**
     * @param $number
     * @return string
     */
    public static function convert($number)
    {
        if ($number <= 0)
        {
            throw new InvalidArgumentException;
        }

        $solution = '';
        foreach (static::$lookup as $limit => $glyph)
        {
            while ($number >= $limit)
            {
                $solution .= $glyph;
                $number -= $limit;
            }
        }
        return $solution;
    }

}