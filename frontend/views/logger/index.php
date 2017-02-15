<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbLoggerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loggers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-logger-index">
    
    <div class="vwsr2listdraf-index">
    <ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?> 
        </a>
    </li>  
</ul>
    <div class="well">
    <h1><?php Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php Html::a('Create Tb Logger', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'action',
            'dates',
            'datetime',
            'user_id',
            // 'ip',
            'action_id',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
