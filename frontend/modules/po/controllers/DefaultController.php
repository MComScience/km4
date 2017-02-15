<?php

namespace app\modules\po\controllers;

use Yii;
use app\modules\po\models\TbPo2Temp;
use app\modules\po\models\TbPo2TempSearch;
use app\modules\po\models\TbPo2Search;
use app\modules\po\models\VwPr2ListForPo2Search;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pr\models\TbPr2;
use app\modules\po\models\TbPo2;
use dektrium\user\models\Profile;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use app\modules\po\models\TbPoitemdetail2Temp;
use app\modules\po\models\TbPoitemdetail2;
use app\modules\pr\models\VwItemListTpu;
use app\modules\po\models\VwPo2DetailNew;
use app\modules\pr\models\TbItempack;
use app\modules\Purchasing\models\TbItem;
use kartik\grid\GridView;
use app\modules\po\models\VwItemndToPodetail;
use app\modules\pr\models\VwItemList;
use yii\data\SqlDataProvider;
use app\modules\pr\models\VwStkStatusSearch;
use app\modules\pr\models\VwQuPricelistSearch;
use app\modules\pr\models\VwPurchasingHistorySearch;
use app\modules\pr\models\VwGpustdCost;
use app\modules\po\models\VwPo2Header;
use app\modules\po\models\VwPo2Header2;
use app\modules\po\models\VwPo2Detail2New;
use app\modules\po\models\VwGr2DetailReceived;
use app\modules\po\models\TbGritemdetail2;
use app\modules\po\models\TbGritemdetail2Temp;
use app\modules\po\models\TbGr2;
use app\modules\po\models\TbItemlotnum2Temp;
use app\modules\pr\models\TbPritemdetail2;
use app\modules\po\models\TbGr2Temp;
use app\modules\po\models\VwPoStatus;
use app\modules\pr\models\VwItemListGpuplanAvalible;

/**
 * DefaultController implements the CRUD actions for TbPo2Temp model.
 */
class DefaultController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TbPo2Temp models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwPr2ListForPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = false;
        TbPo2Temp::deleteAll(['PONum' => null, 'POCreateBy' => Yii::$app->user->getId()]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDraft() {
        $searchModel = new TbPo2TempSearch();
        $dataProvider = $searchModel->search_draft(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = false;

        return $this->render('draft', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitingVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 2);
        $dataProvider->pagination->pageSize = false;

        return $this->render('waiting-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitingApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 10);
        $dataProvider->pagination->pageSize = false;

        return $this->render('waiting-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRejectVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 4);
        $dataProvider->pagination->pageSize = false;

        return $this->render('reject-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 2);
        $dataProvider->pagination->pageSize = false;

        return $this->render('list-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 10);
        $dataProvider->pagination->pageSize = false;

        return $this->render('list-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRejectApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 6);
        $dataProvider->pagination->pageSize = false;

        return $this->render('reject-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post(), 11);
        $dataProvider->pagination->pageSize = false;

        return $this->render('approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrderStatus() {
        $query1 = VwPoStatus::find()
                ->where('PRNum NOT LIKE :query')
                ->addParams([':query' => 'วชย%'])
                ->all();
        $query2 = VwPoStatus::find()
                ->where('PRNum LIKE :query')
                ->addParams([':query' => 'วชย%'])
                ->all();
        return $this->render('order-status', [
                    'query1' => $query1,
                    'query2' => $query2,
        ]);
    }

    /**
     * Displays a single TbPo2Temp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbPo2Temp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($data) {

        if (($modelPR = TbPr2::findOne($data)) !== null) {
            $maxtemp = TbPo2Temp::find()->max('POID');
            $max = TbPo2::find()->max('POID');
            if ($maxtemp > $max) {
                $maxid = $maxtemp + 1;
            } else if ($maxtemp == $max) {
                $maxid = $max + 1;
            } else {
                $maxid = $max + 1;
            }
            $userid = Yii::$app->user->getId();
            Yii::$app->db->createCommand('CALL cmd_po2_create_header_detail(:x,:POID,:POCreateBy);')
                    ->bindParam(':x', $data)
                    ->bindParam(':POID', $maxid)
                    ->bindParam(':POCreateBy', $userid)
                    ->execute();
            return $this->redirect(['update', 'data' => $maxid]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing TbPo2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($data) {
        $model = $this->findModel($data);
        if ($model->load(Yii::$app->request->post())) {
            $posted = Yii::$app->request->post();
            $POExtendedCost = TbPoitemdetail2Temp::find()
                    ->where(['POID' => $posted['TbPo2Temp']['POID'], 'POItemType' => 1])
                    ->sum('POExtenedCost');
            $model->PONum = empty($posted['TbPr2']['PRNum']) ? null : $posted['TbPr2']['PRNum'];
            $model->PODate = empty($posted['TbPo2Temp']['PODate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['TbPo2Temp']['PODate']);
            $model->POContID = empty($posted['TbPo2Temp']['POContID']) ? null : $posted['TbPo2Temp']['POContID'];
            $model->PODueDate = empty($posted['TbPo2Temp']['PODueDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['TbPo2Temp']['PODueDate']);
            $model->VendorID = empty($posted['TbPo2Temp']['VendorID']) ? null : $posted['TbPo2Temp']['VendorID'];
            $model->Menu_VendorID = empty($posted['TbPo2Temp']['Menu_VendorID']) ? null : $posted['TbPo2Temp']['Menu_VendorID'];
            $model->POStatus = 1;
            $model->POTotal = $POExtendedCost;
            $model->save();
            TbPoitemdetail2Temp::updateAll(['PONum' => $posted['TbPr2']['PRNum'], 'POItemNumStatusID' => 1], ['=', 'POID', $posted['TbPo2Temp']['POID']]);
            return $posted['TbPr2']['PRNum'];
        } else {
            if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2Temp::find()
                            ->where(['POID' => $data, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2Temp::find()
                            ->where(['POID' => $data, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return $this->render('update', [
                            'model' => $model,
                            'modelPR' => $modelPR,
                            'dataProvider1' => $dataProvider1,
                            'dataProvider2' => $dataProvider2,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }

    /**
     * Deletes an existing TbPo2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Deleted!');
        return $this->redirect(['draft']);
    }

    /**
     * Finds the TbPo2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbPo2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbPo2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetVendor($type, $action) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query = Profile::find()->where(['UserCatID' => 2])->all();
                return [
                    'title' => $type == '1' ? 'เลือกผู้จำหน่าย' : 'เลือกผู้ผลิต',
                    'content' => $this->renderAjax('_vendor', [
                        'query' => $query,
                        'type' => $type,
                        'action' => $action,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSaveDraftPotemp() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $posted = $request->post('TbPo2Temp');
            $model = $this->findModel($posted['POID']);
            $model->PONum = empty($posted['PONum']) ? null : $posted['PONum'];
            $model->PODate = empty($posted['PODate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODate']);
            $model->POContID = empty($posted['POContID']) ? null : $posted['POContID'];
            $model->PODueDate = empty($posted['PODueDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODueDate']);
            $model->VendorID = empty($posted['VendorID']) ? null : $posted['VendorID'];
            $model->Menu_VendorID = empty($posted['Menu_VendorID']) ? null : $posted['Menu_VendorID'];
            $model->POStatus = 1;
            $model->save();
            return true;
        }
    }

    public function actionSaveDraftPoreject() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $posted = $request->post('TbPo2');
            $model = TbPo2::findOne($posted['POID']);
            $model->PONum = empty($posted['PONum']) ? null : $posted['PONum'];
            $model->PODate = empty($posted['PODate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODate']);
            $model->POContID = empty($posted['POContID']) ? null : $posted['POContID'];
            $model->PODueDate = empty($posted['PODueDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODueDate']);
            $model->VendorID = empty($posted['VendorID']) ? null : $posted['VendorID'];
            $model->Menu_VendorID = empty($posted['Menu_VendorID']) ? null : $posted['Menu_VendorID'];
            $model->POStatus = 4;
            $model->save();
            return true;
        }
    }

    public function actionGetVendorname() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = Profile::findOne(['VendorID' => $request->post('id')]);
            return Json::encode($query['VenderName']);
        }
    }

    public function actionGetTableTpu($ids, $TMTID_GPU) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = VwItemListTpu::find()->where(['TMTID_GPU' => $TMTID_GPU])->all();
            $table = '<table class="default kv-grid-table table table-hover table-condensed kv-table-wrap dataTable no-footer dtr-inline" id="datatable-tpu" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัสสินค้า</th>
                                    <th>รหัสยาการค้า</th>
                                    <th>รายละเอียดยาการค้า</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($query as $v) {
                $table .= '<tr>'
                        . Html::tag('td', '', ['style' => 'text-align: center;'])
                        . Html::tag('td', $v['ItemID'], ['style' => 'text-align: center;'])
                        . Html::tag('td', $v['TMTID_TPU'], ['style' => 'text-align: center;'])
                        . Html::tag('td', $v['FSN_TMT'], ['style' => 'text-align: left;'])
                        . Html::tag('td', Html::a('Select', false, ['class' => 'btn btn-xs btn-success', 'onclick' => 'SelectTPU(this);', 'ids' => $ids, 'itemid' => $v['ItemID']]), ['style' => 'text-align: center;'])
                        . '</tr>';
            }
            $table .= '</tbody></table>';
            return $table;
        }
    }

    public function actionAddItemdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $check = TbPoitemdetail2Temp::find()->where(['POID' => $request->post('POID'), 'ItemID' => $request->post('ItemID')])->all();
            $model = TbPoitemdetail2Temp::findOne($request->post('ids'));
            $modelView = VwPo2DetailNew::findOne(['ids' => $request->post('ids')]);
            $itemList = VwItemList::findOne(['ItemID' => $request->post('ItemID')]);
            $ItemPackUnit = $this->getItemPackUnit($request->post('ItemID'));

            /* if($check !== null){
              return 'false';
              } */
            return $this->renderAjax('_form_detail1', [
                        'model' => $model,
                        'itemList' => $itemList,
                        'modelView' => $modelView,
                        'ItemPackUnit' => $ItemPackUnit,
            ]);
        }
    }

    public function actionCheckitemOnplan() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            #เช็คยาสามัญในแผน
            $itemList = VwItemList::findOne(['ItemID' => $request->post('ItemID')]);
            if (($request->post('PRTypeID') == 1) || ($request->post('PRTypeID') == 2) || ($request->post('PRTypeID') == 4) || ($request->post('PRTypeID') == 6) || ($request->post('PRTypeID') == 7)) {
                $checkgpu = VwItemListGpuplanAvalible::findAll(['TMTID_GPU' => $itemList['TMTID_GPU']]);
            } else {
                $checkgpu = null;
            }
            return $checkgpu != null ? 'true' : 'false';
        }
    }

    public function actionAddItemdetailType2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $check = TbPoitemdetail2Temp::find()->where(['POID' => $request->post('POID'), 'ItemID' => $request->post('ItemID'), 'POItemType' => 2])->all();
            if ($check != null) {
                return 'false';
            } else {
                $model = new TbPoitemdetail2Temp();
                $modelView = new VwPo2DetailNew();
                $itemList = VwItemList::findOne(['ItemID' => $request->post('ItemID')]);
                $ItemPackUnit = $this->getItemPackUnit($request->post('ItemID'));

                return $this->renderAjax('_form_detail1', [
                            'model' => $model,
                            'itemList' => $itemList,
                            'modelView' => $modelView,
                            'ItemPackUnit' => $ItemPackUnit,
                ]);
            }
        }
    }

    public function actionAddItemdetailReject() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $check = TbPoitemdetail2::find()->where(['POID' => $request->post('POID'), 'ItemID' => $request->post('ItemID')])->all();
            $model = TbPoitemdetail2::findOne($request->post('ids'));
            $modelView = VwPo2Detail2New::findOne(['ids' => $request->post('ids')]);
            $itemList = VwItemListTpu::findOne(['ItemID' => $request->post('ItemID')]);
            $ItemPackUnit = $this->getItemPackUnit($request->post('ItemID'));
            /* if($check !== null){
              return 'false';
              } */
            return $this->renderAjax('_form_detail_verify', [
                        'model' => $model,
                        'itemList' => $itemList,
                        'modelView' => $modelView,
                        'ItemPackUnit' => $ItemPackUnit,
            ]);
        }
    }

    public function actionAddItemdetailverifyType2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $check = TbPoitemdetail2::find()->where(['POID' => $request->post('POID'), 'ItemID' => $request->post('ItemID'), 'POItemType' => 2])->all();
            if ($check != null) {
                return 'false';
            } else {
                $model = new TbPoitemdetail2();
                $modelView = new VwPo2Detail2New();
                $itemList = VwItemList::findOne(['ItemID' => $request->post('ItemID')]);
                $ItemPackUnit = $this->getItemPackUnit($request->post('ItemID'));

                return $this->renderAjax('_form_detail_verify', [
                            'model' => $model,
                            'itemList' => $itemList,
                            'modelView' => $modelView,
                            'ItemPackUnit' => $ItemPackUnit,
                ]);
            }
        }
    }

    public function actionUpdateDetail1($id) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $model = TbPoitemdetail2Temp::findOne($id);
            $modelView = VwPo2DetailNew::findOne(['ids' => $id]);
            $itemList = VwItemList::findOne(['ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['ItemID']);

            return $this->renderAjax('_form_detail1', [
                        'model' => $model,
                        'itemList' => $itemList,
                        'modelView' => $modelView,
                        'ItemPackUnit' => $ItemPackUnit,
            ]);
        }
    }

    public function actionUpdateDetailVerify($id) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $model = TbPoitemdetail2::findOne($id);
            $modelView = VwPo2Detail2New::findOne(['ids' => $id]);
            $itemList = VwItemList::findOne(['ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['ItemID']);

            return $this->renderAjax('_form_detail_verify', [
                        'model' => $model,
                        'itemList' => $itemList,
                        'modelView' => $modelView,
                        'ItemPackUnit' => $ItemPackUnit,
            ]);
        }
    }

    public function actionUpdateDetailApprove($id) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $model = TbPoitemdetail2::findOne($id);
            $modelView = VwPo2Detail2New::findOne(['ids' => $id]);
            $itemList = VwItemList::findOne(['ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['ItemID']);

            return $this->renderAjax('_form_detail_approve', [
                        'model' => $model,
                        'itemList' => $itemList,
                        'modelView' => $modelView,
                        'ItemPackUnit' => $ItemPackUnit,
            ]);
        }
    }

    private function getItemPackUnit($ItemID) {
        $query = TbItempack::find()->where(['ItemID' => $ItemID])->all();
        foreach ($query as $d) {
            $result[] = $d['ItemPackUnit'];
        }
        return empty($result) ? null : $result;
    }

    public function actionGetSkuqty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($post['Type'] == 'OnChange') {
                $query = TbItempack::findOne([
                            'ItemID' => $post['ItemID'],
                            'ItemPackUnit' => $post['ItemPackUnit'],
                ]);
                $POOrderQty = $post['POPackQty'] * $query['ItemPackSKUQty']; //คำนวณขอซื้อ
                $POUnitCost = $post['ItemPackCost'] / $query['ItemPackSKUQty'];
                $Total = $POOrderQty * number_format($POUnitCost, 4);
                $arr = array(
                    'ItemPackSKUQty' => number_format($query['ItemPackSKUQty'], 4),
                    'POOrderQty' => $POOrderQty,
                    'POUnitCost' => $POUnitCost,
                    'Total' => $Total,
                    'ItemPackID' => $query['ItemPackID'],
                );
                return $arr;
            } elseif ($post['Type'] == 'OnEdit') {
                $query = TbItempack::findOne($post['PackID']);
                $arr = array(
                    'ItemPackSKUQty' => number_format($query['ItemPackSKUQty'], 4),
                    'ItemPackUnit' => $query['ItemPackUnit'],
                );
                return $arr;
            }
        }
    }

    public function actionSaveItemdetails1() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $posted = $request->post('TbPoitemdetail2Temp');
            /*
              if (($posted['PRTypeID'] == '1') && (($modelpr = TbPritemdetail2::findOne($posted['POItemNum'])) != null)) {
              $modelpr = TbPritemdetail2::findOne($posted['POItemNum']);
              if (($modelpr['TMTID_GPU'] != empty($posted['TMTID_GPU']) ? null : $posted['TMTID_GPU'])) {
              $model->PCPlanNum = null;
              $modelpr->PCPlanNum = null;
              $modelpr->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
              $modelpr->TMTID_GPU = empty($posted['TMTID_GPU']) ? null : $posted['TMTID_GPU'];
              $modelpr->TMTID_TPU = empty($posted['TMTID_TPU']) ? null : $posted['TMTID_TPU'];
              $modelpr->ItemName = empty($posted['ItemName']) ? null : $posted['ItemName'];
              $modelpr->PRPackQtyApprove = empty($posted['POPackQtyApprove']) ? null : $this->strNumber($posted['POPackQtyApprove']);
              $modelpr->ItemPackCostApprove = empty($posted['POPackCostApprove']) ? null : $this->strNumber($posted['POPackCostApprove']);
              $modelpr->ItemPackID = empty($posted['PackID']) ? null : $posted['PackID'];
              $modelpr->PRApprovedOrderQty = empty($posted['POApprovedOrderQty']) ? null : $this->strNumber($posted['POApprovedOrderQty']);
              $modelpr->PRApprovedUnitCost = empty($posted['POApprovedUnitCost']) ? null : $this->strNumber($posted['POApprovedUnitCost']);
              }
              } */
            $model = empty($posted['ids']) ? new TbPoitemdetail2Temp() : TbPoitemdetail2Temp::findOne($posted['ids']);
            $model->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
            $model->POID = empty($posted['POID']) ? null : $posted['POID'];
            $model->PRNum = empty($posted['PRNum']) ? null : $posted['PRNum'];
            $model->TMTID_GPU = empty($posted['TMTID_GPU']) ? null : $posted['TMTID_GPU'];
            $model->TMTID_TPU = empty($posted['TMTID_TPU']) ? null : $posted['TMTID_TPU'];
            $model->ItemName = empty($posted['ItemName']) ? null : $posted['ItemName'];
            $model->POPackQtyApprove = empty($posted['POPackQtyApprove']) ? null : $this->strNumber($posted['POPackQtyApprove']);
            $model->POPackCostApprove = empty($posted['POPackCostApprove']) ? null : $this->strNumber($posted['POPackCostApprove']);
            $model->POItemPackID = empty($posted['PackID']) ? null : $posted['PackID'];
            $model->POApprovedUnitCost = empty($posted['POApprovedUnitCost']) ? null : $this->strNumber($posted['POApprovedUnitCost']);
            $model->POApprovedOrderQty = empty($posted['POApprovedOrderQty']) ? null : $this->strNumber($posted['POApprovedOrderQty']);
            $model->POItemType = $posted['POItemType'] == 2 || empty($posted['POItemType']) ? 2 : 1;
            $model->POItemNumStatusID = 1;
            $model->POCreatedBy = Yii::$app->user->getId();
            $model->POExtenedCost = empty($posted['POExtenedCost']) ? null : $this->strNumber($posted['POExtenedCost']);
            $model->save();

            return 'success';
        }
    }

    public function actionSaveItemdetailVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $posted = $request->post('TbPoitemdetail2');
            $model = empty($posted['ids']) ? new TbPoitemdetail2() : TbPoitemdetail2::findOne($posted['ids']);
            $model->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
            $model->POID = empty($posted['POID']) ? null : $posted['POID'];
            $model->PRNum = empty($posted['PRNum']) ? null : $posted['PRNum'];
            $model->TMTID_GPU = empty($posted['TMTID_GPU']) ? null : $posted['TMTID_GPU'];
            $model->TMTID_TPU = empty($posted['TMTID_TPU']) ? null : $posted['TMTID_TPU'];
            $model->ItemName = empty($posted['ItemName']) ? null : $posted['ItemName'];
            $model->POPackQtyApprove = empty($posted['POPackQtyApprove']) ? null : $this->strNumber($posted['POPackQtyApprove']);
            $model->POPackCostApprove = empty($posted['POPackCostApprove']) ? null : $this->strNumber($posted['POPackCostApprove']);
            $model->POItemPackID = empty($posted['PackID']) ? null : $posted['PackID'];
            $model->POApprovedUnitCost = empty($posted['POApprovedUnitCost']) ? null : $this->strNumber($posted['POApprovedUnitCost']);
            $model->POApprovedOrderQty = empty($posted['POApprovedOrderQty']) ? null : $this->strNumber($posted['POApprovedOrderQty']);
            $model->POExtenedCost = empty($posted['POExtenedCost']) ? null : $this->strNumber($posted['POExtenedCost']);
            $model->POItemType = $posted['POItemType'] == 2 || empty($posted['POItemType']) ? 2 : 1;
            $model->POItemNumStatusID = 2;
            $model->save();
            return 'success';
        }
    }

    public function actionSaveItemdetailApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $posted = $request->post('TbPoitemdetail2');
            $ids = empty($posted['ids']) ? null : $posted['ids'];
            $POPackQtyApprove = empty($posted['POPackQtyApprove']) ? null : $this->strNumber($posted['POPackQtyApprove']);
            $POPackCostApprove = empty($posted['POPackCostApprove']) ? null : $this->strNumber($posted['POPackCostApprove']);
            $PackID = empty($posted['PackID']) ? null : $posted['PackID'];
            $POApprovedUnitCost = empty($posted['POApprovedUnitCost']) ? null : $this->strNumber($posted['POApprovedUnitCost']);
            $POApprovedOrderQty = empty($posted['POApprovedOrderQty']) ? null : $this->strNumber($posted['POApprovedOrderQty']);
            $PONum = empty($posted['PONum']) ? null : $posted['PONum'];
            $PRNum = empty($posted['PRNum']) ? null : $posted['PRNum'];
            $ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
            if (!empty($ids)) {
                $CheckGR = VwGr2DetailReceived::findOne(['ids_po' => $ids]);
            }
            if (($CheckGR !== null) && ($POApprovedOrderQty < $CheckGR['GRReceivedQty'])) {
                return $CheckGR['GRReceivedQty'];
            } else {
                if (($modelgr = TbGritemdetail2::find()->where(['ids_po' => $ids])->all()) !== null) {
                    $SumQty = $POApprovedOrderQty;
                    foreach ($modelgr as $v) {
                        $Query = TbGritemdetail2::findOne($v['ids_gr']);
                        $SumQty = ($SumQty - $v['GRItemQty']);
                        $Query->POPackQtyApprove = $POPackQtyApprove;
                        $Query->POPackCostApprove = $POPackCostApprove;
                        $Query->POItemPackID = $PackID;
                        $Query->POApprovedUnitCost = $POApprovedUnitCost;
                        $Query->POApprovedOrderQty = $POApprovedOrderQty;
                        $Query->GRItemStatusID = $SumQty == 0 ? '2' : '1';
                        $Query->GRLeftItemQty = $SumQty;
                        $Query->save();
                        if ((TbGritemdetail2::find()->where(['PONum' => $PONum, 'GRItemStatusID' => 1])->all()) != null) {
                            $modelGR = TbGr2::findOne($v['GRID']);
                            $modelGR->GRStatusID = 2;
                            $modelGR->save();
                        } else {
                            $modelGR = TbGr2::findOne($v['GRID']);
                            $modelGR->GRStatusID = 3;
                            $modelGR->save();
                            $temp = TbGr2Temp::findOne(['PONum' => $PONum]);
                            TbGritemdetail2Temp::deleteAll(['GRID' => $temp['GRID']]);
                            TbItemlotnum2Temp::deleteAll(['GRID' => $temp['GRID']]);
                            $temp->delete();
                        }
                    }
                    unset($SumQty);
                }
                if (($grmodelTemp = TbGritemdetail2Temp::findOne(['ids_po' => $ids])) !== null) {
                    $sum1 = TbGritemdetail2::find()->where(['ids_po' => $ids])->sum('GRItemQty');
                    $sum2 = TbGritemdetail2Temp::find()->where(['ids_po' => $ids])->sum('GRItemQty');
                    $grmodelTemp->POPackQtyApprove = $POPackQtyApprove;
                    $grmodelTemp->POPackCostApprove = $POPackCostApprove;
                    $grmodelTemp->POItemPackID = $PackID;
                    $grmodelTemp->POApprovedUnitCost = $POApprovedUnitCost;
                    $grmodelTemp->POApprovedOrderQty = $POApprovedOrderQty;
                    $grmodelTemp->GRItemStatusID = $POApprovedOrderQty == $grmodelTemp['GRItemQty'] ? '2' : '1';
                    $grmodelTemp->GRLeftItemQty = $POApprovedOrderQty == $grmodelTemp['GRItemQty'] ? null : ($POApprovedOrderQty - ($sum1 + $sum2));
                    $grmodelTemp->save();
                }
            }
            if (($DetailPR = TbPritemdetail2::findOne(['PRNum' => $PRNum, 'ItemID' => $ItemID])) !== null) {
                $DetailPR->PRPackQtyApprove = $POPackQtyApprove;
                $DetailPR->ItemPackCostApprove = $POPackCostApprove;
                $DetailPR->ItemPackID = $PackID;
                $DetailPR->PRApprovedOrderQty = $POApprovedOrderQty;
                $DetailPR->PRApprovedUnitCost = $POApprovedUnitCost;
                $DetailPR->save();
            }
            $model = empty($posted['ids']) ? new TbPoitemdetail2() : TbPoitemdetail2::findOne($posted['ids']);
            $model->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
            $model->POID = empty($posted['POID']) ? null : $posted['POID'];
            $model->PRNum = empty($posted['PRNum']) ? null : $posted['PRNum'];
            $model->TMTID_GPU = empty($posted['TMTID_GPU']) ? null : $posted['TMTID_GPU'];
            $model->TMTID_TPU = empty($posted['TMTID_TPU']) ? null : $posted['TMTID_TPU'];
            $model->ItemName = empty($posted['ItemName']) ? null : $posted['ItemName'];
            $model->POPackQtyApprove = empty($posted['POPackQtyApprove']) ? null : $this->strNumber($posted['POPackQtyApprove']);
            $model->POPackCostApprove = empty($posted['POPackCostApprove']) ? null : $this->strNumber($posted['POPackCostApprove']);
            $model->POItemPackID = empty($posted['PackID']) ? null : $posted['PackID'];
            $model->POApprovedUnitCost = empty($posted['POApprovedUnitCost']) ? null : $this->strNumber($posted['POApprovedUnitCost']);
            $model->POApprovedOrderQty = empty($posted['POApprovedOrderQty']) ? null : $this->strNumber($posted['POApprovedOrderQty']);
            $model->POExtenedCost = empty($posted['POExtenedCost']) ? null : $this->strNumber($posted['POExtenedCost']);
            $model->POItemType = $posted['POItemType'] == 2 || empty($posted['POItemType']) ? 2 : 1;
            $model->POItemNumStatusID = 2;
            $model->save();
            return 'success';
        }
    }

    private function strNumber($value) {
        if (!empty($value)) {
            return str_replace(',', '', $value);
        } else {
            return NULL;
        }
    }

    public function actionGetModalTpu() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $dataProvider = new ActiveDataProvider([
                'query' => TbItem::find()
                        ->select(['ItemID', 'ItemName', 'TMTID_TPU', 'TMTID_GPU'])
                        ->where(['ItemCatID' => 1]),
                'pagination' => [
                    'pageSize' => false,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'ItemID' => SORT_ASC,
                    ]
                ],
            ]);
            $table = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'bordered' => false,
                        'responsive' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'id' => 'datatable-tpu2', 'width' => '100%'],
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '#',
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->ItemID) ? '-' : $model->ItemID;
                                },
                            ],
                            [
                                'header' => 'รายละเอียดสินค้า',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model->ItemName) ? '-' : $model->ItemName;
                                },
                            ],
                            [
                                'header' => 'รหัสยาการค้า',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'TMTID_TPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->TMTID_TPU) ? '-' : $model->TMTID_TPU;
                                },
                            ],
                            [
                                'header' => 'รหัสยาสามัญ',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'TMTID_GPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'value' => function ($model) {
                                    return empty($model->TMTID_GPU) ? '' : $model->TMTID_GPU;
                                },
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Actions',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'noWrap' => true,
                                'hAlign' => GridView::ALIGN_CENTER,
                                'template' => '{select}',
                                'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::a('Select', false, [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'title' => 'Select',
                                                    'onclick' => 'SelectItemType2(this);',
                                                    'data-id' => $key,
                                        ]);
                                    },
                                ],
                            ],
                        ],
            ]);
            return $table;
        }
    }

    public function actionGetModalNd() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $dataProvider = new ActiveDataProvider([
                'query' => VwItemndToPodetail::find(),
                'pagination' => [
                    'pageSize' => false,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'ItemID' => SORT_ASC,
                    ]
                ],
            ]);
            $table = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'bordered' => false,
                        'responsive' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'id' => 'datatable-nd', 'width' => '100%'],
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '#',
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->ItemID) ? '-' : $model->ItemID;
                                },
                            ],
                            [
                                'header' => 'ประเภทเวชภัณฑ์ฯ',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'ItemNDMedSupply',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->ItemNDMedSupply) ? '-' : $model->ItemNDMedSupply;
                                },
                            ],
                            [
                                'header' => 'ชื่อสินค้า',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model->ItemName) ? '-' : $model->ItemName;
                                },
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Actions',
                                'headerOptions' => ['style' => 'text-align:center; color:black; border-top: 1px solid #ddd;'],
                                'noWrap' => true,
                                'hAlign' => GridView::ALIGN_CENTER,
                                'template' => '{select}',
                                'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::a('Select', false, [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'title' => 'Select',
                                                    'onclick' => 'SelectItemType2(this);',
                                                    'data-id' => $key,
                                        ]);
                                    },
                                ],
                            ],
                        ],
            ]);
            return $table;
        }
    }

    public function actionDeleteDetailtemp() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            TbPoitemdetail2Temp::findOne($request->post('id'))->delete();
        }
    }

    public function actionDeleteDetailVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            TbPoitemdetail2::findOne($request->post('id'))->delete();
        }
    }

    public function actionItemDetails() {
        if (isset($_POST['expandRowKey'])) {
            $query = TbPoitemdetail2Temp::findOne($_POST['expandRowKey']);
            $item = TbItem::findOne($query['ItemID']);
            $query1 = VwPo2Header::findOne($query['POID']);
            if ($item['ItemCatID'] == 1) {
                $dataProvider1 = new SqlDataProvider([
                    'sql' => 'SELECT
                (SELECT SUM(tb_pcplangpudetail.GPUOrderQty) FROM tb_pcplangpudetail WHERE tb_pcplangpudetail.TMTID_GPU = :TMTID_GPU) AS plan_qty,
                (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_GPU = :TMTID_GPU AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                (ifnull((SELECT SUM(tb_pcplangpudetail.GPUOrderQty) FROM tb_pcplangpudetail WHERE tb_pcplangpudetail.TMTID_GPU = :TMTID_GPU),0)-
                ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_GPU = :TMTID_GPU AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                0 AS pr_wip,0 AS po_wip,
                (SELECT tb_gpuconsume_rate.consume_rate FROM tb_gpuconsume_rate WHERE tb_gpuconsume_rate.TMTID_GPU =:TMTID_GPU) AS consume_rate
                 FROM
                    tb_pritemdetail2
                   INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID,
                    tb_gpuconsume_rate
                   WHERE
                   tb_pr2.PRStatusID = 11
                  GROUP BY
                    plan_qty',
                    'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $query1['PRID']],
                ]);
            } else {
                $dataProvider1 = new SqlDataProvider([
                    'sql' => 'SELECT
                            (SELECT SUM(tb_pcplannddetail.PCPlanNDQty) FROM tb_pcplannddetail WHERE tb_pcplannddetail.ItemID = :ItemID) AS plan_qty,
                            (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.ItemID = :ItemID AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                            (ifnull((SELECT SUM(tb_pcplannddetail.PCPlanNDQty) FROM tb_pcplannddetail WHERE tb_pcplannddetail.ItemID = :ItemID),0)
                                -
                            ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.ItemID = :ItemID AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                            0 AS pr_wip,
                            0 AS po_wip,
                            0 AS consume_rate
                            FROM
                                    tb_pritemdetail2
                            INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID
                            WHERE
                            tb_pr2.PRStatusID = 11
                            GROUP BY
                            plan_qty',
                    'params' => [':ItemID' => $query['ItemID'], ':PRID' => $query1['PRID']],
                ]);
            }

            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsPR2(Yii::$app->request->queryParams, $query['ItemID']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_tpu(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search_nd(Yii::$app->request->queryParams, $query['ItemID']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item_details', [
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'dataProvider3' => $dataProvider3,
                        'dataProvider4' => $dataProvider4,
                        'QueryGPU' => $QueryGPU,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionItemDetailsVerify() {
        if (isset($_POST['expandRowKey'])) {
            $query = TbPoitemdetail2::findOne($_POST['expandRowKey']);
            $item = TbItem::findOne($query['ItemID']);
            $query1 = VwPo2Header2::findOne($query['POID']);
            if ($item['ItemCatID'] == 1) {
                $dataProvider1 = new SqlDataProvider([
                    'sql' => 'SELECT
                (SELECT SUM(tb_pcplangpudetail.GPUOrderQty) FROM tb_pcplangpudetail WHERE tb_pcplangpudetail.TMTID_GPU = :TMTID_GPU) AS plan_qty,
                (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_GPU = :TMTID_GPU AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                (ifnull((SELECT SUM(tb_pcplangpudetail.GPUOrderQty) FROM tb_pcplangpudetail WHERE tb_pcplangpudetail.TMTID_GPU = :TMTID_GPU),0)-
                ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_GPU = :TMTID_GPU AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                0 AS pr_wip,0 AS po_wip,
                (SELECT tb_gpuconsume_rate.consume_rate FROM tb_gpuconsume_rate WHERE tb_gpuconsume_rate.TMTID_GPU =:TMTID_GPU) AS consume_rate
                 FROM
                    tb_pritemdetail2
                   INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID,
                    tb_gpuconsume_rate
                   WHERE
                   tb_pr2.PRStatusID = 11
                  GROUP BY
                    plan_qty',
                    'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $query1['PRID']],
                ]);
            } else {
                $dataProvider1 = new SqlDataProvider([
                    'sql' => 'SELECT
                            (SELECT SUM(tb_pcplannddetail.PCPlanNDQty) FROM tb_pcplannddetail WHERE tb_pcplannddetail.ItemID = :ItemID) AS plan_qty,
                            (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.ItemID = :ItemID AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                            (ifnull((SELECT SUM(tb_pcplannddetail.PCPlanNDQty) FROM tb_pcplannddetail WHERE tb_pcplannddetail.ItemID = :ItemID),0)
                                -
                            ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.ItemID = :ItemID AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                            0 AS pr_wip,
                            0 AS po_wip,
                            0 AS consume_rate
                            FROM
                                    tb_pritemdetail2
                            INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID
                            WHERE
                            tb_pr2.PRStatusID = 11
                            GROUP BY
                            plan_qty',
                    'params' => [':ItemID' => $query['ItemID'], ':PRID' => $query1['PRID']],
                ]);
            }

            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsPR2(Yii::$app->request->queryParams, $query['ItemID']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_tpu(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search_nd(Yii::$app->request->queryParams, $query['ItemID']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item_details', [
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'dataProvider3' => $dataProvider3,
                        'dataProvider4' => $dataProvider4,
                        'QueryGPU' => $QueryGPU,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSendtoverify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPoitemdetail2Temp::findAll(['POID' => $request->post('POID'), 'POApprovedOrderQty' => null])) != null) {
                return 'มีรายการที่ไม่ได้บันทึกจำนวนสั่งซื้อ!';
            } else {
                $POID = $request->post('POID');
                $PONum = $request->post('PONum');
                Yii::$app->db->createCommand('CALL cmd_po2_send_to_verify(:x);')
                        ->bindParam(':x', $POID)->execute();
                Yii::$app->session->setFlash('success', 'Send ' . $PONum . ' To Verify Success!');
                //return $this->redirect('/po/default/index');
                return 'success';
            }
        }
    }

    public function actionSendtoverifyReject() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPo2::findOne($request->post('POID'));
            $model->POStatus = 2;
            $model->save();
            TbPoitemdetail2::updateAll(['POItemNumStatusID' => 1, 'POItemType' => 1], ['=', 'POID', $request->post('POID')]);
            Yii::$app->session->setFlash('success', 'Send ' . $request->post('PONum') . ' To Verify Success!');
            //return $this->redirect('/po/default/index');
            return 'success';
        }
    }

    public function actionVerify($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $model->POStatus = 2;
                $model->POVerifyBy = Yii::$app->user->getId();
                $model->POVerifyDate = date('Y-m-d H:i:s');
                $model->save();
                TbPoitemdetail2::updateAll(['POItemNumStatusID' => 2], ['POID' => $data, 'POItemType' => 2]);
                return 'success';
            } else {
                if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                    $dataProvider1 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 1]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    $dataProvider2 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 2]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    return $this->render('_from_verify', [
                                'model' => $model,
                                'modelPR' => $modelPR,
                                'dataProvider1' => $dataProvider1,
                                'dataProvider2' => $dataProvider2,
                    ]);
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewVerify($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $model->POStatus = 5;
                $model->POVerifyBy = Yii::$app->user->getId();
                $model->POVerifyDate = date('Y-m-d H:i:s');
                $model->save();
                return 'success';
            } else {
                if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                    $dataProvider1 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 1]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    $dataProvider2 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 2]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    return $this->render('_from_verify', [
                                'model' => $model,
                                'modelPR' => $modelPR,
                                'dataProvider1' => $dataProvider1,
                                'dataProvider2' => $dataProvider2,
                    ]);
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOkVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPoitemdetail2::findOne($request->post('id'));
            /* $model->POPackQtyApprove = $model->PRPackQtyApprove;
              $model->POPackCostApprove = $model->PRPackCostApprove;
              $model->POItemPackID = $model->ItemPackID;
              $model->POApprovedOrderQty = $model->PRApprovedOrderQty;
              $model->POApprovedUnitCost = $model->PRApprovedUnitCost; */
            $model->POItemNumStatusID = 2;
            $model->save();
            return 'OK Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancelVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPoitemdetail2::findOne($request->post('id'));
            /* $model->POPackQtyApprove = null;
              $model->POPackCostApprove = null;
              $model->POItemPackID = null;
              $model->POApprovedOrderQty = null;
              $model->POApprovedUnitCost = null; */
            $model->POItemNumStatusID = 1;
            $model->save();
            return 'OK Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRejectedVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $POID = $request->post('POID');
            $user_id = Yii::$app->user->getId();
            $PORejectReason = $request->post('PORejectReason');
            $PONum = $request->post('PONum');
            Yii::$app->db->createCommand('CALL cmd_po2_reject_verify(:POID,:user_id,:PORejectReason);')
                    ->bindParam(':POID', $POID)
                    ->bindParam(':user_id', $user_id)
                    ->bindParam(':PORejectReason', $PORejectReason)
                    ->execute();
            Yii::$app->session->setFlash('success', 'Reject ' . $PONum . ' Success!');
            return 'success';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRejectedApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $POID = $request->post('POID');
            $user_id = Yii::$app->user->getId();
            $PORejectReason = $request->post('PORejectReason');
            $PONum = $request->post('PONum');
            Yii::$app->db->createCommand('CALL cmd_po2_reject_approve(:POID,:PORejfromAppNote,:PORejectApproveBy);')
                    ->bindParam(':POID', $POID)
                    ->bindParam(':PORejfromAppNote', $PORejectReason)
                    ->bindParam(':PORejectApproveBy', $user_id)
                    ->execute();
            Yii::$app->session->setFlash('success', 'Reject ' . $PONum . ' Success!');
            return 'success';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionVerifyApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPoitemdetail2::find()->where(['POItemNumStatusID' => 1, 'POID' => $request->post('POID')])->all()) != null) {
                return 'มี ' . TbPoitemdetail2::find()->where(['POItemNumStatusID' => 1, 'POID' => $request->post('POID')])->count('ids') . ' รายการ ที่ยังไม่ได้ถูก Update หรือ OK';
            } else {
                return 'Pass';
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAutoApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $POID = $request->post('POID');
            $POExtendedCost = TbPoitemdetail2::find()
                    ->where(['POID' => $POID, 'POItemType' => 1])
                    ->sum('POExtenedCost');
            $model = TbPo2::findOne($POID);
            $model->POStatus = 11;
            $model->POApproveBy = Yii::$app->user->getId();
            $model->POApproveDate = date('Y-m-d H:i:s');
            $model->POTotal = $POExtendedCost;
            $model->save();
            TbPoitemdetail2::updateAll(['POItemNumStatusID' => 2], ['=', 'POID', $POID]);
            Yii::$app->session->setFlash('success', 'Verify & AutoApprove ' . $model['PONum'] . ' Success!');
            return 'success';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReject($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $posted = Yii::$app->request->post('TbPo2');
                $POExtendedCost = TbPoitemdetail2::find()
                        ->where(['POID' => $data, 'POItemType' => 1])
                        ->sum('POExtenedCost');
                $model->PONum = empty($posted['PONum']) ? null : $posted['PONum'];
                $model->PODate = empty($posted['PODate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODate']);
                $model->POContID = empty($posted['POContID']) ? null : $posted['POContID'];
                $model->PODueDate = empty($posted['PODueDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PODueDate']);
                $model->VendorID = empty($posted['VendorID']) ? null : $posted['VendorID'];
                $model->Menu_VendorID = empty($posted['Menu_VendorID']) ? null : $posted['Menu_VendorID'];
                $model->POStatus = 4;
                $model->POTotal = $POExtendedCost;
                $model->save();
                return 'success';
            } else {
                if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                    $dataProvider1 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 1]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    $dataProvider2 = new ActiveDataProvider([
                        'query' => TbPoitemdetail2::find()
                                ->where(['POID' => $data, 'POItemType' => 2]),
                        'pagination' => [
                            'pageSize' => false,
                        ],
                    ]);
                    return $this->render('_from_reject_verify', [
                                'model' => $model,
                                'modelPR' => $modelPR,
                                'dataProvider1' => $dataProvider1,
                                'dataProvider2' => $dataProvider2,
                    ]);
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewReject($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return $this->render('_from_reject_verify', [
                            'model' => $model,
                            'modelPR' => $modelPR,
                            'dataProvider1' => $dataProvider1,
                            'dataProvider2' => $dataProvider2,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprovePo($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return $this->render('_from_approve', [
                            'model' => $model,
                            'modelPR' => $modelPR,
                            'dataProvider1' => $dataProvider1,
                            'dataProvider2' => $dataProvider2,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewApprove($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return $this->render('_from_approve', [
                            'model' => $model,
                            'modelPR' => $modelPR,
                            'dataProvider1' => $dataProvider1,
                            'dataProvider2' => $dataProvider2,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApproved() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $POExtendedCost = TbPoitemdetail2::find()
                    ->where(['POID' => $request->post('POID'), 'POItemType' => 1])
                    ->sum('POExtenedCost');
            $model = TbPo2::findOne($request->post('POID'));
            $model->POStatus = 11;
            $model->POApproveBy = \Yii::$app->user->getId();
            $model->POApproveDate = date('Y-m-d');
            $model->POTotal = number_format($POExtendedCost, 2);
            $model->save();
            TbPoitemdetail2::updateAll(['POItemNumStatusID' => 2], ['=', 'POID', $request->post('POID')]);
            Yii::$app->session->setFlash('success', 'Approve ' . $model['PONum'] . ' Success!');
            return 'success';
        } else {
            return false;
        }
    }

    public function actionUpdateApprove($data) {
        if (($model = TbPo2::findOne($data)) !== null) {
            if (($modelPR = TbPr2::findOne(['PRNum' => $model['PRNum']])) !== null) {
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $data, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return $this->render('_from_approve', [
                            'model' => $model,
                            'modelPR' => $modelPR,
                            'dataProvider1' => $dataProvider1,
                            'dataProvider2' => $dataProvider2,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancelPo() {
        $request = Yii::$app->request;
        $POID = $request->post('POID');
        if ($request->isPost) {
            if (($Query = TbGr2::find()->where(['PONum' => $request->post('PONum')])->all()) != null || ($Query2 = TbGr2Temp::find()->where(['PONum' => $request->post('PONum')])->all() != null)) {
                return 'false';
            } else {

                Yii::$app->db->createCommand('CALL cmd_po_rollback(:POID);')
                        ->bindParam(':POID', $POID)
                        ->execute();
                $maxid = TbPo2Temp::find()->max('POID');
                TbPoitemdetail2Temp::updateAll(['POID' => $maxid], ['=', 'PONum', $request->post('PONum')]);
                Yii::$app->session->setFlash('success', 'Cencel ' . $request->post('PONum') . '  Success!');
                return true;
            }
        }
    }

    public function actionGetdetailpotomail() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $query = VwPo2Header2::findOne(['POID' => $request->post('id')]);
            $arr = array(
                'PONum' => $query['PONum'],
                'VendorID' => $query['VendorID'],
                'VenderName' => $query['VenderName'],
                'Subject' => $query['EmailSubject'],
                'VenderEmail' => $query['VenderEmail'],
                'PODate' => empty($query['PODate']) ? '' : Yii::$app->formatter->asDate($query['PODate'], 'dd/MM/yyyy'),
            );
            return json_encode($arr);
        }
    }

    public function actionSending() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            $mail = $request->post('mail');
            $name = $request->post('name');
            $subject = $request->post('subject');
            $makrup = $request->post('makrup');
            $result = $request->post('result');
            Yii::$app->mailing->sendMail($name, $mail, $subject, $makrup, $id, $result);
        }
    }

    public function actionViewDetails($PRID, $PRNum,$POID) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (($modelPR = TbPr2::findOne(['PRID' => $PRID, 'PRNum' => $PRNum])) != null) {
                
                $dataProvider = new ActiveDataProvider([
                    'query' => TbPritemdetail2::find()
                            ->select(['PRExtendedCost', 'TMTID_GPU', 'PRItemOnPCPlan', 'ids', 'ItemID', 'ItemName', 'PROrderQty', 'PRUnitCost', 'PRVerifyQty', 'PRVerifyUnitCost', 'ItemPackID', 'ItemPackIDVerify'])
                            ->where(['PRID' => $PRID]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider1 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $POID, 'POItemType' => 1]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $dataProvider2 = new ActiveDataProvider([
                    'query' => TbPoitemdetail2::find()
                            ->where(['POID' => $POID, 'POItemType' => 2]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return [
                    'title' => '<strong>ใบขอซื้อเลขที่ ' . $PRNum . '</strong>',
                    'content' => $this->renderAjax('view_details', [
                        'dataProvider' => $dataProvider,
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'modelPR' => $modelPR,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

}
