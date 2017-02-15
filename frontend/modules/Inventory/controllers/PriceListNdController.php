<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\VwQuPricelist;
use app\modules\Inventory\models\VwQuPricelistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PriceListController implements the CRUD actions for VwQuPricelist model.
 */
class PriceListNdController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VwQuPricelist models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $user_id = Yii::$app->user->identity->profile->user_id;
        $searchModel = new VwQuPricelistSearch();
        $dataProvider = $searchModel->SearchPriceListND(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VwQuPricelist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VwQuPricelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VwQuPricelist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ids_qu]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit()
    {   
        $ids_qu = $_POST['ids_qu'];
        $modeledit = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$ids_qu]);
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$ids_qu]);
        $modeltbitempricelist = \app\modules\Inventory\models\TbItemPricelist::findOne(['ItemID'=>$modeledit['ItemID']]);
        $modelpack = new \app\modules\Inventory\models\Tbpackunit();
         $Item = \app\modules\Inventory\models\VwItemListNd::findOne(['ItemID' => $modeltbitempricelist['TMTID_TPU']]);
        $QTY = $modeledit['QUOrderQty'];
        $UNITCOST = $modeledit['QUUnitCost'];
        $Sum = $QTY*$UNITCOST;
        $tempDocs = $model->QUAttachment;
        if ($modeledit->load(Yii::$app->request->post())) {
            
        } else {
             return $this->renderAjax('_update_detailnd', [
                            'model'=>$model,
                            'modeledit' => $modeledit,
                            'modeltbitempricelist'=>$modeltbitempricelist,
                            'modelpack'=>$modelpack,
                            'ItemID' => $modeltbitempricelist['TMTID_TPU'],
                            'ItemName'=> $modeltbitempricelist['ItemName'],
                            'ItemPackSKUQty' => $modeledit['QUItemPackSKUID'],
                            'ItemUnit' => $Item['DispUnit'],
                            'QUExtenedCost' => $Sum,
                            'PackUnit' => $modeledit['QUPackUnit'],
                            'QUAttachmentPath' =>$model['QUAttachmentPath'],
                            'ids_qu'=>$ids_qu,
                ]);
        }
    }
    public function actionDownload($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttachment)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/price-list-nd/index', 'id' => $id]);
        }
    }  
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ids_qu]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionActive(){
         $ids_qu = $_POST['ids_qu'];
         $sql = "update tb_qu_pricelist set QUItemNumStatusID = 3 WHERE tb_qu_pricelist.ids_qu = $ids_qu;";
         $query = Yii::$app->db->createCommand($sql)->execute();
         echo 'updatesuccess';
    }
    public function actionNotActive(){
         $ids_qu = $_POST['ids_qu'];
         $sql = "update tb_qu_pricelist set QUItemNumStatusID = 2 WHERE tb_qu_pricelist.ids_qu = $ids_qu;";
         $query = Yii::$app->db->createCommand($sql)->execute();
         echo 'updatesuccess';
    }
    /**
     * Deletes an existing VwQuPricelist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VwQuPricelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwQuPricelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwQuPricelist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
