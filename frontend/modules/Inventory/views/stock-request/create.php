<?php

$this->title = 'บันทึกใบขอเบิก';
$this->params['breadcrumbs'][] = ['label' => 'เบิก โอน จ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbsr2temp-create">
    <?= $this->render('_form', [
       'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'model' => $model,
        'section' => $section,
        'SRID'=>$SRID
    ]) ?>

</div>
