var formatdatexi = $('#tbst2temp-stduedate,#tbgr2temp-poduedate').val();
if (formatdatexi != null) {
    $('#tbst2temp-stduedate,#tbgr2temp-poduedate').datepicker({
        dateFormat: "dd/mm/yy",
        minDate: 0,
        changeYear: true,
        changeMonth: true,
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
}
// var daterangxi = $('#').val();
// if (daterangxi != null) {
//     $('#').datepicker({
//         dateFormat: "dd/mm/yy",
//         changeYear: true,
//         changeMonth: true,
//         dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
//         monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
//         beforeShow: function () {
//             $(this).val('');
//             if ($(this).val() != "") {
//                 var arrayDate = $(this).val().split("/");
//                 arrayDate[2] = parseInt(arrayDate[2]) - 543;
//                 $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
//             }
//             setTimeout(function () {
//                 $.each($(".ui-datepicker-year option"), function (j, k) {
//                     var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
//                     $(".ui-datepicker-year option").eq(j).text(textYear);
//                 });
//             }, 50);
//         },
//         onChangeMonthYear: function () {
//             setTimeout(function () {
//                 $.each($(".ui-datepicker-year option"), function (j, k) {
//                     var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
//                     $(".ui-datepicker-year option").eq(j).text(textYear);
//                 });
//             }, 50);
//         },
//         onClose: function () {
//             if ($(this).val() != "" && $(this).val() == dateBefore) {
//                 var arrayDate = dateBefore.split("/");
//                 arrayDate[2] = parseInt(arrayDate[2]) + 543;
//                 $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
//             }
//         },
//         onSelect: function (dateText, inst) {
//             dateBefore = $(this).val();
//             var arrayDate = dateText.split("/");
//             arrayDate[2] = parseInt(arrayDate[2]) + 543;
//             $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
//         }
//     });
// }


