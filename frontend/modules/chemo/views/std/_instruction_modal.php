<?php

use yii\helpers\Html;

$script = <<< JS
     
JS;
$this->registerJs($script);
?>
<!-- Begin Row -->
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="widget flat radius-bordered">
            <!-- Begin Widget Body -->
            <div class="widget-body">
                <div class="widget-main">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat" id="myTab12">
                        </ul>
                        <div class="tab-content tabs-flat bg-white">
                            <!-- Begin Content -->
                            <div id="home11" class="tab-pane in active">
                                <?=
                                $this->render('_form_details_intruction', [
                                    'model' => $drugsetmodel,
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
    <div class="col-lg-6 col-sm-6 col-xs-12">
    </div>
</div>
<!-- End Row -->
<script>
    /* ----------------------------- Begin document ready ------------------------------- */
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
            var id = $('input[id=tbdrugsetdetail-itemid]').val();
            if (id != '') {
                GetDisunit(id);//เรียกใช้ FN 
                $.ajax({
                    url: "index.php?r=chemo/std/selectitem",
                    type: "get",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                        $('.itemdetail').html(result.itemdetail);
                        $('input[id=routeid_des]').val(result.RouteName);
                        $('input[id=routeadvice_des]').val(result.AdviceName);
                        GetRouteSelect(result.TMTID_GPU, result.RouteID, result.AdviceID);
                        if (result.RouteID == '2') {
                            document.getElementById('tbdrugsetdetail-cpoe_iv_driprate').readOnly = true;
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
            var repeat = $('input[id=tbdrugsetdetail-cpoe_repeat]').val();
            if (repeat == '') {
                document.getElementById("Onceradio").checked = true;
                $('input[id=tbdrugsetdetail-cpoe_once]').val('1'); //SetValue
            }
        }

        /* เช็ค PRN */
        function CheckPRN() {//
            if ($("input[id=inputPRN]").is(':checked')) {
                document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = false; //Disabled Reason 
            } else {
                document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = true; //Disabled Reason 
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
            $('input[id="tbdrugsetdetail-itemqty"]').priceFormat({prefix: ''});
        });
        
        /* ดึง Text บน SigCode มาแสดงที่วงรอบการให้ยา*/
        var e = document.getElementById("tbdrugsetdetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip != 'Select Sigcode ...') {
            $('input[id=showsig_code_ip]').val(sig_code_ip);
        }

    });/* ----------------------------- End document ready ------------------------------- */

    function dateset() {
        var myDate = new Date();
        var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
                (myDate.getFullYear() + 543);
        $("#tbdrugsetdetail-cpoe_begindate").val(prettyDate);
    }
    /* ตั้งค่า default ปุ่ม Order One Day */
    function DefaultOrdertype() {
        var ordertypeid = $('#tbdrugsetdetail-cpoe_rxordertype').val();
        if (ordertypeid == '' || ordertypeid == null) {
            $('a[id=orderoneday1]').addClass('active');
            $('#tbdrugsetdetail-cpoe_rxordertype').val('1');
        }
    }
    
    function GetRouteSelect(tmtidgpu, routeid, adviceid) {
        $.ajax({
            url: "index.php?r=chemo/std/getroute-select",
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