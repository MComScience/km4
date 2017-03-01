<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin([
            'id' => 'import-form',
            'options' => ['enctype' => 'multipart/form-data'],
            'type' => ActiveForm::TYPE_HORIZONTAL
        ]);
?>
<div class="form-group">
<!--    <div class="col-sm-2">-->
        <?php // Html::a('<i class="fa fa-user-plus"></i> Add Users', ['create'], ['class' => 'btn btn-primary', 'id' => 'activity-create-link']) ?>
<!--    </div>-->
    <div class="col-sm-3">
        <?=
        kartik\file\FileInput::widget([
            'name' => 'excel_file',
            'pluginOptions' => [
                'previewFileType' => 'any',
                'overwriteInitial' => true,
                'showPreview' => FALSE,
                'showCaption' => true,
                'showRemove' => FALSE,
                'showUpload' => FALSE,
                'allowedFileExtensions' => ['xls', 'xlsx', 'xlsm', 'xlsb', 'csv'],
                'maxFileSize' => 5000,
                'browseLabel' => 'เลือกไฟล์..'
            /*
              'uploadUrl' => Url::to(['/user/admin/upload-ajax']),
              'uploadLabel' => 'นำเข้าข้อมูล',
              'uploadTitle' => 'นำเข้าไฟล์ข้อมูล'
             * 
             */
            ]
        ])
        ?>
    </div>
    <div class="col-sm-2">
        <?= Html::submitButton('<i class="glyphicon glyphicon-import"></i> นำเข้าข้อมูล', ['class' => 'btn btn-info', 'id' => 'Import']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>




