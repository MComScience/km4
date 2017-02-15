<?php

use yii\helpers\Html;

$no = 1;

$script = <<< JS
$(document).ready(function () {
        GettbBasesolution();
        GettbDrugAdditive();
        $('#IVItemQty').autoNumeric('init');
    });     
JS;
$this->registerJs($script);
?>

<style>
    table#tbivdetails thead tr th{
        text-align: center;
    }
</style>

<div class="row tableparent">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Base Solution :'); ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-base', 'cpoeid' => $cpoeid, 'vn_number' => $headermodel->pt_vn_number, 'parentid' => $parentid], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote']); ?>
        </h5>

        <div id="detailsBaseSolution"></div>  

        <hr>

        <h5 class="success">
            <b><?= Html::encode('Drug Additive :') ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-additive', 'cpoeid' => $cpoeid, 'vn_number' => $headermodel->pt_vn_number, 'parentid' => $parentid], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote']); ?>
        </h5>

        <div id="detailsDrugAdditive"></div>  


    </div>
</div>
<br/>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="widget flat radius-bordered">
            <!-- Begin Widget Body -->
            <div class="widget-body">
                <div class="widget-main">
                    <div class="tabbable">
                        <div class="tab-content tabs-flat bg-white">
                            <!-- Begin Content -->
                            <div id="home11" class="tab-pane in active">
                                <?=
                                $this->render('_form_details_intruction', [
                                    'model' => $detailmodel,
                                    'cpoeid' => $cpoeid,
                                    'route' => $route,
                                    'adviceid' => $adviceid,
                                ])
                                ?>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
            </div><!-- End Widget Body -->
        </div>
    </div>
</div>

<script>
    function GettbBasesolution() {
        var parent = <?= "'" . $parentid . "'"; ?>;
        LoadingClass();
        $.ajax({
            url: "index.php?r=pharmacy/rxorderip/gettb-basesolution",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
                $('.tableparent').waitMe('hide');
                $('#detailsBaseSolution').html(result.table);
                $('#tbBasesolution').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 100,
                    responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    "bFilter": false,
                    "bSort": false,
                    "aaSorting": [[0]],
                    "info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    function GettbDrugAdditive() {
        var parent = <?= "'" . $parentid . "'"; ?>;
        LoadingClass();
        $.ajax({
            url: "index.php?r=pharmacy/rxorderip/gettb-drugadditive",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
                $('.tableparent').waitMe('hide');
                $('#detailsDrugAdditive').html(result.table);
                $('#tbDrugAdditive').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 100,
                    responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    "bFilter": false,
                    "bSort": false,
                    "aaSorting": [[0]],
                    "info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    function DeleteSubparent(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=pharmacy/rxorderip/delete-details',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    GettbBasesolution();
                                    GettbDrugAdditive();
                                }
                        );
                    }
                });
    }

    $(document).ready(function () {
//        CheckPRN1();
//        DayWeek1();
//        GetItemDetail1();
//        SetDefaultOnce1();
//        CheckFreDay1();
//        CalculateDrugprice1();
        
        var pt_visit_number = $('input[id=tbcpoe-pt_vn_number]').val();
        $('.pt_visit_number').val(pt_visit_number);
        /* ----------------------------- End Function Set Default ------------------------------- */


        $('.itemqty').autoNumeric('init');

    });/* ----------------------------- End document ready ------------------------------- */

    function dateset() {
        var myDate = new Date();
        var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
                (myDate.getFullYear() + 543);
        $("#tbcpoedetail-cpoe_begindate").val(prettyDate);
    }
    /* ตั้งค่า default ปุ่ม Order One Day */
    function DefaultOrdertype() {
        var ordertypeid = $('#tbcpoedetail-cpoe_rxordertype').val();
        if (ordertypeid == '' || ordertypeid == null) {
            $('a[id=orderoneday1]').addClass('active');
            $('#tbcpoedetail-cpoe_rxordertype').val('1');
        }
    }

    function GetRouteSelect(tmtidgpu, routeid, adviceid) {
        $.ajax({
            url: "index.php?r=pharmacy/rxorderip/getroute-select",
            type: "get",
            data: {gpu: tmtidgpu, routeid: routeid},
            dataType: "JSON",
            success: function (data) {
                $('div[id=drugroutename]').html(data.result);//route
                $('div[id=drugrouteadvicename]').html(data.result1);//routeadvice
                $("#cat-id").val(routeid).trigger("change");
                $("#subcat-id").val(adviceid).trigger("change");
            }
        });
    }
    
    function LoadingClass() {
        $('.tableparent').waitMe({
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