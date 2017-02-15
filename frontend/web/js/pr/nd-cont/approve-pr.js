$(function () {
    SelectVendorName();
});
function SelectVendorName() {
    var e = document.getElementById("tbpr2-pocontactnum");
    var id = e.options[e.selectedIndex].value;
    if (id !== "") {
        $.ajax({
            url: "get-vendorid",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (result) {
                $("#tbpr2-vendorname").val(result).trigger("change");
            }
        });
    } else {
        $("#tbpr2-vendorname").val(null).trigger("change");
    }
}
/*Reject Approve*/
$('#btn-reject').click(function (e) {
    $('#modal_reject').modal('show');
});


/*Save Reject Approve*/
$('#SaveRejectVerify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRRejectReason = $("#PRRejectReason").val();
    var PRNum = $("#tbpr2-prnum").val();
    var l = $('.btn-reject').ladda();
    l.ladda('start');
    if (PRRejectReason === "") {
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

