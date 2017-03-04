<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTIPD */
?>
<div class="km4-getptipd-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PT_HOSPITAL_NUMBER',
            'PT_TITLENAME_ID',
            'PT_FNAME_TH',
            'PT_LNAME_TH',
            'PT_DOB',
            'PT_SEX_ID',
            'PT_NATION_ID',
            'PT_CID',
            'PT_ADMISSION_NUMBER',
            'PT_REGISTRY_DATE',
            'PT_REGISTRY_TIME',
            'PT_REGISTRY_BY',
            'PT_SERVICE_SECTION_ID',
            'PT_SERVICE_FROM_SECTION_ID',
        ],
    ]) ?>

</div>
