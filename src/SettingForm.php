<?php


namespace Dcat\Admin\Extension\Fourn\Setting;


use Dcat\Admin\Extension\Fourn\Setting\Repositories\SettingRepository;

use Dcat\Admin\Form;
use Dcat\Admin\Form\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class SettingForm extends Form
{
    /**
     * @var SettingRepository
     */
    protected $repository;

    public function generateConfigFields(array $config)
    {
        if (!$config) {
            return false;
        }

        foreach ($config as $tab => $fields) {
            $this->tab(admin_trans_label($tab), function (SettingForm $form) use ($fields, $tab) {
                foreach ($fields as $key => $params) {

                    // 允许只配置字段名称
                    if (is_numeric($key) && is_string($params)) {
                        $key = $params;
                        $params = [];
                    }

                    $fieldType = isset($params['type']) ? $params['type'] : 'text';
                    $fieldName = $tab . '-' . $key;

                    // 排除掉指定类型的字段
                    unset($params['type']);

                    // 所有表单可用类型
                    if (isset(SettingForm::extensions()[$fieldType])) {

                        $options = [];
                        if (is_array($params)) {
                            foreach ($params as $paramKey => $paramItem) {
                                if (is_numeric($paramKey) && is_array($paramItem)) {
                                    $options = $paramItem;
                                    unset($params[$paramKey]);
                                }
                            }
                        }

                        // 创建字段
                        $field = $form->$fieldType($fieldName, ...$options);

                        // 循环能够被链式调用的方法
                        foreach ($params as $paramKey => $paramValue) {
                            if (is_numeric($paramKey) && is_string($paramValue)) {
                                // 不需要参数
                                $field->$paramValue();
                            } elseif (Str::endsWith($paramKey, '...')) {
                                // 有多个参数
                                $paramKey = str_replace('...', '', $paramKey);
                                $field->$paramKey(...$paramValue);
                            } else {
                                // 有且仅有一个参数
                                $field->$paramKey($paramValue);
                            }
                        }
                    }
                }
            });
        }

        return true;
    }

    public function settingEidt()
    {
        $this->builder->mode(Builder::MODE_EDIT);
        $this->model(new Fluent($this->repository->settingEidt($this)));

        return $this;
    }

    public function settingUpdate()
    {
        $data = $this->request->all();

        if ($response = $this->beforeSettingUpdate($data)) {
            return $response;
        }

        $this->updates = $this->prepareUpdate($this->updates);

        $updated = $this->repository->settingUpdate($this);

        if (($response = $this->callSaved($updated))) {
            return $response;
        }

        if (! $updated) {
            return $this->error(trans('admin.update_succeeded'));
        }

        return $this->redirect(
            admin_url('setting'),
            trans('admin.update_succeeded')
        );
    }

    protected function beforeSettingUpdate(array &$data)
    {
        $this->builder->mode(Builder::MODE_EDIT);

        $this->inputs = $data;

        $this->model(new Fluent($this->repository->getSettingDataWhenUpdating($this)));

        $this->build();

        $this->setFieldOriginalValue();

        if ($response = $this->callSubmitted()) {
            return $response;
        }

        if ($uploadFileResponse = $this->handleUploadFile($this->inputs)) {
            return $uploadFileResponse;
        }

        $isEditable = $this->isEditable($this->inputs);

        $this->inputs = $this->handleEditable($this->inputs);

        $this->inputs = $this->handleFileDelete($this->inputs);

        $this->inputs = $this->handleHasManyValues($this->inputs);

        if ($response = $this->handleOrderable($this->inputs)) {
            return $response;
        }

        // Handle validation errors.
        if ($validationMessages = $this->validationMessages($this->inputs)) {
            return $this->validationErrorsResponse(
                $isEditable ? Arr::dot($validationMessages->toArray()) : $validationMessages
            );
        }

        if ($response = $this->prepare($this->inputs)) {
            return $response;
        }
    }
}