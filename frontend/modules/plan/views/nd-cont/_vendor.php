<?php

use yii\helpers\Html;

$style = 'color:black;white-space: nowrap;border-top: 1px solid #ddd;text-align: center;';
?>
<table id="table" class="default kv-grid-table table table-hover table-condensed kv-table-wrap dataTable no-footer dtr-inline" width="100%">
    <thead>
        <tr>
            <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

            <?= Html::tag('th', Html::encode('รหัสผู้ขาย'), ['style' => $style]) ?>

            <?= Html::tag('th', Html::encode('ชื่อผู้ขาย'), ['style' => $style]) ?>

            <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($query as $v) : ?>
            <tr>
                <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                <?= Html::tag('td', empty($v['VendorID']) ? '-' : $v['VendorID'], ['style' => 'text-align: center;']) ?>

                <?= Html::tag('td', empty($v['VenderName']) ? '-' : $v['VenderName'], ['style' => 'text-align: left;']) ?>

                <?= Html::tag('td', Html::a('Select', false, ['class' => 'btn btn-xs btn-success', 'id' => $v['VendorID'], 'name' => $v['VenderName'], 'onclick' => 'GetnameVendor(this);']), ['style' => 'text-align: center;']) ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        var t = $('#table').DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
            "pageLength": 10,
            "responsive": true,
            "language": {
                "lengthMenu": "_MENU_",
                "infoEmpty": "No records available",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ],
            "order": [[1, 'asc']]
        });

        $('#table').on('click', 'tr', function () {
            if ($(this).hasClass('warning')) {
                $(this).removeClass('warning');
            } else {
                $('tr.warning').removeClass('warning');
                $(this).addClass('warning');
            }
        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
    function GetnameVendor(e) {
        var vdid = (e.getAttribute("id"));
        var name = (e.getAttribute("name"));
        $("#tbpcplan-pcvendorid").val(vdid);
        $("#tbpcplan-vendorname").val(name);
        $('#ajaxCrudModal').modal('hide');
    }
</script>
