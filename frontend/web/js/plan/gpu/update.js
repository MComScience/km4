$(document).ready(function () {
    GettableDetails();
});
function GettableDetails() {
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    var type = 'edit';
    LoadingClass();
    $.ajax({
        url: 'gettable-details',
        type: 'POST',
        data: {PCPlanNum: PCPlanNum, type: type},
        dataType: 'json',
        success: function (data) {
            $('#tables-content').html(data);
            SetDatatableDetails();
            $('.page-content').waitMe('hide');
        },
        error: function (xhr, status, error) {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
            $('.page-content').waitMe('hide');
        },
    });
}

function SetDatatableDetails() {
    var t = $("#tabledata").DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "order": [[1, "asc"]],
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": "ค้นหา : _INPUT_ " + '<a href="javascript:GetModalTableGPU(this)" class="btn btn-success ladda-button"  data-style= "expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาสามัญ</a>'
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "columns": [
            {"bSortable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ]
    });
    $('#tabledata tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            t.$('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
        ;
        //var settings = t.context[0];
        var rowData = t.row(this).data();
        //console.log(rowData);
        //alert(JSON.stringify(settings.fnRecordsDisplay()));
        //console.log(t.page.info());
        //console.log(settings.fnDisplayEnd());
        //alert( 'Rows '+t.rows( '.selected' ).count()+' are selected' );
        //console.log($(this).data('key'));
    });
    /*
     $('#tabledata').on("click", 'a.edit', function (e) {
     e.preventDefault();
     
     var nRow = $(this).parents('tr')[0];
     var rowData = t.row(nRow).data();
     //var key = $(this).parents('tr').data('key');
     var UnitCost = (rowData[5]).replace(/[^\d\.]/g, "");
     var aData = t.row(nRow);
     console.log(aData[4]);
     });*/
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}
/* เรียกใช้ Modal เลือกยาสามัญ */
function GetModalTableGPU() {
    SaveHeader();
    var e = document.getElementById("tbpcplan-pcplantypeid");
    var PCPlanTypeID = e.options[e.selectedIndex].text || null;
    if (PCPlanTypeID === '----- ประเภทแผนจัดซื้อ -----') {
        swal("Oops!", "กรุณาเลือกประเภทแผน!", "warning");
    } else if ($("#contenttablegpu").val() !== '') {
        $('#modal-table-gpu').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-table-gpu',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-table-gpu').find('.modal-body').html(data);
                $('#contenttablegpu').html(data);
                $('div#modal-table-gpu .modal-title').html('เลือกยาสามัญ');
                $('.page-content').waitMe('hide');
                $('#modal-table-gpu').modal('show');
                var t = $('#datatable-gpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    "responsive": true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    //"bFilter": true,
                    //"bSort": false,
                    //"aaSorting": [[0]],
                    "language": {
                        "lengthMenu": "_MENU_",
                        "infoEmpty": "No records available",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });

                $('#datatable-gpu tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('warning')) {
                        $(this).removeClass('warning');
                    } else {
                        t.$('tr.warning').removeClass('warning');
                        $(this).addClass('warning');
                    }
                });
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            },
        });
    }
}

function AdditemDetail(TMTID_GPU) {
    LoadingClass();
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    $.ajax({
        url: 'add-itemdetail',
        type: 'GET',
        data: {TMTID_GPU: TMTID_GPU, PCPlanNum: PCPlanNum},
        success: function (result)
        {
            if (result === 'false') {
                swal({
                    title: "",
                    text: "คุณเลือกตัวยาซ้ำ!",
                    type: "warning"
                });
                $('.page-content').waitMe('hide');
            } else {
                $('#formitemdetails').trigger("reset");
                $('#gpu-modal').find('.modal-body').html(result);
                $('#gpu-modal .modal-title').html('บันทึกรายการยาสามัญ แผนจัดซื้อ');
                $('#contentfrom').html(result);
                $('.page-content').waitMe('hide');
                $('#gpu-modal').modal('show');
                $('#tbpcplangpudetail-pcplannum').val(PCPlanNum);
            }
        },
        error: function (xhr, status, error)
        {
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

function EditDetails(ids) {
    LoadingClass();
    $.ajax({
        url: 'edit-detail',
        type: 'GET',
        data: {ids: ids},
        success: function (result)
        {
            $('#formitemdetails').trigger("reset");
            $('#gpu-modal').find('.modal-body').html(result);
            $('#gpu-modal .modal-title').html('แก้ไขรายการยาสามัญ แผนจัดซื้อ');
            $('#contentfrom').html(result);
            $('.page-content').waitMe('hide');
            $('#gpu-modal').modal('show');
        },
        error: function (xhr, status, error)
        {
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

function DeleteDetail(ids) {
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
                    $.get(
                            'delete-detail',
                            {
                                ids: ids
                            },
                            function (data)
                            {
                                GettableDetails();
                                setTimeout(function () {
                                    swal("Deleted!", "", "success");
                                }, 200);
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
}

function SaveHeader() {
    var frm = $('#fromheader');
    $.ajax({
        type: frm.attr('method'),
        url: 'save-fromheader',
        data: frm.serialize(),
        success: function (data) {

        }
    });
}
/* Savedraft */
$('#fromheader').on('beforeSubmit', function (e)
{
    var l = $('.save-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                swal({
                    title: "Save Completed!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                $(".sendtoverify").removeAttr("disabled");
                            }
                        });
            })
            .fail(function (xhr, status, error)
            {
                l.ladda('stop');
                swal("Oops...", error, "error");
                console.log(error);
            });
    return false;
});

$('.sendtoverify').click(function (e) {
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    swal({
        title: "ยืนยันการส่งอนุมัติ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: true,
        confirmButtonText: "Confirm",
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'sendto-verify',
                            {
                                PCPlanNum: PCPlanNum
                            },
                            function (data)
                            {
                                window.location.replace("/km4/plan/default/index");
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
});
$('#tbpcplan-pcplantypeid').on('change', function () {
    var PlanType = $(this).find("option:selected").text() || null;
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    var d = new Date();
    var y = d.getFullYear() + 543;
    if (PlanType === 'แผนการจัดซื้อยาสามัญ ประจำปี') {
        $.ajax({
            url: 'check-planofyear',
            type: 'POST',
            dataType: 'json',
            data: {PlanType: PlanType,PCPlanNum:PCPlanNum},
            success: function (result) {
                if (result === 'oftheyear') {
                    swal("มีแผนประจำปี " + y + " อยู่ในระบบแล้ว!", "", "warning");
                } else {

                }
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
});