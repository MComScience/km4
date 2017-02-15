<?php

use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
 <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>

<div class=" col-md-8">
    <div style="text-align: center"><i class="glyphicon glyphicon-hand-down"></i></div> 
    <?php echo
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
    'showPageSummary' => true,
    'layout' => Yii::$app->componentdate->layoutgridview(),
    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
    'columns' => [
        // [
        //     'class' => 'kartik\grid\SerialColumn',
        //     'contentOptions' => ['class' => 'kartik-sheet-style'],
        //     'width' => '36px',
        //     'header' => '<font color="black">#</font>',
        //     'headerOptions' => ['class' => 'kartik-sheet-style']
        // ],
       [
            'header' => '<font color="black">รหัสสินค้า</font>',
            'attribute' => 'ItemID',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        ],
        //  [
        //     'header' => '<font color="black">Re-Order Point</font>',
        //     'attribute' => 'StkID',
        //     'contentOptions' => 
        //     ['style' => 'display:none'],
        //     'headerOptions' => ['style' => 'display:none'],
        //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
          
        // ],
        [
            'header' => '<font color="black">คลังสินค้า</font>',
            'attribute' => 'StkName',
            'pageSummary' => 'รวม',
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        ],
         [
            'header' => '<font color="black">ยอดคงคลัง</font>',
            'attribute' => 'ItemQtyBalance',
            'pageSummaryOptions' => ['style' => 'text-align:right'],
            'pageSummary' => true,
            'format' => ['decimal', 2],
            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
        ],
         [
            'header' => '<font color="black">หน่วย</font>',
            'attribute' => 'DispUnit',
            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        ],
        //  [
        //     'header' => '<font color="black">Re-Order Point</font>',
        //     'attribute' => 'Reorderpoint',
        //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
        // ],

             [
                        'class' => 'kartik\grid\ActionColumn',
                       'header' => '<font color="black">Stock Card</font>',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => ' {view}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                             'view' => function ($key, $model) {
                        $url = Url::to(['/Inventory/dashboard/view-stock-card2','itemid' => $model['ItemID'],'stkid' => $model['StkID']]);
                    return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span> ', $url, [
                                'title' => 'Stock Card',
                                'data-pjax' => 0,
                    ]);
                },
                                ],
                            ],

]]);
?>
<?php yii\widgets\Pjax::end() ?>
    <?php /*
    if ($data != null) {
        $htl = '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center">
					รหัสสินค้า
				</th>
				<th style="text-align:center">
					คลังสินค้า
				</th>
				<th style="text-align:center" width="11%">
					ยอดคงคลัง
				</th>
                                
				<th style="text-align:center">
					หน่วย
				</th>
                                <th style="text-align:center">
					Re-Order Point
				</th>
                                <th style="text-align:center">
					Stock Card
				</th>
			</tr>
                        </thead>
                        <tbody>';
        $no = 1;
        $cost = 0;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['StkName'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['Reorderpoint'] . '</td>';
            $htl .= '<td style="text-align:center"><a class="btn btn-success btn-xs" href="javascript:selectdetail(' . $result['ItemID'] . ',' . $result['StkID'] . ')">Detail</a></td>';
            $htl .='</tr>';
        }
        echo $htl;
    } else {
        echo '
            <div class="panel panel-danger">
                                    <div class="panel-body">
                                     <div align="center">ไม่มีรายการ</div>
                                    </div>
                                  </div>';
    }
   */ ?>
</div>

<script>
    $(document).ajaxStart(function(){
      $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    }); 
    $('#something').click(function() {
     // $('#tpu_sr2_detail_list').modal('hide');
      //$('.modal-backdrop').hide();
   location.reload();
});
    function  selectdetail(itemid, stkid) {
		window.location.replace("index.php?r=Inventory/dashboard/view-stock-card2&itemid="+itemid+"&stkid="+stkid);
         /*$('.modal-backdrop').hide();
      
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
        });*/
    }
</script>
<?php
Modal::begin([
    'id' => 'tpu_sr2_detail_list',
    'header' => '<h4 class="modal-title">Stock Card</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<a  class="btn btn-default" id="something">Close</a>'
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
<div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px !important"><img src='images/712.gif' width="64" height="64" /><br>Loading..</div>
        <?php
        $script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').children("td:eq(1)").text();
		var stk = $(this).closest('tr').children("td:eq(2)").text();
		//$('#tpu_sr2_detail_list').modal('show');
	
 $.ajax({
                    url: 'index.php?r=Inventory/dashboard/view-stockcard',
                    type: 'POST',
                    data: {itemid: fID, stkid: stk},
                    dataType: 'json',
                    success: function (data) {
                        $('#_result').html(data.html);
                        $('#itemid').html(data.itemid);
                        $('#itemname').html(data.itemname);
                      //  $('#tpu_sr2_detail_list').modal('show');
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
 
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
        $this->registerJs($script);
        ?>


