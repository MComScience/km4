<?php

$action = Yii::$app->controller->action->id;
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/loadding.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<?php

if ($action == 'update' || $action == 'view') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/nd-cont/update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if ($action == 'verify-pr' || $action == 'view-verify') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/nd-cont/verify-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if ($action == 'update-reject-verify' || $action == 'view-reject-verify') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/nd-cont/update-reject-verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;

if ($action == 'approve-pr') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/nd-cont/approve-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>