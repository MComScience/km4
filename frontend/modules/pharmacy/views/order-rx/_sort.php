<?php

use kartik\sortinput\SortableInput;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-sort', 'action' => Url::to(['save-sort'])]); ?>
<div class="form-group">
    <?= Html::activeLabel($model, 'cpoe_seq', ['label' => false, 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-8">
        <?=
        $form->field($model, 'cpoe_seq', ['showLabels' => false])->widget(SortableInput::classname(), [
            'items' => $items,
            'hideInput' => true,
            'options' => ['class' => 'form-control', 'readonly' => true],
            'sortableOptions' => [
                'itemOptions' => ['class' => 'alert alert-success'],
                'connected' => true,
            ],
        ]);
        ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-primary confirm ladda-button', 'data-style' => 'slide-left']) ?>  

    </div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    $('#form-sort').on('beforeSubmit', function (e)
    {
        var form = $(this);
        var l = $('.confirm').ladda();
        l.ladda('start');
        $.post(
                form.attr('action'), // serialize Yii2 form
                form.serialize()
                )
                .done(function (result) {
                    swal({
                        title: "Sort Success!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#53a93f",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        confirmButtonText: "OK",
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $('#ajaxCrudModal').modal('hide');
                                   l.ladda('stop');
                                   $.pjax({container: '#cpoedetail-pjax'});
                                }
                            });
                })
                .fail(function (xhr, status, error)
                {
                    l.ladda('stop');
                    swal("Oops...", error, "error");
                    console.log(error);
                });
        return false;
    });
    $(".sortable").sortable({
        start: function (event, ui) {
            var currPos1 = ui.item.index();
        },
        change: function (event, ui) {
            var currPos2 = ui.item.index();
        },
        update: function (event, ui) {
            var currPos2 = ui.item.index();
            $('#textsort').val(ui.item.data('key') + ',' + (parseInt(currPos2) + parseInt(1)));
        }
    });
</script>

