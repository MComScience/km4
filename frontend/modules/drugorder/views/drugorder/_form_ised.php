<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="col-xs-12 col-sm-6 col-md-12">
    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'id' => 'form_ised',
    ]);
    ?>

    <ul class="list-group">
        <li class="list-group-item" style="background-color: #ddd">
            <b><?= Html::encode('Item Detail : '); ?></b><span class="text"><text id="itemdetail"></text></span>
        </li>
    </ul>
    <div class="form-group isedreason1" style="display: none;">
        <h4 class="success"><?= Html::encode('เหตุผลยานอกบัญชีหลักแห่งชาติ'); ?></h4>
        <div class="col-xs-6 col-md-1"></div>
        <div class="col-xs-12 col-sm-6 col-md-11">
            <div class="radio">
                <?php
                $model;
                foreach ($isedreason as $reason) :
                    ?>
                    <label><input type="radio"   <?= $model->ised_reason == $reason->ised_reason_code ? 'checked=""' : '' ?> name="isedreason" id="<?= 'ised' . $reason->ised_reason_code; ?>" value="<?= $reason->ised_reason_code; ?>"><span class="text"> <?= Html::encode($reason->ised_reason_decs) ?></span></label><p></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div id="msgised2"></div>
            </div>
        </div>
    </div>
    <div class="form-group isedreason2" style="display: none;">
        <h4 class="success"><?= Html::encode('ยืนยันการใช้ยาเสพติด'); ?></h4>
        <div class="col-xs-6 col-md-1"></div>
        <div class="col-xs-12 col-sm-6 col-md-11">
            <div class="checkbox">
                <label><input id="cpoe_narcotics_confirmed" type="checkbox" name="cpoe_narcotics_confirmed" <?= $model['cpoe_narcotics_confirmed'] == 1 ? 'checked=""' : ''; ?> value=""><span class="text"><?= Html::encode('ยืนยัน'); ?></span></label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-4 col-md-offset-4" style="text-align: center;">
            <?= Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'backsteb1']) ?>
            <?= Html::button('<i class="glyphicon glyphicon-repeat"></i> ' . 'Clear', ['class' => 'btn btn-danger', 'id' => 'clearstebised']) ?>
            <?= Html::button('Next ' . '<i class="glyphicon glyphicon-chevron-right"></i>', ['class' => 'btn btn-default', 'id' => 'nextstebised']) ?>
            <?php // Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'submit']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    $("input[id=cpoe_narcotics_confirmed]").click(function () {
        if ($(this).is(":checked"))
        {
            $('#msgised2').html('');
            $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val('1');
            document.getElementById("nextstebised").disabled = false;
        } else {
            document.getElementById("nextstebised").disabled = true;
            $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val(null);
        }
    });

    $("input[name=isedreason]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-ised_reason]').val($(this).val());

            if ($('div.isedreason2').css('display') == 'block') { //ยืนยันการใช้ยาเสพติด
                $('input[name=cpoe_narcotics_confirmed]').each(function () {
                    if ($(this).is(':checked')) {
                        document.getElementById("nextstebised").disabled = false;
                    } else {
                        $('#msgised2').html('<div class="alert alert-warning fade in"><i class="fa-fw fa fa-warning"></i><strong>Warning</strong> กรุณายืนยันการใช้ยาเสพติด.</div>');
                        setTimeout(function () {
                            $('#msgised2').html('');
                        }, 2000);
                    }
                });
            } else {
                document.getElementById("nextstebised").disabled = false;
            }
        } else {
            $('input[id=tbcpoedetail-ised]').val(null);
        }
    });
    //ปุ่มกลับ
    $("button[id=backsteb1]").click(function () {
        //Clear Steb 2
        $('#simplewizardstep2').removeClass('active');//AddClass Steb
        $("li[id=simplewizardstep2]").css("display", "none");//Show Steb 2
        $('div[id=numbersteb2]').html(''); //Setnumber Steb
        $('#tabised').removeClass('active');
        $('#home11').addClass('active');
        $('#form_ised').trigger("reset"); //Reset Form id = form_ised
        $('#form_cpoedetail').trigger("reset"); //Reset Form id = form_cpoedetail
    });
    //ปุ่ม Next
    $("button[id=nextstebised]").click(function () {
        $('li.tabised ').removeClass('active');
        $('#tabised').removeClass('active');
        $("li.tabprofile11").css("display", "block");
        $('li.tabprofile11').addClass('active');
        $('#profile11').addClass('active');
        $('#simplewizardstep3').addClass('active');//AddClass Steb
        $('div[id=numbersteb3]').html('3'); //Setnumber Steb
        $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
    });
    //ปุ่ม Clear
    $("button[id=clearstebised]").click(function () {
        $('#form_ised').trigger("reset"); //Reset Form id = form_ised
        $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val(null);
        $('input[id=tbcpoedetail-ised]').val(null);
        document.getElementById("nextstebised").disabled = true;
    });
</script>
