function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

$(document).ready(function () {
    $("#PRUnitCost").keyup(function () {
        $('input[id="PRUnitCost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#PRUnitCost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#PROrderQty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (uni > 0) {
            uni = uni.toFixed(2);
            $("#PRExtendedCost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#PRExtendedCost").val('0.00');
        }

    });
    $("#PROrderQty").keyup(function () {
        $('input[id="PROrderQty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#PRUnitCost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#PROrderQty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#PRExtendedCost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#PRExtendedCost").val('0.00');
        }
    });
});
var dateBefore = null;
// $('#tbpr-prdate,#tbpr-prexpectdate,#tbpo-podate,#tbpo-poduedate,#tbpr2-prdate,#tbpr2-prexpectdate,#tbpr2temp-prdate,#tbpr2temp-prexpectdate,#tbpo2temp-podate,#tbpo2temp-poduedate,#vwgr2lotassigneddetail-itemexpdate').datepicker({
   $('.form-control hasDatepicker').datepicker({
    dateFormat: "dd/mm/yy",
    // constrainInput: true,
    //showOn: 'button',
    // buttonImageOnly: false,
    changeYear: true,
    changeMonth: true,
    //buttonImage: "asset/webengine/images/icons/b_calendar.png",
    dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
    monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
    beforeShow: function () {
        $(this).val('');
        if ($(this).val() != "") {
            var arrayDate = $(this).val().split("/");
            arrayDate[2] = parseInt(arrayDate[2]) - 543;
            $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
        }
        setTimeout(function () {
            $.each($(".ui-datepicker-year option"), function (j, k) {
                var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                $(".ui-datepicker-year option").eq(j).text(textYear);
            });
        }, 50);
    },
    onChangeMonthYear: function () {
        setTimeout(function () {
            $.each($(".ui-datepicker-year option"), function (j, k) {
                var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                $(".ui-datepicker-year option").eq(j).text(textYear);
            });
        }, 50);
    },
    onClose: function () {
        if ($(this).val() != "" && $(this).val() == dateBefore) {
            var arrayDate = dateBefore.split("/");
            arrayDate[2] = parseInt(arrayDate[2]) + 543;
            $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
        }
    },
    onSelect: function (dateText, inst) {
        dateBefore = $(this).val();
        var arrayDate = dateText.split("/");
        arrayDate[2] = parseInt(arrayDate[2]) + 543;
        $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
    }
});

function dateset() {
    var myDate = new Date();
    var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
            (myDate.getFullYear() + 543);
    $("#tbpr-prdate,#tbpo-podate").val(prettyDate);
}
$(function () {
    if ($("#tbpr-prdate,#tbpo-podate,#tbpr2-prdate,#tbpr2temp-prdate").val() == "") {
        dateset();
        var myDate = new Date();
        var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
                (myDate.getFullYear() + 543);
        $("#tbpr-prdate,#tbpo-podate,#tbpr2-prdate,#tbpr2temp-prdate,#tbpo2temp-podate").val(prettyDate);
    }

});
$(document).ready(function () {
    $('#VwPrgpuapprovedlist').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "aLengthMenu": [
            [5, 15, 20, 100, -1],
            [5, 15, 20, 100, "All"]
        ],
        "paging": false,
        "autoWidth": false,
        "bSort": false,
        "bLengthChange": false,
        //"bJQueryUI" : true,
//        "bPaginate" : false,
//        "sScrollY": "200px",
//        "bAutoWidth": false, // Disable the auto width calculation
        //"bFilter": false,
        "pageLength": 10,
        "oTableTools": {
            "aButtons": [
                "copy", "csv", "xls", "pdf", "print"
            ],
            "sSwfPath": "assets/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
            "search": "",
            "sLengthMenu": "_MENU_",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        //"info": false,
        //"order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#viewpoorder').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "aLengthMenu": [
            [5, 15, 20, 100, -1],
            [5, 15, 20, 100, "All"]
        ],
        "paging": false,
        //"bFilter": false,
        "pageLength": 10,
        //"info": false,
        "order": [[1, 'asc']]
    });
});


//   $(document).ready(function(){
//    $('#btn-delete').click(function(){
//
//       var keys = $('#grid').yiiGridView('getSelectedRows');
//        $.post({
//           url: 'http://localhost/cngrx/web/index.php/ponenciaresumen/asignarevisor', 
//           dataType: 'json',
//           data: {keylist: keys},
//
//        });
//    });
//  });

//   $(document).ready(function(){
//    $("#btn-delete").click(function(){
//    
//
//       var keys = $("#w1").yiiGridView("getSelectedRows");
//        $.ajax({
//                type:"POST",
//                url: "delete-all", // your controller action
//                dataType: "json",
//                data: {keylist: keys},
//                success: alert(keys)
//            });
//    });
//  });
//
