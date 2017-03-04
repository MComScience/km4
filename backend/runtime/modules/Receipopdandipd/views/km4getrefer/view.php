<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETREFER */
?>
<div class="km4-getrefer-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'REFER_HRECIEVE_DOC_ID',
            'REFER_HRECIEVE_DOC_DATE',
            'REFER_HSENDER_DOC_ID',
            'DISEASE_CONDITION_CODE',
            'REFER_HSENDER_CODE',
            'REFER_HSENDER_SENT_TYPEID',
            'REFER_HSENDER_DOC_START',
            'REFER_HSENDER_DOC_EXPDATE',
            'PT_HOSPITAL_NUMBER',
        ],
    ]) ?>

</div>
