<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'REFER_HRECIEVE_DOC_ID',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'REFER_HRECIEVE_DOC_DATE',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'REFER_HSENDER_DOC_ID',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'DISEASE_CONDITION_CODE',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'REFER_HSENDER_CODE',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'REFER_HSENDER_SENT_TYPEID',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'REFER_HSENDER_DOC_START',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'REFER_HSENDER_DOC_EXPDATE',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'PT_HOSPITAL_NUMBER',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   