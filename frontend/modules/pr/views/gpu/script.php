<?php
$action = Yii::$app->controller->action->id;
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/loadding.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<!-- Action Update -->
<?php
if ($action == 'update') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/gpu/update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php
if ($action == 'verify-pr'):
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/gpu/verify-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php
if ($action == 'update-reject-verify') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/gpu/update-reject-verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php
if ($action == 'approve-pr') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/gpu/approve-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php if ($action == 'approve') : ?>
    <?php 
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/gpu/prints.js', ['depends' => [\yii\web\JqueryAsset::className()]]);  
    ?>
<?php endif; ?>

