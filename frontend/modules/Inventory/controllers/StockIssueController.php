<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbSt2Temp;
use app\modules\Inventory\models\TbSt2;
use app\modules\Inventory\models\TbSt2Search;
use app\modules\Inventory\models\TbSt2TempSearch;
use app\modules\Inventory\models\Tbsritemdetail2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockIssueController implements the CRUD actions for TbSt2 model.
 */
class StockIssueController extends Controller {

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

    public function action_clear() {
        $x = Yii::$app->request->post('stid');
        Yii::$app->db->createCommand('
                    CALL cmd_st2_clear(:x);')
                ->bindParam(':x', $x)
                ->execute();
        echo '1';
    }

    public function actionCmdSt2StkIssu() {
        $x = Yii::$app->request->post('stid');
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('
                    CALL cmd_st2_stk_issue(:x,:userid);')
                ->bindParam(':x', $x)
                ->bindParam(':userid', $userid)
                ->execute();
        echo '1';
    }

    public function actionSelectLot() {
        $x = Yii::$app->request->get('id');
        $stkid = Yii::$app->request->get('stkid');
        $srid = Yii::$app->request->get('srid');
        $stkall = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $stkid]);
        $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $x]);
        $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
        $dataProvider = $searchModel->search($stkid, $x);
        return $this->renderAjax('form_detail', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'stkall' => $stkall
        ]);
    }

    public function actionStockReceive() {
        $searchModel = new TbSt2Search();
        $dataProvider = $searchModel->searchrecevie(Yii::$app->request->queryParams);

        return $this->render('stock-receive', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStockReceiveHistory() {
        $searchModel = new TbSt2Search();
        $dataProvider = $searchModel->searchreceviehistory(Yii::$app->request->queryParams);

        return $this->render('stock-receive-history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetail($id, $status = '1') {
        $model = TbSt2::findOne(['STID' => $id]);
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
        $stdate = Yii::$app->componentdate->convertThaiToMysqlDate($post['STRecievedDate']);
        $save = TbSt2::findOne(['STNum' => $STNum]);
        $save->STRecievedDate = $stdate;
        $save->save();
        $user_id = Yii::$app->user->id;
        Yii::$app->db->createCommand('
                    CALL cmd_st2_stk_receive(:STNum,:userid);')
                ->bindParam(':STNum', $STNum)
                ->bindParam(':userid', $user_id)
                ->execute();
        return 'full';
    }

    public function actionSpicking() {
        $searchModel = new \app\modules\Inventory\models\Vwsr2listSearch();
        $dataProvider = $searchModel->searchhistory(Yii::$app->request->queryParams);
        return $this->render('stissupicking', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreateheader($id) {
        $sr = \app\modules\Inventory\models\Tbsr2::findOne($id);
        $sr2 = $sr->SRNum;
        $userid = Yii::$app->user->identity->profile->user_id;
        $cmd = Yii::$app->db->createCommand('CALL cmd_st2_create_header(:userid);')->bindParam(':userid', $userid)->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'STID' => $max, 'SRID' => $id, 'SRNum' => $sr2]);
    }

    /**
     * Lists all TbSt2 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TbSt2TempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbSt2 model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbSt2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($STID, $SRID, $SRNum) {
        $model = TbSt2Temp::findOne(['STID' => $STID]);
        if (Yii::$app->request->post() != null) {
            $pos = Yii::$app->request->post('TbSt2Temp');
            $stid = Yii::$app->request->post('stid');
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['STDate']);
            $STNum = $pos['STNum'];
            if ($STNum == null) {
                $STNum = null;
            }
            $SRNum = $SRNum;
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = date('Y-m-d');
            $STIssue_StkID = $pos['STIssue_StkID'];
            $STRecieve_StkID = $pos['STRecieve_StkID'];
            $STStatus = $pos['STStatus'];
            $STNote = $pos['STNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_savedraft(:STID,:STDate,:STNum,:SRNum,:STCreateBy,
                    :STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $stid)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();

            $model12 = TbSt2Temp::findOne(['STID' => $STID]);
            echo $model12->STNum;
        } else {
            $searchModel = new \app\modules\Inventory\models\VwSt2DetailGroupSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $SRID);
            return $this->render('create', [
                        'STID' => $STID,
                        'SRID' => $SRID,
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing TbSt2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing TbSt2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbSt2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbSt2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbSt2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSelectNumBer() {
        if (Yii::$app->request->post() != NULL) {
            $datas = TbSt2Temp::findOne(['STID' => Yii::$app->request->get('stid')]);
            $post = Yii::$app->request->post('TbStitemdetail2Temp');
            $pos = Yii::$app->request->post('VwSt2DetailGroup');
            $poslot = Yii::$app->request->post('VwSt2LotnumberAvalible');
            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackID' => $pos['STItemPackID']]);
            if ($itempack != null) {
                $packdata = Yii::$app->request->post('pack');
                if ($packdata == "1") {
                    $itemp = null;
                } else {
                    $itemp = $itempack->ItemPackID;
                }
            } else {
                $itemp = null;
            }
            $ids = null;
            $STNum = $datas->STNum;
            $STID = Yii::$app->request->get('stid');
            $ItemID = Yii::$app->request->get('itemid');
            $ItemInternalLotNum = Yii::$app->request->get('id');
            $STPackQty = str_replace(",", "", $post['STPackQty']);
            $STPackUnitCost = $poslot['PackItemUnitCost'];
            $STItemPackID = $itemp;
            $STItemQty = str_replace(",", "", $post['STItemQty']);
            $STCreatedBy = Yii::$app->user->identity->profile->user_id;
            $STItemUnitCost = $poslot['ItemUnitCost'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,
                    :STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->execute();
            return 'full';
        }
        $x = Yii::$app->request->get('id');
        $stkid = Yii::$app->request->get('stkid');
        $srid = Yii::$app->request->get('srid');
        $itemid = Yii::$app->request->get('itemid');
        $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $itemid]);
        $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
        $stkmodel = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $stkid]);
        $dataProvider = $searchModel->searchinternallot($stkid, $x);
        $balence = VwSt2SrBalance::findOne(['SRID' => $srid, 'ItemID' => $itemid]);
        $pack = VwItempack::findOne(['ItemPackID' => $model->SRItemPackIDApprove]);
        if (!empty($pack)) {
            $packsize = $pack->ItemPackSKUQty;
        } else {
            $packsize = '0.00';
        }
        $innernallot = VwSt2LotnumberAvalible::findOne(['StkID' => $stkid, 'ItemInternalLotNum' => $x]);
        $stdata = new TbStitemdetail2Temp();

        return $this->renderAjax('determine-the-number', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'stkmodel' => $stkmodel,
                    'balence' => $balence,
                    'stdata' => $stdata,
                    'packsize' => $packsize,
                    'innernallot' => $innernallot
        ]);
    }

    public function actionEditDetail() {
        if (Yii::$app->request->post() != NULL) {
            $post = Yii::$app->request->post('TbStitemdetail2Temp');
            $postv = Yii::$app->request->post('VwSt2DetailGroup');
            $datas = TbSt2Temp::findOne(['STID' => $post['STID']]);
            $itempack = VwItempack::findOne(['ItemID' => $postv['ItemID'], 'ItemPackID' => $postv['STItemPackID']]);
            if ($itempack != null) {
                $packdata = Yii::$app->request->post('pack');
                if ($packdata == "1") {
                    $itemp = null;
                } else {
                    $itemp = $itempack->ItemPackID;
                }
            } else {
                $itemp = null;
            }
            $ids = $post['ids'];
            $STNum = $datas->STNum;
            $STID = $post['STID'];
            $ItemID = $postv['ItemID'];
            $ItemInternalLotNum = $post['ItemInternalLotNum'];
            $STPackQty = str_replace(",", "", $post['STPackQty']);
            $STPackUnitCost = $post['STPackUnitCost'];
            $STItemPackID = $itemp;
            $STItemQty = str_replace(",", "", $post['STItemQty']);
            $STCreatedBy = Yii::$app->user->identity->profile->user_id;
            $STItemUnitCost = $post['STItemUnitCost'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,
                    :STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->execute();
            return 'full';
        } else {
            $id = Yii::$app->request->get('id');
            $stkid = Yii::$app->request->get('stkid');
            $srid = Yii::$app->request->get('srid');
            $stdata = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids' => $id]);
            $stkmodel = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $stkid]);
            $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
            $dataProvider = $searchModel->searchinternallot($stkid, $stdata->ItemInternalLotNum);
            $balence = VwSt2SrBalance::findOne(['SRID' => $srid, 'ItemID' => $stdata->ItemID]);
            $item = \app\modules\Inventory\models\Vwitemlist::findOne(['ItemID' => $stdata->ItemID]);
            $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $stdata->ItemID]);
            $pack = VwItempack::findOne(['ItemPackID' => $model->SRItemPackIDApprove]);
            if (!empty($pack)) {
                $packsize = $pack->ItemPackSKUQty;
            } else {
                $packsize = '0.00';
            }
            return $this->renderAjax('edit_tranfer', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'StkID' => $stkid,
                        'balence' => $balence,
                        'stkmodel' => $stkmodel,
                        'stdata' => $stdata,
                        'item' => $item,
                        'packsize' => $packsize
            ]);
        }
    }

    public function actionDetail1() {
        $id = Yii::$app->request->get('id');
        $model = \app\modules\Inventory\models\Tbsr2::findOne(['SRID' => $id]);
        $searchModel = new Tbsritemdetail2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('_view', [
                    'STID' => $id,
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
//                  
        ]);
    }

    public function actionExtPen() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {
            $model = VwSt2DetailSub::findAll(['ids' => $pos['expandRowKey']]);
            return $this->renderPartial('expenlot', ['lotnumber' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

}
