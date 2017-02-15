<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbSt2;
use app\modules\Inventory\models\SearchTbst2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\Inventory\models\TbStitemdetail2Search;
use app\modules\Inventory\models\VwSt2DetailSub;

class Tbst2Controller extends Controller {

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
    public function actionIndex() {
        $searchModel = new SearchTbst2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    public function actionClickCancel(){
        if(isset($_POST['STID'])){
            $STID = $_POST['STID'];
            $findSTNum = \app\modules\Inventory\models\TbSt2::findOne(['STID'=>$STID]);
            Yii::$app->db->createCommand('CALL cmd_st_stk_cancel_todraft(:x);')
                    ->bindParam(':x', $STID)
                    ->execute();
            Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'title' => 'Cancel!',
                    'message' => 'ยกเลิกใบโอนเลขที่ '.$findSTNum['STNum'].' เรียบร้อยแล้ว',
                ]);
            // Yii::$app->getSession()->setFlash('success', [
            //         'type' => 'success',
            //         'duration' => 5000,
            //         'icon' => 'fa fa-check-square-o',
            //         'title' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบโอนสินค้ารอรับเข้า')),
            //         'message' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบโอนสินค้ารอรับเข้า'.$findSTNum['STNum'].' เรียบร้อยแล้ว')),
            //         'positonY' => 'top',
            //         'positonX' => 'right'
            //     ]);
            return $this->redirect(['stock-wait']);
        }else{
            return false;
        }
        
    }
    public function actionStockReceive() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id'=>$userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $_SESSION['chk_type'] = 'receive';
        $searchModel = new SearchTbst2();
        $dataProvider = $searchModel->searchrecevie(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
		return $this->render('stock-receive', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionStockWait() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id'=>$userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $_SESSION['chk_type'] = 'wait_cancel';
        $searchModel = new SearchTbst2();
        $dataProvider = $searchModel->searchwait(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
		return $this->render('history-tranfer', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStockReceiveHistory() {
    	$userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id'=>$userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $searchModel = new SearchTbst2();
        $dataProvider = $searchModel->searchreceviehistory(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();

        return $this->render('stock-receive-history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new TbSt2();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->STID]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->STID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDetail($id, $status = '1') {

        $model = TbSt2::findOne($id);
        $model->STDate = Yii::$app->componentdate->convertMysqlToThaiDate2($model->STDate);
        if (Yii::$app->request->post()) {
            echo '1';
        } else {
            $searchModel = new \app\modules\Inventory\models\VwSt2DetailGroup2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            return $this->render('_detail', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'status' => $status
            ]);
        }
    }

    public function actionReciveData() {
        $post = Yii::$app->request->post('TbSt2');
        $STNum = $post['STNum'];
        $stdate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['STRecievedDate']);
        $save = TbSt2::findOne(['STNum' => $STNum]);
        $save->STRecievedDate = $stdate;
        $save->save();

        $user_id = Yii::$app->user->id;
        Yii::$app->db->createCommand('
                    CALL cmd_st2_stk_receive(:STNum,:userid);')
                ->bindParam(':STNum', $STNum)
                ->bindParam(':userid', $user_id)
                ->execute();
        Yii::$app->finddata->setmessage("Stock Receive " . $STNum . " Success fully");
        return 'full';
    }

    public function actionExtPen() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {

            $model = \app\modules\Inventory\models\VwSt2DetailSub2::findAll(['ids_sr' => $pos['expandRowKey']]);
            return $this->renderAjax('expenlot', ['lotnumber' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    protected function findModel($id) {
        if (($model = TbSt2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
