<?php

namespace app\modules\AuthenticationandFinance\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
    
       public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}
