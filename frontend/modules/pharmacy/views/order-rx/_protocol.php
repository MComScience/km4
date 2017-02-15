<?php

use yii\helpers\Html;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <table id="table_protocol" class="default responsive kv-grid-table table table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <?= Html::tag('th', Html::encode('#'), []) ?>

                    <?= Html::tag('th', Html::encode('CA DX'), []) ?>

                    <?= Html::tag('th', Html::encode('CA State'), []) ?>

                    <?= Html::tag('th', Html::encode('Protocol'), []) ?>

                    <?= Html::tag('th', Html::encode('รหัสเบิกจ่าย'), []) ?>

                    <?= Html::tag('th', Html::encode('Actions'), []) ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $v) : ?>
                    <tr>
                        <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                        <?= Html::tag('td', empty($v['Dx10CA']) ? '-' : $v['Dx10CA'], ['style' => 'text-align: left;']) ?>

                        <?= Html::tag('td', empty($v['chemo_state_desc']) ? '-' : $v['chemo_state_desc'], []) ?>

                        <?= Html::tag('td', empty($v['protocol_name']) ? '-' : $v['protocol_name'], []) ?>

                        <?= Html::tag('td', empty($v['regimen_paycode']) ? '-' : $v['regimen_paycode'], []) ?>

                        <?php
                        $Button = Html::a('Select', 'javascript:void(0);', [
                                    'title' => 'Select',
                                    'class' => 'btn btn-success btn-xs',
                                    'paycode' => empty($v['regimen_paycode']) ? '' : $v['regimen_paycode'],
                                    'onclick' => 'SelctProtocol(this);'
                        ]);
                        ?>
                        <?= Html::tag('td', $Button, ['style' => 'text-align: center;']) ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var t = $('#table_protocol').DataTable({
            "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
            "pageLength": 10,
            "responsive": true,
            //"ordering": false,
            "language": {
                "lengthMenu": " _MENU_ ",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                "search": '_INPUT_ ',
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ]
        });

        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
        
    });

    function SelctProtocol(e) {
        var paycode = (e.getAttribute("paycode"));
        $('#tbcpoe-pt_trp_regimen_paycode').val(paycode);
        $('#ajaxCrudModal').modal('hide');
    }
</script>
