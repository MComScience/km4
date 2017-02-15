<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\modules\Purchasing\models\TbGr2Temp;
use app\modules\Purchasing\models\TbGr2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrController implements the CRUD actions for TbGr2Temp model.
 */
class GrController extends Controller {

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

    /**
     * Lists all TbGr2Temp models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \app\modules\Purchasing\models\VwPo2ListForGr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListDraft() {
        $searchModel = new TbGr2TempSearch();
        $dataProvider = $searchModel->searchlistdraft(Yii::$app->request->queryParams);

        return $this->render('list-draft', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReceiveHistory() {
        $searchModel = new \app\modules\Purchasing\models\TbGr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('receive-history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbGr2Temp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbGr2Temp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($poid, $ponum, $view) {
        $findid = TbGr2Temp::findOne(['PONum' => $ponum]);
        if ($findid == null) {
            $user_id = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_gr2_create_header_detail(:x,:userid);')
                    ->bindParam(':x', $poid)
                    ->bindParam(':userid', $user_id)
                    ->execute();
        }
        $modelGR = $this->findModel($findid['GRID']);
        $VenderName = \dektrium\user\models\Profile::findOne(['VendorID' => $findid['VenderID']]);


        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['TbGr2Temp']['GRDate']);
            $VenderInvoiceNum = $_POST['TbGr2Temp']['VenderInvoiceNum'];
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft(:GRID,:GRDate,:VenderInvoiceNum);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':VenderInvoiceNum', $VenderInvoiceNum)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];
        } else {
            $searchModel = new \app\modules\Purchasing\models\TbGritemdetail2TempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $ponum);

            return $this->render('_form', [
                        'modelGR' => $modelGR,
                        'VenderName' => $VenderName['VenderName'],
                        'dataProvider' => $dataProvider,
                        'view' => $view,
            ]);
        }
    }

    public function actionEditHistory($id, $ponum, $view) {
        $modelGR = \app\modules\Purchasing\models\TbGr2::findOne($id);
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['TbGr2']['GRDate']);
            $VenderInvoiceNum = $_POST['TbGr2']['VenderInvoiceNum'];
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft_edit(:GRID,:GRDate,:VenderInvoiceNum);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':VenderInvoiceNum', $VenderInvoiceNum)
                    ->execute();
            return 'success';
        } else {
            $VenderName = \dektrium\user\models\Profile::findOne(['VendorID' => $modelGR['VenderID']]);
            $searchModel = new \app\modules\Purchasing\models\TbGritemdetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            return $this->render('_form_history', [
                        'modelGR' => $modelGR,
                        'VenderName' => $VenderName['VenderName'],
                        'dataProvider' => $dataProvider,
                        'view' => $view,
            ]);
        }
    }

    /**
     * Updates an existing TbGr2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->GRID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbGr2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteListdraft() {
        $GRID = $_POST['id'];
        $sql = "
                 DELETE FROM tb_gr2_temp WHERE tb_gr2_temp.GRID=$GRID;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * Finds the TbGr2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbGr2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbGr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAssignLot($id, $ponum) {
        $modelGRTemp = \app\modules\Purchasing\models\VwGr2Detail::findOne(['ids_gr' => $id]);
        $po = \app\modules\Purchasing\models\TbPo2::findOne(['PONum' => $ponum]);
        $modelLot = new \app\modules\Purchasing\models\VwGr2LotAssignedDetail();
        $balance = \app\modules\Purchasing\models\VwGr2LotAssignedBalance::findOne(['ids_gr' => $id]);


        $searchModel = new \app\modules\Purchasing\models\TbItemlotnum2TempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;
        if ($modelGRTemp->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwGr2Detail']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2Detail']['GRPackUnit']]);
            $ids_gr = $_POST['VwGr2Detail']['ids_gr'];
            $GRPackQty = str_replace(',', '', $_POST['VwGr2Detail']['GRPackQty']);
            $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRPackUnitCost']);
            $ItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = str_replace(',', '', $_POST['VwGr2Detail']['GRItemQty']);
            $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRItemUnitCost']);
            $GRLeftQty = str_replace(',', '', $_POST['VwGr2Detail']['GRLeftQty']);
            Yii::$app->db->createCommand('CALL cmd_gr2_item_save(:ids_gr,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRLeftQty);')
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $ItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRLeftQty', $GRLeftQty)
                    ->execute();
            return 'success';
        } elseif ($modelLot->load(Yii::$app->request->post())) {
            
                $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemID1'], 'ItemPackUnit' => $_POST['VwGr2LotAssignedDetail']['PackUnit']]);
                $ItemInternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemInternalLotNum'];
                $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemExternalLotNum'];
                $ItemID = $_POST['ItemID1'];
                $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['VwGr2LotAssignedDetail']['ItemExpDate']);
                $GRPackQty = str_replace(',', '', $_POST['VwGr2LotAssignedDetail']['LNPackQty']);
                $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2LotAssignedDetail']['LNPackUnitCost']);
                $GRItemPackID = $findpackid['ItemPackID'];
                $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2LotAssignedDetail']['LNItemUnitCost']);
                $GRItemQty = str_replace(',', '', $_POST['VwGr2LotAssignedDetail']['LNItemQty']);
                $userid = Yii::$app->user->identity->profile->user_id;
                $ids_gr = $_POST['ids_grlot'];
                $GRNum = '';
                Yii::$app->db->createCommand('CALL cmd_gr2_lotnumber_itemsave(:ItemInternalLotNum,:ItemExternalLotNum,:ItemID,:ItemExpDate,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:userid,:ids_gr,:GRNum);')
                        ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                        ->bindParam(':ItemExternalLotNum', $ItemExternalLotNum)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemExpDate', $ItemExpDate)
                        ->bindParam(':GRPackQty', $GRPackQty)
                        ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                        ->bindParam(':GRItemPackID', $GRItemPackID)
                        ->bindParam(':GRItemQty', $GRItemQty)
                        ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                        ->bindParam(':userid', $userid)
                        ->bindParam(':ids_gr', $ids_gr)
                        ->bindParam(':GRNum', $GRNum)
                        ->execute();
                return 'success';
            
        } else {
            //หาหน่วยแพค
            $findpackunit = \app\models\TbItempack::findAll(['ItemID' => $modelGRTemp['ItemID']]);
            if ($findpackunit == null) {
                $ItemPackUnit = '';
            } else {
                foreach ($findpackunit as $data) {
                    $ItemPackUnit[] = $data['ItemPackUnit'];
                }
            }
            ///
            if ($balance == NULL) {
                $balance = new \app\modules\Purchasing\models\VwGr2LotAssignedBalance();
            }
            //เช็คว่า Receive แล้วหรือยัง
            if ($modelGRTemp['GRItemUnitCost'] == null) {
                return $this->render('_form_assignlot', [
                            'modelGRTemp' => $modelGRTemp,
                            'GRPackQty' => $modelGRTemp['POPackQtyApprove'],
                            'GRItemPackSKUQty' => $modelGRTemp['POItemPackSKUQty'],
                            'GRPackUnitCost' => $modelGRTemp['POPackCostApprove'],
                            'GRItemQty' => $modelGRTemp['POApprovedOrderQty'],
                            'GRItemUnitCost' => $modelGRTemp['POApprovedUnitCost'],
                            'modelLot' => $modelLot,
                            'ItemPackUnit' => $ItemPackUnit,
                            //'PONum' => $ponum,
                            'PackUnit' => $modelGRTemp['POItemPackUnit'],
                            'dataProvider' => $dataProvider,
                            'ponum' => $ponum,
                            'poid' => $po['POID'],
                            'balance' => $balance,
                ]);
            } else {
                $packunit = \app\models\TbItempack::findOne(['ItemPackID' => $modelGRTemp['GRItemPackID']]);
                return $this->render('_form_assignlot', [
                            'modelGRTemp' => $modelGRTemp,
                            'GRPackQty' => $modelGRTemp['GRPackQty'],
                            'GRItemPackSKUQty' => $modelGRTemp['GRItemPackSKUQty'],
                            'GRPackUnitCost' => $modelGRTemp['GRPackUnitCost'],
                            'GRItemQty' => $modelGRTemp['GRItemQty'],
                            'GRItemUnitCost' => $modelGRTemp['GRItemUnitCost'],
                            'modelLot' => $modelLot,
                            'ItemPackUnit' => $ItemPackUnit,
                            //'PONum' => $ponum,
                            'PackUnit' => $packunit['ItemPackUnit'],
                            'dataProvider' => $dataProvider,
                            'ponum' => $ponum,
                            'poid' => $po['POID'],
                            'balance' => $balance,
                ]);
            }
        }
    }

    public function actionAssignLotReceive($id, $ponum, $view) {
        $modelGRTemp = \app\modules\Purchasing\models\VwGr2DetailEdit::findOne(['ids_gr' => $id]);
        $modelLot = new \app\modules\Purchasing\models\VwGr2LotAssignedDetailEdit();
        $balance = \app\modules\Purchasing\models\VwGr2LotAssignedBalanceEdit::findOne(['ids_gr' => $id]);
        $searchModel = new \app\modules\Purchasing\models\TbItemlotnum2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;

        if ($modelGRTemp->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwGr2DetailEdit']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2DetailEdit']['GRPackUnit']]);
            $ids_gr = $_POST['VwGr2DetailEdit']['ids_gr'];
            $GRPackQty = str_replace(',', '', $_POST['VwGr2DetailEdit']['GRPackQty']);
            $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2DetailEdit']['GRPackUnitCost']);
            $ItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = str_replace(',', '', $_POST['VwGr2DetailEdit']['GRItemQty']);
            $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2DetailEdit']['GRItemUnitCost']);
            $GRLeftQty = str_replace(',', '', $_POST['VwGr2DetailEdit']['GRLeftQty']);
            Yii::$app->db->createCommand('CALL cmd_gr2_item_save_edit(:ids_gr,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRLeftQty);')
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $ItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRLeftQty', $GRLeftQty)
                    ->execute();
            return 'success';
        } elseif ($modelLot->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemID1'], 'ItemPackUnit' => $_POST['VwGr2LotAssignedDetailEdit']['PackUnit']]);
            $find_grnum = \app\modules\Purchasing\models\TbGritemdetail2::findOne($_POST['ids_grlot']);
            $ItemInternalLotNum = $_POST['VwGr2LotAssignedDetailEdit']['ItemInternalLotNum'];
            $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetailEdit']['ItemExternalLotNum'];
            $ItemID = $_POST['ItemID1'];
            $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['VwGr2LotAssignedDetailEdit']['ItemExpDate']);
            $GRPackQty = str_replace(',', '', $_POST['VwGr2LotAssignedDetailEdit']['LNPackQty']);
            $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2LotAssignedDetailEdit']['LNPackUnitCost']);
            $GRItemPackID = $findpackid['ItemPackID'];
            $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2LotAssignedDetailEdit']['LNItemUnitCost']);
            $GRItemQty = str_replace(',', '', $_POST['VwGr2LotAssignedDetailEdit']['LNItemQty']);
            $userid = Yii::$app->user->identity->profile->user_id;
            $ids_gr = $_POST['ids_grlot'];
            $GRNum = $find_grnum['GRNum'];
            Yii::$app->db->createCommand('CALL cmd_gr2_lotnumber_itemsave_edit(:ItemInternalLotNum,:ItemExternalLotNum,:ItemID,:ItemExpDate,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:userid,:ids_gr,:GRNum);')
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':ItemExternalLotNum', $ItemExternalLotNum)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemExpDate', $ItemExpDate)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $GRItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':userid', $userid)
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRNum', $GRNum)
                    ->execute();
            return 'success';
        } else {
            if ($balance == NULL) {
                $balance = new \app\modules\Purchasing\models\VwGr2LotAssignedBalanceEdit();
            }
            //หาหน่วยแพค
            $findpackunit = \app\models\TbItempack::findAll(['ItemID' => $modelGRTemp['ItemID']]);
            if ($findpackunit == null) {
                $ItemPackUnit = '';
            } else {
                foreach ($findpackunit as $data) {
                    $ItemPackUnit[] = $data['ItemPackUnit'];
                }
            }
            $packunit = \app\models\TbItempack::findOne(['ItemPackID' => $modelGRTemp['GRItemPackID']]);
            return $this->render('_form_assignlot_receive', [
                        'modelGRTemp' => $modelGRTemp,
                        'PackUnit' => $packunit['ItemPackUnit'],
                        'GRPackQty' => $modelGRTemp['GRPackQty'],
                        'ItemPackUnit' => $ItemPackUnit,
                        'GRItemPackSKUQty' => $modelGRTemp['GRItemPackSKUQty'],
                        'GRPackUnitCost' => $modelGRTemp['GRPackUnitCost'],
                        'GRItemQty' => $modelGRTemp['GRItemQty'],
                        'GRItemUnitCost' => $modelGRTemp['GRItemUnitCost'],
                        'balance' => $balance,
                        'modelLot' => $modelLot,
                        'dataProvider' => $dataProvider,
                        'ponum' => $ponum,
                        'id' => $modelGRTemp['GRID'],
                        'view' => $view,
            ]);
        }
    }

    public function actionGetQty() {
        $qty = \app\models\TbItempack::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
        );
        return json_encode($arr);
    }

    public function actionDeleteitem() {
        $id = $_POST['id'];
        $sql = "
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ItemInternalLotNum=$id;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionDeleteitemHistory() {
        $id = $_POST['id'];
        $sql = "
                 DELETE FROM tb_itemlotnum2 WHERE tb_itemlotnum2.ItemInternalLotNum=$id;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionEdititemLotassign() {
        $find = \app\modules\Purchasing\models\VwGr2LotAssignedDetail::findOne(['ItemInternalLotNum' => $_POST['id']]);
        $savedata = \app\modules\Purchasing\models\TbItemlotnum2Temp::findOne($_POST['id']);
        $sql = "
                UPDATE tb_itemlotnum2_temp

		SET	tb_itemlotnum2_temp.LNItemStatusID = 1

                WHERE tb_itemlotnum2_temp.ids_gr = $savedata->ids_gr;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        $savedata->LNItemStatusID = '3';
        $savedata->save();
        $arr = array(
            'ItemInternalLotNum' => $find['ItemInternalLotNum'],
            'ItemExternalLotNum' => $find['ItemExternalLotNum'],
            'ItemExpDate' => Yii::$app->componentdate->convertMysqlToThaiDate($find['ItemExpDate']),
            'LNPackQty' => number_format($find['LNPackQty'], 2),
            'LNPackUnitCost' => number_format($find['LNPackUnitCost'], 2),
            'LNItemQty' => number_format($find['LNItemQty'], 2),
            'DispUnit' => $find['DispUnit'],
            'LNItemUnitCost' => number_format($find['LNItemUnitCost'], 2),
            'LNExtenedCost' => number_format($find['LNItemQty'] * $find['LNItemUnitCost'], 2),
            'ItemPackUnit' => $find['ItemPackUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'LNItemPackID' => $find['LNItemPackID'],
            'ids_gr' => $find['ids_gr'],
        );
        return json_encode($arr);
    }

    public function actionEdititemLotassignHistory() {
        $find = \app\modules\Purchasing\models\VwGr2LotAssignedDetailEdit::findOne(['ItemInternalLotNum' => $_POST['id']]);
        $savedata = \app\modules\Purchasing\models\TbItemlotnum2::findOne($_POST['id']);
        $sql = "
                UPDATE tb_itemlotnum2

		SET	tb_itemlotnum2.LNItemStatusID = 1

                WHERE tb_itemlotnum2.ids_gr = $savedata->ids_gr;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        $savedata->LNItemStatusID = '3';
        $savedata->save();
        $arr = array(
            'ItemInternalLotNum' => $find['ItemInternalLotNum'],
            'ItemExternalLotNum' => $find['ItemExternalLotNum'],
            'ItemExpDate' => Yii::$app->componentdate->convertMysqlToThaiDate($find['ItemExpDate']),
            'LNPackQty' => number_format($find['LNPackQty'], 2),
            'LNPackUnitCost' => number_format($find['LNPackUnitCost'], 2),
            'LNItemQty' => number_format($find['LNItemQty'], 2),
            'DispUnit' => $find['DispUnit'],
            'LNItemUnitCost' => number_format($find['LNItemUnitCost'], 2),
            'LNExtenedCost' => number_format($find['LNItemQty'] * $find['LNItemUnitCost'], 2),
            'ItemPackUnit' => $find['ItemPackUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'LNItemPackID' => $find['LNItemPackID'],
            'ids_gr' => $find['ids_gr'],
        );
        return json_encode($arr);
    }

    function actionGetBalance() {
        $balance = \app\modules\Purchasing\models\VwGr2LotAssignedBalance::findOne(['ids_gr' => $_POST['id']]);
        $arr = array(
            'LNAssignedQty' => $balance['LNAssignedQty'],
            'LNAssignedLeftQty' => $balance['LNAssignedLeftQty'],
            'GRUnit' => $balance['GRUnit'],
            'LNItemPackID' => $balance['LNItemPackID'],
        );
        return json_encode($arr);
    }

    function actionGetBalanceHistory() {
        $balance = \app\modules\Purchasing\models\VwGr2LotAssignedBalanceEdit::findOne(['ids_gr' => $_POST['id']]);
        $arr = array(
            'LNAssignedQty' => $balance['LNAssignedQty'],
            'LNAssignedLeftQty' => $balance['LNAssignedLeftQty'],
            'GRUnit' => $balance['GRUnit'],
            'LNItemPackID' => $balance['LNItemPackID'],
        );
        return json_encode($arr);
    }

    public function actionSaveLotNumber() {
        $ids_gr = $_POST['ids_gr'];
        $sql = "
                UPDATE tb_itemlotnum2_temp
                SET
                    LNItemStatusID='2'
                WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionSaveLotNumberHistory() {
        $ids_gr = $_POST['ids_gr'];
        $sql = "
                UPDATE tb_itemlotnum2
                SET
                    LNItemStatusID='2'
                WHERE tb_itemlotnum2.ids_gr=$ids_gr;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionClearGrtemp() {
        $GRID = $_POST['id'];
        $find_grid = \app\modules\Purchasing\models\TbGritemdetail2Temp::findAll(['GRID' => $GRID]);
        foreach ($find_grid as $data) {
            $ids_gr[] = $data['ids_gr'];
        }

        foreach ($ids_gr as $key) {
            $sql = "DELETE FROM tb_itemlotnum2_temp WHERE ids_gr = $key";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        $sql = "
                 DELETE FROM tb_gr2_temp WHERE tb_gr2_temp.GRID=$GRID;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/gr/index');
    }

    function actionClearGr2() {
        $GRID = $_POST['id'];
        $GRNum = $_POST['grnum'];
        $find_grid = \app\modules\Purchasing\models\TbGritemdetail2::findAll(['GRID' => $GRID]);
        foreach ($find_grid as $data) {
            $ids_gr[] = $data['ids_gr'];
        }

        foreach ($ids_gr as $key) {
            $sql = "DELETE FROM tb_itemlotnum2 WHERE ids_gr = $key";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        $sql = "
                 DELETE FROM tb_gr2 WHERE tb_gr2.GRID=$GRID;
                 DELETE FROM tb_stk_trans WHERE tb_stk_trans.StkDocNum=$GRNum;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/gr/receive-history');
    }

    function actionReceiveToStock() {
        $GRID = $_POST['id'];
        $user_id = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_gr2_send_to_stk(:x,:userid);')
                ->bindParam(':x', $GRID)
                ->bindParam(':userid', $user_id)
                ->execute();
        return $this->redirect('index.php?r=Purchasing/gr/index');
    }

}
