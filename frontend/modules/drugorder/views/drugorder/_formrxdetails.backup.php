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
    <div class="col-md-6 col-md-offset-3">
        <div id="simplewizard" class="wizard" data-target="#simplewizard-steps">
            <ul class="steps">
                <li id="simplewizardstep1" data-target="#simplewizardstep1" class="active"><span class="step">1</span>เลือกรายการยา<span class="chevron"></span></li>
                <li id="simplewizardstep2" data-target="#simplewizardstep2"><span class="step">2</span>ระบุเหตุผลการใช้ยา<span class="chevron"></span></li>
                <li id="simplewizardstep3" data-target="#simplewizardstep3"><span class="step">3</span>วิธีการใช้ยา<span class="chevron"></span></li>
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
                            <li class="active tabhome11">
                                <a data-toggle="tab" href="#home11">
                                    <?= Html::encode('เลือกรายการ'); ?>
                                </a>
                            </li>
                            <li class="tabised" style="display: none;">
                                <a data-toggle="tab" href="#tabised">
                                    <?= Html::encode('ระบุเหตุผลการใช้ยา'); ?>
                                </a>
                            </li>
                            <li class="tabprofile11" style="display: none;">
                                <a data-toggle="tab" href="#profile11">
                                    <?= Html::encode('วิธีการใช้ยา'); ?>
                                </a>
                            </li>
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
                                                        <td class="text-center"><div id="icon<?= $recorddrug->ItemID; ?>" class="icon select"></div></td>
                                                        <td class=" text-center" style="width: 90px;"><?= $recorddrug->ItemID; ?></td>
                                                        <td><?= $recorddrug->Itemdetail ?></td>
                                                        <td class="text-center"><?= empty($recorddrug->ItemQtyAvalible) ? '-' : number_format($recorddrug->ItemQtyAvalible, 2); ?></td>
                                                        <td class="text-center"><?= empty($recorddrug->DispUnit) ? '-' : $recorddrug->DispUnit; ?></td>
                                                        <td class="text-center" style="width: 90px;"><?= empty($recorddrug->ItemPrice) ? '-' : number_format($recorddrug->ItemPrice, 2); ?></td>
                                                        <td class="text-center" style="width: 90px;"><?= empty($recorddrug->Item_Cr_Amt) ? '-' : $recorddrug->Item_Cr_Amt; ?></td>
                                                        <td class="text-center" style="width: 90px;"><?= empty($recorddrug->Item_Pay_Amt) ? '-' : $recorddrug->Item_Pay_Amt; ?></td>
                                                        <td class="text-center"><?= Html::a('Select', FALSE, ['onclick' => 'SelectItemDrug' . '(this)', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-original-title' => 'Select', 'data-placement' => 'top', 'data-id' => $recorddrug->TMTID_GPU, 'id' => $recorddrug->ItemID]); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>                                       
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
            source: function () {
                var result;
                var gpu = $('#inputroute').val();
                $.ajax({
                    type: 'GET',
                    async: false,
                    global: false,
                    url: 'index.php?r=cpoe/drugorder/route-list',
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
            source: function () {
                var result;
                var gpu = $('#inputroute').val();
                var routeid = $('input[id=inputrouteadvice]').val();
                $.ajax({
                    type: 'GET',
                    async: false,
                    global: false,
                    url: 'index.php?r=cpoe/drugorder/routeadvice-list',
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
    //
    $(document).ready(function () {
        NED();
        Jor12();
        CheckPRN();
        DayWeek();
        Editable();
        CheckedItemType();
        CheckNEDAndISED();
        GetItemDetail();
        SetDefaultOnce();
        CheckFreDay();
        //Set Default Once
        function SetDefaultOnce() {
            var repeat = $('input[id=tbcpoedetail-cpoe_repeat]').val();
            if (repeat == '') {
                document.getElementById("Onceradio").checked = true;
                $('input[id=tbcpoedetail-cpoe_once]').val('1'); //SetValue
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
            if (typeid == '1') {
                document.getElementById("cpoetype1").checked = true;
            } else if (typeid == '2') {
                document.getElementById("cpoetype2").checked = true;
            }
        }
        //เช็คกรณีแก้ไขรายการ
        function CheckNEDAndISED() {
            var ised = $('input[id=tbcpoedetail-ised_reason]').val();
            var ned = $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val();
            var period_value = $('input[id=tbcpoedetail-cpoe_period_value]').val();
            if (ised != '' && ised != null && ned != '' && ned != null) {//กรณีที่เป็นทั้ง NED และ จ1,จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason1').css('display', 'block'); //ShowContent
                $('div.isedreason1').css('display', 'block'); //ShowContent
                $('div.isedreason2').css('display', 'block'); //ShowContent

            } else if (ised == '' && ned != '') {//กรณีที่ไม่เป็นยา NED แต่เป็นยา จ1 หรือ จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason2').css('display', 'block'); //ShowContent

            } else if (ised != '' && ned == '') {//กรณีที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ จ2
                $('li.tabised').css('display', 'block'); //ShowTab
                $('div.isedreason1').css('display', 'block'); //ShowContent 
            }
            if (period_value != '') {
                $('li.tabprofile11').css('display', 'block'); //ShowTab
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
        function CheckPRN() {//ยืนยันการใช้ยาเสพติด
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
        /* Query ItemDetail ในกรณีแก้ไขรายการ  */
        function GetItemDetail() {
            var id = $('input[id=tbcpoedetail-itemid]').val();
            var ids = $('input[id=tbcpoedetail-cpoe_ids]').val();
            if (id != '') {
                GetDisunit(id);
                $.ajax({
                    url: "index.php?r=cpoe/drugorder/gettable-onselcetitem",
                    type: "get",
                    data: {id: id, ids: ids},
                    dataType: "JSON",
                    success: function (result) {
                        //$('#table_detailonselect').html(result.table);
                        $('#itemdetail').html(result.itemdetail);
                        $('#textdetails').html(result.itemdetail);
                        //$('#routeid').editable('setValue', null);
                        //$('#routeadviceid').editable('setValue', null);
                        Editable();
                    }
                });
            }
        }
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
                            (isNaN(min) && ItemQtyAvalible < max) ||
                            (Item_Cr_Amt > min && isNaN(max)) ||
                            (Item_Cr_Amt > min && ItemQtyAvalible < max)
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
    });
    /* FN Query หน่วยของแต่ละ ItemID   */
    function GetDisunit(id) {
        $.ajax({
            url: "index.php?r=cpoe/drugorder/get-disunit",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#disunitontable').html(result);
            }
        });
    }

    /* FN เลือกยา */
    function SelectItemDrug(e) {
        var tmtidgpu = (e.getAttribute("data-id")); //เก็บค่า TMTID_GPU
        var id = (e.getAttribute("id")); //เก็บค่า ItemID
        var ids = $('input[id=tbcpoedetail-cpoe_ids]').val();
        highlight_row(id); //highlight 
        GetDisunit(id);
        $.ajax({
            url: "index.php?r=cpoe/drugorder/gettable-onselcetitem",
            type: "get",
            data: {id: id, ids: ids},
            dataType: "JSON",
            success: function (result) {
                CheckISED(result.ned, result.gp, result.itemdetail); //เช็คว่าเป็นยา NED,จ1 หรือ จ2
                $('#form_ised').trigger("reset"); //Reset Form id = form_ised
                $('#table_detailonselect').html(result.table);
                $('#inputroute').val(tmtidgpu);
                $('#routeid').editable('setValue', null);
                $('#routeadviceid').editable('setValue', null);
                //Set Comment
                $('input[id=tbcpoedetail-item_comment1]').val(result.comment1);
                $('input[id=tbcpoedetail-item_comment2]').val(result.comment2);
                $('input[id=tbcpoedetail-item_comment3]').val(result.comment3);
                //Set ItemPrice
                $('input[id=tbcpoedetail-itemprice]').val(result.ItemPrice);
                $('input[id=tbcpoedetail-itemid]').val(id); //Set ItemID
                Editable();
                //$(".tabhome11>a").attr("aria-expanded", "false");
                //$(".tabprofile11>a").attr("aria-expanded", "true");
                //$('#routeid').editable('toggleDisabled');
                //Notify('ไปที่แท็บ "วิธีการใช้ยา!"', 'top-right', '2000', 'success', 'fa-check', true);
            }
        });
    }

    function Editable() {
        $('.myeditable').editable({
            url: 'index.php?r=cpoe/drugorder/update-comment',
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

    function highlight_row(id) {
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
                $('#icon' + id + '.icon').html('<i class="glyphicon glyphicon-ok"></i>');
            }
        }
    }

    function CheckISED(ned, gp, detail) {
        $('ul#myTab12 >li').removeClass('active');
        $('#home11').removeClass('active');
        $('#itemdetail').html(detail);
        if ((ned == '2' && gp == '5') || (ned == '2' && gp == '6')) {//กรณีที่เป็นยา NED และเป็นยา จ1 หรือ เป็นยา NED และ เป็นยา จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $(".tabised").css("display", "block");
            $(".tabprofile11").css("display", "none"); //ปิดแท็บ วิธีการใช้ยา
            $("div.isedreason1").css("display", "block"); //เหตุผลยานอกบัญชีหลักแห่งชาติ
            $("div.isedreason2").css("display", "block"); //ยืนยันการใช้ยาเสพติด
            $('.tabised').addClass('active');
            $('#tabised').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
        } else if ((ned != '2' && gp == '6') || (ned != '2' && gp == '5')) {//กรณที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ เป็นยา NED แต่ไม่เป็นยา จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $(".tabised").css("display", "block");
            $(".tabprofile11").css("display", "none"); //ปิดแท็บ วิธีการใช้ยา
            $("div.isedreason1").css("display", "none"); //Disable
            $("div.isedreason2").css("display", "block"); //ยืนยันการใช้ยาเสพติด
            $('.tabised').addClass('active');
            $('#tabised').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
        } else {//กรณีที่ไม่เป็นยา NED และไม่เป็นยา จ1 หรือ จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $(".tabised").css("display", "none");
            $(".tabprofile11").css("display", "block");
            $('.tabprofile11').addClass('active');
            $('#profile11').addClass('active');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
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

</script>