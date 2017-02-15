<?php

use yii\helpers\Html;
?>
<div class="checkbox">
    <?= Html::tag('span', 'ตรวจสอบยอดเกินแผน', ['class' => 'text']) ?>
    <label>
        <?= Html::input('text', 'alert', '', ['type' => 'checkbox', 'id' => 'checkbox-alert', 'class' => 'checkbox-slider toggle colored-palegreen']) ?>
        <?= Html::tag('span', '', ['class' => 'text']) ?>
    </label>
</div>
<?php if ($action == 'update-detail-gpu') : ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if (readCookie("alerton") != null) {
                if (readCookie("alerton") == "true") {
                    $('#checkbox-alert').prop('checked', true);
                    $('#checkform-submit').val(null);
                } else {
                    $('#checkbox-alert').prop('checked', false);
                    $('#checkform-submit').val('pass');
                }
            } else {
                $('#checkform-submit').val('pass');
            }
            $("#checkbox-alert").click(function () {
                if (($(this).is(":checked"))) {
                    //$(this).toggleClass('alerton');
                    $('#checkform-submit').val(null);
                    createCookie("alerton", $(this).is(':checked'), 1);
                    //localStorage.setItem("alertplan", "true");
                } else {
                    //localStorage.removeItem("alertplan");
                    $('#checkform-submit').val('pass');
                    createCookie("alerton", $(this).is(':checked'), 0);
                }
            });
        });
    </script>
<?php endif; ?>

<?php if ($action == 'update-verify-gpu') : ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if (readCookie("alerton-verify") != null) {
                if (readCookie("alerton-verify") == "true") {
                    $('#checkbox-alert').prop('checked', true);
                    $('#checkform-submit').val(null);
                } else {
                    $('#checkbox-alert').prop('checked', false);
                    $('#checkform-submit').val('pass');
                }
            }
            $("#checkbox-alert").click(function () {
                if (($(this).is(":checked"))) {
                    //$(this).toggleClass('alerton');
                    $('#checkform-submit').val(null);
                    createCookie("alerton-verify", $(this).is(':checked'), 1);
                    //localStorage.setItem("alertplan", "true");
                } else {
                    //localStorage.removeItem("alertplan");
                    $('#checkform-submit').val('pass');
                    createCookie("alerton-verify", $(this).is(':checked'), 0);
                }
            });
        });
    </script>
<?php endif; ?>
