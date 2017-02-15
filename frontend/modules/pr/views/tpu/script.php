<?php

use yii\helpers\Url;

$action = Yii::$app->controller->action->id;
?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/loadding.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

<?php

if ($action == 'update') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/tpu/update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php

if ($action == 'verify-pr') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/tpu/verify-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>

<?php

if ($action == 'update-reject-verify') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/tpu/update-reject-verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>
<?php

if ($action == 'approve-pr') :
    $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/tpu/approve-pr.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
endif;
?>
