<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\icons\Icon;
use yii\helpers\Url;
use frontend\assets\DataTableAsset;
use common\themes\beyond\assets\DeleteButtonAsset;
use johnitvn\ajaxcrud\CrudAsset;
use frontend\assets\ModalFullScreenAsset;

ModalFullScreenAsset::register($this);
CrudAsset::register($this);
DataTableAsset::register($this);
DeleteButtonAsset::register($this);

$style = ['text-align:center;color:black; border-top: 1px solid #ddd;white-space: nowrap'];

$this->title = 'แผนการจัดชื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<style type="text/css">
    table#DataTables_Table_0 thead tr th{
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget radius-bordered">
            <div class="widget-header">
                <span class="widget-caption"><h5><i class="glyphicon glyphicon-list-alt"></i> <?= $this->title; ?></h5></span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand blue"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus danger"></i>
                    </a>
                </div><!--Widget Buttons-->
            </div><!--Widget Header-->
            <div class="widget-body">
                <?php Pjax::begin(); ?>
                <table class="default kv-grid-table table table-hover table-condensed kv-table-wrap" width="100%">
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
                            if (($v['PCPlanStatusID'] == 2) || ($v['PCPlanStatusID'] == 1)) {
                                if (($v['PCPlanTypeID'] == 1 || $v['PCPlanTypeID'] == 2)) {
                                    /* $action = Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/gpu/view', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Detail')]) . ' '
                                      . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/gpu/update', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-primary', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => 'Edit']) . ' '
                                      . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                      'title' => Yii::t('app', 'Delete'),
                                      'class' => 'btn btn-danger btn-sm delete-button',
                                      'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                      'data-method' => 'post',
                                      'data-pjax' => '0',
                                      'data-toggle' => 'tooltip',
                                      ]); */
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/gpu/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li>
                                               <li>
                                                     ' . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/gpu/update', 'data' => $v['PCPlanNum']], ['data-pjax' => 0, 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'style' => 'font-size:11pt;'
                                            ])
                                            . '</li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                } elseif (($v['PCPlanTypeID'] == 3 || $v['PCPlanTypeID'] == 4)) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/nd/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li>
                                               <li>
                                                     ' . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/nd/update', 'data' => $v['PCPlanNum']], ['data-pjax' => 0, 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'style' => 'font-size:11pt;'
                                            ])
                                            . '</li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                } elseif ($v['PCPlanTypeID'] == 5) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/tpu-cont/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li>
                                               <li>
                                                     ' . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/tpu-cont/update', 'id' => $v['PCPlanNum']], ['data-pjax' => 0, 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'style' => 'font-size:11pt;'
                                            ])
                                            . '</li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                } elseif ($v['PCPlanTypeID'] == 6) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/nd-cont/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li>
                                               <li>
                                                     ' . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/nd-cont/update', 'id' => $v['PCPlanNum']], ['data-pjax' => 0, 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'style' => 'font-size:11pt;'
                                            ])
                                            . '</li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                } elseif (($v['PCPlanTypeID'] == 7 || $v['PCPlanTypeID'] == 8)) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/tpu/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li>
                                               <li>
                                                     ' . Html::a(Icon::show('edit') . Yii::t('app', 'Edit'), ['/plan/tpu/update', 'data' => $v['PCPlanNum']], ['data-pjax' => 0, 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a(Icon::show('trash-o') . Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $v['PCPlanNum']]), [
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-confirm' => Yii::t('app', 'Are you sure delete item?'),
                                                'data-method' => 'post',
                                                'data-pjax' => '0',
                                                'style' => 'font-size:11pt;'
                                            ])
                                            . '</li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                            } else {
                                if (($v['PCPlanTypeID'] == 1 || $v['PCPlanTypeID'] == 2)) {
                                    /* $action = Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/gpu/view', 'data' => $v['PCPlanNum']], ['class' => 'btn btn-xs btn-success', 'data-pjax' => 0, 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Detail')]) . ' '
                                      . Html::button(Icon::show('edit') . Yii::t('app', 'Edit'), ['class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'title' => 'Edit', 'disabled' => true]) . ' '
                                      . Html::button(Icon::show('trash-o') . Yii::t('app', 'Delete'), [
                                      'title' => Yii::t('app', 'Delete'),
                                      'class' => 'btn btn-danger btn-sm delete-button',
                                      'data-toggle' => 'tooltip',
                                      'disabled' => true
                                      ]); */
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;',])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/gpu/details', 'id' => $v['PCPlanNum']], ['style' => 'font-size:11pt;','role' => 'modal-remote',])
                                            . '</li></li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                                if (($v['PCPlanTypeID'] == 3 || $v['PCPlanTypeID'] == 4)) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/nd/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li></li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                                if ($v['PCPlanTypeID'] == 5) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/tpu-cont/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li></li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                                if ($v['PCPlanTypeID'] == 6) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/nd-cont/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li></li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                                if (($v['PCPlanTypeID'] == 7 || $v['PCPlanTypeID'] == 8)) {
                                    $btnaction = '<div class="btn-group dropdown">
                                            ' . Html::a('จัดการ ' . '<span class="caret"></span>', false, ['class' => 'btn btn-sm btn-success dropdown-toggle', 'data-toggle' => 'dropdown', 'data-hover' => 'dropdown', 'data-delay' => 100, 'style' => 'font-size:11pt;'])
                                            . '<ul class="dropdown-menu dropdown-success">
                                                <li>
                                                    ' . Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), ['/plan/tpu/details', 'id' => $v['PCPlanNum']], ['role' => 'modal-remote', 'style' => 'font-size:11pt;'])
                                            . '</li></li><li class="divider"></li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-pdf-o"></i> พิมพ์รายงาน', /* ['/Report/report-inventory/reportpikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print1(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;'])
                                            . '</li>
                                                <li>
                                                    ' . Html::a('<i class="fa fa-file-text-o"></i> พิมพ์ใบบันทึกข้อความ', /* ['/Report/report-inventory/slippikinglist', 'SRID' => $model['SRID']] */ 'javascript:void(0);', [/* 'data-pjax' => 0, 'target' => '_blank' */'onclick' => 'Print2(this);', 'id' => $v['PCPlanNum'], 'style' => 'font-size:11pt;']) . '
                                                </li>
                                            </ul>
                                        </div>';
                                }
                            }
                            ?>
                            <tr class="<?= $v['PCPlanTypeID'] == 5 || $v['PCPlanTypeID'] == 6 ? 'defult' : 'defult' ?>">
                                <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v['PCPlanNum']) ? '-' : $v['PCPlanNum'], ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v['PCPlanDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v->department->DepartmentDesc) ? '-' : $v->department->DepartmentDesc, ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v->section->SectionDecs) ? '-' : $v->section->SectionDecs, ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v->plantype->PCPlanType) ? '-' : $v->plantype->PCPlanType, ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v['PCPlanEndDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanEndDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v['PCPlanEndDate']) ? '-' : Yii::$app->formatter->asDate($v['PCPlanEndDate'], 'dd/MM/yyyy'), ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', empty($v->status->PCPlanStatus) ? '-' : $v->status->PCPlanStatus, ['style' => 'text-align: center;']) ?>

                                <?= Html::tag('td', $btnaction, ['style' => 'text-align: center;white-space: nowrap']) ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php /*
                  echo GridView::widget([
                  'dataProvider' => $provider,
                  'hover' => true,
                  'pjax' => true,
                  'striped' => true,
                  'condensed' => true,
                  'bordered' => false,
                  'responsive' => false,
                  'showOnEmpty' => false,
                  'emptyCell' => '-',
                  'export' => false,
                  'layout' => "{items}",
                  'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'style' => 'width:100%'],
                  'columns' => [
                  [
                  'class' => 'kartik\grid\SerialColumn',
                  'contentOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;'],
                  'width' => '36px',
                  'header' => '#',
                  'headerOptions' => $headerOptions
                  ],
                  [
                  'header' => 'เลขที่แผนจัดซื้อ',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanNum',
                  'contentOptions' => ['style' => 'text-center:center;'],
                  'value' => function ($model) {
                  return empty($model->PCPlanNum) ? '-' : $model->PCPlanNum;
                  },
                  ],
                  [
                  'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanDate',
                  'contentOptions' => ['style' => 'text-center:center;'],
                  'format' => ['date', 'php:d/m/Y'],
                  ],
                  [
                  'header' => 'ฝ่าย',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'DepartmentID',
                  'hAlign' => GridView::ALIGN_CENTER,
                  'value' => function ($model) {
                  return empty($model->department->DepartmentDesc) ? '-' : $model->department->DepartmentDesc;
                  }
                  ],
                  [
                  'header' => 'แผนก',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'SectionID',
                  'hAlign' => GridView::ALIGN_CENTER,
                  'value' => function ($model) {
                  return empty($model->section->SectionDecs) ? '-' : $model->section->SectionDecs;
                  }
                  ],
                  [
                  'header' => 'ประเภทแผนจัดชื้อ',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanTypeID',
                  'contentOptions' => ['class' => 'text-center'],
                  'value' => function($model) {
                  return empty($model->plantype->PCPlanType) ? '-' : $model->plantype->PCPlanType;
                  }
                  ],
                  [
                  'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่เริ่มแผน',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanBeginDate',
                  'contentOptions' => ['style' => 'text-center:center;'],
                  'format' => ['date', 'php:d/m/Y'],
                  ],
                  [
                  'header' => Icon::show('calendar', [], Icon::BSG) . 'วันที่เริ่มแผน',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanEndDate',
                  'contentOptions' => ['style' => 'text-center:center;'],
                  'format' => ['date', 'php:d/m/Y'],
                  ],
                  [
                  'header' => 'สถานะ',
                  'headerOptions' => $headerOptions,
                  'attribute' => 'PCPlanStatusID',
                  'contentOptions' => ['class' => 'text-center'],
                  'value' => function($model) {
                  return empty($model->status->PCPlanStatus) ? '-' : $model->status->PCPlanStatus;
                  }
                  ],
                  [
                  'class' => '\kartik\grid\ActionColumn',
                  'header' => 'Actions',
                  'headerOptions' => $headerOptions,
                  'contentOptions' => ['style' => 'text-align:center;'],
                  'template' => '{view}',
                  'noWrap' => true,
                  'buttons' => [
                  //view button
                  'view' => function ($url, $model) {
                  if (!empty($model->PRNum)) {
                  return Html::a(Icon::show('list-alt') . Yii::t('app', 'Detail'), $url, [
                  'title' => Yii::t('app', 'Detail'),
                  'data-toggle' => 'tooltip',
                  'data-pjax' => 0,
                  'class' => 'btn btn-success btn-sm',
                  ]);
                  }
                  },
                  ],
                  'urlCreator' => function ($action, $model, $key, $index) {
                  if ($action === 'view') {//View
                  return Url::to(['/pr/gpu/view', 'id' => $key]);
                  }
                  if ($action === 'update') {
                  return Url::to(['/pr/gpu/update', 'id' => $key]);
                  }
                  }
                  ],
                  ],
                  ]); */
                ?>
                <?php Pjax::end(); ?>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>
<?php echo $this->render('alert'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/plan/datatables.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>