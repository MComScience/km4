<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\icons\Icon;
use yii\helpers\Url;
use frontend\assets\DataTableAsset;

DataTableAsset::register($this);

$style = ['text-align:center;color:black; border-top: 1px solid #ddd;'];

$this->title = 'แผนจัดซื้อรอการทวนสอบ';
$this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['waiting-verify']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    table#DataTables_Table_0 thead tr th{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/pr/views/default/dashboard_pharmacy.php', ['title' => 'หัวหน้าเภสัชกรรม']); ?>
            <div class="profile-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/pr/views/default/_tab_pharmacy.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin() ?>
                                        <table class="default kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
                                            <thead>
                                                <tr>
                                                    <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('เลขที่แผนจัดชื้อ'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Icon::show('calendar', [], Icon::BSG) . Html::encode('วันที่'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('ฝ่าย'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('แผนก'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('ประเภทแผนจัดชื้อ'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Icon::show('calendar', [], Icon::BSG) . Html::encode('วันที่เริ่มแผน'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Icon::show('calendar', [], Icon::BSG) . Html::encode('วันที่สิ้นสุดแผน'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('สถานะ'), ['style' => $style]) ?>

                                                    <?= Html::tag('th', Html::encode('Actions'), ['style' => $style]) ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($query as $v) : ?>
                                                    <?php
                                                    if (($v['PCPlanTypeID'] == 1) || ($v['PCPlanTypeID'] == 2)) {
                                                        $action = Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), ['/plan/gpu/verify', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Select')]);
                                                    }
                                                    if (($v['PCPlanTypeID'] == 3) || ($v['PCPlanTypeID'] == 4)) {
                                                        $action = Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), ['/plan/nd/verify', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Select')]);
                                                    }
                                                    if ($v['PCPlanTypeID'] == 5) {
                                                        $action = Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), ['/plan/tpu-cont/verify', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Select')]);
                                                    }
                                                    if ($v['PCPlanTypeID'] == 6) {
                                                        $action = Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), ['/plan/nd-cont/verify', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Select')]);
                                                    }
                                                    if (($v['PCPlanTypeID'] == 7) || ($v['PCPlanTypeID'] == 8)) {
                                                        $action = Html::a(Icon::show('hand-up', [], Icon::BSG) . Yii::t('app', 'Select'), ['/plan/tpu/verify', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Select')]);
                                                    }
                                                    ?>
                                                    <tr>
                                                        <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v['PCPlanNum']) ? '-' : $v['PCPlanNum'], ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v['PCPlanDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v->department->DepartmentDesc) ? '-' : $v->department->DepartmentDesc, ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v->section->SectionDecs) ? '-' : $v->section->SectionDecs, ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v->plantype->PCPlanType) ? '-' : $v->plantype->PCPlanType, ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v['PCPlanEndDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanEndDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v['PCPlanEndDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanEndDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', empty($v->status->PCPlanStatus) ? '-' : $v->status->PCPlanStatus, ['style' => 'text-align: center;']) ?>

                                                        <?= Html::tag('td', $action, ['style' => 'text-align: center;']) ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php Pjax::end() ?>
                                    </div>
                                    <div class="col-xs-12 col-md-12" style="text-align: right;">
                                        <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->render('alert'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/plan/gpu/waiting-verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>