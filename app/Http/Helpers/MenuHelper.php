<?php

namespace Helpers;

use Illuminate\Support\Facades\Route;

class MenuHelper {

    public static function getClass($route_name)
    {
        if (strpos(Route::currentRouteName(), $route_name) !== false) {
            return 'list-group-item active';
        }

       return 'list-group-item';
    }
}
