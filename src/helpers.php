<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('setting_route')) {
    function setting_route($controller = 'SettingController', $path = 'setting') {
        Route::get($path, $controller . '@settingIndex');
        Route::put($path, $controller . '@settingUpdate');
    }
}

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        if (is_array($key)) {
            return DB::table('settings')->whereIn('key', $key)->pluck('value', 'key');
        }
        if ($value = DB::table('settings')->where('key', $key)->value('value')) {
            return $value;
        } else {
            return $default;
        }
    }
}

if (!function_exists('settings')) {
    function settings() {
        return DB::table('settings')->pluck('value', 'key');
    }
}