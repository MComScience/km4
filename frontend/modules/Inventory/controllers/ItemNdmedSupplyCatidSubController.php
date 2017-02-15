<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbItemndmedsupplycatidSub;
use app\modules\Inventory\models\TbItemndmedsupply;
use app\modules\Inventory\models\Model;
use app\modules\Inventory\models\TbItemndmedsupplycatidSubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/**
 * ItemNdmedSupplyCatidSubController implements the CRUD actions for TbItemndmedsupplycatidSub model.
 */
class ItemNdmedSupplyCatidSubController extends Controller
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
     * Lists all TbItemndmedsupplycatidSub models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbItemndmedsupplycatidSubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single TbItemndmedsupplycatidSub model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       $model = $this->findModel($id);
    //   $modelsItemndmedsupply = TbItemndmedsupply::find()->where(['ItemNDMedSupplyCatID_sub'=>$model->ItemNDMedSupplyCatID_sub_id])->all();
       return $this->render('view', [
        'model' => $model,
      //  'modelsItemndmedsupply' => (empty($modelsItemndmedsupply)) ? [new TbItemndmedsupply] : $modelsItemndmedsupply,
        'type'=>'view'
        ]);
   }
   public function actionExtPen() {
     $ItemNDMedSupplyCatID_sub = Yii::$app->request->post('expandRowKey');
     $data = TbItemndmedsupply::findAll(['ItemNDMedSupplyCatID_sub' => $ItemNDMedSupplyCatID_sub]);
     $query = TbItemndmedsupply::find()->where(['ItemNDMedSupplyCatID_sub' => $ItemNDMedSupplyCatID_sub]);
     $provider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
        'pageSize' => 10,
        ],
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_DESC,
//                    'title' => SORT_ASC,
//                ]
//            ],
        ]);

     if ($data != "") {
        return $this->renderAjax('ext-pen', [
            'data' => $data,
            'dataProvider' => $provider
            ]);
    } else {
        echo 'ไม่มีรายการ';
    }
}
    /**
     * Creates a new TbItemndmedsupplycatidSub model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TbItemndmedsupplycatidSub();
     //   $modelsItemndmedsupply= [new TbItemndmedsupply];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         /*  $modelsItemndmedsupply = Model::createMultiple(TbItemndmedsupply::classname());
           Model::loadMultiple($modelsItemndmedsupply, Yii::$app->request->post());


            // validate all models
           $valid = $model->validate();
           $valid = Model::validateMultiple($modelsItemndmedsupply) && $valid;

           if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    foreach ($modelsItemndmedsupply as $modelsItemndmedsupply) {
                        $modelsItemndmedsupply->ItemNDMedSupplyCatID_sub = $model->ItemNDMedSupplyCatID_sub_id;
                        if (! ($flag = $modelsItemndmedsupply->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['index']);
                    //return $this->redirect(['view', 'id' => $model->ItemNDMedSupplyCatID_sub_id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }*/
        return $this->redirect(['index']);

    } else {
        return $this->render('create', [
            'model' => $model,
          /*  'modelsItemndmedsupply' => (empty($modelsItemndmedsupply)) ? [new TbItemndmedsupply] : $modelsItemndmedsupply,*/
            'type'=>'create'
            ]);
    }
}

    /**
     * Updates an existing TbItemndmedsupplycatidSub model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       // $modelsItemndmedsupply = TbItemndmedsupply::find()->where(['ItemNDMedSupplyCatID_sub'=>$model->ItemNDMedSupplyCatID_sub_id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
         /*  $oldIDs = ArrayHelper::map($modelsItemndmedsupply, 'ItemNDMedSupplyCatID', 'ItemNDMedSupplyCatID');
           $modelsItemndmedsupply = Model::createMultiple(TbItemndmedsupply::classname(), $modelsItemndmedsupply);
           Model::loadMultiple($modelsItemndmedsupply, Yii::$app->request->post());
           $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItemndmedsupply, 'ItemNDMedSupplyCatID', 'ItemNDMedSupplyCatID')));

            // ajax validation
           if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ArrayHelper::merge(
                ActiveForm::validateMultiple($modelsItemndmedsupply),
                ActiveForm::validate($model)
                );
        }

            // validate all models
        $valid = $model->validate();
        $valid = Model::validateMultiple($modelsItemndmedsupply) && $valid;

        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    if (! empty($deletedIDs )) {
                        TbItemndmedsupply::deleteAll(['ItemNDMedSupplyCatID' => $deletedIDs]);
                    }
                    foreach ($modelsItemndmedsupply as $modelsItemndmedsupply) {
                        $modelsItemndmedsupply->ItemNDMedSupplyCatID_sub = $model->ItemNDMedSupplyCatID_sub_id;
                        if (! ($flag = $modelsItemndmedsupply->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['index']);
                   // return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

*/
         return $this->redirect(['index']);
       // return $this->redirect(['view', 'id' => $model->id]);
    }  else {
        return $this->render('update', [
            'model' => $model,
           // 'modelsItemndmedsupply' => (empty($modelsItemndmedsupply)) ? [new TbItemndmedsupply] : $modelsItemndmedsupply
            ]);
    }
}

    /**
     * Deletes an existing TbItemndmedsupplycatidSub model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        //TbItemndmedsupply::deleteAll(['ItemNDMedSupplyCatID_sub' => $id]);
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the TbItemndmedsupplycatidSub model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbItemndmedsupplycatidSub the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbItemndmedsupplycatidSub::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
