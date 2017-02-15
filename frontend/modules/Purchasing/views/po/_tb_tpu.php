<?php
use yii\helpers\Html;
?>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('เลือกรายการยาการค้า') ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <?php
                    echo $tb;
                    ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tableSelectTPU').DataTable({
            "pageLength": 10,
            responsive: true,
        });
    });
</script>