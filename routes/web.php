<?php

use Dcat\Admin\Extension\Fourn\Setting\Http\Controllers;

Route::get('setting', Controllers\SettingController::class . '@settingIndex');
Route::put('setting', Controllers\SettingController::class . '@settingUpdate');