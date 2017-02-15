

function Reload() {
    $.pjax.reload({container: "#grid-user-pjaxx"});
}

//jQuery(function ($) {
//    jQuery('body').on('change', '#department', function () {
//        jQuery.ajax({
//            'type': 'POST',
//            'url': "http://localhost/Project_Udon/frontend/web/index.php?r=purchasing/plan/ShowSection",
//            'cache': false,
//            'data': {DepartMent: jQuery(this).val()},
//            'success': function (html) {
//                jQuery("#section").html(html);
//            }
//        });
//        return false;
//    });
//
//});
//var save_method; //for save method string
//var table;
//$(document).ready(function () {
//    table = $('#tablenondrug').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        //"paging":   false,
//        //"ordering": false,
//        //"bFilter": false,
//        "ajax": {
//            "url": "http://www.udcancer.com/purchasing/tbplan/data1",
//            "type": "GET",
//        },
//        //Set column definition initialisation properties.
//        "columnDefs": [
//            {
//                "targets": [-1], //last column
//                "orderable": false, //set not orderable
//
//            },
//        ],
//        "pageLength": 3,
//    });
//    
//});

//$(document).ready(function () {
//    tabletmt = $('#tabletmt').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//         "processing": true,
//        "serverSide": true,
//        //"paging":   false,
//        //"ordering": false,
//        //"bFilter": false,
//        "ajax": {
//            "url": "http://localhost/KM4.V1/backend/web/index.php?r=ItemMasterDrug/items/getdatatmt",
//            "type": "GET",
//        },
//        //Set column definition initialisation properties.
//        "columnDefs": [
//            {
//                "targets": [-1], //last column
//                "orderable": false, //set not orderable
//
//            },
//        ],
//        "pageLength": 3,
//    });
//    var detailRows = [];
// 
//    $('#tabletmt').on( 'click', 'tr td.details-control', function () {
//        var tr = $(this).closest('tr');
//        var row = dt.row( tr );
//        var idx = $.inArray( tr.attr('id'), detailRows );
// 
//        if ( row.child.isShown() ) {
//            tr.removeClass( 'details' );
//            row.child.hide();
// 
//            // Remove from the 'open' array
//            detailRows.splice( idx, 1 );
//        }
//        else {
//            tr.addClass( 'details' );
//            row.child( format( row.data() ) ).show();
// 
//            // Add to the 'open' array
//            if ( idx === -1 ) {
//                detailRows.push( tr.attr('id') );
//            }
//        }
//    } );
//    
//});

//$(document).ready(function () {
//    var table2 = $('#table2').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        //Set column definition initialisation properties.
//        "columnDefs": [
//            {
//                "targets": [-1], //last column
//                "orderable": false, //set not orderable
//
//            },
//        ],
//        "pageLength": 2,
//    });
//    table2.on('order.dt search.dt', function () {
//        table2.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
//            cell.innerHTML = i + 1;
//        });
//    }).draw();
//});
//
//
//$(function () {
//    $("#NonDrugUnitCost").keyup(function () {
//        var uni = $("#NonDrugUnitCost").val();
//        var orq = $("#NonDrugOrderQty").val();
//        var jj = uni * orq;
//        $("#NonDrugExtendedCost").val(jj);
//    });
//    $("#NonDrugOrderQty").keyup(function () {
//        var uni = $("#NonDrugUnitCost").val();
//        var orq = $("#NonDrugOrderQty").val();
//        var jj = uni * orq;
//        $("#NonDrugExtendedCost").val(jj);
//    });
//});



//$(document).ready(function () {
//    var today = new Date();
//    var yyyy = today.getFullYear();
//    var hh = yyyy.toString();
//    var res = hh.substring(2, 4);
//    var jj = Math.floor((Math.random() * 10000) + 1);
//    var hh1 = parseInt(res) + 44;
//    var hh1 = hh1.toString();
//    $('#inputEmail3').val('PC' + hh1 + '-' + jj);
//
//});


//
//$(document).ready(function() { 
//     $("#prtypeids").select2({
//            //placeholder: "Select a State",
//            //allowClear: true
//        });
//});
//function myFunction(id) {
//
//        $.ajax({
//            url: "http://localhost/KM4.V1/backend/web/index.php?r=ItemMasterDrug/items/getid",
//            type: "post",
//            data: {id: id},
//            dataType: "JSON",
//            success: function (d) {
//                $("#TMTID_TPU").val(d.TMTID_TPU);
//                $("#TMTID_TPU1").val(d.TMTID_TPU);
//                $("#FSN_TMT").val(d.FSN_TMT);
//                $("#FSN_TMT1").val(d.FSN_TMT);
//                $("#TradeName_TMT").val(d.TradeName_TMT);
//                $("#Manufacturer_TMT").val(d.Manufacturer_TMT);
//                $("#StrNum_TMT").val(d.StrNum_TMT);
//                $("#Contval_TMT").val(d.Contval_TMT);
//                $("#Contunit_TMT").val(d.Contunit_TMT);
//                $("#DispUnit_TMT").val(d.DispUnit_TMT);
//                $("#Dosageform_TMT").val(d.Dosageform_TMT);
//
//            }
//        });
//    }

$(document).ready(function () {
    tabletmt = $('#getdatatmt').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging":   false,
        //"ordering": false,
        //"bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/Inventory/additem/data",
            //"url": "index.php?r=Inventory/additem/data",
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
    });

});


//$("#ddl-province").val("1").trigger("change");
//function saveToGeneric() {
//    $.ajax({
//        url: "http://www.udcancer.com/Inventory/additem/savetogeneric",
//        //url: "index.php?r=Inventory/additem/savetogeneric",
//        type: "post",
//        data: $('#SaveToGeneric').serialize(),
//        dataType: "JSON",
//        success: function (d) {
//
//            if (d.num != 1) {
//                alert(d.message);
//            }
//            if (d.num == 1) {
//                alert(d.message);
//                $("#btn_Posttoitem").html(d.btn);
//            }
//            // jQuery.facebox(d);
//            //$("#btn_Posttoitem").html(d.btn);
//            /* $("input[name=s_id]").val("");
//             $("input[name=s_name]").val("");
//             $("#address").val("");
//             load_div_grid();*/
//        }
//    });
//}
$(document).ready(function () {
    var tbprapp = $('#prstatuslist').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpo/getdatapr",
            "type": "GET",
        },
        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
        "order": [[1, 'asc']]
    });

    tbprapp.on('order.dt search.dt', function () {
        tbprapp.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});


$(document).ready(function () {
    $('#zzzz').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpo/getdatatpupodetail",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#podetailxx1').bootstrapValidator();
});
//$(document).ready(function () {
//    var t = $('#VwPrgpuapprovedlist').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        "paging": false,
//        "bFilter": false,
//        "ajax": {
//            "url": "http://www.udcancer.com/purchasing/addpo/getdataprgpu",
//            "type": "GET",
//        },
//        "columnDefs": [{
//                "searchable": false,
//                "orderable": false,
//                "targets": 0
//            }],
//        "order": [[1, 'asc']]
//    });
//
//    t.on('order.dt search.dt', function () {
//        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
//            cell.innerHTML = i + 1;
//        });
//    }).draw();
//});


function Selectprg(id) {

    $.ajax({
        url: "http://www.udcancer.com/purchasing/addpo/getdataprapp",
        type: "post",
        data: {id: id},
        dataType: "json",
        success: function (d) {
            $('#myModal').modal(show)
        }
    });
}

$(document).ready(function () {
    var t = $('#tbvenderpogpu').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        // "paging":   false,
        // "bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpo/getdatavender",
            "type": "GET",
        },
        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

$(document).ready(function () {
    var t = $('#tbvender1').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        // "paging":   false,
        // "bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpoagreement/getdatavender",
            "type": "GET",
        },
        "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

function Getdatavender1(id) {

    $.ajax({
        url: "http://www.udcancer.com/purchasing/addpo/getdatavender1",
        type: "post",
        data: {id: id},
        dataType: "JSON",
        success: function (d) {
            $("#VendorID").val(d.VendorID);
            $("#VenderName").val(d.VenderName);
        }
    });
}





function myFunselectdata1(id) {
    $.ajax({
        url: 'http://www.udcancer.com/purchasing/tbplan/getdatatbplan',
        method: 'post',
        data: {id: id},
        dataType: 'json',
    }).success(function (result) {
        $("input[name=ItemID]").val(result.ItemID);
        $("#itemname").val(result.ItemName);
        $("#PCPlanNum").val($('#inputEmail13').val());
        //$("#ExtendedCost").val('0');
    });
    $('#modal1').modal('show')
}

//$(function () {
//    $("#POUnitCost").keyup(function () {
//        var uni = $("#POUnitCost").val();
//        var orq = $("#POOrderQty").val();
//        var jj = uni * orq;
//        $("#POExtendedCost").val(jj);
//    });
//    $("#POOrderQty").keyup(function () {
//        var uni = $("#POUnitCost").val();
//        var orq = $("#POOrderQty").val();
//        var jj = uni * orq;
//        $("#POExtendedCost").val(jj);
//    });
//});



$(document).ready(function () {
    var t = $('#Getdatapomodal').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpoagreement/getdatapo",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

$(document).ready(function () {
    var t = $('#Getdataprtpuxxx').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 5,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/additemprtpu/getdataprtpu",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

$(document).ready(function () {
    var t = $('#Getdatapomodalprgpu').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/additemprgpu/getdataprgpu",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});


$(document).ready(function () {
    $('#prdataitem').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 5,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpritem/getdatapritem",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
});

$(document).ready(function () {
    $('#tableGetdataprgpu').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 5,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/additemprgpu/getdataprgpu",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
});

$(document).ready(function () {
    $('#prdatanditem').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 5,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addnditem/getdatapritem",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
});

$(document).ready(function () {
    $('#tb_pr_gpuitem').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        //"pageLength": 10,
        "info": false,
        "iDisplayLength": 5,
        "aLengthMenu": [
            [5, 15, 20, 100, -1],
            [5, 15, 20, 100, "All"]
        ],
        //stateSave: true,
        //"pagingType": "full_numbers",
        //"order": [[1, 'asc']],
        //autoFill: true,
        //colReorder: true,
        //keys: true,
        //fixedHeader: true,
        //"processing": true,
        //responsive: true,
//        fixedHeader: {
//            header: false,
//            footer: true
//        },
        // ordering: true,
        // select: true,
        //scrollY: 200,
        // deferRender: true,
        //scroller: true,
        //fixedColumns: true,
        //"scrollX": true,
//        buttons: [
//            'copy', 'excel', 'pdf'
//        ]
        //fixedHeader: true,
        //rowReorder: true
    });
});
$(document).ready(function () {
    $('#Headeraddpritemeditverify').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 5,
        "info": false,
    });
});

$(document).ready(function () {
    $('#tb_pr_tpuitem').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 10,
        "info": false,
        //"order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#tb_pr_nditem').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 10,
        "info": false,
        //"order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#Headeraddpreditverify').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 10,
        "info": false,
        //"order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#Headeraddnditemupdateforapprove').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 10,
        "info": false,
        //"order": [[1, 'asc']]
    });
});
$(document).ready(function () {
    $('#Headeraddnditemedit').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 10,
        "info": false,
        "order": [[1, 'asc']]
    });
});

$(document).ready(function () {
    $('#Headeractioncreatenditemtemp').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        "pageLength": 5,
        //"info": false,
        "order": [[1, 'asc']]
    });
});

$(document).ready(function () {
    $('#Headeractionsavedataitemprgpudetail').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        "pageLength": 5,
        //"info": false,
        //"order": [[1, 'asc']]
    });
});



$(document).ready(function () {
    var t = $('#qrselectdetailpr').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        // "paging":   false,
        // "bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/createqr/getdatadetailpr",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

$(document).ready(function () {
    var t = $('#tb_vender').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        // "paging":   false,
        // "bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/createqr/getdatavender",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});

$(document).ready(function () {
    var t = $('#tb_venderedit').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        // "paging":   false,
        // "bFilter": false,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/createqr/getdatavenderedit",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});


jQuery(function ($) {
    var $container = $('#container');
    setTimeout(function () {
        $container.isotope({
            itemSelector: '.demo',
            layoutMode: 'fitRows'
                    // sortBy: 'popular'
        });
    }, 1000);

    $('#portfolio-filter').find('button').on('click', function (e) {
        var $this = $(this),
                selector = $this.attr('data-filter');

        $('#portfolio-filter').find('.active').removeClass('active');
        // And filter now
        $container.isotope({
            filter: selector,
            transitionDuration: '0.4s'
        });

        $this.closest('li').addClass('active');
        e.preventDefault();
    });
});


$(document).ready(function () {
    $('#VwQrGpuApprovedAgreementprice1').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        //"bFilter": false,
        "pageLength": 5,
        "info": false,
    });
});
//$(document).ready(function () {
//    var Status = $("#tbpr-prstatusid").val();
//    if (Status == 1) {
//        $('li[data-target=#wiredstep1]').addClass("complete");
//    }
//    if (Status == 2) {
//        $('li[data-target=#wiredstep1],li[data-target=#wiredstep4]').addClass("complete");
//        //$('li[data-target=#wiredstep4]').addClass("complete"); 
//    }
//
//});

//=======================
//$(document).ready(function (){
//   var table = $('#tb_vender').DataTable({
//       "dom": '<"pull-left"f><"pull-right"l>tip',
//      'ajax': {
//         'url': "http://www.udcancer.com/purchasing/createqr/getdatavender", 
//      },
//      'columnDefs': [{
//         'targets': 0,
//         'searchable': false,
//         'orderable': false,
//         'className': 'dt-body-center',
//         'render': function (data, type, full, meta){
//             return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
//         }
//      }],
//      'order': [[1, 'asc']]
//   });
//
//   // Handle click on "Select all" control
//   $('#example-select-all').on('click', function(){
//      // Get all rows with search applied
//      var rows = table.rows({ 'search': 'applied' }).nodes();
//      // Check/uncheck checkboxes for all rows in the table
//      $('input[type="checkbox"]', rows).prop('checked', this.checked);
//   });
//
//   // Handle click on checkbox to set state of "Select all" control
//   $('#tb_vender tbody').on('change', 'input[type="checkbox"]', function(){
//      // If checkbox is not checked
//      if(!this.checked){
//         var el = $('#example-select-all').get(0);
//         // If "Select all" control is checked and has 'indeterminate' property
//         if(el && el.checked && ('indeterminate' in el)){
//            // Set visual state of "Select all" control 
//            // as 'indeterminate'
//            el.indeterminate = true;
//         }
//      }
//   });
//
//   // Handle form submission event
//   $('#frm-example').on('submit', function(e){
//      var form = this;
//
//      // Iterate over all checkboxes in the table
//      table.$('input[type="checkbox"]').each(function(){
//         // If checkbox doesn't exist in DOM
//         if(!$.contains(document, this)){
//            // If checkbox is checked
//            if(this.checked){
//               // Create a hidden element 
//               $(form).append(
//                  $('<input>')
//                     .attr('type', 'hidden')
//                     .attr('name', this.name)
//                     .val(this.value)
//               );
//            }
//         } 
//      });
//   });
//
//});
$(document).ready(function () {
    $('#tableTbPodetailedit1').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        "pageLength": 5,
        "info": false,
        "order": [[1, 'DESC']]
    });
});
$(document).ready(function () {
    $('#tableTbPodetailedit2').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        //"bFilter": false,
        "pageLength": 5,
        //"info": false,
        //"order": [[1, 'DESC']]
    });
});
$(document).ready(function () {
    $('#VwPrgpuapprovedlist12').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        //"bFilter": false,
        "pageLength": 5,
        //"info": false,
        //"order": [[1, 'DESC']]
    });
});
$(document).ready(function () {
    $('#headertableprvirifydetail').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        "pageLength": 5,
        responsive: true,
        //"info": false,
        "scrollX": true,
        //"order": [[1, 'DESC']]
    });
});
$(document).ready(function () {
    $('#').autoNumeric(
            'init', {aSep: ',', mDec: '0', vMax: '99999999999999999999999999'}
    );
});
//   document.onkeydown = function(e) {
//        if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 117)) {//Alt+c, Alt+v will also be disabled sadly.
//            alert('not allowed');
//        }
//        return false;
//};
document.onkeydown = function (e) {
    if (e.ctrlKey &&
            (e.keyCode === 85)) {
        return false;
    }
};

//$(document).ready(function() {
//	$('a[data-confirm]').click(function(ev) {
//		var href = $(this).attr('href');
//		if (!$('#dataConfirmModal').length) {
//			$('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
//		} 
//		$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
//		$('#dataConfirmOK').attr('href', href);
//		$('#dataConfirmModal').modal({show:true});
//		return false;
//	});
//});
//

//  
//  $(document).ready(function() {
//    $("#dialog").dialog({
//      autoOpen: false,
//      modal: true
//    });
//  });
//
//  $("#sas").click(function(e) {
//    e.preventDefault();
//    var targetUrl = $(this).attr("href");
//
//    $("#dialog").dialog({
//      buttons : {
//        "Confirm" : function() {
//          window.location.href = targetUrl;
//        },
//        "Cancel" : function() {
//          $(this).dialog("close");
//        }
//      }
//    });
//
//    $("#dialog").dialog("open");
//  });
//var dateBefore = null;
//function dateset() {
//    var myDate = new Date();
//    var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
//            (myDate.getFullYear() + 543);
//    $("#tbpr-prdate").val(prettyDate);
//}
$(document).ready(function () {
    $('#prdatagpu1').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 5,
        "ajax": {
            "url": "http://www.udcancer.com/purchasing/addpr/getdatagpu",
            "type": "GET",
        },
        "order": [[1, 'asc']]
    });
});
jQuery(function ($) {
    $('#WiredWizard').wizard();
});
