//$(document).ready(function () {
//    $('#headertableprvirifydetail').DataTable({
//        "dom": '<"pull-left"f><"pull-right"l>tip',
//        "paging": false,
//        "bFilter": false,
//        "pageLength": 5,
//        "info": false,
//        //"order": [[1, 'DESC']]
//    });
//});

$(document).ready(function () {
    $('#formwaitingforapprovedpo').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 5,
        "info": false,
        //"order": [[1, 'DESC']]
    });
});

$(document).ready(function () {
    $('#Headergrdetailgoodreceving').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        //"paging": false,
        //"bFilter": false,
        "pageLength": 10,
        "info": false,
        //"order": [[1, 'DESC']]
    });
});

//$(document).ready(function () {
//    $("#Headergrdetailgoodreceving tr").click(function () {
//        var a = $(this).children(":first").text();
//        var b = $(this).children(":first").next().next().text();
//        $('#a').val(a);
//        $('#b').val(b);
//    });
//});
$(document).ready(function () {
    $('#HeaderSaveLotassign').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "paging": false,
        "bFilter": false,
        "pageLength": 5,
        "info": false,
        //"order": [[1, 'DESC']]
    });
});
var InitiateEdit = function () {
    return {
        init: function () {
//            //Datatable Initiating
//            var oTable = $('#editabledatatable').dataTable({
//                "aLengthMenu": [
//                    [5, 15, 20, 100, -1],
//                    [5, 15, 20, 100, "All"]
//                ],
//                "iDisplayLength": 5,
//                "sPaginationType": "bootstrap",
//                "paging": false,
//                "bFilter": false,
//                "dom": '<"pull-left"f><"pull-right"l>tip',
//                //"sDom": "Tflt<'row DTTTFooter'<'col-sm-6'i><'col-sm-6'p>>",
//                "language": {
//                    "search": "",
//                    "sLengthMenu": "_MENU_",
//                    "oPaginate": {
//                        "sPrevious": "Prev",
//                        "sNext": "Next"
//                    }
//                },
////                    "aoColumns": [
////                        null,
////                        null,
////                        null,
////                        null,
////                        {"bSortable": false}
////                    ]
//            });
//
//            var isEditing = null;
//
//            //Add New Row
//            $('#editabledatatable_new').click(function (e) {
//                e.preventDefault();
//
//                var aiNew = oTable.fnAddData([
//                    '', '', '', '',
//                    '<a  class="btn btn-success btn-xs save"><i class="fa fa-edit"></i> Save</a> <a href="#" class="btn btn-warning btn-xs cancel" data-mode="new"><i class="fa fa-times"></i> Cancel</a>'
//                ]);
//                var nRow = oTable.fnGetNodes(aiNew[0]);
//                editAddedRow(oTable, nRow);
//                isEditing = nRow;
//            });
//
//            //Delete an Existing Row
//            $('#editabledatatable').on("click", 'a.delete', function (e) {
//                e.preventDefault();
//
//                if (confirm("Are You Sure To Delete This Row?") == false) {
//                    return;
//                }
//
//                var nRow = $(this).parents('tr')[0];
//                oTable.fnDeleteRow(nRow);
//                alert("Row Has Been Deleted!");
//            });
//
//            //Cancel Editing or Adding a Row
//            $('#editabledatatable').on("click", 'a.cancel', function (e) {
//                e.preventDefault();
//                if ($(this).attr("data-mode") == "new") {
//                    var nRow = $(this).parents('tr')[0];
//                    oTable.fnDeleteRow(nRow);
//                    isEditing = null;
//                } else {
//                    restoreRow(oTable, isEditing);
//                    isEditing = null;
//                }
//            });
//
//            //Edit A Row
//            $('#editabledatatable').on("click", 'a.edit', function (e) {
//                e.preventDefault();
//
//                var nRow = $(this).parents('tr')[0];
//
//                if (isEditing !== null && isEditing != nRow) {
//                    restoreRow(oTable, isEditing);
//                    editRow(oTable, nRow);
//                    isEditing = nRow;
//                } else {
//                    editRow(oTable, nRow);
//                    isEditing = nRow;
//                }
//            });
//
//            //Save an Editing Row
//            $('#editabledatatable').on("click", 'a.save', function (e) {
//                e.preventDefault();
//                if (this.innerHTML.indexOf("Save") >= 0) {
//                    var h1 = $("#h1").val();
//                    var h2 = $("#h2").val();
//                    var h3 = $("#h3").val();
//                    var h4 = $("#h4").val();
//
//
//
//                    $.ajax({
//                        url: "http://www.udcancer.com/purchasing/good-receiving/save-lotassign",
//                        type: "post",
//                        //data: $('#editabledatatable').serialize(),
//                        data: {h1: h1, h2: h2, h3: h3, h4: h4},
//                        success: function (result) {
//                            alert(h1);
//                        }
//                    });
//                    saveRow(oTable, isEditing);
//                    isEditing = null;
//                    //Some Code to Highlight Updated Row
//                }
//            });
//
//
//            function restoreRow(oTable, nRow) {
//                var aData = oTable.fnGetData(nRow);
//                var jqTds = $('>td', nRow);
//
//                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
//                    oTable.fnUpdate(aData[i], nRow, i, false);
//                }
//
//                oTable.fnDraw();
//            }
//
//            function editRow(oTable, nRow) {
//                var aData = oTable.fnGetData(nRow);
//                var jqTds = $('>td', nRow);
//                jqTds[0].innerHTML = '<input id="h1" type="text" class="form-control input-small" value="' + aData[0] + '">';
//                jqTds[1].innerHTML = '<input id="h2" type="text" class="form-control input-small" value="' + aData[1] + '">';
//                jqTds[2].innerHTML = '<input id="h3" type="text" class="form-control input-small" value="' + aData[2] + '">';
//                jqTds[3].innerHTML = '<input id="h4" type="text" class="form-control input-small" value="' + aData[3] + '">';
//                //jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
//                //jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[5] + '">';
//                //jqTds[6].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[6] + '">';
//                //jqTds[7].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[7] + '">';
//                //jqTds[8].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[8] + '">';
//                //jqTds[9].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[9] + '">';
//                //jqTds[10].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[10] + '">';
//                //jqTds[11].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[11] + '">';
//                jqTds[4].innerHTML = '<a href="#" class="btn btn-success btn-xs save"><i class="fa fa-save"></i> Save</a> <a href="#" class="btn btn-warning btn-xs cancel"><i class="fa fa-times"></i> Cancel</a>';
//            }
//
//            function editAddedRow(oTable, nRow) {
//                var aData = oTable.fnGetData(nRow);
//                var jqTds = $('>td', nRow);
//                jqTds[0].innerHTML = '<input id="h1" type="text" class="form-control input-small" value="' + aData[0] + '">';
//                jqTds[1].innerHTML = '<input id="h2" type="text" class="form-control input-small" value="' + aData[1] + '">';
//                jqTds[2].innerHTML = '<input id="h3" type="text" class="form-control input-small" value="' + aData[2] + '">';
//                jqTds[3].innerHTML = '<input id="h4" type="text" class="form-control input-small" value="' + aData[3] + '">';
//                //jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
//                //jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[5] + '">';
//                //jqTds[6].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[6] + '">';
//                //jqTds[7].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[7] + '">';
//                //jqTds[8].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[8] + '">';
//                //jqTds[9].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[9] + '">';
//                //jqTds[10].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[10] + '">';
//                // jqTds[11].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[11] + '">';
//                jqTds[4].innerHTML = aData[4];
//            }
//
//            function saveRow(oTable, nRow) {
//                var jqInputs = $('input', nRow);
//                oTable.fnUpdate(jqInputs[0].value, nRow, 0, true);
//                oTable.fnUpdate(jqInputs[1].value, nRow, 1, true);
//                oTable.fnUpdate(jqInputs[2].value, nRow, 2, true);
//                oTable.fnUpdate(jqInputs[3].value, nRow, 3, true);
//                //oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
////                    oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
////                    oTable.fnUpdate(jqInputs[6].value, nRow, 6, false);
////                    oTable.fnUpdate(jqInputs[7].value, nRow, 7, false);
////                    oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
////                    oTable.fnUpdate(jqInputs[9].value, nRow, 9, false);
//                //oTable.fnUpdate(jqInputs[10].value, nRow, 10, false);
//                //oTable.fnUpdate(jqInputs[11].value, nRow, 11, false);
//                oTable.fnUpdate('<a href="#" class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i> Edit</a> <a href="#" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>', nRow, 4, false);
//                oTable.fnDraw();
//            }
//
//            function cancelEditRow(oTable, nRow) {
//                var jqInputs = $('input', nRow);
//                oTable.fnUpdate(jqInputs[0].value, nRow, 0, true);
//                oTable.fnUpdate(jqInputs[1].value, nRow, 1, true);
//                oTable.fnUpdate(jqInputs[2].value, nRow, 2, true);
//                oTable.fnUpdate(jqInputs[3].value, nRow, 3, true);
//                //oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
////                    oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
////                    oTable.fnUpdate(jqInputs[6].value, nRow, 6, false);
////                    oTable.fnUpdate(jqInputs[7].value, nRow, 7, false);
////                    oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
////                    oTable.fnUpdate(jqInputs[9].value, nRow, 9, false);
//                //oTable.fnUpdate(jqInputs[10].value, nRow, 10, false);
//                //oTable.fnUpdate(jqInputs[11].value, nRow, 11, false);
//                oTable.fnUpdate('<a href="#" class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i> Edit</a> <a href="#" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>', nRow, 4, false);
//                oTable.fnDraw();
//            }
        }

    };
}();
InitiateEdit.init();

//$(function () {
//    $("#h4").datepicker({});
//});