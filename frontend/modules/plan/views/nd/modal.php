<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\assets\ModalFullScreenAsset;
use frontend\assets\DataTableAsset;

ModalFullScreenAsset::register($this);
DataTableAsset::register($this);
?>
<?php

Modal::begin([
    'id' => 'modal-table-nd',
    'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
]);
?>
<?php echo '<div id="contenttablend"></div>'; ?>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'nd-modal',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
        //'closeButton' => false,
]);
?>
<?php echo '<div id="contentfrom"></div>'; ?>
<?php Modal::end(); ?>