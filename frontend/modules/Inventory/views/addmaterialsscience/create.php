<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'บันทึกรายการวัสดุวิทยาศาสตร์');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'จัดการรายการสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        สร้างรหัสสินค้า
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">

                    <div class="tb-item-create">

                        <?=
                        $this->render('_form', [
                            'model' => $model,
                            'initialPreview' => $initialPreview,
                            'initialPreviewConfig' => $initialPreviewConfig,
                            'initialPreview1' => $initialPreview1,
                            'initialPreviewConfig1' => $initialPreviewConfig1,
                            'true' => $true,
                        ])
                        ?>
                    </div>
                </div>
            </div>
            <div class="horizontal-space"></div>
        </div>
    </div>
</div>
