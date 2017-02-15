<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
#models
use app\modules\Purchasing\models\VwPr2ListForPoSearch;
use app\modules\Purchasing\models\TbPo2Search;
use app\modules\Purchasing\models\TbPr2;
//use app\models\Profile;
use app\modules\Purchasing\models\TbPo2Temp;
use app\modules\Purchasing\models\TbPo2TempSearch;
use app\modules\Purchasing\models\TbPoitemdetail2TempSearch;
use dektrium\user\models\Profile;
use app\modules\Purchasing\models\TbPoitemdetail2Temp;
use app\modules\Purchasing\models\VwPo2SubPohistory;
use app\modules\Purchasing\models\Vwpo2subpricelist;
use app\models\VwItemListTpu;
use app\models\TbItem;
use app\modules\Purchasing\models\VwItemndToPodetail;
use app\modules\Purchasing\models\VwPo2SubPr2Detail;
use app\modules\Purchasing\models\VwItemList;
use app\modules\Purchasing\models\TbPoitemdetail2;
use app\modules\Purchasing\models\TbPo2;
use app\modules\Purchasing\models\Vwpo2header2;
use app\models\TbItempack;
use app\modules\Purchasing\models\TbPoitemdetail2Search;
use app\modules\Purchasing\models\VwPo2SubPr2Detail2;
use app\modules\Purchasing\models\VwPurchasingPricelistSearch;
use app\modules\Purchasing\models\VwPurchasingHistorySearch;
use app\modules\Purchasing\models\VwGpustdCost;
use app\modules\Purchasing\models\VwPurchasingplanStatusSearch;
use app\modules\Purchasing\models\VwPr2ListForPo2Search;
use app\modules\Purchasing\models\VwPurchasingStatus2NdSearch;
use app\modules\Purchasing\models\VwPurchasingplanStatus2Search;
use app\modules\Purchasing\models\VwStkStatusSearch;
use app\modules\Purchasing\models\VwQuPricelistSearch;
use app\modules\Purchasing\models\VwGr2DetailReceived;
use app\modules\Purchasing\models\TbGritemdetail2;
use app\modules\Purchasing\models\TbGr2;
use app\modules\Purchasing\models\TbGritemdetail2Temp;
use app\modules\Purchasing\models\TbPritemdetail2;
use app\modules\Purchasing\models\TbGr2Temp;
use app\modules\Purchasing\models\TbItemlotnum2Temp;

/**
 * PoController implements the CRUD actions for TbPo2Temp model.
 */
class PoController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        //'actions' => ['index', 'input-data'],
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        $searchModel = new VwPr2ListForPo2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailDraft() {
        $searchModel = new TbPo2TempSearch();
        $dataProvider = $searchModel->searchdetaildraft(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('detail-draft', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchdetailverify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('detail-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchdetailverify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectVerify() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchrejectverify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-reject-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchrejectapprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-reject-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchlistapprove(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListWatingApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchwatingapprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-wating-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailWatingApprove() {
        $searchModel = new TbPo2Search();
        $dataProvider = $searchModel->searchwatingapprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('detail-wating-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($prid, $prnum) {
        if (Yii::$app->request->post()) {
            $PRNum = empty($_POST['TbPr2']['PRNum']) ? '' : $_POST['TbPr2']['PRNum'];
            $query = TbPoitemdetail2Temp::find()->where(['PRNum' => $PRNum, 'POApprovedOrderQty' => null])->all();
            if ($query != NULL) {
                return 'null';
            } else {
                $POID = $_POST['TbPo2Temp']['POID'];
                $PODate = empty($_POST['TbPo2Temp']['PODate']) ? null : Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPo2Temp']['PODate']);
                $POContID = empty($_POST['TbPo2Temp']['POContID']) ? null : $_POST['TbPo2Temp']['POContID'];
                $PODueDate = empty($_POST['TbPo2Temp']['PODueDate']) ? null : Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPo2Temp']['PODueDate']);
                $VendorID = empty($_POST['TbPo2Temp']['VendorID']) ? null : $_POST['TbPo2Temp']['VendorID'];
                $Menu_VendorID = empty($_POST['TbPo2Temp']['Menu_VendorID']) ? null : $_POST['TbPo2Temp']['Menu_VendorID'];
                $data = Yii::$app->db->createCommand('CALL cmd_po2_savedraft(:POID,:PODate,:POContID,:PODueDate,:VendorID,:Menu_VendorID);')
                        ->bindParam(':POID', $POID)
                        ->bindParam(':PODate', $PODate)
                        ->bindParam(':POContID', $POContID)
                        ->bindParam(':PODueDate', $PODueDate)
                        ->bindParam(':VendorID', $VendorID)
                        ->bindParam(':Menu_VendorID', $Menu_VendorID)
                        ->execute();
                $modelPO = $this->findModel($POID);
                echo $modelPO['PONum'];
            }
        } else {
            if (!empty($prid)) {
                $modelPR = TbPr2::findOne(['PRID' => $prid]);
            } else {
                $findprid = TbPr2::findOne(['PRNum' => $prnum]);
                $modelPR = TbPr2::findOne(['PRID' => $findprid['PRID']]);
            }

            $modelPO = TbPo2Temp::findOne(['PRNum' => $prnum]);
            $findVendor = Profile::findOne(['VendorID' => $modelPO['VendorID']]);

            $VenderName = $findVendor['VenderName'];
            if (!empty($modelPO['Menu_VendorID'])) {
                $findVendorMenu = Profile::findOne(['VendorID' => $modelPO['Menu_VendorID']]);
                $MenuVenderName = $findVendorMenu['VenderName'];
            } else {
                $MenuVenderName = null;
            }

            $searchModel = new TbPoitemdetail2TempSearch();
            $dataProvider = $searchModel->SearchType1(Yii::$app->request->queryParams, $prnum);
            $postProvider = $searchModel->SearchType2(Yii::$app->request->queryParams, $prnum);
            $dataProvider->pagination->pageSize = 5;
            $postProvider->pagination->pageSize = 5;

            if (empty($modelPO)) {
                $max = TbPo2::find()
                        ->select('max(POID)')
                        ->scalar();
                $maxTemp = TbPo2Temp::find()
                        ->select('max(POID)')
                        ->scalar();
                if ($max > $maxTemp) {
                    $maxID = $max + 1;
                } elseif ($max < $maxTemp) {
                    $maxID = $maxTemp + 1;
                }
                Yii::$app->db->createCommand('CALL cmd_po2_create_header_detail(:x,:POID);')
                        ->bindParam(':x', $prid)
                        ->bindParam(':POID', $maxID)
                        ->execute();
                $modelPO = $this->findModel($maxID);
            }
            return $this->render('create', [
                        'modelPO' => $modelPO,
                        'modelPR' => $modelPR,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'postProvider' => $postProvider,
                        'VenderName' => $VenderName,
                        'MenuVenderName' => $MenuVenderName,
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
        $model = Profile::find()
                ->where(['UserCatID' => 2])
                ->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatavendortable">
                            <thead class="bordered-success">
                                <tr>
                                    <th width="10%" style="text-align: center">ลำดับ</th>
                                    <th  style="text-align: center">รหัสผู้จำหน่าย</th>
                                    <th style="text-align: center">ชื่อผู้จำหน่าย</th>
                                    <th  style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($model as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VenderName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . Html::a('Select', 'javascript:void(0);', ['class' => 'btn btn-success btn-sm', 'type' => $_GET['type'], 'id' => $result->user_id, 'onclick' => 'GetnameVendor(this)']) . '</td>';
            //$htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="GetnameVendor(' . $result->user_id . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetnameVendor() {
        $data = Profile::find()->where(['user_id' => $_POST['id']])->one();
        $arr = array(
            'VendorID' => $data['VendorID'],
            'VenderName' => $data['VenderName'],
        );
        return json_encode($arr);
    }

    public function actionViewDetail($prid) {
        if (isset($_POST['expandRowKey'])) {
            $query = TbPoitemdetail2Temp::findOne($_POST['expandRowKey']);

            if (empty($query['TMTID_GPU'])) {
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
                    'params' => [':ItemID' => $query['ItemID'], ':PRID' => $prid],
                ]);

                $searchModel2 = new VwStkStatusSearch();
                $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['ItemID']);
            } else {
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
                    'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $prid],
                ]);
                /*
                  $searchModel1 = new VwPurchasingplanStatus2Search();
                  $dataProvider1 = $searchModel1->searchDetailsPR(Yii::$app->request->queryParams, $query['TMTID_GPU']);
                 */
                $searchModel2 = new VwStkStatusSearch();
                $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['TMTID_GPU']);
            }

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_nd(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item-details', [
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

    /*
      public function actionViewDetail() {
      if (isset($_POST['expandRowKey'])) {
      $model = TbPoitemdetail2Temp::findOne(['ids' => $_POST['expandRowKey']]);
      $records = VwPo2SubPohistory::find()->where(['ItemID' => $model['ItemID']])->all();
      $pricelist = Vwpo2subpricelist::find()->where(['ItemID' => $model['ItemID']])->all();
      return $this->renderPartial('viewdetail', [
      'model' => $model,
      'records' => $records,
      'pricelist' => $pricelist,
      ]);
      } else {
      return '<div class="alert alert-danger">No data found</div>';
      }
      } */

    public function actionSelectTableTpu() {
        $data = TbPoitemdetail2Temp::findOne(['ids' => $_POST['id']]);
        $model = VwItemListTpu::find()
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
            $tb .= '<tr>';
            $tb .= '<td style="text-align: center;">' . $no . '</td>';
            $tb .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $tb .= '<td>' . $result['FSN_TMT'] . '</td>';
            $tb .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $tb .= '<td style="text-align: center;"><a class="btn btn-success btn-sm"  onclick="SelectAndSavetpu(' . $result->ItemID . ');" > Select</a></td>';
            $tb .= '</tr>';
            $no++;
        }
        $tb .= '</tr></tbody>
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
        $data = TbItem::find()->where(['ItemCatID' => 1])->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['TMTID_TPU'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailtpu(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
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
            <th style="text-align: center">รหัสสินค้า</th>
            <th width="" style="text-align: center">ประเภทเวชภัณฑ์ฯ</th>
            <th width="" style="text-align: center">ชื่อสินค้า</th>
            <th width="" style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = VwItemndToPodetail::find()->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemNDMedSupply'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailND(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
            </div>
            ';
        return json_encode($htl);
    }

    public function actionSelectAndSavetpu($ids, $ItemID, $PRNum) {
        //เช็ครายการที่บันทึก
        $check = VwPo2SubPr2Detail::findOne(['ItemID' => $ItemID, 'PRNum' => $PRNum, 'POItemType' => '1']);
        if (!empty($check)) {
            return 'false';
        }
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '1';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $modeledit = VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            $Item = VwItemListTpu::findOne(['ItemID' => $ItemID]);
            $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], /* 'ItemID' => $ItemID */]);
            if (!empty($checkpack)) {
                foreach ($checkpack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
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
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '1';
            $PRNum = NULL;
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $modeledit = VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            if (!empty($modeledit->POItemPackID)) {
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], /* 'ItemID' => $modeledit['ItemID'] */]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }

                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
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
        $qty = TbItempack::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 4),
        );
        return json_encode($arr);
    }

    public function actionAddNewItemdetailtpu($ItemID, $PRNum, $ItemType) {
        $check = VwPo2SubPr2Detail::findOne(['ItemID' => $ItemID, 'PRNum' => $PRNum, 'POItemType' => '2']);
        if (!empty($check)) {
            return 'false';
        }

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '2';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            if ($ItemType == 'TPU') {
                $modeledit = new VwPo2SubPr2Detail();
                $Item = VwItemListTpu::findOne(['ItemID' => $ItemID]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if (!empty($checkpack)) {
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
                            'POPackQtyApprove' => NULL,
                            'POPackCostApprove' => NULL,
                            'POApprovedOrderQty' => NULL,
                            'POApprovedUnitCost' => NULL,
                            'PackUnit' => '',
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                ]);
            } elseif ($ItemType == 'ND') {
                $modeledit = new VwPo2SubPr2Detail();
                $Item = VwItemList::findOne(['ItemID' => $ItemID]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if (!empty($checkpack)) {
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
                            'POPackQtyApprove' => NULL,
                            'POPackCostApprove' => NULL,
                            'POApprovedOrderQty' => NULL,
                            'POApprovedUnitCost' => NULL,
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
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail']['ItemID'],
                            //'TMTID_GPU' => $_POST['VwPo2SubPr2Detail']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = '';
            }

            $ids = $_POST['VwPo2SubPr2Detail']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POApprovedOrderQty']);
            $POItemType = '2';
            $PRNum = '';
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:PRNum,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $modeledit = VwPo2SubPr2Detail::findOne(['ids' => $ids]);
            if (!empty($modeledit->POItemPackID) || $modeledit->POItemPackID == 0) {
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send To Verify Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('/Purchasing/po/index');
    }

    public function actionViewDetailVerify($prid) {
        if (isset($_POST['expandRowKey'])) {
            $query = TbPoitemdetail2::findOne($_POST['expandRowKey']);

            if (empty($query['TMTID_GPU'])) {
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
                    'params' => [':ItemID' => $query['ItemID'], ':PRID' => $prid],
                ]);

                $searchModel2 = new VwStkStatusSearch();
                $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['ItemID']);
            } else {
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
                    'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $prid],
                ]);

                $searchModel2 = new VwStkStatusSearch();
                $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['TMTID_GPU']);
            }

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_nd(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item-details', [
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'dataProvider3' => $dataProvider3,
                        'dataProvider4' => $dataProvider4,
                        'QueryGPU' => $QueryGPU,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
        /*
          if (isset($_POST['expandRowKey'])) {
          $model = TbPoitemdetail2::findOne(['ids' => $_POST['expandRowKey']]);
          $id = $model['POID'];
          $ItemID = $model['ItemID'];
          $PONum = $model['PONum'];
          $searchModel = new TbPoitemdetail2Search();
          $dataProvider = $searchModel->SearchHistory(Yii::$app->request->queryParams, $id, $ItemID);

          $records = VwPo2SubPohistory::find()
          ->where('PONum <> :userid and ItemID = :ItemID', [':userid' => $PONum, ':ItemID' => $ItemID,])
          ->all();

          $pricelist = Vwpo2subpricelist::find()->where(['ItemID' => $model['ItemID']])->all();
          return $this->renderPartial('view_detail_verify', [
          'model' => $model,
          'dataProvider' => $dataProvider,
          'pricelist' => $pricelist,
          'records' => $records
          ]);
          } else {
          return '<div class="alert alert-danger">No data found</div>';
          } */
    }

    public function actionEditpoDetailVerify() {

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail2']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail2']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '1';
            $POID = NULL;
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail2']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $modeledit = VwPo2SubPr2Detail2::findOne(['ids' => $_GET['ids']]);
            if (!empty($modeledit['POItemPackID']) || $modeledit['POItemPackID'] == 0) {
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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

    public function actionEditpoDetailApprove() {

        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail2']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail2']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '1';
            $POID = NULL;
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail2']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POExtenedCost']);
            $checkGr = VwGr2DetailReceived::findOne(['ids_po' => $ids]);
            if (($checkGr !== null) && ($POApprovedOrderQty < $checkGr['GRReceivedQty'])) {
                return $checkGr['GRReceivedQty'];
            } else {
                if (($grmodel = TbGritemdetail2::find()->where(['ids_po' => $ids])->all()) !== null) {
                    $SumQty = $POApprovedOrderQty; //600
                    foreach ($grmodel as $v) {
                        $Query = TbGritemdetail2::findOne($v['ids_gr']);
                        $SumQty = $SumQty - $v['GRItemQty']; //600-500
                        $Query->POPackQtyApprove = $POPackQtyApprove;
                        $Query->POPackCostApprove = $POPackCostApprove;
                        $Query->POItemPackID = $POItemPackID;
                        $Query->POApprovedUnitCost = $POApprovedUnitCost;
                        $Query->POApprovedOrderQty = $POApprovedOrderQty;
                        $Query->GRItemStatusID = $SumQty == 0 ? '2' : '1';
                        $Query->GRLeftItemQty = $SumQty;
                        $Query->save();
                        if ((TbGritemdetail2::find()->where(['PONum' => $_POST['VwPo2SubPr2Detail2']['PONum'], 'GRItemStatusID' => 1])->all()) != null) {
                            $modelGR = TbGr2::findOne($v['GRID']);
                            $modelGR->GRStatusID = 2;
                            $modelGR->save();
                        } else {
                            /*
                              $sql = "
                              UPDATE tb_gr2
                              SET
                              GRStatusID = 3
                              WHERE tb_gr2.GRID=$grmodel->GRID;

                              UPDATE tb_poitemdetail2
                              SET
                              POItemNumStatusID = 1
                              WHERE tb_poitemdetail2.POID=$POID;
                              ";
                              $query = Yii::$app->db->createCommand($sql)->execute(); */
                            $modelGR = TbGr2::findOne($v['GRID']);
                            $modelGR->GRStatusID = 3;
                            $modelGR->save();
                            $temp = TbGr2Temp::findOne(['PONum' => $_POST['VwPo2SubPr2Detail2']['PONum']]);
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
                    $grmodelTemp->POItemPackID = $POItemPackID;
                    $grmodelTemp->POApprovedUnitCost = $POApprovedUnitCost;
                    $grmodelTemp->POApprovedOrderQty = $POApprovedOrderQty;
                    $grmodelTemp->GRItemStatusID = $POApprovedOrderQty == $grmodelTemp['GRItemQty'] ? '2' : '1';
                    $grmodelTemp->GRLeftItemQty = $POApprovedOrderQty == $grmodelTemp['GRItemQty'] ? null : ($POApprovedOrderQty - ($sum1 + $sum2));
                    $grmodelTemp->save();
                }

                if (($DetailPR = TbPritemdetail2::findOne(['PRNum' => $_POST['VwPo2SubPr2Detail2']['PRNum'], 'ItemID' => $ItemID])) !== null) {
                    $DetailPR->PRPackQtyApprove = $POPackQtyApprove;
                    $DetailPR->ItemPackCostApprove = $POPackCostApprove;
                    $DetailPR->ItemPackID = $POItemPackID;
                    $DetailPR->PRApprovedOrderQty = $POApprovedOrderQty;
                    $DetailPR->PRApprovedUnitCost = $POApprovedUnitCost;
                    $DetailPR->save();
                }

                Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy,:POExtenedCost);')
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
                        ->bindParam(':POExtenedCost', $POExtenedCost)
                        ->execute();
                echo '1';
            }
        } else {
            $modeledit = VwPo2SubPr2Detail2::findOne(['ids' => $_GET['ids']]);
            if (!empty($modeledit['POItemPackID']) || $modeledit['POItemPackID'] == 0) {
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                return $this->renderAjax('_update_detail_approve', [
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
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                if ($modeledit['TMTID_GPU'] == 0 || empty($modeledit['TMTID_GPU'])) {
                    $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                } else {
                    $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU'], 'ItemID' => $modeledit['ItemID']]);
                    if (!empty($checkpack)) {
                        foreach ($checkpack as $data) {
                            $pack[] = $data['ItemPackUnit'];
                        }
                    } else {
                        $pack = '';
                    }
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
                $ItemPackSKUQty = $ItemPackUnit['ItemPackSKUQty'];
            }
        }
    }

    public function actionEditpoDetailVerifytype2() {
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 1) {
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID = $_POST['VwPo2SubPr2Detail2']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail2']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '2';
            $POID = $_POST['VwPo2SubPr2Detail']['POID'];
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail2']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $modeledit = VwPo2SubPr2Detail2::findOne(['ids' => $_GET['ids']]);
            if (!empty($modeledit->POItemPackID) || $modeledit->POItemPackID == 0) {
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = NULL;
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
                $Item = VwItemListTpu::findOne(['ItemID' => $modeledit['ItemID']]);
                $checkpack = TbItempack::findAll(['ItemID' => $modeledit['ItemID']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = NULL;
                }
                $ItemPackUnit = TbItempack::findOne(['ItemPackID' => $modeledit['POItemPackID']]);
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
                $find = TbItempack::findOne([
                            'ItemID' => $_POST['VwPo2SubPr2Detail2']['ItemID'],
                            'ItemPackUnit' => $_POST['VwPo2SubPr2Detail2']['POItemPackID']
                ]);
                $POItemPackID = $find['ItemPackID'];
            } else {
                $POItemPackID = NULL;
            }

            $ids = $_POST['VwPo2SubPr2Detail2']['ids'];
            $ItemID1 = $_POST['VwPo2SubPr2Detail2']['ItemID'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'] == 0 ? NULL : $_POST['VwPo2SubPr2Detail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPo2SubPr2Detail2']['ItemDetail'];
            $POPackQtyApprove = $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackQtyApprove']);
            $POPackCostApprove = $_POST['VwPo2SubPr2Detail2']['POPackCostApprove'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POPackCostApprove']);
            $POApprovedUnitCost = $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedUnitCost']);
            $POApprovedOrderQty = $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POApprovedOrderQty']);
            $POItemType = '2';
            $POID = $_POST['VwPo2SubPr2Detail']['POID'];
            $POCreatedBy = Yii::$app->user->identity->profile->user_id;
            $POExtenedCost = empty($_POST['VwPo2SubPr2Detail2']['POExtenedCost']) ? null : str_replace(',', '', $_POST['VwPo2SubPr2Detail2']['POExtenedCost']);
            Yii::$app->db->createCommand('CALL cmd_po2_item_save2(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:POPackQtyApprove,:POPackCostApprove,:POItemPackID,:POApprovedUnitCost,:POApprovedOrderQty,:POItemType,:POID,:POCreatedBy,:POExtenedCost);')
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
                    ->bindParam(':POExtenedCost', $POExtenedCost)
                    ->execute();
            echo '1';
        } else {
            $check = VwPo2SubPr2Detail2::findOne(['ItemID' => $ItemID, 'POID' => $POID, 'POItemType' => '2']);
            if (!empty($check)) {
                return 'false';
            }
            if ($ItemType == 'TPU') {
                $modeledit = new VwPo2SubPr2Detail2();
                $Item = VwItemListTpu::findOne(['ItemID' => $ItemID]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = NULL;
                } else {
                    $pack = NULL;
                    $ItemPackSKUQty = NULL;
                }
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => NULL,
                            'POPackCostApprove' => NULL,
                            'POApprovedOrderQty' => NULL,
                            'POApprovedUnitCost' => NULL,
                            'PackUnit' => NULL,
                            'ItemPackSKUQty' => $ItemPackSKUQty,
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                            'POID' => $POID,
                ]);
            } elseif ($ItemType == 'ND') {
                $modeledit = new VwPo2SubPr2Detail2();
                $Item = VwItemList::findOne(['ItemID' => $ItemID]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU'], 'ItemID' => $ItemID]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = NULL;
                } else {
                    $pack = NULL;
                    $ItemPackSKUQty = NULL;
                }
                return $this->renderAjax('_update_detail_verify2', [
                            'modeledit' => $modeledit,
                            'Item' => $Item,
                            'pack' => $pack,
                            'POPackQtyApprove' => NULL,
                            'POPackCostApprove' => NULL,
                            'POApprovedOrderQty' => NULL,
                            'POApprovedUnitCost' => NULL,
                            'PackUnit' => NULL,
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
        $PORejectReason = $_POST['PORejectReason'];
        $user_id = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_po2_reject_verify(:POID,:user_id,:PORejectReason);')
                ->bindParam(':POID', $POID)
                ->bindParam(':user_id', $user_id)
                ->bindParam(':PORejectReason', $PORejectReason)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Rejected Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('/km4/Purchasing/po/detail-verify');
    }

    public function actionVerify() {
        $POID = $_POST['POID'];
        $user_id = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_po2_verify(:POID,:user_id);')
                ->bindParam(':POID', $POID)
                ->bindParam(':user_id', $user_id)
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send to approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('/km4/Purchasing/po/detail-verify');
    }

    public function actionUpdateDetailApprove($id, $view) {
        $modelPO2 = TbPo2::findOne($id);
        $modelPR = TbPr2::findOne(['PRNum' => $modelPO2['PRNum']]);
        $findVendor = Profile::findOne(['VendorID' => $modelPO2['VendorID']]);
        $findMenuVendor = Profile::findOne(['VendorID' => $modelPO2['Menu_VendorID']]);
        $searchModel = new TbPoitemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify1(Yii::$app->request->queryParams, $id);
        $postProvider = $searchModel->SearchDetailVerify2(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;
        $postProvider->pagination->pageSize = 5;
        return $this->render('_form_detail_approve', [
                    'modelPO2' => $modelPO2,
                    'view' => $view,
                    'modelPR' => $modelPR,
                    'VendorName' => $findVendor['VenderName'],
                    'MenuVendorName' => $findMenuVendor['VenderName'],
                    'dataProvider' => $dataProvider,
                    'postProvider' => $postProvider,
        ]);
    }

    public function actionUpdateDetailVerify($id, $view) {
        $modelPO2 = TbPo2::findOne($id);
        $modelPR = TbPr2::findOne(['PRNum' => $modelPO2['PRNum']]);
        $findVendor = Profile::findOne(['VendorID' => $modelPO2['VendorID']]);
        $findMenuVendor = Profile::findOne(['VendorID' => $modelPO2['Menu_VendorID']]);
        $searchModel = new TbPoitemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify1(Yii::$app->request->queryParams, $id);
        $postProvider = $searchModel->SearchDetailVerify2(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 5;
        $postProvider->pagination->pageSize = 5;
        return $this->render('_form_detail_verify', [
                    'modelPO2' => $modelPO2,
                    'view' => $view,
                    'modelPR' => $modelPR,
                    'VendorName' => $findVendor['VenderName'],
                    'MenuVendorName' => $findMenuVendor['VenderName'],
                    'dataProvider' => $dataProvider,
                    'postProvider' => $postProvider,
        ]);
    }

    public function actionRejectedApprove() {
        $POID = $_POST['POID'];
        $PORejfromAppNote = $_POST['PORejfromAppNote'];
        $PORejectApproveBy = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_po2_reject_approve(:POID,:PORejfromAppNote,:PORejectApproveBy);')
                ->bindParam(':POID', $POID)
                ->bindParam(':PORejfromAppNote', $PORejfromAppNote)
                ->bindParam(':PORejectApproveBy', $PORejectApproveBy)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Rejected Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-wating-approve');
    }

    public function actionApprove() {
        $POID = $_POST['POID'];
        $user_id = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_po2_approve(:POID,:user_id);')
                ->bindParam(':POID', $POID)
                ->bindParam(':user_id', $user_id)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/detail-wating-approve');
    }

    public function actionGetdetailpotomail() {
        $query = Vwpo2header2::findOne(['POID' => $_POST['id']]);
        $arr = array(
            'PONum' => $query['PONum'],
            'VendorID' => $query['VendorID'],
            'VenderName' => $query['VenderName'],
            'Subject' => $query['EmailSubject'],
            'VenderEmail' => $query['VenderEmail'],
            'PODate' => $query['PODate'],
        );
        return json_encode($arr);
    }

    public function actionSending() {
        $id = $_POST['id'];
        $mail = $_POST['mail'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $makrup = $_POST['makrup'];
        Yii::$app->mailing->sendMail($name, $mail, $subject, $makrup, $id);
    }

    protected function sendMail($name, $mail, $subject, $makrup) {
        Yii::$app->mailer->compose('@app/mail/layouts/register', [
                    'fullname' => $name,
                    'makrup' => $makrup
                ])
                ->setFrom([Yii::$app->user->identity->user->email => 'UDCANCER'])
                ->setTo($mail)
                ->setSubject($subject)
                ->attach(Yii::getAlias('@webroot') . '/uploads/' . 'PO.pdf')
                //->attach(Yii::getAlias('@webroot').'/attach/'.'Poster.pdf')
                ->send();
        $paths = Yii::getAlias('@webroot') . '/uploads/' . '';
        $file = 'PO.pdf';
        unlink($paths . $file);
    }

    #Reject

    public function actionUpdateRejectVerify($id, $view) {
        $modelPO2 = TbPo2::findOne($id);
        if ($modelPO2->load(Yii::$app->request->post())) {
            $POID = $_POST['TbPo2']['POID'];
            $PODate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPo2']['PODate']);
            $POContID = $_POST['TbPo2']['POContID'];
            $PODueDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPo2']['PODueDate']);
            $VendorID = $_POST['TbPo2']['VendorID'];
            $sql = "
                 UPDATE tb_po2
                    SET
                        PODate='$PODate',
                        POContID='$POContID',
                        PODueDate='$PODueDate',
                        VendorID=$VendorID
                    WHERE tb_po2.POID=$POID;
                 ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            return 'success';
        } else {
            $modelPR = TbPr2::findOne(['PRNum' => $modelPO2['PRNum']]);
            $findVendor = Profile::findOne(['VendorID' => $modelPO2['VendorID']]);
            $searchModel = new TbPoitemdetail2Search();
            $dataProvider = $searchModel->SearchDetailVerify1(Yii::$app->request->queryParams, $id);
            $postProvider = $searchModel->SearchDetailVerify2(Yii::$app->request->queryParams, $id);
            $dataProvider->pagination->pageSize = 5;
            $postProvider->pagination->pageSize = 5;
            return $this->render('_form_reject_verify', [
                        'modelPO2' => $modelPO2,
                        'view' => $view,
                        'modelPR' => $modelPR,
                        'VendorName' => $findVendor['VenderName'],
                        'dataProvider' => $dataProvider,
                        'postProvider' => $postProvider,
            ]);
        }
    }

    public function actionSendtoverifyResend() {
        $POID = $_POST['POID'];
        $sql = "
                 UPDATE tb_po2
                 SET
                 POStatus = 2 
                 WHERE tb_po2.POID=$POID;
                     
                 UPDATE tb_poitemdetail2
                    SET
                    POItemNumStatusID = 1
                 WHERE tb_poitemdetail2.POID=$POID;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send To Verify Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/po/index');
    }

    public function actionCancelVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPoitemdetail2::findOne($request->post('id'));
            $model->POPackQtyApprove = null;
            $model->POPackCostApprove = null;
            $model->POItemPackID = null;
            $model->POApprovedOrderQty = null;
            $model->POApprovedUnitCost = null;
            $model->POItemNumStatusID = 1;
            $model->save();
            return 'Cancel Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionVerifyApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPoitemdetail2::find()->where(['POApprovedOrderQty' => null, 'POID' => $request->post('POID')])->all()) != null) {
                return 'มี ' . TbPoitemdetail2::find()->where(['POApprovedOrderQty' => null, 'POID' => $request->post('POID')])->count('ids') . ' รายการ ที่ยังไม่ได้ถูก Update หรือ OK';
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
            $user_id = Yii::$app->user->getId();
            Yii::$app->db->createCommand('CALL cmd_po2_approve(:POID,:user_id);')
                    ->bindParam(':POID', $POID)
                    ->bindParam(':user_id', $user_id)
                    ->execute();
            return $this->redirect('/km4/Purchasing/po/detail-verify');
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
                return true;
            }
        }
    }

}
