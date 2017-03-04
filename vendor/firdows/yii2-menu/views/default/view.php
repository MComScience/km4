<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model firdows\menu\models\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
     <!-- <h3 class='box-title'><?= Html::encode($this->title) ?></h3>-->
    </div><!--box-header -->
    
    <div class='box-body pad'>

    <p>
        <?php /*
        <?= Html::a(Yii::t('menu', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('menu', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('menu', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
         * 
         */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'attribute' => 'menu_category_id',
                'label' => 'หมวดเมนู',
                'value' => $model->menuCategory->title,
            ],
            [
                'attribute' => 'parent_id',
                'label' => 'ภายใต้เมนู',
                'value' => empty($model->parent_id) ? '-' : $model->parentTitle,
            ],
            'router',
            'parameter',
            [
                'attribute' => 'icon',
                'label' => 'icon',
                'format' => 'html',
                'value' => '<i class="'.$model->icon.'">'.'</i>',
            ],
            [
                'attribute' => 'status',
                'label' => 'สถานะ',
                'value' => $model->statusLabel,
            ],
            //'item_name',
            'itemsList',
            //'target',
            //'protocol',
           // 'home',
           // 'sort',
            //'language',
            //'assoc',
            [
                'attribute' => 'created_at',
                'label' => 'สร้างเมื่อ',
                'value' => date('Y-m-d G:i:s', $model->created_at),
            ],
            [
                'attribute' => 'created_by',
                'label' => 'สร้างโดย',
                'value' => Yii::$app->user->identity->getUserName($model->created_by),
            ],
        ],
    ]) ?>


    </div><!--box-body pad-->
 </div><!--box box-info-->
