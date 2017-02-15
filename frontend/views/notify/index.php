<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbProblemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการแจ้งปัญหา';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .blueimp-gallery-display {
        display: none;
        opacity: 1;
    }
</style>
<div class="tb-problem-index">
    <?php Pjax::begin(); ?>    
    <?php /*
      GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      'subject',
      'details:ntext',
      'create_by',
      // 'update_by',
      // 'create_date',
      // 'status',
      ['class' => 'yii\grid\ActionColumn'],
      ],
      ]); */
    ?>
    <?php Pjax::end(); ?>
</div>
<?php foreach ($model as $value) : ?>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="panel <?= $value['status'] == '1' ? 'panel-danger' : 'panel-success' ?>">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?= Icon::show('hand-right', [], Icon::BSG) . Html::encode($value['subject']); ?>
                        <div class="pull-right">
                            <?= Icon::show('user', [], Icon::BSG) . Html::encode('แจ้งโดย : '); ?> <?= $value->getUser($value['create_by']); ?>
                            # <?= Html::encode('สถานะ : '); ?><?= $value['status'] == '1' ? Icon::show('hourglass', [], Icon::BSG).'รอดำเนินการ' : Icon::show('ok', [], Icon::BSG).'ดำเนินการเสร็จสิ้น' ?>  
                        </div>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-10 col-sm-12 col-xs-12">
                            <p>
                                <strong style="font-size: 13pt;" class="success"><?= Html::encode('รายละเอียด :'); ?></strong>
                                <?= $value['details']; ?>
                            </p>
                        </div>
                        <div class="col-lg-2 col-sm-12 col-xs-12">
                            <p style="text-align: right;">
                                <small>
                                    <?= Icon::show('calendar', [], Icon::BSG) . ' วันที่แจ้ง ' . $value['create_date']; ?>
                                </small>  
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-sm-12 col-xs-12">
                            <p>
                                <strong style="font-size: 10pt;" class="success"><?= Html::encode('Comment ตอบกลับ :'); ?></strong>
                                <?= $value['comment']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">

                            <h5><strong style="font-size: 13pt;"><?= Html::encode('ภาพเพิ่มเติม'); ?></strong></h5>
                            <p>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?= dosamigos\gallery\Gallery::widget(['items' => $value->getThumbnails($value->ref, $value->subject)]); ?>
                                </div>
                            </div>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: right;">
                            <?php if (Yii::$app->user->identity->username == 'webmaster' || Yii::$app->user->identity->username == 'admin') : ?>
                            <?= Html::a(Icon::show('edit', [], Icon::BSG), ['update', 'id' => $value['id']], ['class' => 'btn btn-primary']); ?>
                            <?=
                            Html::a(Icon::show('trash', [], Icon::BSG), ['delete', 'id' => $value->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

