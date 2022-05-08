<?php

use App\Models\Setting;
use Spatie\Permission\Models\Role;


if (!function_exists('getSetting')) {
    function getSetting($option): ?string
    {
        return Setting::where('option', $option)->value('value');
    }
}


if (!function_exists('role')) {
    function role($identifier): ?Role
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
        return null;
    }
}
