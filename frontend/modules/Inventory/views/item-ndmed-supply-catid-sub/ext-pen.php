<?php

use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\bootstrap\Html;
?>
 <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
<?php
GridView::widget([
    'dataProvider' => $dataProvider,
    'bootstrap' => true,
    'responsiveWrap' => FALSE,
    'responsive' => true,
    'hover' => true,
    'pjax' => true,
    'striped' => false,
    'condensed' => true,
    'toggleData' => true,
    'layout' => Yii::$app->componentdate->layoutgridview(),
    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'contentOptions' => ['class' => 'kartik-sheet-style'],
            'width' => '36px',
            'header' => '<font color="black">#</font>',
            'headerOptions' => ['class' => 'kartik-sheet-style']
        ],
       [
            'header' => '<font color="black">รหัสสินค้า</font>',
            'attribute' => 'ItemNDMedSupply',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        ],
		 [
            'header' => '<font color="black">Re-Order Point</font>',
            'attribute' => 'ItemNDMedSupplyDesc',
			'contentOptions' => 
            ['style' => 'display:none'],
			'headerOptions' => ['style' => 'display:none'],
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
          
        ],
       
]]);
?>
<?php yii\widgets\Pjax::end() ?>
<div class=" col-md-8">
    <?php
    if ($data != null) {
        $htl = '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center">
					ลำดับ
				</th>
				<th style="text-align:center">
					ชื่อหมวดย่อย
				</th>
				<th style="text-align:center" width="11%">
					รายละเอียด
				</th>
			</tr>
                        </thead>
                        <tbody>';
        $no = 1;
        $cost = 0;
        $i = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
              $htl .= '<td style="text-align:center">' . $i . '</td>';
            $htl .= '<td style="text-align:left">' . $result['ItemNDMedSupply'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['ItemNDMedSupplyDesc'] . '</td>';
          
            $htl .='</tr>';
            $i++;
        }
        echo $htl;
    } else {
        echo '
            <div class="panel panel-danger">
                                    <div class="panel-body">
                                     <div align="center">ไม่มีรายการ</div>
                                    </div>
                                  </div>';
    }
    ?>
</div>
