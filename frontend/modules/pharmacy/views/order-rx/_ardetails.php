<?php
use yii\helpers\Html;
$avatar = ($userAvatar = $profile->getAvatar($profile->pt_visit_number)) ? $userAvatar : $profile->getAvatar(NULL);
$no = 1;
?>
<style type="text/css">
    table#details thead th{
        text-align: center;
    }
    table#details thead tr th{
        background-color: #ddd;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-1 text-center">
        <br/>
        <?= Html::img($avatar, ['alt' => 'Profile','class' => 'img-circle','width' => 50,'height' => 50]) ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-11">
        <br/>
        <table id="details" class="table table-hover table-bordered table-striped table-condensed kv-table-wrap">
            <thead>
                <tr>
                    <?= Html::tag('th', Html::encode('ลำดับสิทธิ'), []) ?>
                    <?= Html::tag('th', Html::encode('สิทธิการรักษา'), []) ?>
                    <?= Html::tag('th', Html::encode('เลขที่ใบส่งตัว'), []) ?>
                    <?= Html::tag('th', Html::encode('วันเริ่มใบส่งตัว'), []) ?>
                    <?= Html::tag('th', Html::encode('วันสิ้นสุดใบส่งตัว'), []) ?>
                    <?= Html::tag('th', Html::encode('ใช้สิทธิ'), []) ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ardetails as $items) :?>
                    <tr>
                        <?= Html::tag('td', $no, ['style' => 'text-align: center;']) ?>
                        <?= Html::tag('td', $items['ar_name'], ['style' => 'text-align: left;']) ?>
                        <?= Html::tag('td', $items['refer_hsender_doc_id'], ['style' => 'text-align: center;']) ?>
                        <?= Html::tag('td', empty($items->refer_hsender_doc_start) ? '-' : Yii::$app->componentdate->convertMysqlToThaiDate($items->refer_hsender_doc_start), ['style' => 'text-align: center;']) ?>
                        <?= Html::tag('td', empty($items->refer_hsender_doc_expdate) ? '-' : Yii::$app->componentdate->convertMysqlToThaiDate($items->refer_hsender_doc_expdate), ['style' => 'text-align: center;']) ?>
                        <?= Html::tag('td', $items['pt_ar_usage'], ['style' => 'text-align: center;']) ?>
                    </tr>
                    <?php $no++; ?>
                    <?php  endforeach; ?>
            </tbody>
        </table>
        <br/>
    </div>
</div>
