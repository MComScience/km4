<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="jumbotron">
      <h1><?=Html::img(Url::base().'/images/Minion_icon.png')?><?= Html::encode($this->title) ?></h1>
      <p class="text-danger"><?= nl2br(Html::encode($message)) ?></p>
</div>
