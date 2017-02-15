//$("#prtypeids,#pcplantypeid,#prstatusids,#departmentIds,#sectionid,#potypeids,#pcplanstatusid").select2();
var message_confirmdelete = 'ยืนยันการลบ ?';
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

$(function () {
    //ค้นหาประเภทแผนpcให้บันทึกปีงบประมาณละครั้ง
    $("#tbpcplan-pcplantypeid").change(function () {
        if ($("#tbpcplan-pcplantypeid").val() == "1") {
            var prnums = $("#inputEmail3").val();
            $.ajax({
                url: "index.php?r=Purchasing/tbpcplan/checkpcplan",
                type: "post",
                data: {prnums: prnums},
                dataType: 'json',
                success: function (result) {
//                    alert(result.status);
                    if (result.status == '0') {
                        swal("", "มีรายการแล้วสามารถบันทึกได้รายงานเดียวต่อปีงบประมาณเท่านั้น", "warning");
                        $("#tbpcplan-pcplantypeid").val('').trigger("change");
                    }
                }
            });
        }
        else if ($("#tbpcplan-pcplantypeid").val() == "3") {

            var prnums = $("#inputEmail13").val();
            $.ajax({
                url: "index.php?r=Purchasing/tbplan/checkpcplan",
                type: "post",
                data: {prnums: prnums},
                dataType: 'json',
                success: function (result) {
//                    alert(result.status);
                    if (result.status == '0') {
                        swal("", "มีรายการแล้วสามารถบันทึกได้รายงานเดียวต่อปีงบประมาณเท่านั้น", "warning");
                        $("#tbpcplan-pcplantypeid").val('').trigger("change");

                    }
                }
            });
        }else if ($("#tbpcplan-pcplantypeid").val() == "7") {

            var prnums = $("#inputEmail13").val();
            $.ajax({
                url: "index.php?r=Purchasing/tbplandrug/checkpcplan",
                type: "post",
                data: {prnums: prnums},
                dataType: 'json',
                success: function (result) {
//                    alert(result.status);
                    if (result.status == '0') {
                        swal("", "มีรายการแล้วสามารถบันทึกได้รายงานเดียวต่อปีงบประมาณเท่านั้น", "warning");
                        $("#tbpcplan-pcplantypeid").val('').trigger("change");

                    }
                }
            });
        }
    });
    //ค้นหาประเภทแผนplandrugให้บันทึกปีงบประมาณละครั้ง
    $("#tbpcplan-pcplantypeid2").change(function () {
        if ($("#tbpcplan-pcplantypeid2").val() == "7") {
            var prnums = $("#inputEmail13").val();
            $.ajax({
                url: "index.php?r=Purchasing/tbplandrug/checkpcplan",
                type: "post",
                data: {prnums: prnums},
                dataType: 'json',
                success: function (result) {
                    if (result.status == '0') {
                        swal("", "มีรายการแล้วสามารถบันทึกได้รายงานเดียวต่อปีงบประมาณเท่านั้น", "warning");
                        $("#tbpcplan-pcplantypeid").val('').trigger("change");
                        $('#plancssid').removeAttr('class');
                        $('#plancssid').show();
                    }
                }
            });
        } else {
            $('#plancssid').hide();
        }
    });
    //บวกเลขแผนจัดชื้อยาสามัญ
    $("#gpuorderqty").keyup(function () {
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
        sum1 = sum1 * sum2;
        sum1 = sum1.toFixed(2);
        $('#gpuextended').val(addCommas(sum1));

    });
    $("#gpuunitCost").keyup(function () {
        $('input[id="gpuunitCost"]').priceFormat({prefix: ''});
        //**************************************ค่าเสียหาย***************************** 
        var sum1 = 0;
        var sum2 = 0;
        if ($('input[id="gpuunitCost"]').val() != '') {

            sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
            sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
            sum1 = sum1 * sum2;
            if (sum1 > 0) {
                var num = parseFloat(sum1);
                sum1 = num.toFixed(2);
                $('#gpuextended').val(addCommas(sum1));
            } else {
                $('#gpuextended').val('0.00');
            }
        }
    });
    //บวกเลขแผนจัดชื้อยาสามัญ
    $("#gpuorderqty").keyup(function () {
        $('input[id="gpuorderqty"]').priceFormat({prefix: ''});
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#gpuextended').val(addCommas(sum1));

    });
    $("#gpuunitCost").keyup(function () {
        $('input[id="gpuunitCost"]').priceFormat({prefix: ''});
        //**************************************ค่าเสียหาย***************************** 
        var sum1 = 0;
        var sum2 = 0;
        if ($('input[id="gpuunitCost"]').val() != '') {

            sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
            sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
            sum1 = sum2 * sum1;
            if (sum1 > 0) {
                var num = parseFloat(sum1);
                sum1 = num.toFixed(2);
                $('#gpuextended').val(addCommas(sum1));
            } else {
                $('#gpuextended').val('0.00');
            }
        }
    });
    //บวกเลขแผนจัดชื้อเวชภัณฑ์
    $("#NonDrugUnitCost").keyup(function () {
        $('input[id="NonDrugUnitCost"]').priceFormat({prefix: ''});
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="NonDrugUnitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="NonDrugOrderQty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#NonDrugExtendedCost').val(addCommas(sum1));

    });
    $("#NonDrugOrderQty").keyup(function () {
        $('input[id="NonDrugOrderQty"]').priceFormat({prefix: ''});
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="NonDrugUnitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="NonDrugOrderQty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#NonDrugExtendedCost').val(addCommas(sum1));

    });
});
$(document).ready(function () {

    $('#prtable').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 5,
        responsive: true,
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": "ค้นหา "
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "ajax": {
            "url": "index.php?r=Purchasing/tbpr/datapcplanbydrug",
            "type": "GET"
        },
    });
    $('#prtbss').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 5,
        "ajax": {
            "url": "index.php?=Purchasing/tbpr/dataverify",
            "type": "GET"
        },
    });
    $('#prtbsss').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 5,
        "ajax": {
            "url": "index.php?=Purchasing/tbpr/datap",
            "type": "GET"
        },
    });
   /* $('#pcplandrugtable').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 5,
        "ajax": {
            "url": "index.php?r=Purchasing/tbplandrug/datapcplandrug",
            "type": "GET"
        }
    });*/
//       $('#testt').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        "ajax": {
//            "url": "/km4/backend/web/index.php?r=Purchasing/tbpr/readdata",
//            "type": "POST"
//        }
//    });
});
var dateBefore = null;
function dateset() {
    var myDate = new Date();
    var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
            (myDate.getFullYear() + 543);
	$("#tbst2temp-stdate,#tbpr-prdate,#tbpr-prexpectdate,#effectivedate").val(prettyDate);
   // $("#tbst2temp-stdate,#tbpcplan-pcplandate,#tbpcplan-pcplanenddate,#tbpr-prdate,#tbpr-prexpectdate,#effectivedate").val(prettyDate);
}
$(function () {
    if ($("#tbpcplan-pcplanbegindate").val() == "") {
        dateset();
        var myDate = new Date();
        $("#tbpcplan-pcplanbegindate").val('1/10/' + (myDate.getFullYear() + 542));
        $("#tbpcplan-pcplanenddate").val('1/09/' + (myDate.getFullYear() + 543));
    }
    if ($("#tbpcplan2-pcplanbegindate").val() == "") {
        var myDate = new Date();
        var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
                (myDate.getFullYear() + 543);
        $("#tbst2temp-stdate,#tbpcplan2-pcplandate,#tbpcplan2-pcplanenddate,#tbpr-prdate,#tbpr-prexpectdate,#effectivedate").val(prettyDate);

        var myDate = new Date();
        $("#tbpcplan2-pcplanbegindate").val('1/10/' + (myDate.getFullYear() + 542));
        $("#tbpcplan2-pcplanenddate").val('1/09/' + (myDate.getFullYear() + 543));
    }

});
//$("#tbpcplan-pcplandate").datepicker();

//$(function () {//view tbpr _ form แผนจัดชื้อยา PrUnitCost * PROrderQty = PRExtendedCost
//    $("#prunitcost").keyup(function () {
//        var uni = $("#prunitcost").val();
//        var orq = $("#prorderqty").val();
//        var jj = uni * orq;
//        $("#prextendedcost").val(jj);
//    });
//    $("#prorderqty").keyup(function () {
//        var uni = $("#prorderqty").val();
//        var orq = $("#prunitcost").val();
//        var jj = uni * orq;
//        $("#prextendedcost").val(jj);
//    });
//});
//$(function () {//view tbpr _ form แผนจัดชื้อยา ปริมาณตามแผน - ปริมาณขอชื้อแล้ว = ปริมาณที่ชื้อได้ตามแผน
//    $("#pcgpuqty").keyup(function () {
//        var uni = $("#pcgpuqty").val();
//        var orq = $("#sumprgp").val();
//        var jj = uni - orq;
//        $("#pcgpuavalible").val(jj);
//    });
//    $("#sumprgp").keyup(function () {
//        var uni = $("#pcgpuqty").val();
//        var orq = $("#sumprgp").val();
//        var jj = uni - orq;
//        $("#pcgpuavalible").val(jj);
//    });
//});
//$(function () {//view tbpr _ form แผนจัดชื้อยา ปริมาณตามแผน - ปริมาณขอชื้อแล้ว = ปริมาณที่ชื้อได้ตามแผน
//    $("#PRVerifyUnitCost").keyup(function () {
//        var uni = $("#PRVerifyUnitCost").val();
//        var orq = $("#PRVerifyQty").val();
//        var jj = uni * orq;
//        $("#prextendedcost").val(jj);
//    });
//    $("#PRVerifyQty").keyup(function () {
//        var uni = $("#PRVerifyUnitCost").val();
//        var orq = $("#PRVerifyQty").val();
//        var jj = uni * orq;
//        $("#prextendedcost").val(jj);
//    });
//});
$(document).ready(function () {
   /* table = $('#tablenondrugs').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging":   false,
        //"ordering": false,
        //"bFilter": false,
        "ajax": {
            "url": "index.php?r=Purchasing/tbplan/data1",
            "type": "GET",
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [-1], //last column
                "orderable": false, //set not orderable

            },
        ],
        "pageLength": 10,
    });*/
});
//$(function () {
//    $("#NonDrugUnitCost").keyup(function () {
//        var uni = parseFloat($("#NonDrugUnitCost").val());
//        //uni = uni.replace(',','');
//        // uni = uni.replace('.','');
//        var orq = parseFloat($("#NonDrugOrderQty").val());
//        // orq = orq.replace(',','');
//        // orq = orq.replace('.','');
//        var jj = uni * orq;
//        $("#NonDrugExtendedCost").val(jj);
//    });
//    $("#NonDrugOrderQty").keyup(function () {
//        var uni = parseFloat($("#NonDrugUnitCost").val());
//        var orq = parseFloat($("#NonDrugOrderQty").val());
//        var jj = uni * orq;
//        $("#NonDrugExtendedCost").val(jj);
//    });
//});
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
         swal("","กรุณากรอกตัวเลข", "warning");
        return false;
    } else {


        return true;
    }

}

function chkNum(ele)
{
    var num = parseFloat(ele.value);
    ele.value = addCommas(num.toFixed(2));
}
function rem() {
    var element = document.getElementById('tbpcplan-pcplantypeid');
    element.value = "";
}
/*$('#tbpcplan-pcplantypeid').on("change", function (e) {
 var uri;
 switch ($("#types").val()) {
 case 'pcplan':
 uri = "index.php?r=Purchasing/tbpcplan/findsave";
 break;
 case 'plan':
 uri = "index.php?r=Purchasing/tbplan/findsave";
 break;
 case 'plandrug':
 uri = "index.php?r=Purchasing/tbplandrug/findsave";
 break;
 }
 if ($("#tbpcplan-pcplantypeid").val() == 1 || $("#tbpcplan-pcplantypeid").val() == 2) {
 $.ajax({
 url: uri,
 //type: "post",
 // data: {id: a},
 // dataType: 'json',
 success: function (r) {
 if (r == 0) {
 alert("มีรายการบันทึกแล้วกรุณาไปแก้ไขข้อมูล");
 rem();
 }
 }
 });
 }
 });*/
/*$('#PCPlanTypeID').on("change", function (e) {
 if ($("#PCPlanTypeID").val() == 1) {
 $.ajax({
 url: "index.php?r=Purchasing/tbplandrug/findsave",
 //type: "post",
 // data: {id: a},
 // dataType: 'json',
 success: function (r) {
 if (r == 1) {
 alert("มีรายการบันทึกแล้วกรุณาไปแก้ไขข้อมูล");
 var element = document.getElementById('PCPlanTypeID');
 element.value = "";
 }
 }
 });
 }
 });
 $('#PCPlanTypeID_plan').on("change", function (e) {
 if ($("#PCPlanTypeID_plan").val() == 2) {
 $.ajax({
 url: "index.php?r=Purchasing/tbplan/findsave",
 //type: "post",
 // data: {id: a},
 // dataType: 'json',
 success: function (r) {
 if (r == 1) {
 alert("มีรายการบันทึกแล้วกรุณาไปแก้ไขข้อมูล");
 var element = document.getElementById('PCPlanTypeID_plan');
 element.value = "";
 }
 }
 });
 }
 });*/
function crear() {
    $('#NonDrugExtendedCost').val("");
    $('#NonDrugOrderQty').val("");
    $('#NonDrugUnitCost').val("");
}
//
var s1 = $('#tbpcplan-pcplanbegindate,#tbpcplan-pcplanenddate').val();
if(s1 != null){
dateset();
$('#tbpcplan-pcplanbegindate,#tbpcplan-pcplanenddate').datepicker({
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
        if($('#tbpcplan-pcplanbegindate').val()!=""){
		var StartDate_case = $('#tbpcplan-pcplanbegindate').val();
        var StartDateArr_case = StartDate_case.split("/");
        var StartDateF_case = new Date((StartDateArr_case[2] - 543), (parseInt(StartDateArr_case[1]) - 1), StartDateArr_case[0]);
        var StopDate_case = $('#tbpcplan-pcplanenddate').val();
        var StopDateArr_case = StopDate_case.split("/");
        var StopDateF_case = new Date((StopDateArr_case[2] - 543), (parseInt(StopDateArr_case[1]) - 1), StopDateArr_case[0]);
        if ($('#tbpcplan-pcplanenddate').val() != '')
        {
            if (StopDateF_case < StartDateF_case) {
                $('#tbpcplan-pcplanbegindate').val('');
                $('#tbpcplan-pcplanenddate').val('');
                swal("", "วันที่สิ้นสุดแผนจะต้องไม่น้อยกว่าวันที่เริ่มแผน");
            }
        }
	}
	
    }
});
}
var s = $('#tbsa2-sadate,#effectivedate,#tbpcplan-pcplandate,#tbpcplan2-pcplandate,#tbst2-strecieveddate').val();
if (s != null) {
    $('#tbsa2-sadate,#effectivedate,#tbpcplan-pcplandate,#tbpcplan2-pcplandate,#tbst2-strecieveddate').datepicker({
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
var s3 = $('#tbpcplan2-pcplanenddate,#tbpcplan2-pcplanbegindate').val();
if (s3 != null) {
    $('#tbpcplan2-pcplanenddate,#tbpcplan2-pcplanbegindate').datepicker({
        dateFormat: "dd/mm/yy",
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
if($('#tbpcplan2-pcplanbegindate').val()!=""){
        var StartDate_case = $('#tbpcplan2-pcplanbegindate').val();
        var StartDateArr_case = StartDate_case.split("/");
        var StartDateF_case = new Date((StartDateArr_case[2] - 543), (parseInt(StartDateArr_case[1]) - 1), StartDateArr_case[0]);
        var StopDate_case = $('#tbpcplan2-pcplanenddate').val();
        var StopDateArr_case = StopDate_case.split("/");
        var StopDateF_case = new Date((StopDateArr_case[2] - 543), (parseInt(StopDateArr_case[1]) - 1), StopDateArr_case[0]);
        if ($('#tbpcplan2-pcplanenddate').val() != '')
        {
            if (StopDateF_case < StartDateF_case) {
                $('#tbpcplan2-pcplanbegindate').val('');
                $('#tbpcplan2-pcplanenddate').val('');
                swal("", "วันที่สิ้นสุดแผนจะต้องไม่น้อยกว่าวันที่เริ่มแผน");
            }
        }

	}
        }
    });
}
$('#date_start_movment,#date_end_movment').datepicker({
    dateFormat: "dd/mm/yy",
    //minDate: 0,
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
        var StartDate_case = $('#date_start_movment').val();
        var StartDateArr_case = StartDate_case.split("/");
        var StartDateF_case = new Date((StartDateArr_case[2] - 543), (parseInt(StartDateArr_case[1]) - 1), StartDateArr_case[0]);
        var StopDate_case = $('#date_end_movment').val();
        var StopDateArr_case = StopDate_case.split("/");
        var StopDateF_case = new Date((StopDateArr_case[2] - 543), (parseInt(StopDateArr_case[1]) - 1), StopDateArr_case[0]);
        if ($('#date_end_movment').val() != '')
        {
            if (StopDateF_case < StartDateF_case) {
                $('#date_start_movment').val('');
                $('#date_end_movment').val('');
                //  alert('วันที่สิ้นสุดแผนจะต้องไม่น้อยกว่าวันที่เริ่มแผน');
                swal("", "วันที่สิ้นสุดจะต้องไม่น้อยกว่าวันที่เริ่ม");
            }
        }
    }
});
$('#tbsr2temp-srreqdate').datepicker({
    dateFormat: "dd/mm/yy",
    //minDate: 0,
    changeYear: true,
    changeMonth: false,
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
$('#date_start_lastmovment,#date_end_lastmovment').datepicker({
    dateFormat: "dd/mm/yy",
    //minDate: 0,
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
        var StartDate_case = $('#date_start_lastmovment').val();
        var StartDateArr_case = StartDate_case.split("/");
        var StartDateF_case = new Date((StartDateArr_case[2] - 543), (parseInt(StartDateArr_case[1]) - 1), StartDateArr_case[0]);
        var StopDate_case = $('#date_end_lastmovment').val();
        var StopDateArr_case = StopDate_case.split("/");
        var StopDateF_case = new Date((StopDateArr_case[2] - 543), (parseInt(StopDateArr_case[1]) - 1), StopDateArr_case[0]);
        if ($('#date_end_lastmovment').val() != '')
        {
            if (StopDateF_case < StartDateF_case) {
                $('#date_start_lastmovment').val('');
                $('#date_end_lastmovment').val('');
                //  alert('วันที่สิ้นสุดแผนจะต้องไม่น้อยกว่าวันที่เริ่มแผน');
                swal("", "วันที่สิ้นสุดจะต้องไม่น้อยกว่าวันที่เริ่ม");
            }
        }
    }
});
