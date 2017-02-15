<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\modules\Purchasing\models\TbPo2Temp;
use app\modules\Purchasing\models\TbPo2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PoController implements the CRUD actions for TbPo2Temp model.
 */
class PoController extends Controller {

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
     * Lists all TbPo2Temp models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new \app\modules\Purchasing\models\VwPr2ListForPoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailDraft() {
        $searchModel = new TbPo2TempSearch();
        $dataProvider = $searchModel->searchdetaildraft(Yii::$app->request->queryParams);

        return $this->render('detail-draft', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailVerify() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchdetailverify(Yii::$app->request->queryParams);

        return $this->render('detail-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListVerify() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchdetailverify(Yii::$app->request->queryParams);

        return $this->render('list-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectVerify() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchrejectverify(Yii::$app->request->queryParams);

        return $this->render('list-reject-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectApprove() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchrejectapprove(Yii::$app->request->queryParams);

        return $this->render('list-reject-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListApprove() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchlistapprove(Yii::$app->request->queryParams);

        return $this->render('list-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListWatingApprove() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchwatingapprove(Yii::$app->request->queryParams);

        return $this->render('list-wating-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailWatingApprove() {
        $searchModel = new \app\modules\Purchasing\models\TbPo2Search();
        $dataProvider = $searchModel->searchwatingapprove(Yii::$app->request->queryParams);

        return $this->render('detail-wating-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
    public function actionCreate($prid, $prnum) {
        if (Yii::$app->request->post()) {
            $POID = $_POST['TbPo2Temp']['POID'];
            $PODate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['TbPo2Temp']['PODate']);
            $POContID = $_POST['TbPo2Temp']['POContID'];
            $PODueDate = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['TbPo2Temp']['PODueDate']);
            $VendorID = $_POST['TbPo2Temp']['VendorID'];
            $data = Yii::$app->db->createCommand('CALL cmd_po2_savedraft(:POID,:PODate,:POContID,:PODueDate,:VendorID);')
                    ->bindParam(':POID', $POID)
                    ->bindParam(':PODate', $PODate)
                    ->bindParam(':POContID', $POContID)
                    ->bindParam(':PODueDate', $PODueDate)
                    ->bindParam(':VendorID', $VendorID)
                    ->execute();
            $modelPO = $this->findModel($POID);
            echo $modelPO['PONum'];
        } else {
            if ($prid != NULL) {
                $modelPR = \app\modules\Purchasing\models\TbPr2::findOne(['PRID' => $prid]);
            } else {
                $findprid = \app\modules\Purchasing\models\TbPr2::findOne(['PRNum' => $prnum]);
                $modelPR = \app\modules\Purchasing\models\TbPr2::findOne(['PRID' => $findprid['PRID']]);
            }

            $modelPO = TbPo2Temp::findOne(['PRNum' => $prnum]);
            $findVendor = \app\models\Profile::findOne(['VendorID' => $modelPO['VendorID']]);
            $VenderName = $findVendor['VenderName'];
            $searchModel = new \app\modules\Purchasing\models\TbPoitemdetail2TempSearch();
            $dataProvider = $searchModel->SearchType1(Yii::$app->request->queryParams, $prnum);
            $postProvider = $searchModel->SearchType2(Yii::$app->request->queryParams, $prnum);
            $dataProvider->pagination->pageSize = 5;
            $postProvider->pagination->pageSize = 5;

            if ($modelPO == null) {
                Yii::$app->db->createCommand('CALL cmd_po2_create_header_detail(:x);')
                        ->bindParam(':x', $prid)
                        ->execute();
            }
            return $this->render('create', [
                        'modelPO' => $modelPO,
                        'modelPR' => $modelPR,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'postProvider' => $postProvider,
                        'VenderName' => $VenderName,
            ]);
        }
    }

    /**
     * Updates an existing TbPo2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->POID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
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

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbPo2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbPo2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($modelPO = TbPo2Temp::findOne($id)) !== null) {
            return $modelPO;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionGetdataVendor() {
        $model = \dektrium\user\models\Profile::find()
                ->where(['UserCatID' => 2])
                ->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatavendortable">
                            <thead class="bordered-success">
                                <tr>
                                    <th  style="text-align: center">ลำดับ</th>
                                    <th  style="text-align: center">รหัสผู้จำหน่าย</th>
                                    <th style="text-align: center">ชื่อผู้จำหน่าย</th>
                                    <th  style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($model as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VenderName'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="GetnameVendor(' . $result->user_id . ');" > Select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetnameVendor() {
        $data = \dektrium\user\models\Profile::find()->where(['user_id' => $_POST['id']])->one();
        $arr = array(
            'VendorID' => $data['VendorID'],
            'VenderName' => $data['VenderName'],
        );
        return json_encode($arr);
    }

    public function actionViewDetail() {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\modules\Purchasing\models\TbPoitemdetail2Temp::findOne(['ids' => $_POST['expandRowKey']]);
//            $packunit = \app\models\TbItempack::findOne(['TMTID_GPU' => $model['TMTID_GPU'], 'ItemPackUnit' => $model['ItemPackID']]);
//            $pack = \app\models\TbPackunit::findOne($packunit['ItemPackUnit']);
            $records = \app\modules\Purchasing\models\VwPo2SubPohistory::find()->where(['ItemID' => $model['ItemID']])->all();
            $pricelist = \app\modules\Purchasing\models\Vwpo2subpricelist::find()->where(['ItemID' => $model['ItemID']])->all();
            return $this->renderPartial('viewdetail', [
                        'model' => $model,
                        'records' => $records,
                        'pricelist' => $pricelist,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSelectTableTpu() {
        $data = \app\modules\Purchasing\models\TbPoitemdetail2Temp::findOne(['ids' => $_POST['id']]);
        $model = \app\models\VwItemListTpu::find()
                ->where(['TMTID_GPU' => $data['TMTID_GPU']])
                ->all();
        $tb = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="tableSelectTPU">
                            <thead class="bordered-success">
                                <tr>
                                    <th style="text-align: center">ลำดับ</th>
                                    <th style="text-align: center">รหัสสินค้า</th>
                                    <th style="text-align: center">รายละเอียดยาการค้า</th>
                                    <th style="text-align: center">รหัสยาการค้า</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($model as $result) {
            $tb .='<tr>';
            $tb .= '<td style="text-align: center;">' . $no . '</td>';
            $tb .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $tb .= '<td>' . $result['FSN_TMT'] . '</td>';
            $tb .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $tb .='<td style="text-align: center;"><a class="btn btn-success btn-sm"  onclick="SelectAndSavetpu(' . $result->ItemID . ');" > Select</a></td>';
            $tb .='</tr>';
            $no++;
        }
        $tb .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($tb);
    }

    function actionGetdataTpu() {
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive " cellspacing="0" width="100%" id="getvw_itemtpu_to_podetail">
    <thead class="bordered-success">
        <tr>
            <th style="text-align: center">ลำดับ</th>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th style="text-align: center">TMTID_TPU</th>
            <th style="text-align: center">TMTID_GPU</th>
            <th style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = \app\models\TbItem::find()->where(['ItemCatID' => 1])->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['TMTID_TPU'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['TMTID_GPU'] . '</td>';
            $htl .='<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailtpu(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
            </div>
            ';
        return json_encode($htl);
    }

    function actionGetdataNd() {
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="getvw_itemnd_to_podetail">
    <thead class="bordered-success">
        <tr>
            <th width="5%" style="text-align: center">ลำดับ</th>
            <th style="text-align: center">ประเภทเวชภัณฑ์ฯ</th>
            <th width="" style="text-align: center">รหัสสินค้า</th>
            <th width="" style="text-align: center">ชื่อสินค้า</th>
            <th width="" style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = \app\modules\Purchasing\models\VwItemndToPodetail::find()->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemNDMedSupply'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemName'] . '</td>';
            $htl .='<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailND(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
            </div>
            ';
        return json_encode($htl);
    }

    public function actionSelectAndSavetpu($ids, $ItemID, $PRNum) {
        //เช็ครายการที่บันทึก
        $check = \app\modules\Purchasing\models\VwPo2SubPr2Detail::findOne(['ItemID' => $ItemID, 'PRNum' => $PRNum, 'POItemType' => '1']);
        if ($check != null) {
            return 'false';
        }
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '1';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':PRNum', $PRNum)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $modeledit = \app\modules\Purchasing\models\VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $ItemID]);
            $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $ItemID]);
            if ($checkpack != null) {
                foreach ($checkpack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                $PackUnit = $ItemPackUnit['ItemPackUnit'];
            } else {
                $pack = '';
                $ItemPackSKUQty = '';
                $PackUnit = '';
            }
            return $this->renderAjax('_form_update_detail', [
                        'modeledit' => $modeledit,
                        'Item' => $Item,
                        'pack' => $pack,
                        'POPackQtyApprove' => $modeledit['PRPackQtyApprove'],
                        'POPackCostApprove' => $modeledit['PRPackCostApprove'],
                        'POApprovedOrderQty' => $modeledit['PRApprovedOrderQty'],
                        'POApprovedUnitCost' => $modeledit['PRApprovedUnitCost'],
                        'PackUnit' => $PackUnit,
                        'ItemPackSKUQty' => $ItemPackSKUQty,
                        'DispUnit' => $Item['DispUnit'],
            ]);
        }
    }

    public function actionEditpoDetail($ids) {

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '1';
            $PRNum = '';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':PRNum', $PRNum)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $modeledit = \app\modules\Purchasing\models\VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            if ($modeledit->POItemPackID != null) {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || $modeledit['TMTID_GPU'] == NULL) {
                    $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_form_update_detail', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['POPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['POPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['POApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['POApprovedUnitCost'],
                            'PackUnit' => $ItemPackUnit['ItemPackUnit'],
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                ]);
            } else {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || $modeledit['TMTID_GPU'] == NULL) {
                    $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }

                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_form_update_detail', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['PRPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['PRPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['PRApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['PRApprovedUnitCost'],
                            'PackUnit' => $ItemPackUnit['ItemPackUnit'],
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $modeledit['DispUnit'],
                ]);
            }
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

    public function actionAddNewItemdetailtpu($ItemID, $PRNum, $ItemType) {
        $check = \app\modules\Purchasing\models\VwPo2SubPr2Detail::findOne(['ItemID' => $ItemID, 'PRNum' => $PRNum, 'POItemType' => '2']);
        if ($check != null) {
            return 'false';
        }

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '2';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':PRNum', $PRNum)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            if ($ItemType == 'TPU') {
                $modeledit = new \app\modules\Purchasing\models\VwPo2SubPr2Detail();
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $ItemID]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }

                return $this->renderAjax('_form_update_detail2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => '0.00',
                            'POPackCostApprove' => '0.00',
                            'POApprovedOrderQty' => '0.00',
                            'POApprovedUnitCost' => '0.00',
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                ]);
            } elseif ($ItemType == 'ND') {
                $modeledit = new \app\modules\Purchasing\models\VwPo2SubPr2Detail();
                $Item = \app\modules\Purchasing\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }
                return $this->renderAjax('_form_update_detail2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => '0.00',
                            'POPackCostApprove' => '0.00',
                            'POApprovedOrderQty' => '0.00',
                            'POApprovedUnitCost' => '0.00',
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                ]);
            }
        }
    }

    function actionDeleteDetail() {
        $key = $_POST['id'];
        $sql = "DELETE FROM tb_poitemdetail2_temp WHERE ids = $key";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionDeleteDetailVerify() {
        $key = $_POST['id'];
        $sql = "DELETE FROM tb_poitemdetail2 WHERE ids = $key";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionEditpoDetailtype2($ids) {
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '2';
            $PRNum = '';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':PRNum', $PRNum)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $modeledit = \app\modules\Purchasing\models\VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            if ($modeledit->POItemPackID != null || $modeledit->POItemPackID == 0) {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_form_update_detail2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['POPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['POPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['POApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['POApprovedUnitCost'],
                            'PackUnit' => $ItemPackUnit['ItemPackUnit'],
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $modeledit['ItemDetail'],
                ]);
            } else {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_form_update_detail2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['PRPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['PRPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['PRApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['PRApprovedUnitCost'],
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'ItemDetail' => $modeledit['ItemDetail'],
                ]);
            }
        }
    }

    public function actionClear() {
        $POID = $_POST['POID'];
        $sql = "
                DELETE FROM tb_po2_temp WHERE POID = $POID;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/po/index');
    }

    public function actionSendtoverify() {
        $PRID = $_POST['POID'];
        $PRNum = $_POST['PRNum'];
        Yii::$app->db->createCommand('CALL cmd_po2_send_to_verify(:x);')
                ->bindParam(':x', $PRID)->execute();
        $sql = "
                 DELETE FROM tb_po2_temp WHERE tb_po2_temp.POID=$PRID;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Send To Verify Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/index');
    }

    public function actionViewDetailVerify() {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\modules\Purchasing\models\TbPoitemdetail2::findOne(['ids' => $_POST['expandRowKey']]);
            $id = $model['POID'];
            $ItemID = $model['ItemID'];
            $searchModel = new \app\modules\Purchasing\models\TbPoitemdetail2Search();
            $dataProvider = $searchModel->SearchHistory(Yii::$app->request->queryParams, $id, $ItemID);

            $pricelist = \app\modules\Purchasing\models\Vwpo2subpricelist::find()->where(['ItemID' => $model['ItemID']])->all();
            return $this->renderPartial('view_detail_verify', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'pricelist' => $pricelist,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionEditpoDetailVerify($ids) {

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '1';
            $POID = '';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':POID', $POID)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $modeledit = \app\modules\Purchasing\models\VwPo2SubPr2Detail2::findOne(['ids' => $ids]);
            if ($modeledit['POItemPackID'] != null || $modeledit['POItemPackID'] == 0) {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || $modeledit['TMTID_GPU'] == NULL) {
                    $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                return $this->renderAjax('_update_detail_verify', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['POPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['POPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['POApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['POApprovedUnitCost'],
                            'PackUnit' => $ItemPackUnit['ItemPackUnit'],
                            'ItemPackSKUQty' => $ItemPackUnit['ItemPackSKUQty'],
                            'DispUnit' => $Item['DispUnit'],
                ]);
            } else {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || $modeledit['TMTID_GPU'] == NULL) {
                    $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if ($checkpack != null) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
//                return $this->renderAjax('_update_detail_verify', [
//                            'modeledit' => $modeledit,
//                            'Item' => $Item,
//                            'pack' => $pack,
//                            'POPackQtyApprove' => $modeledit['PRPackQtyApprove'],
//                            'POPackCostApprove' => $modeledit['PRPackCostApprove'],
//                            'POApprovedOrderQty' => $modeledit['PRApprovedOrderQty'],
//                            'POApprovedUnitCost' => $modeledit['PRApprovedUnitCost'],
//                            'PackUnit' => '',
//                            'ItemPackSKUQty' => $ItemPackSKUQty,
//                ]);
            }
        }
    }

    public function actionEditpoDetailVerifytype2($ids) {
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '2';
            $POID = $_POST['VwPo2SubPr2Detail']['POID'];
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':POID', $POID)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $modeledit = \app\modules\Purchasing\models\VwPo2SubPr2Detail2::findOne(['ids' => $ids]);
            if ($modeledit->POItemPackID != null || $modeledit->POItemPackID == 0) {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['POPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['POPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['POApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['POApprovedUnitCost'],
                            'PackUnit' => $ItemPackUnit['ItemPackUnit'],
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $modeledit['ItemDetail'],
                            'POID' => $modeledit['POID']
                ]);
            } else {
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => $modeledit['PRPackQtyApprove'],
                            'POPackCostApprove' => $modeledit['PRPackCostApprove'],
                            'POApprovedOrderQty' => $modeledit['PRApprovedOrderQty'],
                            'POApprovedUnitCost' => $modeledit['PRApprovedUnitCost'],
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'ItemDetail' => $modeledit['ItemDetail'],
                            'POID' => $modeledit['POID']
                ]);
            }
        }
    }

    public function actionAdditemDetailtpu($ItemID, $POID, $ItemType) {

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }
            
            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID1 = $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '2';
            $POID = $_POST['VwPo2SubPr2Detail']['POID'];
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':ItemID', $ItemID1)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':POPackQtyApprove', $POPackQtyApprove)
                    ->bindParam(':POPackCostApprove', $POPackCostApprove)
                    ->bindParam(':POItemPackID', $POItemPackID)
                    ->bindParam(':POApprovedUnitCost', $POApprovedUnitCost)
                    ->bindParam(':POApprovedOrderQty', $POApprovedOrderQty)
                    ->bindParam(':POItemType', $POItemType)
                    ->bindParam(':POID', $POID)
                    ->bindParam(':POCreatedBy', $POCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $check = \app\modules\Purchasing\models\VwPo2SubPr2Detail2::findOne(['ItemID' => $ItemID, 'POID' => $POID, 'POItemType' => '2']);
            if ($check != null) {
                return 'false';
            }
            if ($ItemType == 'TPU') {
                $modeledit = new \app\modules\Purchasing\models\VwPo2SubPr2Detail2();
                $Item = \app\models\VwItemListTpu::findOne(['ItemID' => $ItemID]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => '0.00',
                            'POPackCostApprove' => '0.00',
                            'POApprovedOrderQty' => '0.00',
                            'POApprovedUnitCost' => '0.00',
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                            'POID' => $POID,
                ]);
            } elseif ($ItemType == 'ND') {
                $modeledit = new \app\modules\Purchasing\models\VwPo2SubPr2Detail2();
                $Item = \app\modules\Purchasing\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => '0.00',
                            'POPackCostApprove' => '0.00',
                            'POApprovedOrderQty' => '0.00',
                            'POApprovedUnitCost' => '0.00',
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                            'POID' => $POID,
                ]);
            }
        }
    }

    public function actionRejectedVerify() {
        $POID = $_POST['POID'];
        $user_id = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_po2_reject_verify(:POID,:user_id);')
                ->bindParam(':POID', $POID)
                ->bindParam(':user_id', $user_id)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Rejected Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-verify');
    }

    public function actionVerify() {
        $POID = $_POST['POID'];
        Yii::$app->db->createCommand('CALL cmd_po2_verify(:POID);')
                ->bindParam(':POID', $POID)
                ->execute();
    }

    public function actionOkVerify() {
        $id = $_POST['id'];
        Yii::$app->db->createCommand('CALL cmd_po2_itemok(:x);')
                ->bindParam(':x', $id)
                ->execute();
    }

    public function actionSendtoApprove() {
        $POID = $_POST['POID'];
        Yii::$app->db->createCommand('CALL cmd_po2_send_to_approve(:x);')
                ->bindParam(':x', $POID)
                ->execute();

        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Send to approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-verify');
    }

    public function actionUpdateDetailApprove($id, $view) {
        $modelPO2 = \app\modules\Purchasing\models\TbPo2::findOne(['POID' => $id]);
        $modelPR = \app\modules\Purchasing\models\TbPr2::findOne(['PRNum' => $modelPO2['PRNum']]);
        $findVendor = \app\models\Profile::findOne(['VendorID' => $modelPO2['VendorID']]);
        $searchModel = new \app\modules\Purchasing\models\TbPoitemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify1(Yii::$app->request->queryParams, $id);
        $postProvider = $searchModel->SearchDetailVerify2(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;
        $postProvider->pagination->pageSize = 5;
        return $this->render('_form_detail_approve', [
                    'modelPO2' => $modelPO2,
                    'view' => $view,
                    'modelPR' => $modelPR,
                    'VendorName' => $findVendor['VenderName'],
                    'dataProvider' => $dataProvider,
                    'postProvider' => $postProvider,
        ]);
    }

    public function actionUpdateDetailVerify($id, $view) {
        $modelPO2 = \app\modules\Purchasing\models\TbPo2::findOne($id);
        $modelPR = \app\modules\Purchasing\models\TbPr2::findOne(['PRNum' => $modelPO2['PRNum']]);
        $findVendor = \app\models\Profile::findOne(['VendorID' => $modelPO2['VendorID']]);
        $searchModel = new \app\modules\Purchasing\models\TbPoitemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify1(Yii::$app->request->queryParams, $id);
        $postProvider = $searchModel->SearchDetailVerify2(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;
        $postProvider->pagination->pageSize = 5;
        return $this->render('_form_detail_verify', [
                    'modelPO2' => $modelPO2,
                    'view' => $view,
                    'modelPR' => $modelPR,
                    'VendorName' => $findVendor['VenderName'],
                    'dataProvider' => $dataProvider,
                    'postProvider' => $postProvider,
        ]);
    }

    public function actionRejectedApprove() {
        $POID = $_POST['POID'];
        Yii::$app->db->createCommand('CALL cmd_po2_reject_approve(:POID);')
                ->bindParam(':POID', $POID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Rejected Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-wating-approve');
    }

    public function actionApprove() {
        $POID = $_POST['POID'];
        Yii::$app->db->createCommand('CALL cmd_po2_approve(:POID);')
                ->bindParam(':POID', $POID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-wating-approve');
    }

}
