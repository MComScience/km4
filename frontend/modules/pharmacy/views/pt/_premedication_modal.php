<?php

use yii\helpers\Html;

$sort = '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="เฉพาะรายการมีสิทธิการรักษา" type="checkbox" /><span class="text"></span> เฉพาะรายการมีสิทธิการรักษา</label>'
        . '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="เฉพาะรายการมีสินค้า" type="checkbox" /><span class="text"></span> เฉพาะรายการมีสินค้า</label>';
?>

<div class="row">
    <div class="col-md-7 col-md-offset-0">
        <div id="simplewizard" class="wizard" data-target="#simplewizard-steps">
            <ul class="steps">
                <li id="simplewizardstep1" data-target="#simplewizardstep1" class="active"><span class="step">1</span><?= Html::encode('เลือกยา'); ?><span class="chevron"></span></li>
                <li id="simplewizardstep2" style="display: none;" data-target="#simplewizardstep2"><span class="step"><div id="numbersteb2"></div></span><?= Html::encode('ระบุข้อกำหนดการใช้ยา'); ?><span class="chevron"></span></li>
                <li id="simplewizardstep3" style="display: none;" data-target="#simplewizardstep3"><span class="step"><div id="numbersteb3"></div></span><?= Html::encode('วิธีการใช้ยา'); ?><span class="chevron"></span></li>
            </ul>
        </div>
    </div>
</div>
<p></p>
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
                            <div id="content1" class="tab-pane in active">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <table class="table table-bordered table-striped table-hover table-condensed" id="tbrxdetails" width="100%">
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
                                                <?php foreach ($druglistop as $recorddrug): ?>
                                                    <tr  id="<?= $recorddrug->ItemID; ?>">
                                                        <td class="text-center"><div id="icon<?= $recorddrug->ItemID . $recorddrug->credit_group_id; ?>" class="icon select"></div></td>
                                                        <td class=" text-center" style="width: 90px;"><?= $recorddrug->ItemID; ?></td>
                                                        <td><?= $recorddrug->Itemdetail ?></td>
                                                        <td class="text-right"><?= empty($recorddrug->ItemQtyAvalible) ? '-' : number_format($recorddrug->ItemQtyAvalible, 2); ?></td>
                                                        <td class="text-center"><?= empty($recorddrug->DispUnit) ? '-' : $recorddrug->DispUnit; ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->ItemPrice) ? '-' : number_format($recorddrug->ItemPrice, 2); ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->Item_Cr_Amt) ? '-' : $recorddrug->Item_Cr_Amt; ?></td>
                                                        <td class="text-right" style="width: 90px;"><?= empty($recorddrug->Item_Pay_Amt) ? '-' : $recorddrug->Item_Pay_Amt; ?></td>
                                                        <td class="text-center">
                                                            <?=
                                                            Html::a('Select', FALSE, [
                                                                'onclick' => 'SelectItemDrug' . '(this)',
                                                                'class' => 'btn btn-xs btn-success',
                                                                'data-toggle' => $recorddrug->credit_group_id,
                                                                'ned' => $recorddrug->NED_required,
                                                                'gp' => $recorddrug->Jor2_required,
                                                                'data-id' => $recorddrug->TMTID_GPU,
                                                                'id' => $recorddrug->ItemID,
                                                                'detail' => $recorddrug->Itemdetail,
                                                                'DispUnit' => $recorddrug->DispUnit,
                                                                'ItemPrice' => $recorddrug->ItemPrice,
                                                            ]);
                                                            ?>
                                                        </td>
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
                            <div id="content2" class="tab-pane">
                                <div class="row">
                                    <?php echo $this->render('_form_ised', ['model' => $drugsetModel, 'isedmodel' => $isedModel,]) ?>
                                </div>
                            </div>
                            <!-- End Content -->

                            <!-- Begin Content -->
                            <div id="content3" class="tab-pane">

                                <?=
                                $this->render('_form_details_premed', [
                                    'model' => $drugsetModel,
                                    'drugsetid' => $drugsetid,
                                    'route' => $route,
                                ]);
                                ?>
                            </div><!-- End Content -->
                        </div>
                    </div>
                </div>
            </div><!-- End Widget Body -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        SetDefaultOnce();
        NED();
        CheckPRN();
        Jor2();
        DayWeek();
        ShowContentOnEdit();
        
        var ids = $('#tbdrugsetdetail-drugset_ids').val();
        if (ids != '') {
            GetItemDetail();
            CalculateDrugprice();
        }

        $('#tbdrugsetdetail-itemqty').autoNumeric('init');

        /* Datatable Config  */
        var table = $('#tbrxdetails').DataTable(
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

        //Set Default Once
        function SetDefaultOnce() {
            var repeat = $('input[id=tbdrugsetdetail-cpoe_repeat]').val();
            if (repeat == '') {
                document.getElementById("Onceradio").checked = true;
                $('input[id=tbdrugsetdetail-cpoe_once]').val('1'); //SetValue
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
                document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = false; //Disabled Reason 
            } else {
                document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = true; //Disabled Reason 
            }
        }
        /* เช็คปุ่ม Next ในแท็บ ระบุเหตุผลการใช้ยา */
        function Jor2() {//ยืนยันการใช้ยาเสพติด
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

        //กรณีแก้ไขรายการ
        function ShowContentOnEdit() {
            var ised = $('input[id=tbdrugsetdetail-ised_reason]').val();//เหตุผลยานอกบัญชีหลักแห่งชาติ
            var ned = $('input[id=tbdrugsetdetail-cpoe_narcotics_confirmed]').val();//ยืนยันการใช้ยาเสพติด
            var itemstatus = $('#tbdrugsetdetail-cpoe_itemstatus').val();
            if (ised == '' && ned != '' && itemstatus != '') {/* กรณีที่มีการระบุเหตุผลการใช้ยา */
                //Steb2 Event
                $('#simplewizardstep2').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
                $("div.isedreason2").css("display", "block");
                $('div[id=numbersteb2]').html('2'); //AddClass Steb
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('3'); //AddClass Steb
                //ShowContent
                $('#content1').removeClass('active');
                $('#content3').addClass('active');
            } else if (ised != '' && ned == '' && itemstatus != '') {
                //Steb2 Event
                $('#simplewizardstep2').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
                $("div.isedreason1").css("display", "block");
                $('div[id=numbersteb2]').html('2'); //AddClass Steb
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('3'); //AddClass Steb
                //ShowContent
                $('#content1').removeClass('active');
                $('#content3').addClass('active');
            } else if (ised != '' && ned != '' && itemstatus != '') {
                //Steb2 Event
                $('#simplewizardstep2').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
                $("div.isedreason1").css("display", "block");
                $("div.isedreason2").css("display", "block");
                $('div[id=numbersteb2]').html('2'); //AddClass Steb
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('3'); //AddClass Steb
                //ShowContent
                $('#content1').removeClass('active');
                $('#content3').addClass('active');
            } else if (itemstatus != '') {
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('2'); //AddClass Steb
                //ShowContent
                $('#content1').removeClass('active');
                $('#content3').addClass('active');
            }
        }

        /* Query ItemDetail ในกรณีแก้ไขรายการ  */
        function GetItemDetail() {
            var id = $('input[id=tbdrugsetdetail-itemid]').val();
            if (id != '') {
                GetDisunit(id);//เรียกใช้ FN 
                $.ajax({
                    url: "index.php?r=pharmacy/pt/selectitem",
                    type: "get",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                        var pt_visit_number = $('input[id=tbpttrpchemo-pt_visit_number]').val();
                        $('#pt_visit_number').val(pt_visit_number);
                        $("input[id=inputroute]").val(result.TMTID_GPU);
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

        /* ดึง Text บน SigCode มาแสดงที่วงรอบการให้ยา*/
        var e = document.getElementById("tbdrugsetdetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip != 'Select Sigcode ...') {
            $('input[id=showsig_code_ip]').val(sig_code_ip);
        }
    });

    /* FN เลือกยา */
    function SelectItemDrug(e) {
        var tmtidgpu = (e.getAttribute("data-id")); //เก็บค่า TMTID_GPU
        var id = (e.getAttribute("id")); //เก็บค่า ItemID
        var ned = (e.getAttribute("ned"));
        var gp = (e.getAttribute("gp"));
        var itemdetail = (e.getAttribute("detail"));
        var DispUnit = (e.getAttribute("DispUnit"));
        var ItemPrice = (e.getAttribute("ItemPrice"));
        var groupid = (e.getAttribute("data-toggle"));
        highlight_row(id, groupid); //highlight 
        //GetDisunit(id);//ดึงหน่วย Item ยา มาแสดงหลังจำนวน
        $.ajax({
            url: "index.php?r=pharmacy/pt/selectitem",
            type: "get",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#form_ised').trigger("reset"); //Reset Form id = form_ised
                $('#form_drugsetdetail').trigger("reset");
                $('.disunitontable').html(DispUnit);
                var pt_visit_number = $('input[id=tbpttrpchemo-pt_visit_number]').val();
                $('#pt_visit_number').val(pt_visit_number);

                CheckISED(ned, gp, itemdetail); //เช็คว่าเป็นยา NED,จ1 หรือ จ2
                GetRouteSelect(tmtidgpu, result.RouteID, result.AdviceID);
                /* set value GPU กับ RouteID*/
                $('#inputroute').val(tmtidgpu);
                $('input[id=inputrouteadvice]').val(result.RouteID);

                $("#tbdrugsetdetail-cpoe_sig_code").val('3').trigger("change");//Set ค่า Default SIG เป็น วันละ 1 ครั้ง
                $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");//Set ค่า Default ระยะเวลาเป็น Day

                //Set Comment
                $('input[id=tbdrugsetdetail-item_comment1]').val(result.comment1);//Set ค่า comment1
                $('input[id=tbdrugsetdetail-item_comment2]').val(result.comment2);//Set ค่า comment2
                $('input[id=tbdrugsetdetail-item_comment3]').val(result.comment3);//Set ค่า comment3

                $('input[id=tbdrugsetdetail-itemprice]').val(ItemPrice);//Set Itemprice ที่ได้จากการเลือก ItemID
                $('input[id=tbdrugsetdetail-itemid]').val(id); //Set ItemID
                $('input[id=tbdrugsetdetail-cpoe_route_id]').val(result.RouteID);//Set ค่า RouteID ที่ได้จากการเลือกตัวยาของแต่ละ ItemID
                $('input[id=tbdrugsetdetail-cpoe_drugprandialadviceid]').val(result.AdviceID);//Set ค่า RouteAdviceID ที่ได้จากการเลือก ItemID

                document.getElementById("Onceradio").checked = true;//Set Default Every day
                $('input[id=tbdrugsetdetail-cpoe_once]').val('1'); //SetValue
                dateset();//Set Default วันเริ่ม
                DefaultOrdertype();
                GetSigcodeDetail();

                if (result.RouteID == '2') {
                    document.getElementById('tbdrugsetdetail-cpoe_iv_driprate').readOnly = true;
                }

            }
        });
    }

    function highlight_row(id, groupid) {
        var table = document.getElementById('tbrxdetails');
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

    function CheckISED(ned, gp, detail) {
        $('#content1').removeClass('active');//ปิดแท็บ table เลือกยา
        $('.itemdetail').html(detail);
        if ((ned == '2' && gp == '2')) {//กรณีที่เป็นทั้งยา NED และยา จ2 หรือ จ1
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลยานอกบัญชีหลักแห่งชาติ
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('#content2').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else if ((ned != '2' && gp == '2')) {//กรณที่ไม่เป็นยา NED แต่เป็นยา จ1 หรือ เป็นยา จ2
            $("div.isedreason1").css("display", "none"); //ไม่แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('#content2').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else if (ned == '2' && gp != '2') {//กรณีที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ จ2
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "none"); //ไม่แสดงการยืนยันการใช้ยาเสพติด
            $('#content2').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block");//Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else {//กรณีที่ไม่เป็นยา NED และไม่เป็นยา จ1 หรือ จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $('#content3').addClass('active');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
            $('div[id=numbersteb3]').html('2'); //AddClass Steb
        }
    }

    /* FN Query หน่วยของแต่ละ ItemID   */
    function GetDisunit(id) {
        $.ajax({
            url: "index.php?r=pharmacy/pt/get-disunit",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('.disunitontable').html(result);
            }
        });
    }

    function GetRouteSelect(tmtidgpu, routeid, adviceid) {
        $.ajax({
            url: "index.php?r=pharmacy/pt/getroute-select",
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

    function GetSigcodeDetail() {
        var e = document.getElementById("tbdrugsetdetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip != 'Select Sigcode ...') {
            $('input[id=showsig_code_ip]').val(sig_code_ip);
        }
    }
</script>