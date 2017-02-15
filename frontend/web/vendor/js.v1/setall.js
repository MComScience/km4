//$("#prtypeids,#pcplantypeid,#prstatusids,#departmentIds,#sectionid,#potypeids,#pcplanstatusid").select2();
$(function () {
    $("#gpuunitCost").keyup(function () {
        var uni = $("#gpuunitCost").val();
        var orq = $("#gpuorderqty").val();
        var jj = uni * orq;
        $("#gpuextended").val(jj);
    });
    $("#gpuorderqty").keyup(function () {
        var uni = $("#gpuunitCost").val();
        var orq = $("#gpuorderqty").val();
        var jj = uni * orq;
        $("#gpuextended").val(jj);
    });
});
$(document).ready(function () {
//    $('#pcplanbydrugtable').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        "ajax": {
//            "url": "/km4/backend/web/index.php?r=Purchasing/tbpcplan/datapcplanbydrug",
//             "processing": true,
//             "serverSide": true,
//             "type": "POST"
//        },
//    });
    $('#prtable').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/tbpr/datapcplanbydrug",
            "type": "POST"
        },
    });
    $('#prtbss').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "/km4/backend/web/index.php?=Purchasing/tbpr/dataverify",
            "type": "POST"
        },
    });
     $('#prtbsss').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "/km4/backend/web/index.php?=Purchasing/tbpr/datap",
            "type": "POST"
        },
    });
     $('#pcplandrugtable').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "/km4/backend/web/index.php?r=Purchasing/tbplandrug/datapcplandrug",
            "type": "POST"
        }
    });
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
            (myDate.getFullYear());
    $("#tbpcplan-pcplandate,#tbpcplan-pcplanbegindate,#tbpcplan-pcplanenddate,#tbpr-prdate,#tbpr-prexpectdate,#effectivedate").val(prettyDate);
}
$(function () {
    if($("#tbpcplan-pcplanbegindate").val()== ""){
         dateset();
    }
   
});
$(function () {//view tbpr _ form แผนจัดชื้อยา PrUnitCost * PROrderQty = PRExtendedCost
    $("#prunitcost").keyup(function () {
        var uni = $("#prunitcost").val();
        var orq = $("#prorderqty").val();
        var jj = uni * orq;
        $("#prextendedcost").val(jj);
    });
    $("#prorderqty").keyup(function () {
        var uni = $("#prorderqty").val();
        var orq = $("#prunitcost").val();
        var jj = uni * orq;
        $("#prextendedcost").val(jj);
    });
});
$(function () {//view tbpr _ form แผนจัดชื้อยา ปริมาณตามแผน - ปริมาณขอชื้อแล้ว = ปริมาณที่ชื้อได้ตามแผน
    $("#pcgpuqty").keyup(function () {
        var uni = $("#pcgpuqty").val();
        var orq = $("#sumprgp").val();
        var jj = uni - orq;
        $("#pcgpuavalible").val(jj);
    });
    $("#sumprgp").keyup(function () {
        var uni = $("#pcgpuqty").val();
        var orq = $("#sumprgp").val();
        var jj = uni - orq;
        $("#pcgpuavalible").val(jj);
    });
});
$(function () {//view tbpr _ form แผนจัดชื้อยา ปริมาณตามแผน - ปริมาณขอชื้อแล้ว = ปริมาณที่ชื้อได้ตามแผน
    $("#PRVerifyUnitCost").keyup(function () {
        var uni = $("#PRVerifyUnitCost").val();
        var orq = $("#PRVerifyQty").val();
        var jj = uni * orq;
        $("#prextendedcost").val(jj);
    });
    $("#PRVerifyQty").keyup(function () {
        var uni = $("#PRVerifyUnitCost").val();
        var orq = $("#PRVerifyQty").val();
        var jj = uni * orq;
        $("#prextendedcost").val(jj);
    });
});
$(document).ready(function () {
    table = $('#tablenondrugs').DataTable({
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
            "pageLength": 3,
        });
    
});
$(function () {
    $("#NonDrugUnitCost").keyup(function () {
        var uni = $("#NonDrugUnitCost").val();
        var orq = $("#NonDrugOrderQty").val();
        var jj = uni * orq;
        $("#NonDrugExtendedCost").val(jj);
    });
    $("#NonDrugOrderQty").keyup(function () {
        var uni = $("#NonDrugUnitCost").val();
        var orq = $("#NonDrugOrderQty").val();
        var jj = uni * orq;
        $("#NonDrugExtendedCost").val(jj);
    });
});
   function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57)){
            alert("กรุณากรอกตัวเลข");
             return false;
         }else{
             

          return true;
         }
       }
