<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$this->title = 'Create Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'ห้องจ่ายยาผู้ป่วยนอก', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'Standard Regimen', 'url' => ['/chemos/standard/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.kv-grid-table thead tr th{
        text-align: center;
        background-color: white;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
    div#solution-modal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-warning active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('Create Regimen Cycle'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php
                            echo $this->render('_form_header_regimencycle', [
                                'modelChemo' => $modelChemo,
                                'modelDrugset' => $modelDrugset,
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php
                            echo $this->render('_grid_drugset_details', [
                                'dataProvider' => $dataProvider,
                                'modelDrugset' => $modelDrugset,
                                'modelChemo' => $modelChemo,
                            ]);
                            ?>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12" style="text-align: right;">
                            <?= Html::a('Close', ['/chemos/standard/index'], ['class' => 'btn btn-default']); ?>
                            <?= Html::button('SaveDraft',['class' => 'btn btn-success','id' => 'btn-savedraft-cycle']); ?>
                            <?= Html::button('Save',['class' => 'btn btn-success','id' => 'btn-save-cycle']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>

<?php
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        //'closeButton' => false,
]);
?>
<div id="data"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php Modal::end(); ?>

<?php
$script1 = <<< JS
$(document).ready(function () {
    var status = $("#tbdrugset-drugset_status").val();
    if(status == '1' || status == ''){
        document.getElementById("btn-save-cycle").disabled = true;
    }else{
        document.getElementById("btn-savedraft-cycle").disabled = true;
    }
});
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemos/standard/delete-drugsetdetail',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#drugdetdetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#drugdetdetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

JS;
$this->registerJs($script1);
?>
