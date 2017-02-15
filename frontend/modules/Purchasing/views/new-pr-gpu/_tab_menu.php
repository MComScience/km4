<?php

use yii\helpers\Html;

$VwPrStatusCount = app\modules\Purchasing\models\VwPr2Prstatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-warning" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('บันทึกใบขอซื้อนอกแผน') ?> <span ><?php // echo '(' . $VwPo2Postatuscount[0]['POStatusCount'] . ')'; ?></span>
            </a>
        </li>
    </ul>
<?php /*
  <div class="btn-group">
  <a href="index" class="btn btn-default btn-lg" id="tab_index" role="button">รายการใบขอชื้อ
  <span class="badge"><?php echo $VwPrStatusCount[0]['PRStatusCount']; ?></span>
  </a>
  <a href="list-verify" class="btn btn-default btn-lg" id="list-verify" role="button">ใบขอซื้อรอการทวนสอบ
  <span class="badge"><?php echo $VwPrStatusCount[1]['PRStatusCount']; ?></span>
  </a>
  <a href="list-reject-verify" class="btn btn-default btn-lg" id="list-reject-verify" role="button">ใบขอชื้อไม่ผ่านการทวนสอบ
  <span class="badge"><?php echo $VwPrStatusCount[3]['PRStatusCount']; ?></span>
  </a>
  <a href="list-wating-approve" class="btn btn-default btn-lg" id="list-wating-approve" role="button">ใบขอชื้อรอการอนุมัติ
  <span class="badge"><?php echo $VwPrStatusCount[4]['PRStatusCount']; ?></span>
  </a>
  <a href="list-reject-approve" class="btn btn-default btn-lg" id="list-reject-approve" role="button">ใบขอชื้อไม่ผ่านการอนุมัติ
  <span class="badge"><?php echo $VwPrStatusCount[5]['PRStatusCount']; ?></span>
  </a>
  <a href="list-approve" class="btn btn-default btn-lg" id="list-approve" role="button">ใบขอชื้อผ่านการอนุมัติ
  <span class="badge"><?php echo $VwPrStatusCount[10]['PRStatusCount']; ?></span>
  </a>
  </div>
 * 
 */ ?>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
JS;
$this->registerJs($script);
?>