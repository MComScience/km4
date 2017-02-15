<?php
/*
use yii\helpers\Html;
use kartik\grid\GridView;


$this->title = 'คลังยาย่อย';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-stk-balance-item-id-index">

    <div class="vwsr2listdraf-index">
        <ul class="nav nav-tabs " id="myTab5">
            <li class="active">
                <a data-toggle="tab" href="#home5">
                    <?= Html::encode($this->title) ?> 
                </a>
            </li>  
        </ul>
        <div class="well">

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>   

            <?=
            fedemotta\datatables\DataTables::widget([
                // 'dataProvider' => $dataProvider,
                // 'bootstrap' => true,
                // 'responsiveWrap' => FALSE,
                // 'responsive' => true,
                // 'hover' => true,
                // 'pjax' => true,
                // 'striped' => false,
                // 'condensed' => true,
                // 'toggleData' => true,
                // 'layout' => Yii::$app->componentdate->layoutgridview(),
                // 'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                'tableOptions' => [
                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                ],
                'options' => [
                'retrieve' => true
                ],
                'clientOptions' => [
                'bSortable' => false,
                'bAutoWidth' => true,
                'ordering' => false,
                'pageLength' => 20,
                                    //'bFilter' => false,
                'language' => [
                'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                'lengthMenu' => '_MENU_'.' '.$btnprint,
                'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                'search' => '_INPUT_'.$this->render('');
                ],
                "lengthMenu" => [[10, 20, 40, 60, -1], [10, 20, 40, 60, "All"]],
                "responsive" => true,
                "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                ],

                'columns' => [
                [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;'],
                ],
//            'ids',
//            'StkTransID',
//            'StkTransDateTime',
//            'StkID',
//            'StkName',
               //     'ItemID',
                [
                'header' => '<font color="black">รหัสสินค้า</font>',
                'attribute' => 'ItemID',
                'contentOptions' => ['style' => 'text-align:center;',],
                'value' => function ($model) {
                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                }
                ],
                  //  'ItemCatID',
                   // 'ItemName',
                [
                'header' => '<font color="black"><span text-align:center>รายละเอียดสินค้า</span></font>',
                'attribute' => 'ItemName',
                'contentOptions' => ['style' => 'text-align:center;',],
                'value' => function ($model) {
                    return empty($model['ItemName']) ? '-' : $model['ItemName'];
                }
                        //'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                ],
                [
                'header' => '<font color="black">ยอดคงคลัง</font>',
                'attribute' => 'ItemQtyBalance',
                'contentOptions' => ['style' => 'text-align:center;',],
                'value' => function ($model) {
                    return empty($model['ItemQtyBalance']) ? '-' : $model['ItemQtyBalance'];
                ],
                [
                'header' => '<font color="black">หน่วย</font>',
                'attribute' => 'DispUnit',
                'contentOptions' => ['style' => 'text-align:center;',],
                'value' => function ($model) {
                    return empty($model['ItemQtyBalance']) ? '-' : $model['ItemQtyBalance'];
                ],
                [
                'header' => '<font color="black">Re-Order Point</font>',
                'attribute' => 'Reorderpoint',
                'contentOptions' => ['style' => 'text-align:center;',],
                'value' => function ($model) {
                    return empty($model['ItemQtyBalance']) ? '-' : $model['ItemQtyBalance'];
                ],
                    //'ItemQtyBalance',
                   // 'DispUnit',
                   // 'Reorderpoint',
                   // 'ItemTargetLevel',
                    //'ItemROPDiff',
                [
                'class' => 'kartik\grid\ActionColumn',
                'header' => '<font color="black">Actions</font>',
                'options' => ['style' => 'width:160px;'],
                'width' => '200px',
                'template' => '{stockcard}',
                'buttonOptions' => ['class' => 'btn btn-default'],
                'buttons' => [
                'stockcard' => function ($url, $model, $key) {
                    return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span>', '#', [
                        'title' => 'stockcard',
                        ]);
                },
                ],
                ],
                ],
                ]);
                ?>
            </div>
        </div>