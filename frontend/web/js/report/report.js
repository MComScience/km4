$(function () {
    $('table.default tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            $('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
    });
});

function GetfromReport(e) {
    var title = (e.getAttribute("title"));
    $.ajax({
        url: 'getfrom-report',
        type: 'POST',
        data: {title: title},
        dataType: 'json',
        success: function (result)
        {
            $('#modal-content').find('.modal-body').html(result);
            $('#modal_report .modal-title').html(title);
            $('#modal-content').html(result);
            $('#modal_report').modal('show');
        },
        error: function (xhr, status, error)
        {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
        }
    });
}
/* รายงานยอดคงเหลือรวม */
function PrintReportStkBalancetotal(e) {
    var catid = (e.getAttribute("catid"));
    PrintReport("stk-balance-total?ItemCatID=" + catid);
}
/* รายงานยอดคงเหลือแยกตามคลังสินค้า */
function PrintReportSeparate(catid) {
    var stkid = $('#state_2 :selected').val();

    if ((stkid === undefined) || (stkid === '')) {
        swal("Oops!", "กรุณาเลือกคลัง!", "error");
    } else {
        PrintReport("balancetotal-drug?stkid=" + stkid + "&ItemCatID=" + catid);
    }
}
/* รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ */
function PrintReportDrugofCount(catid) {
    var stkid = $('#state_2 :selected').val();

    if ((stkid === undefined) || (stkid === '')) {
        swal("Oops!", "กรุณาเลือกคลัง!", "error");
    } else {
        PrintReport("balance-drugcount?stkid=" + stkid + "&ItemCatID=" + catid);
    }
}
/* รายงานปริมาณการขายสินค้า สรุปรายเดือน */
function PrintReportYearcut(catid) {
    var year = $('#state_3 :selected').val();

    if ((year === undefined) || (year === '')) {
        swal("Oops!", "กรุณาเลือกปี!", "error");
    } else {
        PrintReport("yearcut?year=" + year + "&ItemCatID=" + catid);
    }
}
/* รายงานยอดคงเหลือแยกตาม Lot */
function PrintReportStkBalancelotnumber(catid) {
    PrintReport("balancelotnumber?ItemCatID=" + catid);
}
/* รายงานเคลื่อนไหวคลังสินค้า */
function PrintReportProductmovements(catid) {
    var start = ConvertDate($('#w1-start').val()) || null;
    var end = ConvertDate($('#w1-end').val()) || null;
    //var start = $('#w1-start').val() || null;
    //var end = $('#w1-end').val() || null;
    if ((start === null) || (end === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    } else {
        PrintReport("productmovements?start=" + start + "&end=" + end + "&catid=" + catid);
    }
}

/* รายงานสินค้าที่ไม่มีการเคลื่อนไหว */
function PrintReportProductNotmovements(catid) {
    var start = $('#w1-start').val() || null;
    var end = $('#w1-end').val() || null;
    if ((start === null) || (end === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    } else {
        PrintReport("product-notmovements?start=" + start + "&end=" + end + "&catid=" + catid);
    }
}
/* รายงานสินค้าหมดอายุ */
function PrintReportNondrugExpired(catid) {
    PrintReport("itemnondrug-balance-expired?catid=" + catid);
}
/* รายงานสินค้าต่ำกว่าจุดสั่งชื้อ */
function PrintReportReorderpoint(catid) {
    PrintReport("reorderpoint?catid=" + catid);
}
/* รายงานสินค้าสูงกว่าระดับการเก็บ */
function PrintReportOverstock(catid) {
    PrintReport("overstock?catid=" + catid);
}
/* รายงานการโอนสินค้ารายเดือน */
function PrintReportTranfer(catid) {
    var st_recieve = $('#state_2').val() || null;
    var st_issue = $('#state_1').val() || null;
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((st_recieve === null) || (st_issue === null)) {
        swal("Oops!", "กรุณาเลือกคลัง!", "error");
    } else if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    } else {
        PrintReport("tranfer?st_recieve=" + st_recieve + "&st_issue=" + st_issue + "&startdate=" + startdate + "&enddate=" + enddate + "&catid=" + catid);
    }
}
/* รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย */
function PrintReportPOHistory($type){
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    }else{
        PrintReport("po-history?startdate=" + startdate + "&enddate=" + enddate + "&type=" + $type);
    }
}
/* รายงานสถานะการสั่งชื้อ */
function PrintReportPocompareplan(){
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    }else{
        PrintReport("pocompareplan?startdate=" + startdate + "&enddate=" + enddate);
    }
}

/* รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ */
function PrintReportPOCompareplangeneric(type){
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    }else{
        PrintReport("pocompareplangeneric?startdate=" + startdate + "&enddate=" + enddate + "&type=" + type);
    }
}

/* รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย */
function PrintReportPOCompareTheagreementtosell(pcplantype){
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    }else{
        PrintReport("compared-theagreementtosell-drug-trade?startdate=" + startdate + "&enddate=" + enddate + "&pcplantype=" + pcplantype);
    }
}

/* ประวัติการอนุมัติ ยาขอใช้นอกแผน */
function PrintReportHistoryApprove(status){
    var startdate = ConvertDate($('#w1-start').val()) || null;
    var enddate = ConvertDate($('#w1-end').val()) || null;
    if ((startdate === null) || (enddate === null)) {
        swal("Oops!", "กรุณาเลือกวันที่!", "error");
    }else{
        PrintReport("history-approve?startdate=" + startdate + "&enddate=" + enddate+ "&status=" + status);
    }
}

/* PriceList */
function PrintReportPriceList(catid){
    PrintReport("price-list-qu?catid=" + catid);
}

function PrintReport(path) {
    var url = window.location.pathname.replace(/(index.*)/i, '');
    var myPrint = window.open(url + path, /*'_blank'*/"", "top=100,left=auto,width=" + screen.width + ",height=550");
    myPrint.window.print();
}

/* แปลงวันที่ */
function ConvertDate(myString) {
    var array = new Array();
    array = myString.split('/');
//from array concatenate into new date string format: "DD/MM/YYYY"
    var newDate = (array[2] + "-" + array[1] + "-" + array[0]);

    return newDate;
}