<?php

namespace Dcat\Admin\Extension\Fourn\Setting;

use Dcat\Admin\Extension;

class Setting extends Extension
{
    const NAME = 'setting';

    protected $serviceProvider = SettingServiceProvider::class;

    protected $composer = __DIR__.'/../composer.json';

    protected $migrations = __DIR__.'/../database/migrations';

    protected $lang = __DIR__.'/../resources/lang';

    protected $menu = [
        'title' => 'Setting',
        'path'  => 'setting',
        'icon'  => 'fa-gear',
    ];
}
