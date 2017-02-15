<?php

use yii\helpers\Html;

$script = <<< JS
     
JS;
$this->registerJs($script);
?>
<style>
    table#rxdetails thead tr th{
        background-color: #ddd;
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-0">
        <div id="simplewizard" class="wizard" data-target="#simplewizard-steps">
            <ul class="steps">
                <li id="simplewizardstep1" data-target="#simplewizardstep1" class="active"><span class="step">1</span>เลือกรายการยา<span class="chevron"></span></li>
                <li id="simplewizardstep2" style="display: none;" data-target="#simplewizardstep2"><span class="step"><div id="numbersteb2"></div></span>ระบุเหตุผลการใช้ยา<span class="chevron"></span></li>
                <li id="simplewizardstep3" style="display: none;" data-target="#simplewizardstep3"><span class="step"><div id="numbersteb3"></div></span>วิธีการใช้ยา<span class="chevron"></span></li>
            </ul>
        </div>
    </div>
</div>
<p></p>
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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="row ">
                                            <div class="col-md-3">
                                                <div class="radio text-center" style="background-color: #fbfbfb">
                                                    <?php foreach ($cpoetype as $record): ?>
                                                        <label>
                                                            <input name="cpoetype" type="radio"  value="<?= $record->cpoe_itemtype_id; ?>" id="cpoetype<?= $record->cpoe_itemtype_id; ?>">
                                                            <span class="text"><?= $record->cpoe_itemtype_decs; ?></span>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-xs-8 text-right">

                                            </div>
                                        </div>
                                        <br/>
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="rxdetails" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><?= Html::encode('#'); ?></th>
                                                    <th><?= Html::encode('รหัสสินค้า'); ?></th>
                                                    <th><?= Html::encode('รายการ'); ?></th>
                                                    <th><?= Html::encode('ยอดใช้ได้'); ?></th>
                                                    <th><?= Html::encode('หน่วย'); ?></th>
                                                    <th><?= Html::encode('ราคา/หน่วย'); ?></th>
                                                    <th><?= Html::encode('เบิกได้'); ?></th>
                                                    <th><?= Html::encode('เบิกไม่ได้'); ?></th>
                                                    <th><?= Html::encode('Actions'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($druglist as $recorddrug): ?>
                                                    <tr  id="<?= $recorddrug->ItemID; ?>">
                                                        <td class="text-center"><div id="icon<?= $recorddrug->ItemID . $recorddrug->credit_group_id; ?>" class="icon select"></div></td>
                                                        <td class=" text-center" style="width: 90px;"><?= $recorddrug->ItemID; ?></td>
                                                        <td><?= $recorddrug->Itemdetail ?></td>
                                                        <td class="text-right"><?= empty($recorddrug->ItemQtyAvalible) ? '-' : number_format($recorddrug->ItemQtyAvalible, 2); ?></td>
                                                        <td class="text-center"><?= empty($recorddrug->DispUnit) ? '-' : $recorddrug->DispUnit; ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->ItemPrice) ? '-' : number_format($recorddrug->ItemPrice, 2); ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->Item_Cr_Amt) ? '-' : $recorddrug->Item_Cr_Amt; ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->Item_Pay_Amt) ? '-' : $recorddrug->Item_Pay_Amt; ?></td>
                                                        <td class="text-center"><?= Html::a('Select', FALSE, ['onclick' => 'SelectItemDrug' . '(this)', 'class' => 'btn btn-xs btn-success', 'data-toggle' => $recorddrug->credit_group_id, 'data-original-title' => 'Select', 'data-placement' => 'top', 'data-id' => $recorddrug->TMTID_GPU, 'id' => $recorddrug->ItemID]); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <br/>
                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                        <input type="hidden"  id="ItemQtyAvalible" name="min">
                                        <input type="hidden"  id="Item_Cr_Amt" name="max">
                                    </div>
                                </div>
                            </div>
                            <!-- End Content -->

                            <!-- Begin Content -->
                            <div id="tabised" class="tab-pane">
                                <div class="row">
                                    <?= $this->render('_form_ised', ['model' => $cpoedetail, 'isedreason' => $isedreason]) ?>
                                </div>
                            </div>
                            <!-- End Content -->

                            <!-- Begin Content -->
                            <div id="profile11" class="tab-pane">

                                <?=
                                $this->render('_form_details', [
                                    'model' => $cpoedetail,
                                    'cpoeid' => $cpoeid,
                                    'route' => $route,
                                ])
                                ?>
                            </div><!-- End Content -->
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
<?php
$sort = '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="เฉพาะรายการมีสิทธิการรักษา" type="checkbox" /><span class="text"></span> เฉพาะรายการมีสิทธิการรักษา</label>'
        . '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="เฉพาะรายการมีสินค้า" type="checkbox" /><span class="text"></span> เฉพาะรายการมีสินค้า</label>';
?>
<script>
    $(function () {
        $('#routeid').editable({
            showbuttons: false,
            mode: 'popup',
            emptytext: 'Route...',
            prepend: "not selected",
            source: function () {
                var result;
                var gpu = $('#inputroute').val();
                $.ajax({
                    type: 'GET',
                    async: false,
                    global: false,
                    url: 'index.php?r=cpoes/drugorder/route-list',
                    data: {gpu: gpu},
                    dataType: "json",
                    success: function (data) {
                        result = data;
                    }
                });
                return result;
            },
            success: function (response, newValue) {
                //$('#routeadviceid').editable('toggleDisabled');
                //$(this).parent().siblings('td').children('a.area').data('zona', newValue);
                console.log(response, newValue);
            },
            params: function (params) {
                $('input[id=inputrouteadvice]').val(params.value);
                $('input[id=tbcpoedetail-cpoe_route_id]').val(params.value);
                var data = {};
                data[params.name] = params.value;
                return JSON.stringify(data);
            }
        });
        $('#routeadviceid').editable({
            showbuttons: false,
            mode: 'popup',
            emptytext: 'Route Advice...',
            prepend: "not selected",
            source: function () {
                var result;
                var gpu = $('#inputroute').val();
                var routeid = $('input[id=inputrouteadvice]').val();
                $.ajax({
                    type: 'GET',
                    async: false,
                    global: false,
                    url: 'index.php?r=cpoes/drugorder/routeadvice-list',
                    data: {gpu: gpu, routeid: routeid},
                    dataType: "json",
                    success: function (data) {
                        result = data;
                    }
                });
                return result;
            },
            success: function (response, newValue) {
                $(this).parent().siblings('td').children('a.area').data('zona', newValue);
                console.log(response, newValue);
            },
            params: function (params) {
                $('input[id=tbcpoedetail-cpoe_drugprandialadviceid]').val(params.value);
                var data = {};
                data[params.name] = params.value;
                return JSON.stringify(data);
            }
        });
        //$('#routeadviceid').editable('toggleDisabled');
        // $('#routeid').editable('toggleDisabled');

        function log(settings, response) {
            var s = [], str;
            s.push(settings.type.toUpperCase() + ' url = "' + settings.url + '"');
            for (var a in settings.data) {
                if (settings.data[a] && typeof settings.data[a] === 'object') {
                    str = [];
                    for (var j in settings.data[a]) {
                        str.push(j + ': "' + settings.data[a][j] + '"');
                    }
                    str = '{ ' + str.join(', ') + ' }';
                } else {
                    str = '"' + settings.data[a] + '"';
                }
                s.push(a + ' = ' + str);
            }
            s.push('RESPONSE: status = ' + response.status);
            if (response.responseText) {
                if ($.isArray(response.responseText)) {
                    s.push('[');
                    $.each(response.responseText, function (i, v) {
                        s.push('{value: ' + v.value + ', text: "' + v.text + '"}');
                    });
                    s.push(']');
                } else {
                    s.push($.trim(response.responseText));
                }
            }
            s.push('--------------------------------------\n');
            $('#console').val(s.join('\n') + $('#console').val());
        }

    });
    /* ----------------------------- Begin document ready ------------------------------- */
    $(document).ready(function () {
        NED();
        Jor12();
        CheckPRN();
        DayWeek();
        // Editable();
        CheckedItemType();
        CheckNEDAndISED();
        GetItemDetail();
        SetDefaultOnce();
        CheckFreDay();
        ShowContentOnEdit();
        CalculateDrugprice();
        DefaultOrdertype();

        /*-------------------------------- Begin Function On Edit ----------------------------------- */
        /* Query ItemDetail ในกรณีแก้ไขรายการ  */
        function GetItemDetail() {
            var id = $('input[id=tbcpoedetail-itemid]').val();
            var ids = $('input[id=tbcpoedetail-cpoe_ids]').val();
            if (id != '') {
                GetDisunit(id);//เรียกใช้ FN 
                $.ajax({
                    url: "index.php?r=cpoes/drugorder/gettable-onselcetitem",
                    type: "get",
                    data: {id: id, ids: ids},
                    dataType: "JSON",
                    success: function (result) {
                        //$('#table_detailonselect').html(result.table);
                        $('#itemdetail').html(result.itemdetail);
                        $('text.itemdetail').html(result.itemdetail);
                        $('#textdetails').html(result.itemdetail);
                        $('input[id=routeid_des]').val(result.RouteName);
                        $('input[id=routeadvice_des]').val(result.AdviceName);
                        GetRouteSelect(result.TMTID_GPU, result.RouteID, result.AdviceID);
                        if (result.RouteID == '2') {
                            document.getElementById('tbcpoedetail-cpoe_iv_driprate').readOnly = true;
                        }
                        //$('#routeid').editable('setValue', null);
                        //$('#routeadviceid').editable('setValue', null);
                        //Editable();
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

        //เช็คกรณีแก้ไขรายการ
        function CheckedItemType() {
            var typeid = $('input[id=tbcpoedetail-cpoe_itemtype]').val();
            if (typeid == '10') {
                document.getElementById("cpoetype10").checked = true;
            } else if (typeid == '20') {
                document.getElementById("cpoetype20").checked = true;
            } else {
                document.getElementById("cpoetype10").checked = true;
                $('input[id=tbcpoedetail-cpoe_itemtype]').val('10');
            }
        }
        //เช็คกรณีแก้ไขรายการ
        function CheckNEDAndISED() {
            var ised = $('input[id=tbcpoedetail-ised_reason]').val();//เหตุผลยานอกบัญชีหลักแห่งชาติ
            var ned = $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val();//ยืนยันการใช้ยาเสพติด
            var cpoe_doseqty = $('input[id=tbcpoedetail-cpoe_doseqty]').val();
            if (ised != '' && ised != null && ned != '' && ned != null) {//กรณีที่เป็นทั้ง NED และ จ1,จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason1').css('display', 'block'); //ShowContent
                $('div.isedreason2').css('display', 'block'); //ShowContent

            } else if (ised == '' && ned != '') {//กรณีที่ไม่เป็นยา NED แต่เป็นยา จ1 หรือ จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason2').css('display', 'block'); //ShowContent

            } else if (ised != '' && ned == '') {//กรณีที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason1').css('display', 'block'); //ShowContent 
            }
            if (cpoe_doseqty != '') {
                $('li.tabprofile11').css('display', 'block'); //ShowTab
            }
        }

        //กรณีแก้ไขรายการ
        function ShowContentOnEdit() {
            var cpoe_doseqty = $('input[id=tbcpoedetail-cpoe_doseqty]').val();
            var ised = $('input[id=tbcpoedetail-ised_reason]').val();//เหตุผลยานอกบัญชีหลักแห่งชาติ
            var ned = $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val();//ยืนยันการใช้ยาเสพติด
            if (ised != '' || ned != '' && cpoe_doseqty != '') {/* กรณีที่มีการระบุเหตุผลการใช้ยา */
                //Steb2 Event
                $('#simplewizardstep2').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
                $('div[id=numbersteb2]').html('2'); //AddClass Steb
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('3'); //AddClass Steb
                //ShowContent
                $('#home11').removeClass('active');
                $('#profile11').addClass('active');
            } else if (cpoe_doseqty != '') {
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('2'); //AddClass Steb
                //ShowContent
                $('#home11').removeClass('active');
                $('#profile11').addClass('active');
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
        /* FN Set Value ในกรณีที่เป็นยา NED */
        function NED() {//ยืนยันการใช้ยาเสพติด
            if ($("input[id=cpoe_narcotics_confirmed]").is(':checked')) {
                $('input[id=cpoe_narcotics_confirmed]').val('1'); //Set Value เป็น 1
                document.getElementById("nextstebised").disabled = false; //Disabled ปุ่ม Next 
            } else {
                document.getElementById("nextstebised").disabled = true; //Disabled ปุ่ม Next 
                $('input[id=cpoe_narcotics_confirmed]').val(null); //Set Value เป็น 0
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

        /* เช็คปุ่ม Next ในแท็บ ระบุเหตุผลการใช้ยา */
        function Jor12() {//ยืนยันการใช้ยาเสพติด
            if ($("input[name=isedreason]").is(':checked')) {
                document.getElementById("nextstebised").disabled = false; //Disabled ปุ่ม Next 
            } else {
                document.getElementById("nextstebised").disabled = true; //Disabled ปุ่ม Next 
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

        /* ----------------------------- Begin Datatable ------------------------------- */
        /* Datatable Config  */
        var table = $('#rxdetails').DataTable(
                {
                    "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": " _MENU_ ",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": 'ค้นหา _INPUT_ ' + <?= "'" . $sort . "'" ?>,
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ]
                }
        );
        $('#min, #max').keyup(function () {
            table.draw();
        });
        $("input[id=เฉพาะรายการมีสิทธิการรักษา]").click(function () {
            if ($(this).is(':checked')) {
                $('#Item_Cr_Amt').val('0');
                table.draw();
            } else {
                $('#Item_Cr_Amt').val('');
                table.draw();
            }
        });
        $("input[id=เฉพาะรายการมีสินค้า]").click(function () {
            if ($(this).is(':checked')) {
                $('#ItemQtyAvalible').val('0');
                table.draw();
            } else {
                $('#ItemQtyAvalible').val('');
                table.draw();
            }
        });
        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = parseInt($('#ItemQtyAvalible').val(), 10);
                    var max = parseInt($('#Item_Cr_Amt').val(), 10);
                    var ItemQtyAvalible = parseFloat(data[3].replace(/[,]/g, "")) || 0; // use data for the age column
                    var Item_Cr_Amt = parseFloat(data[6].replace(/[,]/g, "")) || 0;
                    if (
                            (isNaN(min) && isNaN(max)) ||
                            (ItemQtyAvalible > 0 && Item_Cr_Amt > 0)
//                            ||
//                            (min < Item_Cr_Amt && isNaN(max)) ||
//                            (min < Item_Cr_Amt && ItemQtyAvalible < max)
                            )
                    {
                        return true;
                    }
                    return false;
                }
        );
        $("#tbcpoedetail-itemqty").keyup(function () {
            $('input[id="tbcpoedetail-itemqty"]').priceFormat({prefix: ''});
        });
        /* ดึง Text บน SigCode มาแสดงที่วงรอบการให้ยา*/
        var e = document.getElementById("tbcpoedetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip != 'Select Sigcode ...') {
            $('input[id=showsig_code_ip]').val(sig_code_ip);
        }

        /* ----------------------------- End Datatable Funtion ------------------------------- */
        /*
         $("table thead td").each(function (i) {
         var select = $('<select class="form-control"><option value=""></option></select>')
         .appendTo($(this).empty())
         .on('change', function () {
         table.column(i)
         .search($(this).val())
         .draw();
         });
         
         table.column(i).data().unique().sort().each(function (d, j) {
         select.append('<option value="' + d + '">' + d + '</option>')
         });
         });
         
         $('td.search').html('');
         */
    });/* ----------------------------- End document ready ------------------------------- */

    /* FN เลือกยา */
    function SelectItemDrug(e) {
        var tmtidgpu = (e.getAttribute("data-id")); //เก็บค่า TMTID_GPU
        var id = (e.getAttribute("id")); //เก็บค่า ItemID
        var ids = $('input[id=tbcpoedetail-cpoe_ids]').val();
        var groupid = (e.getAttribute("data-toggle"));
        highlight_row(id, groupid); //highlight 
        GetDisunit(id);//ดึงหน่วย Item ยา มาแสดงหลังจำนวน
        $.ajax({
            url: "index.php?r=cpoes/drugorder/gettable-onselcetitem",
            type: "get",
            data: {id: id, ids: ids},
            dataType: "JSON",
            success: function (result) {
                CheckISED(result.ned, result.gp, result.itemdetail); //เช็คว่าเป็นยา NED,จ1 หรือ จ2
                GetRouteSelect(tmtidgpu, result.RouteID, result.AdviceID);
                $('#form_ised').trigger("reset"); //Reset Form id = form_ised
                $('#form_cpoedetail').trigger("reset"); //Reset Form id = form_cpoedetail
                $('#table_detailonselect').html(result.table);
                $('#inputroute').val(tmtidgpu);
                $('input[id=inputrouteadvice]').val(result.RouteID);
                $("#tbcpoedetail-cpoe_sig_code").val('3').trigger("change");//Set ค่า Default SIG เป็น วันละ 1 ครั้ง
                $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");//Set ค่า Default ระยะเวลาเป็น Day
                $('input[id=tbcpoedetail-cpeo_begintime]').val('08:00:00');//Set Default ระยะเวลา
                //$('#routeid').editable('setValue', (result.RouteID));
                //$('#routeadviceid').editable('setValue', (result.AdviceID));
                //Set Comment
                $('input[id=tbcpoedetail-item_comment1]').val(result.comment1);//Set ค่า comment1
                $('input[id=tbcpoedetail-item_comment2]').val(result.comment2);//Set ค่า comment2
                $('input[id=tbcpoedetail-item_comment3]').val(result.comment3);//Set ค่า comment3
                $('input[id=tbcpoedetail-cpoe_doseqty]').val(result.cpoe_doseqty);//Set Default Dose เป็น 1
                //Set ItemPrice
                $('input[id=tbcpoedetail-itemprice]').val(result.ItemPrice);//Set Itemprice ที่ได้จากการเลือก ItemID
                $('input[id=tbcpoedetail-itemid]').val(id); //Set ItemID
                $('input[id=tbcpoedetail-cpoe_route_id]').val(result.RouteID);//Set ค่า RouteID ที่ได้จากการเลือกตัวยาของแต่ละ ItemID
                $('input[id=tbcpoedetail-cpoe_drugprandialadviceid]').val(result.AdviceID);//Set ค่า RouteAdviceID ที่ได้จากการเลือก ItemID
                //
                document.getElementById("Onceradio").checked = true;
                $('input[id=tbcpoedetail-cpoe_once]').val('1'); //SetValue
                dateset();//Set Default วันเริ่ม
                DefaultOrdertype();
                if (result.RouteID == '2') {
                    document.getElementById('tbcpoedetail-cpoe_iv_driprate').readOnly = true;
                }
                //Editable();//เรียกใช้ Edittable
            }
        });
    }
    /* FN Query หน่วยของแต่ละ ItemID   */
    function GetDisunit(id) {
        $.ajax({
            url: "index.php?r=cpoes/drugorder/get-disunit",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#disunitontable').html(result);
                $('#disunitontable1').html(result);
            }
        });
    }

    function GetRouteSelect(tmtidgpu, routeid, adviceid) {
        $.ajax({
            url: "index.php?r=cpoes/drugorder/getroute-select",
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

    function CheckISED(ned, gp, detail) {
        $('ul#myTab12 >li').removeClass('active');
        $('#home11').removeClass('active');
        $('#itemdetail').html(detail);
        $('text.itemdetail').html(detail);
        if ((ned == '2' && gp == '2')) {//กรณีที่เป็นทั้งยา NED และยา จ2 หรือ จ1
            $(".tabised").css("display", "block");//Show Tab NED/Jor2
            $(".tabprofile11").css("display", "none"); //ปิดแท็บ วิธีการใช้ยา
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลยานอกบัญชีหลักแห่งชาติ
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('.tabised').addClass('active');
            $('#tabised').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else if ((ned != '2' && gp == '2')) {//กรณที่ไม่เป็นยา NED แต่เป็นยา จ1 หรือ เป็นยา จ2
            $(".tabised").css("display", "block");//Show Tab NED/Jor2
            $(".tabprofile11").css("display", "none"); //ปิดแท็บ วิธีการใช้ยา
            $("div.isedreason1").css("display", "none"); //ไม่แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('.tabised').addClass('active');
            $('#tabised').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else if (ned == '2' && gp != '2') {//กรณีที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ จ2
            $(".tabised").css("display", "block");//Show Tab NED/Jor2
            $(".tabprofile11").css("display", "none"); //ปิดแท็บ วิธีการใช้ยา
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "none"); //ไม่แสดงการยืนยันการใช้ยาเสพติด
            $('.tabised').addClass('active');
            $('#tabised').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else {//กรณีที่ไม่เป็นยา NED และไม่เป็นยา จ1 หรือ จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $(".tabised").css("display", "none");
            $(".tabprofile11").css("display", "block");
            $('.tabprofile11').addClass('active');
            $('#profile11').addClass('active');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
            $('div[id=numbersteb3]').html('2'); //AddClass Steb
        }
    }

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

    function Editable() {
        $('.myeditable').editable({
            url: 'index.php?r=cpoes/drugorder/update-comment',
            title: 'Edit',
            rows: 3,
            emptytext: '-',
            //type: 'text',
            anim: true,
            cols: 10,
            //mode: 'inline',
            ajaxOptions: {
                dataType: 'json' //assuming json response
            },
            success: function (data, config) {
                var msg = 'Save Completed!';
                $('#msg').addClass('alert-success').removeClass('alert-error').html(msg).show();
                setTimeout(function () {
                    $('#msg').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 5000);
            },
            params: function (params) {
                if (params.name == 'item_comment1') {
                    $('input[id=tbcpoedetail-item_comment1]').val(params.value);
                } else if (params.name == 'item_comment2') {
                    $('input[id=tbcpoedetail-item_comment2]').val(params.value);
                } else if (params.name == 'item_comment3') {
                    $('input[id=tbcpoedetail-item_comment3]').val(params.value);
                }
                var data = {};
                data[params.name] = params.value;
                return JSON.stringify(data);
            }
        });
    }

    function highlight_row(id, groupid) {
        var table = document.getElementById('rxdetails');
        var cells = table.getElementsByTagName('td');
        $('td>div.select').html(''); //Set Icon Select
        for (var i = 0; i < cells.length; i++) {
            // Take each cell
            var cell = cells[i];
            // do something on onclick event for cell
            cell.onclick = function () {
                // Get the row id where the cell exists
                var rowId = this.parentNode.rowIndex;
                var rowsNotSelected = table.getElementsByTagName('tr');
                for (var row = 0; row < rowsNotSelected.length; row++) {
                    rowsNotSelected[row].style.backgroundColor = "";
                    rowsNotSelected[row].classList.remove('selected');
                }
                var rowSelected = table.getElementsByTagName('tr')[rowId];
                rowSelected.style.backgroundColor = "#ffff99";
                rowSelected.className += " selected";
                msg = 'The ID of the company is: ';
                msg += rowSelected.cells[0].innerHTML;
                msg += '\nThe cell value is: ' + this.innerHTML;
                $('#icon' + id + groupid + '.icon').html('<i class="glyphicon glyphicon-ok"></i>');
            }
        }
    }


    /*  เลือกยากลับบ้าน  */
    $("input[id=cpoetype1]").click(function () {
        if ($(this).is(":checked"))//ถ้า Checked 
        {
            $('input[id=tbcpoedetail-cpoe_itemtype]').val($(this).val()); //Set Value ให้กับ Input
        } else {//ถ้าไม่ Checked 
            $('input[id=tbcpoedetail-cpoe_itemtype]').val(null); //Set Value = Null
        }
    });
    /* เลือกยาใช้ในโรงพยาบาล */
    $("input[id=cpoetype2]").click(function () {
        if ($(this).is(":checked"))//ถ้า Checked 
        {
            $('input[id=tbcpoedetail-cpoe_itemtype]').val($(this).val()); //Set Value ให้กับ Input
        } else {//ถ้าไม่ Checked 
            $('input[id=tbcpoedetail-cpoe_itemtype]').val(); //Set Value = Null
        }
    });
    /* กรณีที่คลิกแท็บ เลือกรายการยา */
    $("li.tabhome11").click(function () {
        $('#simplewizardstep2').removeClass('active'); //AddClass Steb
        $('#simplewizardstep3').removeClass('active'); //AddClass Steb
    });
    /* กรณีที่คลิกแท็บ ระบุเหตุผลการใช้ยา */
    $("li.tabised").click(function () {
        $('#simplewizardstep2').addClass('active'); //AddClass Steb
        $('#simplewizardstep3').removeClass('active'); //AddClass Steb
    });
    /* กรณีที่คลิกแท็บ วิธีการใช้ยา */
    $("li.tabprofile11").click(function () {
        $('#simplewizardstep2').addClass('active'); //AddClass Steb
        $('#simplewizardstep3').addClass('active'); //AddClass Steb
    });

    //ปุ่มกลับ
    $("button[id=backsteb2]").click(function () {
        if ($('div.isedreason1').css('display') == 'block' || $('div.isedreason2').css('display') == 'block') {
            //Back to Steb 2
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#profile11').removeClass('active');
            $('#tabised').addClass('active');
        } else {
            //Back to Steb 1
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#profile11').removeClass('active');
            $('#home11').addClass('active');
        }

    });

</script>