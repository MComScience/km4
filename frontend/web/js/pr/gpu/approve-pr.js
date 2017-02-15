/*Reject Verify*/
$('#btn-reject').click(function (e) {
    $('#modal_reject').modal('show');
});

/*Save Reject Verify*/
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
                'rejected-approve',
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

/*Approve*/
$('.btn-approve').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    swal({
        title: "ยืนยันการอนุมัติใบขอซื้อ?",
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
                            'approve',
                            {
                                PRID: PRID
                            },
                            function (data)
                            {

                            }
                    ).error(function (xhr, status, error) {
                        //swal("Oops...", error, "error");
                    });
                }
            });
});