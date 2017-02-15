<?php
use yii\helpers\Html;
?>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    echo \yii2mod\alert\Alert::widget([
        'useSessionFlash' => false,
        'options' => [
            'timer' => null,
            'type' => \yii2mod\alert\Alert::TYPE_SUCCESS,
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'closeOnConfirm' => true,
            'showCancelButton' => false,
        ],
    ]);
    ?>
<?php endforeach; ?>