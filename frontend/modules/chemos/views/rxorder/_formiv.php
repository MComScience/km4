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

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Base Solution :'); ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-base', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote']); ?>
        </h5>

        <div id="detailsBaseSolution"></div>  

        <hr>

        <h5 class="success">
            <b><?= Html::encode('Drug Additive :') ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-additive', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote']); ?>
        </h5>

        <div id="detailsDrugAdditive"></div>  


    </div>
</div>

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
        var parent = <?= "'" . $cpoe_ids . "'"; ?>;
        $.ajax({
            url: "index.php?r=chemo/rxorder/gettb-basesolution",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
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
        var parent = <?= "'" . $cpoe_ids . "'"; ?>;
        $.ajax({
            url: "index.php?r=chemo/rxorder/gettb-drugadditive",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
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
                                'index.php?r=chemo/rxorder/delete-details',
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

    function SaveIVSolutionitem(id) {
        var ItemQty = $('#IVItemQty').val();
        $.post(
                'index.php?r=chemo/rxorder/saveitem-ivsolution',
                {
                    id: id, ItemQty: ItemQty
                },
                function (data)
                {
                    swal({
                        title: "",
                        text: "Save Complete!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $('#solution-modal').modal('hide');
                                    $.pjax({container: '#cpoedetail-pjax'});
                                }
                            });
                }
        );
    }

    $(document).ready(function () {
        CheckPRN();
        DayWeek();
        GetItemDetail();
        SetDefaultOnce();
        CheckFreDay();
        CalculateDrugprice();
        

        /*-------------------------------- Begin Function On Edit ----------------------------------- */
        /* Query ItemDetail ในกรณีแก้ไขรายการ  */
        function GetItemDetail() {
            var id = $('input[id=tbcpoedetail-itemid]').val();
            if (id != '') {
                GetDisunit(id);//เรียกใช้ FN 
                $.ajax({
                    url: "index.php?r=chemos/rxorder/selectitem",
                    type: "get",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                        $('.itemdetail').html(result.itemdetail);
                        $('input[id=routeid_des]').val(result.RouteName);
                        $('input[id=routeadvice_des]').val(result.AdviceName);
                        GetRouteSelect(result.TMTID_GPU, result.RouteID, result.AdviceID);
                        if (result.RouteID == '2') {
                            document.getElementById('tbcpoedetail-cpoe_iv_driprate').readOnly = true;
                        }
                    }
                });
            }
        }

        /* FN ในกรณี Edit #เช็คว่า Frequency หรือ Day ถูกเลือกอยู่ ให้ Disabled ตัวเลือกตรงกันข้าม */
        function CheckFreDay() {
            if ($('input[id=frequencyday]').is(":checked"))
            {
                DisableFrequency();
                RemoveDisabledFrequency();
            }
            if ($('input[id=frequencydayrepeat]').is(":checked"))
            {
                DisabledDayweek();
                RemoveDisabledDayweek();
            }
        }

        /* ----------------------------- End Function On Edit----------------------------------- */

        /* ----------------------------- Begin Function Set Default ------------------------------- */
        //Set Default Once
        function SetDefaultOnce() {
            var repeat = $('input[id=tbcpoedetail-cpoe_repeat]').val();
            if (repeat == '') {
                document.getElementById("Onceradio").checked = true;
                $('input[id=tbcpoedetail-cpoe_once]').val('1'); //SetValue
            }
        }

        /* เช็ค PRN */
        function CheckPRN() {//
            if ($("input[id=inputPRN]").is(':checked')) {
                document.getElementById("tbcpoedetail-cpoe_prn_reason").disabled = false; //Disabled Reason 
            } else {
                document.getElementById("tbcpoedetail-cpoe_prn_reason").disabled = true; //Disabled Reason 
            }
        }

        /* FN Set Value ให้กับ Day  */
        function DayWeek() {
            if ($("input.dayweek").is(':checked')) {
                $('input.dayweek').val('1');
            } else {
                $('input.dayweek').val(null);
            }
        }
        /* ----------------------------- End Function Set Default ------------------------------- */


        $("#tbcpoedetail-itemqty").keyup(function () {
            $('input[id="tbcpoedetail-itemqty"]').priceFormat({prefix: ''});
        });

        /* ดึง Text บน SigCode มาแสดงที่วงรอบการให้ยา*/
        var e = document.getElementById("tbcpoedetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip != 'Select Sigcode ...') {
            $('input[id=showsig_code_ip]').val(sig_code_ip);
        }

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
            url: "index.php?r=chemos/rxorder/getroute-select",
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
</script>