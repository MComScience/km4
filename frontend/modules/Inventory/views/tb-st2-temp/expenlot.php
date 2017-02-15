<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
$style = 'text-align:center;white-space:nowrap;background-color:white';
?>
<div class="tb-pr-temp-view">
    <div class="col-sm-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= Html::encode('Lot Number Detail') ?>   
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive"> 
                    <?php if ($lotnumber != null) :?>
                     <table class="table table-hover table-bordered table-condensed dt-responsive norap" width="100%" id="tabledata" >
                        <thead>
                            <tr role="row">
                            <?= Html::tag('th', Html::encode('Internal Lot Number'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('หมายเลขการผลิต'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('วันหมดอายุ'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('จำนวนแพค'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('หน่วยแพค'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('ราคา/แพค'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('จำนวน'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('หน่วย'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('ราคา/หน่วย'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('เป็นเงิน'), ['style' => $style]) ?>
                            <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lotnumber as $result) : ?>
                                <tr>
                                    <?php 
                                    $edit = Html::a('Edit', false, ['class' => 'btn btn-xs btn-success','ids' => $result['ids'],'ids_sr' =>$result['ids_sr'],'onclick' => 'selectedt(this)']);
                                    $delete = Html::a('Delete', false, ['class' => 'btn btn-xs btn-danger','ids' => $result['ids'],'ids_sr' =>$result['ids_sr'],'onclick' => 'selectdelete(this)']);
                                    ?>
                                    <?= Html::tag('td', $result['ItemInternalLotNum'], ['style' => 'text-align:center;']) ?>
                                    <?= Html::tag('td', $result['ItemExternalLotNum'], ['style' => 'text-align:center;']) ?>
                                    <?= Html::tag('td', $result['ItemExpDate'], ['style' => 'text-align:center;']) ?>
                                    <?= Html::tag('td', $result['STPackQty'] , ['style' => 'text-align:right;']) ?>
                                    <?= Html::tag('td', $result['STPackUnit'], ['style' => 'text-align:center;']) ?>
                                    <?= Html::tag('td', $result['STPackUnitCost'], ['style' => 'text-align:right;']) ?>
                                    <?= Html::tag('td', $result['STItemQty'], ['style' => 'text-align:right;']) ?>
                                    <?= Html::tag('td', $result['DispUnit'], ['style' => 'text-align:center;']) ?>
                                    <?= Html::tag('td', $result['STItemUnitCost'], ['style' => 'text-align:right;']) ?>
                                    <?= Html::tag('td', $result['STExtenedCost'], ['style' => 'text-align:right;']) ?>
                                    <?= Html::tag('td', $edit.' '.$delete, ['style' => 'text-align: center;']) ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else :?>
                         <div class="panel panel-danger">
                                <div class="panel-body">
                                    <div align="center">ไม่มีรายการ</div>
                                </div>
                            </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        function selectedt(e) {
            var ids = (e.getAttribute("ids"));
            var ids_sr = (e.getAttribute("ids_sr"));
            /*$.ajax({
                url: 'edit-detail',
                type: 'GET',
                data: {id: ids, ids_sr: ids_sr},
                dataType: 'json',
                success: function (data) {
                    $('#formdetail2').html(data);
                    $('#editlotselect_').modal('show');
                }
            });*/
            $.get(
                'edit-detail',
                {
                    id: ids, ids_sr: ids_sr
                },
                function (data)
                {
                     $('#formdetail2').html(data);
                    $('#editlotselect_').modal('show');
                }
                );
        }
          function selectdelete(e) {
            var ids = (e.getAttribute("ids"));
            var ids_sr = (e.getAttribute("ids_sr"));
               swal({
          title: "ยืนยันการลบ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
            $.ajax({
                url: 'delete-detail2',
                type: 'GET',
                data: {id: ids, ids_sr: ids_sr},
                success: function (data) {
                  location.reload();
                }
            });
        }
    });
        }
    </script>
   
                <?php
                    Modal::begin([
                        'id' => 'editlotselect_',
                        'header' => '<h4 class="modal-title">แก้ไขข้อมูล</h4>',
                        'size' => 'modal-dialog modal-lg',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => FALSE,
                    ]);
                    ?>
                    <div id="formdetail2"></div>
                    <?php
                    Modal::end();
                ?>
<?php
$script = <<< JS
/*$(document).ready(function() {
   $("#tabledata").DataTable({bFilter: false, bInfo: false,
                    "dom": '<"pull-right"f><"pull-right"l>tip'}
       );
        });*/
JS;
$this->registerJs($script);
?>