$(document).ready(function () {
    $(".modal-reject").on('show.bs.modal', function () {
        setTimeout(function () {
        }, 0);
    });
});
function init_click_handlers() {
//Edit Verify
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-verify',
                {
                    id: fID
                },
                function (data)
                {
                    $('#formitemdetails').trigger("reset");
                    $('#nd-modal').find('.modal-body').html(data);
                    $('#data').html(data);
                    $('div#nd-modal .modal-title').html('ปรับปรุงรายการเวชภัณฑ์ ทวนสอบใบขอซื้อ');
                    $('.page-content').waitMe('hide');
                    $('#nd-modal').modal('show');
                }
        ).fail(function (xhr, status, error) {
            $('.page-content').waitMe('hide');
            swal("Oops...", error, "error");
        });
    });

    //OK Verify
    $('.activity-ok-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "Are you sure ok verify",
            text: "ตกลงตามยอดขอซื้อ",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'ok-verify',
                                {
                                    id: fID
                                },
                                function (result) {
                                    $.pjax.reload({container: '#verify_nd_pjax'});
                                    swal(result, "", "success");
                                }
                        ).fail(function (xhr, status, error) {
                            swal("Oops...", error, "error");
                        });
                    }
                });
    });

    //Cancel
    $('.btn-cancel').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "Are you sure Cancel?",
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
                                'cancel-verify',
                                {
                                    id: fID
                                },
                                function (result) {
                                    $.pjax.reload({container: '#verify_nd_pjax'});
                                }
                        ).fail(function (xhr, status, error) {
                            swal("Oops...", error, "error");
                        });
                    }
                });
    });
}

init_click_handlers(); //first run
$('#verify_nd_pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

/*Reject Verify*/
$('#btn-reject').click(function (e) {
    $('#modal_reject').modal('show');
});

//Save Reject Verify
$('#SaveRejectVerify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRRejectReason = $("#PRRejectReason").val();
    var PRNum = $("#tbpr2-prnum").val();
    var l = $('.btn-reject').ladda();
    l.ladda('start');
    if (PRRejectReason == "") {
        swal({
            title: "",
            text: "กรุณากรอกเหตุผล!",
            type: "warning",
            showCancelButton: false,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        l.ladda('stop');
                    }
                });
    } else {
        $.post(
                'rejected-verify',
                {
                    PRID: PRID, PRRejectReason: PRRejectReason, PRNum: PRNum
                },
                function (data)
                {

                }
        ).fail(function (xhr, status, error) {
            // swal("Oops...", error, "error");
            l.ladda('stop');
        });
    }
});
/* Savedraft */
$('#form-verify').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                swal({
                    title: "SaveDraft Completed!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-approve").disabled = false;
                                /*location.reload*/
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

/*AutoApprove*/
$('.auto-approve').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    swal({
        title: "Verify & Auto Approve?",
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
                            'verify-approve',
                            {
                                PRID: PRID
                            },
                            function (result) {
                                if (result != 'Pass') {
                                    swal({
                                        title: "ยืนยัน?",
                                        text: '<span style="color:#F8BB86">' + result + '</span>',
                                        type: "warning",
                                        showCancelButton: true,
                                        closeOnConfirm: true,
                                        closeOnCancel: true,
                                        confirmButtonText: "Confirm",
                                        html: true,
                                        showLoaderOnConfirm: true,
                                    },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    $.post(
                                                            'auto-approve',
                                                            {
                                                                PRID: PRID
                                                            },
                                                            function (result) {

                                                                //$.pjax.reload({container: '#verify_pjax_id'});
                                                            }
                                                    ).fail(function (xhr, status, error) {
                                                        //swal("Oops...", error, "error");
                                                    });
                                                }
                                            });
                                } else {
                                    $.post(
                                            'auto-approve',
                                            {
                                                PRID: PRID
                                            },
                                            function (result) {

                                            }
                                    ).fail(function (xhr, status, error) {
                                        //swal("Oops...", error, "error");
                                    });
                                }
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
});