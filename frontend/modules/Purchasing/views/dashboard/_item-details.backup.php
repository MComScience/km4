<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>

<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-4 col-sm-12 col-xs-12">
        <ul class="list-group">
            <li class="list-group-item" style="border: 0px solid white;background-color: #fbfbfb;">
                <span class="text"><?= Html::encode('ราคากลาง :'); ?> <?php echo empty($QueryGPU) ? '0.00' : $QueryGPU['GPUStdCost'] ?></span>
            </li>
        </ul>
    </div>  
</div>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <h5 class="success"><b>ปริมาณคลังย่อย</b></h5>
        <div id="tbstock"></div>
        <?php /*
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => true,
            'layout' => $layout,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'columns' => [
                    [
                    'header' => 'รหัสสินค้า',
                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                    'attribute' => 'ItemID',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return empty($model['ItemID']) ? '-' : $model['ItemID'];
                    }
                ],
                    [
                    'header' => 'คลังสินค้า',
                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                    'attribute' => 'StkName',
                    'hAlign' => GridView::ALIGN_LEFT,
                    'pageSummary' => 'รวม',
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'value' => function ($model) {
                        return empty($model['StkName']) ? '-' : $model['StkName'];
                    }
                ],
                    [
                    'header' => 'ยอดคลงคลัง',
                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                    'attribute' => 'ItemQtyBalance',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'pageSummary' => true,
                    'format' => ['decimal', 2],
                    'value' => function ($model) {
                        return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                    }
                ],
                    [
                    'header' => 'หน่วย',
                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                    'attribute' => 'DispUnit',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                        return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                    }
                ],
            ]
        ]);*/
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-10 col-sm-12 col-xs-12">
        <h5 class="success"><b>Price List</b></h5>
           <div id="tbpricelist"></div>
        <?php /*
          echo GridView::widget([
          'dataProvider' => $dataProvider1,
          'responsive' => true,
          'hover' => true,
          'layout' => $layout,
          'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
          'columns' => [
          [
          'header' => 'ผู้จำหน่าย',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'VendorID',
          'hAlign' => GridView::ALIGN_LEFT,
          'value' => function ($model) {
          return empty($model['VendorID']) ? '-' : $model['VendorID'];
          }
          ],
          [
          'header' => 'รหัสสินค้า',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'ItemID',
          'hAlign' => GridView::ALIGN_CENTER,
          'value' => function ($model) {
          return empty($model['ItemID']) ? '-' : $model['ItemID'];
          }
          ],
          [
          'header' => 'ชื่อสินค้า',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'ItemName',
          'hAlign' => GridView::ALIGN_LEFT,
          'value' => function ($model) {
          return empty($model['ItemName']) ? '-' : $model['ItemName'];
          }
          ],
          [
          'header' => 'ราคาต่อหน่วย',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'QUUnitCost',
          'hAlign' => GridView::ALIGN_CENTER,
          'format' => ['decimal', 2],
          'value' => function ($model) {
          return empty($model['QUUnitCost']) ? '' : $model['QUUnitCost'];
          }
          ],
          [
          'header' => 'หน่วย',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'DispUnit',
          'hAlign' => GridView::ALIGN_CENTER,
          'value' => function ($model) {
          return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
          }
          ],
          [
          'header' => 'ยืนราคา',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'QUValidDate',
          'hAlign' => GridView::ALIGN_CENTER,
          'format' => ['decimal', 2],
          'value' => function ($model) {
          return empty($model['QUValidDate']) ? '' : $model['QUValidDate'];
          }
          ],
          ]
          ]); */
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-10 col-sm-12 col-xs-12">
        <h5 class="success"><b>ประวัติการสั่งซื้อ</b></h5>
        <div id="tbhistory"></div>
        <?php /*
          echo GridView::widget([
          'dataProvider' => $dataProvider2,
          'responsive' => true,
          'hover' => true,
          'layout' => $layout,
          'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
          'columns' => [
          [
          'header' => 'เลขที่',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'PONum',
          'hAlign' => GridView::ALIGN_CENTER,
          'value' => function ($model) {
          return empty($model['PONum']) ? '-' : $model['PONum'];
          }
          ],
          [
          'header' => 'วันที่',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'PODate',
          'hAlign' => GridView::ALIGN_CENTER,
          'format' => ['date', 'php:d/m/Y'],
          'value' => function ($model) {
          return empty($model['PODate']) ? '-' : $model['PODate'];
          }
          ],
          [
          'header' => 'รหัสสินค้า',
          'headerOptions' => ['style' => 'color:black;text-align:center;'],
          'attribute' => 'ItemID',
          'hAlign' => GridView::ALIGN_CENTER,
          'value' => function ($model) {
          return empty($model['ItemID']) ? '-' : $model['ItemID'];
          }
          ],
          [
          'header' => 'ชื่อสินค้า',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'ItemName',
          'hAlign' => GridView::ALIGN_LEFT,
          'value' => function ($model) {
          return empty($model['ItemName']) ? '' : $model['ItemName'];
          }
          ],
          [
          'header' => 'ราคาต่อหน่วย',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'POApprovedUnitCost',
          'hAlign' => GridView::ALIGN_RIGHT,
          'format' => ['decimal', 2],
          'value' => function ($model) {
          return empty($model['POApprovedUnitCost']) ? '' : $model['POApprovedUnitCost'];
          }
          ],
          [
          'header' => 'หน่วย',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'DispUnit',
          'hAlign' => GridView::ALIGN_CENTER,
          'value' => function ($model) {
          return empty($model['DispUnit']) ? '' : $model['DispUnit'];
          }
          ],
          [
          'header' => 'จำนวน',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'POApprovedOrderQty',
          'hAlign' => GridView::ALIGN_RIGHT,
          'format' => ['decimal', 2],
          'value' => function ($model) {
          return empty($model['POApprovedOrderQty']) ? '' : $model['POApprovedOrderQty'];
          }
          ],
          [
          'header' => 'เป็นเงิน',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'POExtcost',
          'hAlign' => GridView::ALIGN_RIGHT,
          'format' => ['decimal', 2],
          'value' => function ($model) {
          return $model['POApprovedOrderQty'] * $model['POApprovedUnitCost'];
          }
          ],
          [
          'header' => 'ผู้จำหน่าย',
          'headerOptions' => ['style' => 'color:black; text-align:center;'],
          'attribute' => 'VenderName',
          'hAlign' => GridView::ALIGN_LEFT,
          'value' => function ($model) {
          return empty($model['VenderName']) ? '-' : $model['VenderName'];
          }
          ],
          ]
          ]); */
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        GettbList();
    });

    function GettbList() {
        var id = <?= "'" . $ItemID . "'"; ?>;
        LoadingClass();
        $.ajax({
            url: "index.php?r=Purchasing/dashboard/gettb-list",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#tbstock').html(result.tb1);
                $('#tbpricelist').html(result.tb2);
                $('#tbhistory').html(result.tb3);
                $('div#ajaxCrudModal .modal-body').waitMe('hide');
            }
        });
    }

    function LoadingClass() {
        $('div#ajaxCrudModal .modal-body').waitMe({
            effect: 'ios', //roundBounce
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
</script>