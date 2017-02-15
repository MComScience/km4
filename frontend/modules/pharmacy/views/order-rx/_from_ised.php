<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_ised',
            'method' => 'post',
            'action' => Url::to(['save-cpoedetail']),
        ]);
?>
<h5 class="success">
    <b><?= Html::encode('ItemDetail :') ?></b>
</h5>
<ul class="list-group">
    <li class="list-group-item" style="background-color: #f5f5f5">
        <span class="text"><text class="ItemName"></text></span>
    </li>
</ul>
<div class="form-group isedreason1" style="display: none;">
    <h4 class="success"><?= Html::encode('เหตุผลยานอกบัญชีหลักแห่งชาติ'); ?></h4>
    <div class="col-xs-6 col-md-1"></div>
    <div class="col-xs-12 col-sm-6 col-md-11">
        <div class="radio">
            <?php foreach ($IsedModel as $reason) : ?>
                <p><label><input type="radio"   name="isedreason" id="<?= 'ised' . $reason->ised_reason_code; ?>" value="<?= $reason->ised_reason_code; ?>" class="inverted ised-reason-code"><span class="text"> <?= Html::encode($reason->ised_reason_decs) ?></span></label></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <div class="col-sm-1"></div>
        <div class="col-lg-4">
            <div id="msgised2"></div>
        </div>
    </div>
</div>
<div class="form-group isedreason2" style="display: none;">
    <h4 class="success"><?= Html::encode('ยืนยันการใช้ยาเสพติด'); ?></h4>
    <div class="col-xs-6 col-md-1"></div>
    <div class="col-xs-12 col-sm-6 col-md-11">
        <div class="checkbox">
            <label><input id="cpoe_narcotics_confirmed" type="checkbox" name="cpoe_narcotics_confirmed"  value="" class="inverted"><span class="text"><?= Html::encode('ยืนยัน'); ?></span></label>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-4" style="text-align: center;">
        <?= Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'backsteb1']) ?>
        <?= Html::resetButton('<i class="glyphicon glyphicon-repeat"></i> ' . 'Clear', ['class' => 'btn btn-danger', 'id' => 'clearstebised']) ?>
        <?= Html::button('Next ' . '<i class="glyphicon glyphicon-chevron-right"></i>', ['class' => 'btn btn-default', 'id' => 'nextstebised', 'disabled' => true]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    //ปุ่มกลับ
    $("button[id=backsteb1]").click(function () {
        //Clear Steb 2
        $('#msgised2').html('');
        $('#simplewizardstep2').removeClass('active');//AddClass Steb
        $("li[id=simplewizardstep2]").css("display", "none");//Show Steb 2
        $('div[id=numbersteb2]').html(''); //Setnumber Steb
        $('#content2').removeClass('active');
        $('#content1').addClass('active');
        $('#form_ised').trigger("reset"); //Reset Form id = form_ised
        $('#form_cpoedetail').trigger("reset"); //Reset Form id = form_cpoedetail
    });
    //ปุ่ม Next
    $("button[id=nextstebised]").click(function () {
        $('#content2').removeClass('active');
        $('#content3').addClass('active');
        $('#simplewizardstep3').addClass('active');//AddClass Steb
        $('div[id=numbersteb3]').html('3'); //Setnumber Steb
        $("li[id=simplewizardstep3]").css("display", "block");//Show Steb 3
        ShowButtonSave();
    });
    /* ยืนยันการใช้ยาเสพติด */
    $("input[id=cpoe_narcotics_confirmed]").click(function () {
        if ($(this).is(":checked"))
        {
            $(this).val('1');
            $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val('1');
            $('#msgised2').html('');
            document.getElementById("nextstebised").disabled = false;
        } else {
            $('input[id=tbcpoedetail-cpoe_narcotics_confirmed]').val(null);
            $(this).val(null);
            document.getElementById("nextstebised").disabled = true;
        }
    });
    /* เหตุผลยานอกบัญชีหลักแห่งชาติ */
    $(".ised-reason-code").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-ised_reason]').val($(this).val());
            if ($('div.isedreason2').css('display') === 'block') { //ยืนยันการใช้ยาเสพติด
                $('input[name=cpoe_narcotics_confirmed]').each(function () {
                    if ($(this).is(':checked')) {
                        document.getElementById("nextstebised").disabled = false;
                    } else {
                        $('#msgised2').html('<div class="alert alert-warning fade in"><i class="fa-fw fa fa-warning"></i><strong>Warning</strong> กรุณายืนยันการใช้ยาเสพติด.</div>');
                    }
                });
            } else {
                document.getElementById("nextstebised").disabled = false;
            }
        } else {
            $('input[id=tbcpoedetail-ised_reason]').val(null);
        }
    });

    $('#Savecpoedetail').click(function (e) {
        var frm = $('#form_ised');
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Save Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                            }
                        });
            }
        });
    });
    /*  เลือกยากลับบ้าน  */
    $("input[id=cpoetype10]").click(function () {
        if ($(this).is(":checked"))//ถ้า Checked 
        {
            $('input[id=Itemtype]').val($(this).val()); //Set Value ให้กับ Input
        } else {//ถ้าไม่ Checked 
            $('input[id=Itemtype]').val(null); //Set Value = Null
        }
    });
    /* เลือกยาใช้ในโรงพยาบาล */
    $("input[id=cpoetype20]").click(function () {
        if ($(this).is(":checked"))//ถ้า Checked 
        {
            $('input[id=Itemtype]').val($(this).val()); //Set Value ให้กับ Input
        } else {//ถ้าไม่ Checked 
            $('input[id=Itemtype]').val(null); //Set Value = Null
        }
    });
</script>