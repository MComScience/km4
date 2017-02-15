<?php
namespace backend\controllers;
use PDO;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * Site controller
 */
class SiteController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */

    public function actionTest(){
        $connection = \Yii::$app->db2;
   $model = $connection->createCommand('select * from KM4GETPTOPD');
$model2 = $connection->createCommand('select * from KM4GETPATENT');
        $model3 = $connection->createCommand('select * from KM4GETREFER ');
 $model4 = $connection->createCommand('select * from KM4GETPTIPD ');
	$model5 = $connection->createCommand('select * from KM4GETPTADMIT');
        $users = $model->queryOne();
		$users2 = $model2->queryOne();
		$users3 = $model3->queryOne();
		$users4 = $model4->queryOne();
		$users5 = $model5->queryOne();
        print_r($users);
		print_r($users2);
		print_r($users3);
		print_r($users4);
		print_r($users5);
     
      
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
       $this->layout='main2';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
