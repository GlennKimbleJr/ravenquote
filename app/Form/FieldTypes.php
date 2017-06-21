<?php

namespace App\Form;

class FieldTypes {

    /**
     * An array of allowable values for the type column on the form_fields table.
     * @var array
     */
    protected static $array = [
        'radio_button',
        'check_box',
        'dropdown_menu',
        'number_input',
        'text_input',
        'hidden_input'
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
