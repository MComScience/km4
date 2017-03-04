<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTOPD */
?>
<div class="km4-getptopd-view">
 
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
            'PT_REGISTRY_DATE',
            'PT_REGISTRY_TIME',
            'PT_REGISTRY_BY',
            'PT_SERVICE_INCOMING_ID',
            'PT_SERVICE_SECTION_ID',
            'PT_SERVICE_DOCTOR_ID',
        ],
    ]) ?>

</div>
