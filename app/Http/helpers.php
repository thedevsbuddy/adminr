<?php

use App\Models\Setting;
use Spatie\Permission\Models\Role;

/**
 * Returns the setting value by the
 * option provided
 *
 * @param String $option
 */
if (!function_exists('getSetting')) {
    function getSetting($option)
    {
        return Setting::where('option', $option)->first()
            ? Setting::where('option', $option)->first()->value
            : null;
    }
}


/**
 * Returns role data for provided name | id
 *
 * @param mixed $identifier
 */
if (!function_exists('role')) {
    function role($identifier)
    {
        if(is_string($identifier)){
            return Role::where('name', $identifier)->first()
                ? Role::where('name', $identifier)->first()
                : null;
        } elseif (is_integer($identifier)){
            return Role::where('id', $identifier)->first()
                ? Role::where('id', $identifier)->first()
                : null;
        }
    }
}