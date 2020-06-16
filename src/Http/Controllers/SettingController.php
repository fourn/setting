<?php

namespace Dcat\Admin\Extension\Fourn\Setting\Http\Controllers;

use Dcat\Admin\Extension\Fourn\Setting\Repositories\SettingRepository;
use Dcat\Admin\Extension\Fourn\Setting\SettingForm;
use Illuminate\Routing\Controller;
use Dcat\Admin\Layout\Content;

class SettingController extends Controller
{
    public function settingIndex(Content $content)
    {
        return $content
            ->title($this->title())
            ->body($this->settingForm()->settingEidt());
    }

    public function settingUpdate()
    {
        return $this->settingForm()->settingUpdate();
    }

    protected function settingForm()
    {
        return SettingForm::make(new SettingRepository(), function (SettingForm $form) {
            $form->disableHeader();
            $form->footer(function ($footer) {
                $footer->disableReset();
                $footer->disableViewCheck();
                $footer->disableEditingCheck();
                $footer->disableCreatingCheck();
            });
            $this->setAction($form);
            $this->generateFields($form);
        });
    }

    protected function setAction(SettingForm $form)
    {
        $form->action(admin_url('setting'));
    }

    protected function generateFields(SettingForm $form)
    {
        $form->generateConfigFields(config('setting'));
    }

    protected function title()
    {
        return admin_trans('setting.labels.setting');
    }
}