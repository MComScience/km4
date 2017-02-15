<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\assets\DataTableAsset;
use kartik\icons\Icon;
use kartik\dropdown\DropdownX;

DataTableAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pr\models\TbPr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb Pr2 Temps';
$this->params['breadcrumbs'][] = $this->title;

$brn = Html::beginTag('div', ['class' => 'dropdown']) .
        Html::button('Click Dropdown <span class="caret"></span></button>', ['type' => 'button', 'class' => 'btn btn-default', 'data-toggle' => 'dropdown']) .
        DropdownX::widget([
            'items' => [
                    ['label' => 'Action', 'url' => '#'],
                    ['label' => 'Submenu 1', 'items' => [
                            ['label' => 'Action', 'url' => '#'],
                            ['label' => 'Another action', 'url' => '#'],
                            ['label' => 'Something else here', 'url' => '#'],
                        '<li class="divider"></li>',
                            ['label' => 'Submenu 2', 'items' => [
                                    ['label' => 'Action', 'url' => '#'],
                                    ['label' => 'Another action', 'url' => '#'],
                                    ['label' => 'Something else here', 'url' => '#'],
                                '<li class="divider"></li>',
                                    ['label' => 'Separated link', 'url' => '#'],
                            ]],
                    ]],
                    ['label' => 'Something else here', 'url' => '#'],
                '<li class="divider"></li>',
                    ['label' => 'Separated link', 'url' => '#'],
            ],
        ]) .
        Html::endTag('div');

$script = <<< JS
    $(document).ready(function() {
        $('#example').DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
            "bSort": false,
            "responsive": true,
            "language": {
                "lengthMenu": "_MENU_",
                "search": '_INPUT_',
                "sSearchPlaceholder": "ค้นหาข้อมูล",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            },
        });
    });    
JS;
$this->registerJs($script);


/*
  ?>
  <div class="tb-pr2-temp-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <p>
  <?= Html::a('Create Tb Pr2 Temp', ['create'], ['class' => 'btn btn-success']) ?>
  </p>
  <?php Pjax::begin(); ?>    <?= GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'columns' => [
  ['class' => 'yii\grid\SerialColumn'],

  'PRID',
  'PRNum',
  'PRDate',
  'DepartmentID',
  'SectionID',
  // 'PRTypeID',
  // 'PRReasonNote',
  // 'POTypeID',
  // 'POContactNum',
  // 'PRExpectDate',
  // 'VendorID',
  // 'PRSubtotal',
  // 'PRVat',
  // 'PRTotal',
  // 'PRSummitted',
  // 'PRSummitedBy',
  // 'PRSummitedDate',
  // 'PRSummitedTime',
  // 'PRStatusID',
  // 'PRApprovalID',
  // 'PRRejectID',
  // 'PRCreatedBy',
  // 'PRCreatedDate',
  // 'PRCreatedTime',
  // 'PRRejectDate',
  // 'PRApprovaDate',
  // 'PRApprovatime',
  // 'PRStatus',
  // 'PRRejectReason',
  // 'PRRejectTime',
  // 'PCPlanNum',
  // 'ids_PR_selected',
  // 'PRVerifyNote',
  // 'PRbudgetID',

  ['class' => 'yii\grid\ActionColumn'],
  ],
  ]); ?>
  <?php Pjax::end(); ?></div>
 * 
 */
?>
<style>
    table.default th{
        background-color: white;
        text-align: center;
    }
    table.default td{
        text-align: center;
    }
</style>
<table id="example" class="default kv-grid-table table table-hover table-striped table-condensed kv-table-wrap" width="100%">
    <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th>
                <?= Html::encode('เลขที่ใบขอซื้อ'); ?>
            </th>
            <th>
                <?= Icon::show('calendar', [], Icon::BSG); ?><?= Html::encode('วันที่'); ?>
            </th>
            <th>
                <?= Html::encode('ประเภทใบขอซื้อ'); ?>
            </th>
            <th>
                <?= Html::encode('ประเภทการสั่งซื้อ'); ?>
            </th>
            <th>
                <?= Html::encode('กำหนดเวลาการส่งมอบ'); ?>
            </th>
            <th>
                <?= Html::encode('Actions'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model as $v) : ?>
            <tr>
                <td style="width: 20px;"></td>
                <td>
                    <?php echo empty($v['PRNum']) ? 'Draft' : $v['PRNum']; ?> 
                </td>
                <td>
                    <?php echo Yii::$app->formatter->asDate($v['PRDate'], 'dd/MM/yyyy'); ?> 
                </td>
                <td>
                    <?php echo empty($v->prtype->PRType) ? '-' : $v->prtype->PRType; ?> 
                </td>
                <td>
                    <?php echo empty($v->potype->POType) ? '-' : $v->potype->POType; ?> 
                </td>
                <td>
                    <?php echo empty($v->PRExpectDate) ? '-' : 'ภายใน ' . $v->PRExpectDate . ' วัน'; ?> 
                </td>
                <td>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
