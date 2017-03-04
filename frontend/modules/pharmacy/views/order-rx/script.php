<?php

use yii\helpers\Html;
use frontend\assets\WaitMeAsset;

WaitMeAsset::register($this);

$search = Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', [])
        . '<label>'
        . Html::input('text', 'เฉพาะรายการมีสิทธิการรักษา', '', ['type' => 'checkbox'])
        . Html::tag('span', 'เฉพาะรายการมีสิทธิการรักษา', ['class' => 'text'])
        . '</label>' . Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', [])
        . '<label>'
        . Html::input('text', 'เฉพาะรายการมีสินค้า', '', ['type' => 'checkbox'])
        . Html::tag('span', 'เฉพาะรายการมีสินค้า', ['class' => 'text'])
        . '</label>';
?>
<?php
$script = <<< JS
    $('#cpoe_comment').keyup(function (e) {
        $('#tbcpoe-cpoe_comment').val($(this).val());
    });
    $(document).ready(function () {
        GetDefaultTable();
        GetFromIsed();
    });
    $('#modal-default-table').on('hidden.bs.modal', function (e) {
        $.fn.dataTable.ext.search.pop();
        ResetContentModal();
        $(".homemed").css("display", "none");
        $("li[id=simplewizardstep2]").css("display", "none");
        $("li[id=simplewizardstep3]").css("display", "none");
    });
    $('#solution-modal').on('hidden.bs.modal', function (e) {
       $('#solution-modal .modal-body').html('<p>Content 2</p>');
       $.pjax({container: '#cpoedetails-pjax'});
       //QueryTabledetails();
    });
    $('#ajaxCrudModal').on('show.bs.modal', function (e) {
        $.fn.dataTable.ext.search.pop();
    });
    $('#modal-default-table').on('show.bs.modal', function (e) {
        DatatablePush();
        DisabledButtonSave();
    });
        
    function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm : true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            setTimeout(function () {
                                swal("Deleted!", "", "success");
                                $.pjax.reload({container: '#cpoedetails-pjax'});
                            }, 0);
                        }
                        );
                    }
                });
    });
    /* PrintSingle */
    $('.btn-printlabel').click(function (e) {
        var ids = $(this).closest('tr').data('key');
        swal({
            title: "Print?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        CheckPrint(ids);
                    }
                });
    });
}
init_click_handlers(); //first run
$('#cpoedetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
        
$('.autosave').click(function (e) {
        var frm = $('#form-header-cpoe');
        $.ajax({
            type: frm.attr('method'),
            url: 'savecpoe-headerauto',
            data: frm.serialize(),
            success: function (data) {

            },
            error: function (xhr, status, error) {
                swal({
                title: error,
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                });
            }
        });
});
JS;
$this->registerJs($script);
?>
<script type="text/javascript">

    function GetDefaultTable() {
        var vn = $('#tbcpoe-pt_vn_number').val();
        $.ajax({
            url: 'get-table-byvn',
            type: 'POST',
            data: {vn: vn},
            dataType: 'json',
            success: function (data) {
                $('#data-default').html(data);
                setTimeout(function () {
                    var table = $('#tbrxdetails').DataTable(
                            {
                                "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
                                "pageLength": 5,
                                "responsive": true,
                                //"bSortable": false,
                                //"ordering": false,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": 'ค้นหา _INPUT_ ' + <?= "'" . $search . "'" ?>,
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            }
                    );
                    $('#tbrxdetails tbody').on('click', 'tr', function () {
                        if ($(this).hasClass('warning')) {
                            $(this).removeClass('warning');
                        } else {
                            table.$('tr.warning').removeClass('warning');
                            $(this).addClass('warning');
                        }
                    });
                    $('#min, #max').keyup(function () {
                        table.draw();
                    });
                    $("input[name=เฉพาะรายการมีสิทธิการรักษา]").click(function () {
                        if ($(this).is(':checked')) {
                            $('#Item_Cr_Amt').val('0');
                            table.draw();
                        } else {
                            $('#Item_Cr_Amt').val('');
                            table.draw();
                        }
                    });
                    $("input[name=เฉพาะรายการมีสินค้า]").click(function () {
                        if ($(this).is(':checked')) {
                            $('#ItemQtyAvalible').val('0');
                            table.draw();
                        } else {
                            $('#ItemQtyAvalible').val('');
                            table.draw();
                        }
                    });
                }, 100);
            }
        });
    }
    function GetFromIsed() {
        $.ajax({
            url: 'get-from-ised',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                $('#from-ised').html(data);
            }
        });
    }

    function DatatablePush() {
        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = parseInt($('#ItemQtyAvalible').val(), 10);
                    var max = parseInt($('#Item_Cr_Amt').val(), 10);
                    var ItemQtyAvalible = parseFloat(data[2].replace(/[,]/g, "")) || 0; // use data for the age column
                    var Item_Cr_Amt = parseFloat(data[5].replace(/[,]/g, "")) || 0;
                    if (
                            (isNaN(min) && isNaN(max)) ||
                            (ItemQtyAvalible > 0 && Item_Cr_Amt > 0)
                            )
                    {
                        return true;
                    }
                    return false;
                }
        );
    }

    function LoadingClass() {
        $('.modal-body').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar,rotation
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#001940', //default #000
            maxSize: '60',
            //source: 'img.svg',
            fontSize: '18px',
            onClose: function () {
            }
        });
    }

    function LoadingClassIV() {
        $('.page-content').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar,rotation
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#001940', //default #000
            maxSize: '60',
            //source: 'img.svg',
            fontSize: '18px',
            onClose: function () {
            }
        });
    }

    /* Premed */
    function CreateByType(e) {
        console.log(e.getAttribute("title-modal"));
        $('#modal-default-table').modal('show');
        var TitleModal = (e.getAttribute("title-modal"));
        $('input[id=seq]').val(e.getAttribute("seq"));
        $('.default-title').html(TitleModal);
        $('#Itemtype').val(e.getAttribute("item-type"));
        if (e.getAttribute("item-type") === '21') {
            $('text[id=numbersteb1]').html('เลือก KVO Solution');
        } else if (e.getAttribute("item-type") === '22') {
            $('text[id=numbersteb1]').html('เลือกยา');
        } else if (e.getAttribute("item-type") === '53') {
            $('text[id=numbersteb1]').html('เลือกยา');
        } else if (e.getAttribute("item-type") === '10') {
            $('input[id=cpoetype10]').prop('checked', true);
            $('text[id=numbersteb1]').html('เลือกยา');
            $(".homemed").css("display", "block");
        } else if (e.getAttribute("item-type") === '40') {
            $('text[id=numbersteb1]').html('เลือก Base Solution');
            $('#textstep3').html('Dispense Qty');
        } else if (e.getAttribute("item-type") === '41') {
            $('text[id=numbersteb1]').html('เลือก Base Solution');
            $('#textstep3').html('Dispense Qty');
        } else if (e.getAttribute("item-type") === '42') {
            $('text[id=numbersteb1]').html('เลือกตัวยา');
            $('#textstep3').html('Dispense Qty');
        } else if (e.getAttribute("item-type") === '51') {
            $('text[id=numbersteb1]').html('เลือก Base Solution');
            $('#textstep3').html('Dispense Qty');
        } else if (e.getAttribute("item-type") === '52') {
            $('text[id=numbersteb1]').html('เลือกตัวยา');
            $('#textstep3').html('Dispense Qty');
        }
    }

    function LoadingEdit() {
        $('.page-content').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar,rotation
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#001940', //default #000
            maxSize: '60',
            //source: 'img.svg',
            fontSize: '18px',
            onClose: function () {
            }
        });
    }

    function EditByType(e) {
        LoadingEdit();
        var ids = e.getAttribute("ids");
        $('.default-title').html(e.getAttribute("title-modal"));
        if (e.getAttribute("item-type") === '21') {
            $('text[id=numbersteb1]').html('เลือก KVO Solution');
        } else if (e.getAttribute("item-type") === '22') {
            $('text[id=numbersteb1]').html('เลือกยา');
        } else if (e.getAttribute("item-type") === '53') {
            $('text[id=numbersteb1]').html('เลือกยา');
        } else if (e.getAttribute("item-type") === '10') {
            $('input[id=cpoetype10]').prop('checked', true);
            $('text[id=numbersteb1]').html('เลือกยา');
            $(".homemed").css("display", "block");
        } else if (e.getAttribute("item-type") === '41') {
            $('text[id=numbersteb1]').html('เลือก Base Solution');
            $('#textstep3').html('Dispense Qty');
        } else if (e.getAttribute("item-type") === '42') {
            $('text[id=numbersteb1]').html('เลือกตัวยา');
            $('#textstep3').html('Dispense Qty');
        }
        $.ajax({
            url: 'edit-by-type',
            type: 'POST',
            data: {ids: ids},
            dataType: 'json',
            success: function (result) {
                $('#from-input').html(result.from); //Query From
                ShowContentEdit(result);
                $('#modal-default-table').modal('show');
                $('.page-content').waitMe('hide');
                if ((e.getAttribute("item-type") !== "41") && (e.getAttribute("item-type") !== "42")) {
                    CalculateQty();
                    console.log(e.getAttribute("item-type"));
                }

            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            }
        });
    }

    function ShowContentEdit(result) {
        $('#content1').removeClass('active');
        $('.ItemName').html(result.ItemDetail);
        var reason = $('#tbcpoedetail-ised_reason').val();
        if ((result.ised_reason !== null) && (parseFloat(result.confirmed) === parseFloat('1'))) {
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2');
            $("div.isedreason1").css("display", "block");
            $("div.isedreason2").css("display", "block");
            $('#ised' + reason).prop('checked', true);
            $('#cpoe_narcotics_confirmed').prop('checked', true);
            document.getElementById("nextstebised").disabled = false;
            //Show Content 3
            $('div[id=numbersteb3]').html('3');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block"); //Show Steb 3
            $('#content3').addClass('active');
        } else if (parseFloat(result.confirmed) === parseFloat('1')) {
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2');
            $("div.isedreason2").css("display", "block");
            $('#cpoe_narcotics_confirmed').prop('checked', true);
            document.getElementById("nextstebised").disabled = false;
            //Show Content 3
            $('div[id=numbersteb3]').html('3');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block"); //Show Steb 3
            $('#content3').addClass('active');
        } else if (result.ised_reason !== null) {
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2');
            $("div.isedreason1").css("display", "block");
            $('#ised' + reason).prop('checked', true);
            document.getElementById("nextstebised").disabled = false;
            //Show Content 3
            $('div[id=numbersteb3]').html('3');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block"); //Show Steb 3
            $('#content3').addClass('active');
        } else {
            $('div[id=numbersteb3]').html('2');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block"); //Show Steb 3
            $('#content3').addClass('active');
        }
    }

    function SelectItemDrug(e) {
        var ItemID = (e.getAttribute("id"));
        var ItemName = (e.getAttribute("detail"));
        var NED = (e.getAttribute("ned"));
        var GP = (e.getAttribute("gp"));
        var ItemType = $('#Itemtype').val();
        var seq = $('input[id=seq]').val();
        LoadingClass();
        $.ajax({
            url: 'details-from',
            type: 'POST',
            data: {ItemID: ItemID, ItemType: ItemType},
            dataType: 'json',
            success: function (data) {
                $('#from-input').html(data); //Query From
                $('.ItemName').html(ItemName);
                CheckNED(NED, GP);
                $('.modal-body').waitMe('hide');
                $('#tbcpoedetail-cpoe_seq2').val(seq);
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.modal-body').waitMe('hide');
            }
        });
    }
    function CheckNED(NED, GP) {
        $('#content1').removeClass('active');
        var ItemType = $('#Itemtype').val();
        console.log(ItemType);
        if ((NED === '2') && (GP === '2') && (ItemType !== "41") && (ItemType !== "42") && (ItemType !== "51") && (ItemType !== "52")) {//กรณีที่เป็นทั้งยา NED และยา จ2 หรือ จ1
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลยานอกบัญชีหลักแห่งชาติ
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
            $('#content2').addClass('active');
        } else if ((NED !== '2') && (GP === '2') && (ItemType !== "41") && (ItemType !== "42") && (ItemType !== "51") && (ItemType !== "52")) {//กรณที่ไม่เป็นยา NED แต่เป็นยา จ1 หรือ เป็นยา จ2
            $("div.isedreason1").css("display", "none"); //ไม่แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "block"); //แสดงการยืนยันการใช้ยาเสพติด
            $('#content2').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else if ((NED === '2') && (GP !== '2') && (ItemType !== "41") && (ItemType !== "42") && (ItemType !== "51") && (ItemType !== "52")) {//กรณีที่เป็นยา NED แต่ไม่เป็นยา จ1 หรือ จ2
            $("div.isedreason1").css("display", "block"); //แสดงเหตุผลการใช้ยานอกบัญชี
            $("div.isedreason2").css("display", "none"); //ไม่แสดงการยืนยันการใช้ยาเสพติด
            $('#content2').addClass('active');
            $('#simplewizardstep2').addClass('active'); //AddClass Steb
            //Steb
            $("li[id=simplewizardstep2]").css("display", "block"); //Show Steb 2
            $('div[id=numbersteb2]').html('2'); //AddClass Steb
        } else {//กรณีที่ไม่เป็นยา NED และไม่เป็นยา จ1 หรือ จ2
            $('#form_ised').trigger("reset"); //Reset Form id = form_ised
            $('#content2').removeClass('active');
            $('div[id=numbersteb3]').html('2');
            $('#simplewizardstep3').addClass('active'); //AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "block"); //Show Steb 3
            $("div.isedreason1").css("display", "none");
            $("div.isedreason2").css("display", "none");
            $('#content3').addClass('active');
            /* ShowButton Save */
            ShowButtonSave();
        }
    }

    function ShowButtonSave() {
        $(".btn-save-back").css("display", "block");
        $(".btn-close").css("display", "none");
    }

    function DisabledButtonSave() {
        $(".btn-save-back").css("display", "none");
        $(".btn-close").css("display", "block");
    }

    function ResetContentModal() {
        GetDefaultTable();
        GetFromIsed();
        $('#form_ised,#form_cpoedetail').trigger("reset");
        $('#content1').addClass('active');
        $('#content2').removeClass('active');
        $('#content3').removeClass('active');
    }

    function CreateIVSolution(e) {
        var type = (e.getAttribute("item-type"));
        var cpoe_id = (e.getAttribute("cpoe_id"));
        $('.modal-title').html(e.getAttribute("title-modal"));
        LoadingClassIV();
        $.ajax({
            url: 'create-iv',
            type: 'GET',
            data: {type: type, cpoe_id: cpoe_id},
            dataType: 'json',
            success: function (result) {
                $('#solution-modal').find('.modal-body').html(result);
                $('#from-iv').html(result);
                $('#solution-modal').modal('show');
                $('.page-content').waitMe('hide');
                SetDatatablesFromIV();
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            }
        });
    }

    function EditIVSolution(id) {
        LoadingClassIV();
        $.ajax({
            url: 'edit-ivsolution',
            type: 'GET',
            data: {id: id},
            dataType: 'json',
            success: function (result) {
                $('#solution-modal').find('.modal-body').html(result);
                $('#from-iv').html(result);
                $('#solution-modal').modal('show');
                $('.page-content').waitMe('hide');
                //SetDatatablesFromIV();
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            }
        });
    }

    function SetDatatablesFromIV() {
        $('#tbBasesolution').DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
            "pageLength": 10,
            responsive: true,
            "bDestroy": true,
            "bAutoWidth": true,
            //"bFilter": false,
            //"bSort": false,
            "aaSorting": [[0]],
            "info": false,
            "language": {
                "lengthMenu": "",
                "infoEmpty": "",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                "search": "ค้นหา : _INPUT_ " + '<a class="btn btn-success" title-modal="Base Solution" item-type="41" onclick="CreateByType(this);"><i class="glyphicon glyphicon-plus"></i>Add</a>'
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ],
        });
        $('#tbDrugAdditive').DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
            "pageLength": 10,
            responsive: true,
            "bDestroy": true,
            "bAutoWidth": true,
            //"bFilter": false,
            //"bSort": false,
            "aaSorting": [[0]],
            //"info": false,
            "language": {
                "lengthMenu": "",
                "infoEmpty": "",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                "search": "ค้นหา : _INPUT_ " + '<a class="btn btn-success" title-modal="Additive" item-type="42" onclick="CreateByType(this);"><i class="glyphicon glyphicon-plus"></i>Add</a>'
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ],
        });
    }

    function QueryTabledetails() {
        var cpoe_id = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            type: 'POST',
            url: 'query-tabledetails',
            data: {cpoe_id: cpoe_id},
            success: function (result) {
                $('#content-tabledetails').html(result);
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    }

    function PrintdetailLabel(ids) {
        swal({
            title: "Print?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        CheckPrint(ids);
                    }
                });
    }

    function CheckPrint(ids) {
        $.post(
                'check-print-label',
                {
                    ids: ids
                },
                function (result)
                {
                    if (result === 'duplicate') {
                        swal({
                            title: "ต้องการสั่งพิมพ์ซ้ำ ?",
                            text: "",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#53a93f",
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            confirmButtonText: "Confirm",
                            showLoaderOnConfirm: true,
                        },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        PrintSingle(ids);
                                    }
                                });
                    } else {
                        PrintSingle(ids);
                    }
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
        });
    }

    function PrintSingle(ids) {
        $.post(
                'print-single-label',
                {
                    ids: ids
                },
                function (result)
                {
                    swal(result, "", "success");
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
        });
    }

    function DeleteCpoeDetails(ids) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-details',
                                {
                                    id: ids
                                },
                                function (data)
                                {
                                    setTimeout(function () {
                                        swal("Deleted!", "", "success");
                                        //QueryTabledetails();
                                    }, 0);
                                }
                        );
                    }
                });
    }

    function SaveDraftCpoe() {
        var frm = $('#form-header-cpoe');
        var l = $('#btn-savedraft-cpoe').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'savedraft-cpoe',
            data: frm.serialize(),
            success: function (data) {
                $('#tbcpoe-cpoe_num').val(data);
                swal({
                    title: "",
                    text: "SaveDraft Completed!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-save-cpoe").disabled = false;
                            }
                        });
            }
        });
    }

    function SaveCpoe() {
        var frm = $('#form-header-cpoe');
        var l = $('#btn-save-cpoe').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'save-cpoe',
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Save Completed!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-print").disabled = false;
                                //location.reload();
                            }
                        });
            }
        });
    }

    function DeleteDetails(ids,cpoeid) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-details',
                                {
                                    id: ids,cpoeid:cpoeid
                                },
                                function (data)
                                {
                                    setTimeout(function () {
                                        swal("Deleted!", "", "success");
                                        $.pjax.reload({container: '#cpoedetails-pjax'});
                                    }, 0);
                                }
                        );
                    }
                });
    }
</script>
