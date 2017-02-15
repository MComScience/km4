<?php
$action = Yii::$app->controller->action->id;
?>
<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/po/loadding.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

if ($action == 'update') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/po/update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if (($action == 'verify') || ($action == 'view-verify')) :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/po/verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if ($action == 'reject') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/po/reject-verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if (($action == 'approve-po') || ($action == 'view-approve') || ($action == 'update-approve')) :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/po/approve-po.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>
