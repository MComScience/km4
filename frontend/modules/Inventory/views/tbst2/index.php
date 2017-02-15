<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\SearchTbst2 */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb St2s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-st2-index">
    
    <div class="vwsr2listdraf-index">
    <ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?> 
        </a>
    </li>  
</ul>
    <div class="well">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tb St2', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
                    
            ['class' => 'kartik\grid\SerialColumn',
                'mergeHeader'=>true,
                
               ],
             [
            'attribute'=>'STID', 
            'width'=>'310px',
//            'value'=>function ($model, $key, $index, $widget) { 
//                return $model->supplier->company_name;
//            },
            'filterType'=>GridView::FILTER_SELECT2,
          //  'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
            'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[3,4],[5,6]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        1=>'1',
                        2=>'2',
                        3=>'ขอเบิก',
                        5=>'ยอดโอน',
                    ],
                       'contentOptions'=>[      // content html attributes for each summary cell
                        1=>['style'=>'text-align:center'],
                        2=>['style'=>'text-align:center'],
                        3=>['style'=>'text-align:center'],
                        5=>['style'=>'text-align:center'],
                    ],
                ];
            }
        ],
        
            
 
            [
            'header' => false,
            'attribute' => 'STID',
          
        ],
            'STID',            
            'STDate',
            'STNum',
            'STTypeID',
//            'SRNum',
            // 'STCreateBy',
            // 'STCreateDate',
            // 'STIssue_StkID',
            // 'STRecieve_StkID',
            // 'STRecievedDate',
            // 'STRecievedBy',
            // 'STStatus',
            // 'STPerson',
            // 'STNote',
            // 'STDueDate',
//                 [
//            'class'=>'kartik\grid\FormulaColumn',
//            'header'=>'Amount In Stock',
//            'value'=>function ($model, $key, $index, $widget) { 
//                $p = compact('model', 'key', 'index');
//                return $widget->col(2, $p) * $widget->col(5, $p);
//            },
//            'mergeHeader'=>true,
//            'width'=>'150px',
//            'hAlign'=>'right',
//            'format'=>['decimal', 2],
////            'pageSummary'=>true
//        ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
