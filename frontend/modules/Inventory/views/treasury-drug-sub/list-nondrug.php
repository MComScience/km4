<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\VwStkBalanceItemIDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJs('$("#tab_B").addClass("active");');
$this->title = 'คลังยาย่อย';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-stk-balance-item-id-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab', ['model' => $searchModel]); ?>  
        <div class="well">

            <?php $this->render('_search', ['model' => $searchModel, 'action' => 'list-nondrug']); ?>   

            <?php
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
                    //  'StkName',
                    [
                        'header' => '<font color="black">คลังสินค้า</font>',
                        'attribute' => 'StkName',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
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
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-stockcard-link',
                                ]);
                            },
                                ],
                            ],
                        ],
                    ]);
                    ?>

                    <style>
                        table, thead, tr,th {
                            text-align: center;
                        }
                    </style>
                    <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="success">
                                <th style="display:none">คลังสินค้า</th>
                                <th>#</th>
                                <th style="color:black">คลังสินค้า</th>
                                <th style="color:black">รหัสสินค้า</th>
                                <th style="color:black">รายละเอียดสินค้า</th>
                                <th style="color:black">ยอดคงคลัง</th>
                                <th style="color:black">หน่วย</th>
                                <th style="color:black">จุดสั่งชื้อ</th>
                                <th style="color:black">ต่ำกว่าจุดสั่งชื้อ</th>
                                <th style="color:black">Stock Card</th>
                            </tr>
                        </thead>

        <!--                        <tfoot>
                                    <tr>
                                        <th>คลังสินค้า</th>
                                        <th>รหัสสินค้า</th>
                                        <th id="detail_product">รายละเอียดสินค้า</th>
                                        <th>ยอดคงคลัง</th>
                                        <th>หน่วย</th>
                                        <th>Re-Order Point</th>
                                        <th id="action_product">Actions</th>
                                    </tr>
                                </tfoot>-->

                        <tbody>
                            <?php
                            $i= 1;
                            foreach ($dataProvider->getModels() as $record) {
                                echo '<tr>';
                                echo '<td style="display:none" >' . $record->StkName . '</td><td>' . $i . '</td><td>' . $record->StkName . '</td><td>' . $record->ItemID . '</td><td>' . $record->ItemName . '</td><td style="text-align:right">' . number_format($record->ItemQtyBalance, 2) . '</td><td>' . $record->DispUnit . '</td><td style="text-align:right">' . number_format($record->Reorderpoint, 2) . '</td><td style="text-align:right">' . number_format($record->ItemROPDiff, 2) . '</td><td><a class="activity-stockcard-link" href="javascript:selectdetail(' . $record->ItemID . ',' . $record->StkID . ')" ><span class="btn btn-success btn-xs"> Stock Card </span></a></td>';
                                echo '</tr>';
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <script>
                function  selectdetail(itemid, stkid) {
                    $.ajax({
                        url: 'index.php?r=Inventory/dashboard/view-stockcard',
                        type: 'POST',
                        data: {itemid: itemid, stkid: stkid},
                        dataType: 'json',
                        success: function (data) {
                            $('#_result').html(data.html);
                            $('#itemid').html(data.itemid);
                            $('#itemname').html(data.itemname);
                            $('#tpu_sr2_detail_list').modal('show');
                            $('#data_tpu').DataTable({
                                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "pageLength": 10,
                                responsive: true,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": "ค้นหา "
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            });
                        }
                    });
                }
            </script>
            <?php
            Modal::begin([
                'id' => 'tpu_sr2_detail_list',
                'header' => '<h4 class="modal-title">Stock Card</h4>',
                'size' => 'modal-lg modal-primary',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'closeButton' => FALSE,
                'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
            ]);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-8">รหัสสินค้า:  <span id="itemid"></span></label>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >ชื่อสินค้า:  <span id="itemname"></span></label> 
                    </div>
                </div>
            </div>
            <br>
            <div id="_result"></div>
            <?php Modal::end(); ?>
            <?php
            $s = <<< JS
$(document).ready(function() {
  var table = $('#example').DataTable(
   {
     "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
                        "pageLength": 10,
                        responsive: true,
                    "oTableTools": {
                    "aButtons": [
                         "xls",   {
                    "sExtends": "pdf",
                   
                    //"sPdfMessage": "Your custom message would go here.",
      
                },
                    ],
                    "sSwfPath": "assets/swf/copy_csv_xls_pdf.swf"
                },
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            "search": "ค้นหา _INPUT_ "+' <span id="aaa"></span>'
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
                        ]    
   }   
   );

    $("#aaa").each( function ( i ) {
  
        var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo( $(this).empty() )
            .on( 'change', function () {
              table.column( i )
                    .search( $(this).val() )
                    .draw();   
            } );
 
          table.column( i ).data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
    } ); 
  $('#detail_product,#action_product').html('');     
  });
JS;
            $this->registerJs($s);
            ?>
</div>

