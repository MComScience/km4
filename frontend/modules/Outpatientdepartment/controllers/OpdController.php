<?php

namespace app\modules\Outpatientdepartment\controllers;

class OpdController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
