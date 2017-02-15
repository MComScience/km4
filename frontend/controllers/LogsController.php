<?php

namespace frontend\controllers;
use Yii;
use dektrium\user\models\log\LoginForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use chrmorandi\jasper\Jasper;

class LogsController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        'roles' => ['Admin', 'SuperAdmin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find(),
            'sort' => ['defaultOrder' => ['log_id' => SORT_DESC]],
        ]);

        return $this->render('index', [
                    'data' => $data
        ]);
    }

    public function actionReport() {
        // Set alias for sample directory
        Yii::setAlias('example', '@web/report');

        /* @var $jasper Jasper */
        $jasper = new \chrmorandi\jasper\Jasper();

        // Compile a JRXML to Jasper
        $jasper->compile(Yii::getAlias('@example') . '/hello_world.jrxml')->execute();

        // Process a Jasper file to PDF and RTF (you can use directly the .jrxml)
        $jasper->process(Yii::getAlias('@example') . '/hello_world.jasper', [
            'php_version' => '7.0'
                ], [
            'pdf',
           // 'rtf'
                ], false, false)->execute();

        // List the parameters from a Jasper file.
        $array = $jasper->listParameters(Yii::getAlias('@example') . '/hello_world.jasper')->execute();

        // return pdf file
        Yii::$app->response->sendFile(Yii::getAlias('@example') . '/hello_world.pdf');
    }

}
