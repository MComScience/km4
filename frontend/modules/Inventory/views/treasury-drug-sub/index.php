<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\VwStkBalanceItemIDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                       'header' => '<font color="black">#</font>',
                        'headerOptions' => ['class' => 'kartik-sheet-style']
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
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                  //  'ItemCatID',
                   // 'ItemName',
                        [
                        'header' => '<font color="black"><span text-align:center>รายละเอียดสินค้า</span></font>',
                        'attribute' => 'ItemName',
                        //'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                     [
                        'header' => '<font color="black">ยอดคงคลัง</font>',
                        'attribute' => 'ItemQtyBalance',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                       [
                        'header' => '<font color="black">หน่วย</font>',
                        'attribute' => 'DispUnit',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                        [
                        'header' => '<font color="black">Re-Order Point</font>',
                        'attribute' => 'Reorderpoint',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
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