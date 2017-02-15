<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>
<?php 
Modal::begin([
    'header' => '<h4 class="modal-title"></h4>',
    'id' => 'modal_report',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
]);
echo '<div id="modal-content"></div>';
Modal::end();?>