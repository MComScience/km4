$(document).ready(function () {
    var t = $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": -1,
        "responsive": true,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ],
        "language": {
            "search": "ค้นหา : _INPUT_ " + '<div class="btn-group dropdown">\n\
            <a style="font-size:11pt;" class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100">\n\
                บันทึกแผนจัดซื้อ <b class="caret"></b>\n\
            </a>\n\
            <ul class="dropdown-menu dropdown-success">\n\
                <li><a href="/km4/plan/gpu/create" data-pjax="0" style="font-size:11pt;"><i class="glyphicon glyphicon-edit"></i> ยาสามัญ</a></li>\n\
                <li><a href="/km4/plan/tpu/create" data-pjax="0" style="font-size:11pt;"><i class="glyphicon glyphicon-edit"></i> ยาการค้า</a></li>\n\
                <li><a href="/km4/plan/nd/create" data-pjax="0" style="font-size:11pt;"><i class="glyphicon glyphicon-edit"></i> เวชภัณฑ์ฯ</a></li>\n\
            </ul></div>' + '\n\
                <div class="checkbox">\n\
                <label><input type="checkbox" id="SortGPU" /><span class="text">ยาสามัญ</span></label>\n\
                <label><input type="checkbox" id="SortTPU" /><span class="text">ยาการค้า</span></label>\n\
                <label><input type="checkbox" id="SortND" /><span class="text">เวชภัณฑ์ฯ</span></label>\n\
                </div>\n\
            ',
            /*"search": "ค้นหา : _INPUT_ " + '<a class="btn btn-success" href="/km4/plan/gpu/create" data-pjax="0"><i class="glyphicon glyphicon-plus"></i>บันทึกแผนยาสามัญ</a>\n\
             <a class="btn btn-success" href="/km4/plan/tpu/create" data-pjax="0"><i class="glyphicon glyphicon-plus"></i>บันทึกแผนยาการค้า</a>\n\
             <a class="btn btn-success" href="/km4/plan/nd/create" data-pjax="0"><i class="glyphicon glyphicon-plus"></i>บันทึกแผนเวชภัณฑ์ฯ</a>\n\
             <a class="btn btn-success" href="/km4/plan/tpu-cont/create" data-pjax="0"><i class="glyphicon glyphicon-plus"></i>บันทึกแผนจะซื้อจะขายยา</a>\n\
             <a class="btn btn-success" href="/km4/plan/nd-cont/create" data-pjax="0"><i class="glyphicon glyphicon-plus"></i>บันทึกแผนจะซื้อจะขายเวชภัณฑ์ฯ</a>',
             /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
            "lengthMenu": "_MENU_",
            "infoEmpty": "No records available",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
    });
    $('table.default tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            t.$('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
    });
    $('#SortGPU').click(function () {
        $.fn.dataTable.ext.search.pop();
        if ($(this).is(":checked") && $('#SortTPU').is(":checked") === false && $('#SortND').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortTPU').is(":checked") === true && $('#SortND').is(":checked") === true) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/) || sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortTPU').is(":checked") === true && $('#SortND').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/) || sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortND').is(":checked") === true && $('#SortTPU').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else {//ถ้าไม่ Checked
            $.fn.dataTable.ext.search.pop();
            if ($('#SortTPU').is(":checked") === true && $('#SortND').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortTPU').is(":checked") === true && $('#SortND').is(":checked") === false) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortTPU').is(":checked") === false && $('#SortND').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else {
                //table.destroy();
                var newTable = $('table.default').DataTable();
                newTable.draw();
            }
        }
    });
    $('#SortTPU').click(function () {
        $.fn.dataTable.ext.search.pop();
        if ($(this).is(":checked") && $('#SortGPU').is(":checked") === false && $('#SortND').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortGPU').is(":checked") === true && $('#SortND').is(":checked") === true) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortGPU').is(":checked") === true && $('#SortND').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortND').is(":checked") === true && $('#SortTPU').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else {//ถ้าไม่ Checked
            $.fn.dataTable.ext.search.pop();
            if ($('#SortGPU').is(":checked") === true && $('#SortND').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/) || sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortGPU').is(":checked") === true && $('#SortND').is(":checked") === false) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortGPU').is(":checked") === false && $('#SortND').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else {
                //table.destroy();
                var newTable = $('table.default').DataTable();
                newTable.draw();
            }
        }
    });
    $('#SortND').click(function () {
        $.fn.dataTable.ext.search.pop();
        if ($(this).is(":checked") && $('#SortTPU').is(":checked") === false && $('#SortGPU').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortTPU').is(":checked") === true && $('#SortGPU').is(":checked") === true) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/) || sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortTPU').is(":checked") === true && $('#SortGPU').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/) || sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else if ($(this).is(":checked") && $('#SortGPU').is(":checked") === true && $('#SortTPU').is(":checked") === false) {
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var sorttb = data[5] || null;
                        if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/) || sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                        {
                            return true;
                        }
                        return false;
                    }
            );
            t.draw();
        } else {//ถ้าไม่ Checked
            $.fn.dataTable.ext.search.pop();
            if ($('#SortTPU').is(":checked") === true && $('#SortGPU').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/) || sorttb.match(/^แผนการจัดซื้อยาสามัญ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortTPU').is(":checked") === true && $('#SortGPU').is(":checked") === false) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อยาการค้า.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else if ($('#SortTPU').is(":checked") === false && $('#SortGPU').is(":checked") === true) {
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var sorttb = data[5] || null;
                            if (sorttb.match(/^แผนการจัดซื้อเวชภัณฑ์ฯ.*$/))
                            {
                                return true;
                            }
                            return false;
                        }
                );
                t.draw();
            } else {
                //table.destroy();
                var newTable = $('table.default').DataTable();
                newTable.draw();
            }
        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});
function Print1(e) {
    var PCPlanNum = (e.getAttribute("id"));
    //event.preventDefault();
    var myWindow = window.open("/km4/Report/report-purchasing/plan-gpu?PCPlanNum=" + PCPlanNum, "", "top=100,left=200,width=" + (screen.width - '400') + ",height=550,right=auto");
    myWindow.window.print();
}
function Print2(e) {
    var PCPlanNum = (e.getAttribute("id"));
    //event.preventDefault();
    var myWindow = window.open("/km4/Report/report-purchasing/plan-gpureport?PCPlanNum=" + PCPlanNum, "", "top=100,left=50,width=" + (screen.width - '100') + ",height=550,right=auto");
    myWindow.window.print();
}