<?php

use yii\web\JqueryAsset;

?>
<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/report/report.js', [
    'depends' => [JqueryAsset::className()]
]);
?>