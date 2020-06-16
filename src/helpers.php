<?php

if (!function_exists('setting_route')) {
    function setting_route($controller = 'SettingController', $path = 'setting') {
        Route::get($path, $controller . '@settingIndex');
        Route::put($path, $controller . '@settingUpdate');
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null) {

    }
}