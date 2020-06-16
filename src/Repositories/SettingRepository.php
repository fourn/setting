<?php


namespace Dcat\Admin\Extension\Fourn\Setting\Repositories;


use Dcat\Admin\Extension\Fourn\Setting\Models\Setting as SettingModel;
use Dcat\Admin\Extension\Fourn\Setting\SettingForm;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class SettingRepository extends EloquentRepository
{
    protected $eloquentClass = SettingModel::class;

    public function settingEidt(SettingForm $form): array
    {
        $data = $this->newQuery()->pluck('value', 'key')->toArray();

        $values = [];
        foreach ($data as $key => $value) {
            $values[str_replace('.', '-', $key)] = $value;
        }

        $this->model = $this->model->fill($values);

        return $this->model->toArray();
    }

    public function getSettingDataWhenUpdating(SettingForm $form): array
    {
        return $this->settingEidt($form);
    }

    public function settingUpdate(SettingForm $form)
    {
        $model = $this->eloquent();

        $result = null;

        DB::transaction(function () use ($form, $model, &$result) {
            $updates = $form->updates();

            foreach ($updates as $key => $value) {
                // 多选框可能会返回数组
                if (is_array($value)) {
                    $value = implode(',', $value);
                }
                $model->newQuery()->updateOrCreate(
                    ['key' => str_replace('-', '.', $key)],
                    ['value' => $value]
                );
            }

            $result = true;
        });

        return $result;
    }
}