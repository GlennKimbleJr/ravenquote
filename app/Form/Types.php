<?php

namespace App\Form;

class Types {

    /**
     * An array of allowable values for the type column on the forms table.
     * @var array
     */
    protected static $array = [
        'live_calculation',
        'click_to_calculate',
        'request_for_quote',
        'email_calculation',
        'email_calculation_with_admin_approval'
    ];

    /**
     * Return the array property
     * @return array
     */
    public static function get()
    {
        return self::$array;
    }
}
