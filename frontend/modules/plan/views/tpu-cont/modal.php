<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\assets\ModalFullScreenAsset;
use frontend\assets\DataTableAsset;
use johnitvn\ajaxcrud\CrudAsset;

ModalFullScreenAsset::register($this);
DataTableAsset::register($this);
CrudAsset::register($this);
?>
<?php

Modal::begin([
    'id' => 'modal-table-tpu',
    'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
    'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
]);
?>
<?php echo '<div id="contenttabletpu"></div>'; ?>
<?php Modal::end(); ?>

<?php

Modal::begin([
    'id' => 'tpu-modal',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
        //'closeButton' => false,
]);
?>
<?php echo '<div id="contentfrom"></div>'; ?>
<?php Modal::end(); ?>

<?php

Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>