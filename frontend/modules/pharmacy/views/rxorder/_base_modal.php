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
                <li id="simplewizardstep1" data-target="#simplewizardstep1" class="active"><span class="step">1</span><?= Html::encode('เลือก Base Solution'); ?><span class="chevron"></span></li>
                <li id="simplewizardstep2" style="display: none;" data-target="#simplewizardstep2"><span class="step"><div id="numbersteb2"></div></span><?= Html::encode('ระบุข้อกำหนดการใช้ยา'); ?><span class="chevron"></span></li>
                <li id="simplewizardstep3" style="display: none;" data-target="#simplewizardstep3"><span class="step"><div id="numbersteb3"></div></span><?= Html::encode('Dispense Qty'); ?><span class="chevron"></span></li>
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
                            <div id="content1" class="tab-pane in active content1">
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
                            <div id="content2" class="tab-pane content2">

                                <?=
                                $this->render('_form_details_base', [
                                    'model' => $detailmodel,
                                    'cpoeid' => $cpoeid,
                                    'route' => $route,
                                    'parentid' => $parentid,
                                    'seq' => $seq,
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
        ShowContentOnEdit();
        
        var ids = $('#tbcpoedetail-cpoe_ids').val();
        if (ids != '') {
            GetItemDetail();
            CalculateDrugprice();
        }

        $('.itemqty').autoNumeric('init');
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

        //กรณีแก้ไขรายการ
        function ShowContentOnEdit() {
            var itemstatus = $('#tbcpoedetail-cpoe_itemstatus').val();
            if (itemstatus == '1') {
                //Steb3 Event
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('2'); //AddClass Steb
                //ShowContent
                $('.content1').removeClass('active');
                $('.content2').addClass('active');
            }
        }

        /* Query ItemDetail ในกรณีแก้ไขรายการ  */
        function GetItemDetail() {
            var id = $('input.ItemID').val();
            if (id != '') {
                GetDisunit(id);//เรียกใช้ FN 
                $.ajax({
                    url: "index.php?r=pharmacy/rxorder/selectitem",
                    type: "get",
                    data: {id: id},
                    dataType: "JSON",
                    success: function (result) {
                        var pt_visit_number = $('input[id=tbcpoe-pt_vn_number]').val();
                        $('#pt_visit_number').val(pt_visit_number);
                        $('.itemdetail').html(result.itemdetail);
                    }
                });
            }
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
            url: "index.php?r=pharmacy/rxorder/selectitem",
            type: "get",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#form_cpoedetail').trigger("reset");

                $('.disunitontable').html(DispUnit);
                var pt_visit_number = $('input[id=tbcpoe-pt_vn_number]').val();
                $('#pt_visit_number').val(pt_visit_number);

                //Set Comment
                $('input[id=tbcpoedetail-item_comment1]').val(result.comment1);//Set ค่า comment1
                $('input[id=tbcpoedetail-item_comment2]').val(result.comment2);//Set ค่า comment2
                $('input[id=tbcpoedetail-item_comment3]').val(result.comment3);//Set ค่า comment3

                $('input[id=tbcpoedetail-itemprice]').val(ItemPrice);//Set Itemprice ที่ได้จากการเลือก ItemID
                $('input.ItemID').val(id); //Set ItemID
                $('input[id=tbcpoedetail-cpoe_route_id]').val(result.RouteID);//Set ค่า RouteID ที่ได้จากการเลือกตัวยาของแต่ละ ItemID
                $('input[id=tbcpoedetail-cpoe_drugprandialadviceid]').val(result.AdviceID);//Set ค่า RouteAdviceID ที่ได้จากการเลือก ItemID

                $('input[id=tbcpoedetail-cpoe_once]').val('1'); //SetValue

                $('.itemdetail').html(result.itemdetail);
                $('.content1').removeClass('active');//ปิดแท็บ table เลือกยา
                $('.content2').addClass('active');
                $('#simplewizardstep3').addClass('active'); //AddClass Steb
                $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
                $('div[id=numbersteb3]').html('2'); //AddClass Steb

            }
        });
    }

    /* FN Query หน่วยของแต่ละ ItemID   */
    function GetDisunit(id) {
        $.ajax({
            url: "index.php?r=pharmacy/rxorder/get-disunit",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('.disunitontable').html(result);
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
</script>