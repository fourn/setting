<?php

return [
    'sample' => [
        'value',
        'value1'=>['help'=>'help content', 'default'=>'default value'],
        'value2'=>['placeholder'=>'typing...', 'rules'=>'required'],
        'value3'=>[['标题'], 'type'=>'select', 'options'=>['option1'=>'option1', 'option2'=>'option2']],
        'value4'=>[['sample-value4end', '时间区间'], 'type'=>'timeRange'],
        'value5'=>['type'=>'checkbox', 'options'=>['foo'=>'foo', 'bar'=>'bar']],
        'value6'=>['type'=>'ip'],
        'value7'=>['type'=>'mobile'],
        'value8'=>['type'=>'color'],
        'value9'=>['type'=>'time', 'format'=>'HH:mm'],
        'value10'=>['width...' => [4, 2]],
        'value11'=>['type'=>'number', 'min'=>100, 'default'=>100],
        'value12'=>['type'=>'rate'],
        'value13'=>['type'=>'image', 'uniqueName'],
        'value14'=>['type'=>'file', 'uniqueName'],
        'value18'=>['type'=>'switch'],
        'value19'=>['type'=>'tags'],
    ],
    'sample2' => [
        'demo'
    ]
];
