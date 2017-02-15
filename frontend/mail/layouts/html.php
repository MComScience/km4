<?php

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div style="border: solid 1px rgb(236, 236, 236);border-radius: 5px;padding: 20px;">
            <?= $content ?>
        </div>
<!--        <p style="text-align:right;margin-top:5px;"> โรงพยาบาลมะเร็งอุดรธานี <small ><i>Tel 042-207375-80</i></small></p>-->

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>