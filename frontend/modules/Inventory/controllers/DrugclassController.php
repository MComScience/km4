<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbDrugclass;
use app\modules\Inventory\models\TbDrugclassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\Inventory\models\TbDrugsubclass;
use app\modules\Inventory\models\Modeldrugclass;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * DrugclassController implements the CRUD actions for TbDrugclass model.
 */
class DrugclassController extends Controller
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
     * Lists all TbDrugclass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TbDrugclassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single TbDrugclass model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $model = $this->findModel($id);
       //$modelsDrugsubclass = TbDrugsubclass::find()->where(['DrugClassID'=>$model->DrugClassID])->all();
       return $this->render('view', [
        'model' => $model,
       // 'modelsDrugsubclass' => (empty($modelsDrugsubclass)) ? [new TbDrugsubclass] : $modelsDrugsubclass,
        'type'=>'view'
        ]);
    }

    /**
     * Creates a new TbDrugclass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TbDrugclass();
     //   $modelsDrugsubclass= [new TbDrugsubclass];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        /* $modelsDrugsubclass = Modeldrugclass::createMultiple(TbDrugsubclass::classname());
         Modeldrugclass::loadMultiple($modelsDrugsubclass, Yii::$app->request->post());
            // validate all models
         $valid = $model->validate();
         $valid = Modeldrugclass::validateMultiple($modelsDrugsubclass) && $valid;

         if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    foreach ($modelsDrugsubclass as $modelsDrugsubclass) {
                        $modelsDrugsubclass->DrugClassID = $model->DrugClassID;
                        if (! ($flag = $modelsDrugsubclass->save(false))) {
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
           // 'modelsDrugsubclass' => (empty($modelsDrugsubclass)) ? [new TbDrugsubclass] : $modelsDrugsubclass,
            'type'=>'create'
            ]);
    }
}
public function actionExtPen() {
 $DrugClassID = Yii::$app->request->post('expandRowKey');
 $data = TbDrugsubclass::findAll(['DrugClassID' => $DrugClassID]);
 $query = TbDrugsubclass::find()->where(['DrugClassID' => $DrugClassID]);
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
     * Updates an existing TbDrugclass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       // $modelsDrugsubclass = TbDrugsubclass::find()->where(['DrugClassID'=>$id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             /*$oldIDs = ArrayHelper::map($modelsDrugsubclass, 'DrugSubClassID', 'DrugSubClassID');

           $modelsDrugsubclass = Modeldrugclass::createMultiple(TbDrugsubclass::classname(), $modelsDrugsubclass);
           Modeldrugclass::loadMultiple($modelsDrugsubclass, Yii::$app->request->post());
           $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsDrugsubclass, 'DrugSubClassID', 'DrugSubClassID')));
          
            // ajax validation
           if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ArrayHelper::merge(
                ActiveForm::validateMultiple($modelsDrugsubclass),
                ActiveForm::validate($model)
                );
        }

            // validate all models
        $valid = $model->validate();
        $valid = Modeldrugclass::validateMultiple($modelsDrugsubclass) && $valid;

        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    if (! empty($oldIDs)) {
                        TbDrugsubclass::deleteAll(['DrugSubClassID' => $oldIDs]);
                    }
                    foreach ($modelsDrugsubclass as $modelsDrugsubclass) {
                        $modelsDrugsubclass->DrugClassID = $model->DrugClassID;
                        if (! ($flag = $modelsDrugsubclass->save(false))) {
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
        }*/
        return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
               // 'modelsDrugsubclass' => (empty($modelsDrugsubclass)) ? [new TbDrugsubclass] : $modelsDrugsubclass
                ]);
        }
    }

    /**
     * Deletes an existing TbDrugclass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
       // TbDrugsubclass::deleteAll(['DrugClassID' => $id]);
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the TbDrugclass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbDrugclass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbDrugclass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
