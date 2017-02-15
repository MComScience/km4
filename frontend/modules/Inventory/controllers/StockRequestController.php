<?php
namespace app\modules\Inventory\controllers;
use Yii;
use app\modules\Inventory\models\Tbsr2temp;
use app\modules\Inventory\models\Tbsr2;
use app\modules\Inventory\models\Tbsr2Search;
use app\modules\Inventory\models\Tbsritemdetail2temp;
use app\modules\Inventory\models\Sritemdetail2Search;
use app\modules\Inventory\models\VwItemList;
use app\modules\Inventory\models\VwItempack;
use app\modules\Inventory\models\Tbsritemdetail2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\Tbsritemdetail2tempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class StockRequestController extends Controller {

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

    public function actionDeletedetailgpu() {
        $delete = Tbsritemdetail2temp::findOne(Yii::$app->request->post('id'));
        $delete->delete();
    }

    protected function getAmphur($id) {
        $datas = \app\models\TbSection::find()->where(['DepartmentID' => $id])->all();
        return $this->MapData($datas, 'SectionID', 'SectionDecs');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    protected function updatestk($SRID, $stkid, $receivestkid) {
        $model = Tbsr2temp::findOne(['SRID' => $SRID]);
        $model->SRIssue_stkID = $stkid;
        $model->SRReceive_stkID = $receivestkid;
        $model->save();
    }

    function actionGetsrwaitApprov() {
        $vwsrwaitapprovecount = \app\modules\Inventory\models\Vwsr2list::find()->where(['SRStatus' => 2])->count();
        $vwsawaitapprovecount = \app\modules\Inventory\models\VwSaList::find()->where(['SAStatus' => 2])->count();
        $vwpcwaitapprovecount = \app\models\TbPcplan::find()->where(['PCPlanStatusID' => 4])->count();
        $data = array(
            'srcount' => $vwsrwaitapprovecount,
            'sacount' => $vwsawaitapprovecount,
            'plancount' => $vwpcwaitapprovecount);
        echo json_encode($data);
    }

    public function GetData($StkID, $like) {
        if ($like == '1%') {
            $sql = "SELECT
            `tb_stk`.`StkID` AS `StkID`,
            `tb_stk`.`StkName` AS `StkName`,
            `tb_item`.`ItemID` AS `ItemID`,
            `tb_item`.`ItemName` AS `ItemName`,
            `tb_mastertmt`.`TradeName_TMT` AS TradeName,
            ifnull(
                (
                    SELECT
                        `vw_stk_balance_byItemID`.`ItemQtyBalance`
                    FROM
                        `vw_stk_balance_byItemID`
                    WHERE
                        (
                            (
                                `vw_stk_balance_byItemID`.`StkID` = `tb_stk`.`StkID`
                            )
                            AND (
                                `vw_stk_balance_byItemID`.`ItemID` = `tb_item`.`ItemID`
                            )
                        )
                ),
                0
            ) AS `ItemQtyBalance`,
            `tb_dispunit`.`DispUnit` AS `DispUnit`,
            `tb_item`.`ItemCatID` AS `ItemCatID`,
            `tb_item`.`ItemNDMedSupplyCatID` AS `ItemNDMedSupplyCatID`
            FROM
                (
                    `tb_stk`
                    JOIN (
                        `tb_item`
                        LEFT JOIN `tb_dispunit` ON (
                            (
                                `tb_item`.`itemDispUnit` = `tb_dispunit`.`DispUnitID`
                            )
                        )
                    )
                )
                LEFT JOIN `tb_mastertmt` ON `tb_item`.`TMTID_TPU` = `tb_mastertmt`.`TMTID_TPU`
            WHERE
            tb_stk.StkID = $StkID AND
            tb_item.ItemID LIKE '$like'
            ORDER BY
            ItemName ASC";
        } else {
            $sql = "SELECT
            `tb_stk`.`StkID` AS `StkID`,
            `tb_stk`.`StkName` AS `StkName`,
            `tb_item`.`ItemID` AS `ItemID`,
            `tb_item`.`ItemName` AS `ItemName`,
            `tb_mastertmt`.`TradeName_TMT` AS TradeName,
            ifnull(
                (
                    SELECT
                        `vw_stk_balance_byItemID`.`ItemQtyBalance`
                    FROM
                        `vw_stk_balance_byItemID`
                    WHERE
                        (
                            (
                                `vw_stk_balance_byItemID`.`StkID` = `tb_stk`.`StkID`
                            )
                            AND (
                                `vw_stk_balance_byItemID`.`ItemID` = `tb_item`.`ItemID`
                            )
                        )
                ),
                0
            ) AS `ItemQtyBalance`,
            `tb_dispunit`.`DispUnit` AS `DispUnit`,
            `tb_item`.`ItemCatID` AS `ItemCatID`,
            `tb_item`.`ItemNDMedSupplyCatID` AS `ItemNDMedSupplyCatID`
            FROM
                (
                    `tb_stk`
                    JOIN (
                        `tb_item`
                        LEFT JOIN `tb_dispunit` ON (
                            (
                                `tb_item`.`itemDispUnit` = `tb_dispunit`.`DispUnitID`
                            )
                        )
                    )
                )
                LEFT JOIN `tb_mastertmt` ON `tb_item`.`TMTID_TPU` = `tb_mastertmt`.`TMTID_TPU`
            WHERE
            tb_stk.StkID = $StkID AND
            tb_item.ItemID LIKE '$like'";
        }
        $sub_query = Yii::$app->db->createCommand($sql)->queryAll();
        return $sub_query;
    }

    public function GetDataQueryNd($StkID, $like, $like2) {
        $sql = "SELECT
            `tb_stk`.`StkID` AS `StkID`,
            `tb_stk`.`StkName` AS `StkName`,
            `tb_item`.`ItemID` AS `ItemID`,
            `tb_item`.`ItemName` AS `ItemName`,
            `tb_mastertmt`.`TradeName_TMT` AS TradeName,
            ifnull(
                (
                    SELECT
                        `vw_stk_balance_byItemID`.`ItemQtyBalance`
                    FROM
                        `vw_stk_balance_byItemID`
                    WHERE
                        (
                            (
                                `vw_stk_balance_byItemID`.`StkID` = `tb_stk`.`StkID`
                            )
                            AND (
                                `vw_stk_balance_byItemID`.`ItemID` = `tb_item`.`ItemID`
                            )
                        )
                ),
                0
            ) AS `ItemQtyBalance`,
            `tb_dispunit`.`DispUnit` AS `DispUnit`,
            `tb_item`.`ItemCatID` AS `ItemCatID`,
            `tb_item`.`ItemNDMedSupplyCatID` AS `ItemNDMedSupplyCatID`
       FROM
                (
                    `tb_stk`
                    JOIN (
                        `tb_item`
                        LEFT JOIN `tb_dispunit` ON (
                            (
                                `tb_item`.`itemDispUnit` = `tb_dispunit`.`DispUnitID`
                            )
                        )
                    )
                )
                LEFT JOIN `tb_mastertmt` ON `tb_item`.`TMTID_TPU` = `tb_mastertmt`.`TMTID_TPU`
            WHERE
        tb_stk.StkID = $StkID AND
        (tb_item.ItemID LIKE '$like' or tb_item.ItemID LIKE '$like2')";
        $sub_query = Yii::$app->db->createCommand($sql)->queryAll();
        return $sub_query;
    }

    function actionCountdata() {
        $data = Tbsr2temp::find()->count();
        echo $data;
    }

    public function actionPritpickinglist() {
        return $this->renderAjax('pickinglist');
    }

    public function actionBeforeSelect() {
        $SRID = $_POST['SRID'];
        $SRIssue = $_POST['SRIssue'];
        $SRReceive = $_POST['SRReceive'];
        $SRType = $_POST['SRType'];
        if (isset($_POST['SRReqdate'])) {
            $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['SRDate']);
            $SRReqdate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['SRReqdate']);
            $sql = "update tb_sr2_temp set SRDate = '$SRDate',SRReqDate = '$SRReqdate',SRIssue_stkID = $SRIssue,SRReceive_stkID = $SRReceive,SRTypeID = $SRType WHERE tb_sr2_temp.SRID = $SRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        } else {
            $sql = "update tb_sr2_temp set SRIssue_stkID = $SRIssue,SRReceive_stkID = $SRReceive,SRTypeID = $SRType WHERE tb_sr2_temp.SRID = $SRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
    }

    public function actionGettpu() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $SRID = Yii::$app->request->post('SRID');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '1', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetData($tbsr2tempsrissuestkid, $like = '1%');
        //print_r($Productmodel);
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
          <thead class="bordered-success">
          <tr>
          <th width="5%" style="text-align: center;">ลำดับ</th>
          <th width="50%" style="text-align: center;">รหัสสินค้า</th>
          <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
           <th width="100%" style="text-align: center;"> ชื่อยาการค้า</th>
          <th width="50%" style="text-align: center;">คงเหลือ</th>
          <th width="50%" style="text-align: center;">หน่วย</th>
          <th width="10%" style="text-align: center;">Action</th>
          </tr>
          </thead>
          <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td>' . $result['TradeName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',1,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
          </table>
          </div>
          ';
        return json_encode($htl);
    }

    public function actionGetnd() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetDataQueryNd($tbsr2tempsrissuestkid, $like = '2%', $like2 = '3%');
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetndPhama() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetData($tbsr2tempsrissuestkid, $like = '3%');
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetndCssd() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetData($tbsr2tempsrissuestkid, $like = '4%');
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetndScience() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetData($tbsr2tempsrissuestkid, $like = '5%');
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGetndParcel() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $this->updatestk($SRID, $tbsr2tempsrissuestkid, $receivestkid);
        // $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $Productmodel = $this->GetData($tbsr2tempsrissuestkid, $like = '6%');
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result['ItemID'] . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionGettpu2() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $SRID = Yii::$app->request->post('SRID');
        $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '1', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
          <thead class="bordered-success">
          <tr>
          <th width="5%" style="text-align: center;">ลำดับ</th>
          <th width="50%" style="text-align: center;">รหัสสินค้า</th>
          <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
          <th width="50%" style="text-align: center;">คงเหลือ</th>
          <th width="50%" style="text-align: center;">หน่วย</th>
          <th width="10%" style="text-align: center;">Action</th>
          </tr>
          </thead>
          <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->ItemID . ',1,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
          </table>
          </div>
          ';
        return json_encode($htl);
    }

    public function actionGetnd2() {
        $tbsr2tempsrissuestkid = Yii::$app->request->post('stkid');
        $SRID = Yii::$app->request->post('SRID');
        $receivestkid = Yii::$app->request->post('receivestkid');
        $Productmodel = \app\modules\Inventory\models\VwStkBalanceItemid2::find()->where(['ItemCatID' => '2', 'StkID' => $tbsr2tempsrissuestkid])->all();
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr >
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="50%" style="text-align: center;">คงเหลือ</th>
                                    <th width="50%" style="text-align: center;">หน่วย</th>
                                    <th width="10%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemQtyBalance'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->ItemID . ',2,' . $result['ItemQtyBalance'] . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionIndex() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id' => $userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $countdata = Tbsr2temp::find()->count();
        $searchModel = new \app\modules\Inventory\models\Vwsr2listdrafSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'countdata' => $countdata
        ]);
    }

    public function actionWaitApprove() {

        $searchModel = new \app\modules\Inventory\models\Vwsr2listSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        return $this->render('wait-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClickCancel() {
        if (isset($_POST['SRID'])) {
            $SRID = $_POST['SRID'];
            $findSRNum = \app\modules\Inventory\models\Tbsr2::findOne(['SRID' => $SRID]);
            Yii::$app->db->createCommand('CALL cmd_sr_stk_cancel_todraft(:x);')
                    ->bindParam(':x', $SRID)
                    ->execute();
            Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'fa fa-check-square-o',
                'title' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบขอเบิกสินค้า')),
                'message' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบขอเบิกสินค้า ' . $findSRNum['SRNum'] . ' เรียบร้อยแล้ว')),
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
            return '99';
        } else {
            return false;
        }
    }

    public function actionWaitSale() {
        $searchModel = new \app\modules\Inventory\models\Vwsr2listSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('wait-sale', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitReceive() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id' => $userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $searchModel = new \app\modules\Inventory\models\Vwsr2listSearch();
        $dataProvider = $searchModel->searchrecive(Yii::$app->request->queryParams);
        return $this->render('wait-receive', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistory() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id' => $userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $searchModel = new \app\modules\Inventory\models\Vwsr2listSearch();
        $dataProvider = $searchModel->searchhistory(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        return $this->render('history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitApprovePharmacy() {
        $searchModel = new Tbsr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('wait-approve-pharmacy', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaitApprovePharmacys() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id' => $userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $searchModel = new Tbsr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        return $this->render('wait-approve-pharmacys', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproveSr() {

        $userid = Yii::$app->user->identity->profile->user_id;
        $findProfile = \app\modules\Inventory\models\Profile::findOne(['user_id' => $userid]);
        $_SESSION['ss_sectionid'] = $findProfile['User_sectionid'];
        $searchModel = new Tbsr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();

        return $this->render('_approve_sr', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistoryPharmacy() {
        $searchModel = new Tbsr2Search();
        $dataProvider = $searchModel->searchhistory(Yii::$app->request->queryParams);
        return $this->render('history-pharmacy', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewWait($id, $type) {
        $model = Tbsr2::findOne($id);
        $model->SRDate = $model->SRDate;
        $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
        $searchModel = new Sritemdetail2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('_viewwait', [
                    'model' => $model,
                    'section' => $section,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'type' => $type
        ]);
    }

    public function actionHistoryDetail($id, $type) {
        $model = Tbsr2::findOne($id);
        $model->SRDate = $model->SRDate;
        $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
        $searchModel = new Sritemdetail2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('_history_detail', [
                    'model' => $model,
                    'section' => $section,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'type' => $type
        ]);
    }

    /**
     * Displays a single TbSr2Temp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function CheckAuto() {
        $MaxSRID_temp = \app\modules\Inventory\models\Tbsr2temp::find()->max('SRID');
        $MaxSRID_Nottemp = \app\modules\Inventory\models\Tbsr2::find()->max('SRID');
        $MaxIdsSR_temp = \app\modules\Inventory\models\Tbsritemdetail2temp::find()->max('ids');
        $MaxIdsSR_Nottemp = \app\modules\Inventory\models\Tbsritemdetail2::find()->max('ids');
        if (empty($MaxSRID_temp) && empty($MaxSRID_Nottemp)) {
            $setAuto_sr2temp = "ALTER TABLE tb_sr2_temp AUTO_INCREMENT = 1;";
        } elseif ($MaxSRID_Nottemp > $MaxSRID_temp) {
            $NextSRID = $MaxSRID_Nottemp + 1;
            $setAuto_sr2temp = "ALTER TABLE tb_sr2_temp AUTO_INCREMENT = $NextSRID;";
        } elseif ($MaxSRID_Nottemp < $MaxSRID_temp) {
            $NextSRID = $MaxSRID_temp + 1;
            $setAuto_sr2temp = "ALTER TABLE tb_sr2_temp AUTO_INCREMENT = $NextSRID;";
        }
        if (empty($MaxIdsSR_temp) && empty($MaxIdsSR_Nottemp)) {
            $setAuto_sritemdetail2temp = "ALTER TABLE tb_sritemdetail2_temp AUTO_INCREMENT = 1;";
        } elseif ($MaxIdsSR_Nottemp > $MaxIdsSR_temp) {
            $NextIds = $MaxIdsSR_Nottemp + 1;
            $setAuto_sritemdetail2temp = "ALTER TABLE tb_sritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        } elseif ($MaxIdsSR_Nottemp < $MaxIdsSR_temp) {
            $NextIds = $MaxIdsSR_temp + 1;
            $setAuto_sritemdetail2temp = "ALTER TABLE tb_sritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }
        Yii::$app->db->createCommand($setAuto_sr2temp)->query();
        Yii::$app->db->createCommand($setAuto_sritemdetail2temp)->query();
    }

    public function actionCreatepridtemp() {
        $this->CheckAuto();
        $userid = Yii::$app->user->identity->profile->user_id;
        $cmd = Yii::$app->db->createCommand('CALL cmd_sr2_create_header(:userid);')->bindParam(':userid', $userid)->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'SRID' => $max]);
    }

    public function actionCreate($SRID) {
        $model = Tbsr2temp::findOne(['SRID' => $SRID]);
        if ($model->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsr2temp');
            $SRID = Yii::$app->request->post('SRID');
            $SRReceive_stkID = $pos['SRReceive_stkID'];
            $SRTypeID = $pos['SRTypeID'];
            $DepartmentID = 1;
            $SectionID = 1;
            $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
            $SRReqDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRReqDate']);
            $stk_issue = $pos['SRIssue_stkID'];
            $SRCreateDate = date('Y-m-d');
            $SRExpectDate = date('Y-m-d');
            $SRCreatedBy = Yii::$app->user->id;
            $SRNote = $pos['SRNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,
                    :SRExpectDate,:SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote,:SRReqDate);')
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':SRDate', $SRDate)
                    ->bindParam(':DepartmentID', $DepartmentID)
                    ->bindParam(':SectionID', $SectionID)
                    ->bindParam(':SRTypeID', $SRTypeID)
                    ->bindParam(':SRExpectDate', $SRExpectDate)
                    ->bindParam(':SRIssue_stkID', $stk_issue)
                    ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                    ->bindParam(':SRCreateDate', $SRCreateDate)
                    ->bindParam(':SRCreateBy', $SRCreatedBy)
                    ->bindParam(':SRNote', $SRNote)
                    ->bindParam(':SRReqDate', $SRReqDate)
                    ->execute();
            $model2 = Tbsr2temp::findOne(['SRID' => $SRID]);
            echo $model2['SRNum'];
        } else {
            $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
            $searchModel = new Tbsritemdetail2tempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $SRID);
            $model->SRDate = $model->SRDate;
            return $this->render('create', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'SRID' => $SRID,
                        'section' => $section
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = Tbsr2temp::findOne(['SRID' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsr2temp');
            $SRID = Yii::$app->request->post('SRID');
            $SRReceive_stkID = $pos['SRReceive_stkID'];
            $SRTypeID = $pos['SRTypeID'];
            $DepartmentID = 1;
            $SectionID = 1;
            $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
            $SRReqDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRReqDate']);
            $stk_issue = $pos['SRIssue_stkID'];
            $SRCreateDate = date('Y-m-d');
            $SRExpectDate = date('Y-m-d');
            $SRCreatedBy = Yii::$app->user->id;
            $SRNote = $pos['SRNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,
                    :SRExpectDate,:SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote,:SRReqDate);')
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':SRDate', $SRDate)
                    ->bindParam(':DepartmentID', $DepartmentID)
                    ->bindParam(':SectionID', $SectionID)
                    ->bindParam(':SRTypeID', $SRTypeID)
                    ->bindParam(':SRExpectDate', $SRExpectDate)
                    ->bindParam(':SRIssue_stkID', $stk_issue)
                    ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                    ->bindParam(':SRCreateDate', $SRCreateDate)
                    ->bindParam(':SRCreateBy', $SRCreatedBy)
                    ->bindParam(':SRNote', $SRNote)
                    ->bindParam(':SRReqDate', $SRReqDate)
                    ->execute();
            $model2 = Tbsr2temp::findOne(['SRID' => $id]);
            echo $model2['SRNum'];
        } else {
            $searchModel = new Tbsritemdetail2tempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $model->SRDate = $model->SRDate;
            $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'SRID' => $id
            ]);
        }
    }

    /**
     * Deletes an existing TbSr2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        Tbsritemdetail2temp::deleteAll(['SRID' => $id]);
        // return $this->redirect(['index']);
    }

    public function actionDelete2() {
        $id = Yii::$app->request->post('id');
        Tbsr2::findOne($id)->delete();
        Tbsritemdetail2::deleteAll(['SRID' => $id]);
        // return $this->redirect(['index']);
    }

    public function actionDetailselect() {
        $modeledit = new Tbsritemdetail2temp();
        if ($modeledit->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsritemdetail2temp');
            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackUnit' => !empty($pos['SRItemPackID']) ? $pos['SRItemPackID'] : '']);
            if (!empty($itempack)) {
                if ($itempack != null) {
                    $packdata = Yii::$app->request->post('แพค');
                    if ($packdata == "no") {
                        $itemp = "";
                    } else {
                        $itemp = $itempack->ItemPackID;
                    }
                }
            } else {
                $itemp = "";
            }
            $ids = "";
            $SRID = $pos['SRID'];
            $SRIDDATA = Tbsr2temp::findOne(['SRID' => $SRID]);
            $SRNum = $SRIDDATA->SRNum;
            $ItemID = $pos['ItemID'];
            $SRPackQty = str_replace(',', '', $pos['SRPackQty']);
            $SRItemPackID = $itemp;
            $SRItemOrderQty = str_replace(',', '', $pos['SRItemOrderQty']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_item_save(:ids,:SRNum,:SRID,:ItemID,:SRPackQty,
                    :SRItemPackID,:SRItemOrderQty,:SRCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':SRPackQty', $SRPackQty)
                    ->bindParam(':SRItemPackID', $SRItemPackID)
                    ->bindParam(':SRItemOrderQty', $SRItemOrderQty)
                    ->bindParam(':SRCreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $pos = Yii::$app->request->post();
            $check = Tbsritemdetail2temp::findAll(['ItemID' => $pos['id'], 'SRID' => $pos['SRID']]);
            if ($check != null) {
                return 'false';
            } else {
                $Item = VwItemList::findOne(['ItemID' => $pos['id']]);
                $modeledit['ItemID'] = $Item['ItemID'];
                $modeledit['ItemName'] = $Item['ItemName'];
                $DispUnit = $Item['DispUnit'];
                $checkpack = VwItempack::findAll(['ItemID' => $pos['id']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>';
                }
                return $this->renderAjax('_form_detail', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'DispUnit' => $DispUnit,
                            'btn' => $btn,
                            'SRID' => $pos['SRID'],
                            'balance' => $pos['balance']
                ]);
            }
        }
    }

    public function actionUpdateDetailgpu($id = null, $stkid) {
        $modeledit = Tbsritemdetail2temp::findOne(['ids' => $id]);
        if ($modeledit->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsritemdetail2temp');
            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackUnit' => !empty($pos['SRItemPackID']) ? $pos['SRItemPackID'] : '']);
            if ($itempack != null) {
                $packdata = Yii::$app->request->post('แพค');
                if ($packdata == "no") {
                    $itemp = "";
                } else {
                    $itemp = $itempack->ItemPackID;
                }
            } else {
                if (!empty($pos['SRItemPackID'])) {
                    $itemp = $pos['SRItemPackID'];
                } else {
                    $itemp = '';
                }
            }
            $ids = $pos['ids'];
            $SRID = $pos['SRID'];
            $SRIDDATA = Tbsr2temp::findOne(['SRID' => $SRID]);
            $SRNum = $SRIDDATA->SRNum;
            $ItemID = $pos['ItemID'];
            $SRPackQty = str_replace(',', '', $pos['SRPackQty']);
            $SRItemPackID = $itemp;
            $SRItemOrderQty = str_replace(',', '', $pos['SRItemOrderQty']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_item_save(:ids,:SRNum,:SRID,:ItemID,:SRPackQty,
                    :SRItemPackID,:SRItemOrderQty,:SRCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':SRPackQty', $SRPackQty)
                    ->bindParam(':SRItemPackID', $SRItemPackID)
                    ->bindParam(':SRItemOrderQty', $SRItemOrderQty)
                    ->bindParam(':SRCreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $itemlist = VwItemList::findOne(['ItemID' => $modeledit['ItemID']]);
            $modeledit['ItemName'] = $itemlist['ItemName'];
            $itempack = VwItempack::findAll(['ItemID' => $modeledit['ItemID']]);
            if ($itempack == null) {
                $pack[] = '';
            } else {
                foreach ($itempack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            }
            $itempack2 = VwItempack::findOne(['ItemID' => $modeledit['ItemID'], 'ItemPackID' => $modeledit->SRItemPackID]);
            if (!empty($itempack2)) {
                $itempack2 = $itempack2->ItemPackUnit;
            } else {
                $itempack2 = '';
            }
            $itempack3 = VwItempack::findOne(['ItemID' => $modeledit['ItemID'], 'ItemPackID' => $modeledit->SRItemPackID]);
            if (!empty($itempack3)) {

                $ItemPackSKU = $itempack3->ItemPackSKUQty;
            } else {

                $ItemPackSKU = '';
            }
            $sr2detail = \app\modules\Inventory\models\Vwsr2detail::findOne(['ids' => $id]);
            $balance = \app\modules\Inventory\models\VwStkBalanceItemid::findOne(['ItemID' => $modeledit['ItemID'], 'StkID' => $stkid]);
            return $this->renderAjax('_form_detail', [
                        'modeledit' => $modeledit,
                        'pack' => $pack,
                        'SRID' => $modeledit['SRID'],
                        'btn' => '',
                        'sritempackid' => $itempack2,
                        'ItemPackSKUQty' => $ItemPackSKU,
                        'DispUnit' => $sr2detail['DispUnit'],
                        'balance' => $balance['ItemQtyBalance']
            ]);
        }
    }

    public function actionSelectBox() {
        $item_ids = Yii::$app->request->get('item_ids');
        $item_packid_unit = Yii::$app->request->get('item_packid_unit');
        $qty = VwItempack::findOne([
                    'ItemID' => $item_ids,
                    'ItemPackUnit' => $item_packid_unit
        ]);
        if (isset($qty->ItemPackSKUQty)) {
            echo $qty->ItemPackSKUQty;
        }
    }

    public function actionSr2_approve($id) {
        $x = $id;
        $userid = Yii::$app->user->id;
        Yii::$app->db->createCommand('
                    CALL cmd_sr2_approve(:x,:userid);')
                ->bindParam(':x', $x)
                ->bindParam(':userid', $userid)
                ->execute();
        Yii::$app->finddata->setmessage("StockRuest " . $id . "Approve Success fully");
        echo '1';
    }

    public function actionRejecct() {
        $pos = Yii::$app->request->get();
        $x = $pos['id'];
        $userid = Yii::$app->user->id;
        $SRRejectNote = $pos['SRRejectNote'];
        Yii::$app->db->createCommand('
                    CALL cmd_sr2_reject(:x,:userid,:SRRejectNote);')
                ->bindParam(':x', $x)
                ->bindParam(':userid', $userid)
                ->bindParam(':SRRejectNote', $SRRejectNote)
                ->execute();
        echo '1';
    }

    public function actionCmd_sr2_approve_ok($id) {
        $x = $id;
        Yii::$app->db->createCommand('CALL cmd_sr2_approve_ok(:x);')->bindParam(':x', $x)->execute();
        echo '1';
    }

    public function actionDeleteDetail() {
        $id = Yii::$app->request->post('id');
        \app\modules\Inventory\models\Tbsritemdetail2::findOne(['ids' => $id])->delete();
    }

    public function actionSavesendtoapprove() {
        $pos = Yii::$app->request->post('Tbsr2temp');
        $SRID = Yii::$app->request->post('SRID'); //$_POST['SRID'];//$SRID;
        $SRReceive_stkID = $pos['SRReceive_stkID'];
        $SRTypeID = $pos['SRTypeID'];
        $DepartmentID = 1;
        $SectionID = 1;
        $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
        $SRReqDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRReqDate']);
        $stk_issue = $pos['SRIssue_stkID'];
        $SRCreateDate = date('Y-m-d');
        $SRExpectDate = date('Y-m-d');
        $SRCreatedBy = Yii::$app->user->id;
        $SRNote = $pos['SRNote'];
        Yii::$app->db->createCommand('
                    CALL cmd_sr2_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,
                    :SRExpectDate,:SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote,:SRReqDate);')
                ->bindParam(':SRID', $SRID)
                ->bindParam(':SRDate', $SRDate)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':SRTypeID', $SRTypeID)
                ->bindParam(':SRExpectDate', $SRExpectDate)
                ->bindParam(':SRIssue_stkID', $stk_issue)
                ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                ->bindParam(':SRCreateDate', $SRCreateDate)
                ->bindParam(':SRCreateBy', $SRCreatedBy)
                ->bindParam(':SRNote', $SRNote)
                ->bindParam(':SRReqDate', $SRReqDate)
                ->execute();

        Yii::$app->db->createCommand('CALL cmd_sr_sent_to_approve(:x);')
                ->bindParam(':x', $SRID)
                ->execute();
        echo $SRID;
        Yii::$app->finddata->setmessage("StockRequest " . $SRID . " Send to Approve Success fully");
    }

    public function actionOkall() {
        $SRID = $_POST['SRID'];
        if (empty($SRID)) {
            return false;
        } else {
            $sql = "SELECT SRPackQtyApprove,SRItemPackIDApprove,SRItemOrderQtyApprove from tb_sritemdetail2 where tb_sritemdetail2.SRID = '$SRID' AND (SRPackQtyApprove <> 0 OR SRItemPackIDApprove <> 0 OR SRItemOrderQtyApprove <> 0);";
            $query = Yii::$app->db->createCommand($sql)->queryAll();
            if (!empty($query)) {
                $sql_update = "update tb_sritemdetail2 SET SRPackQtyApprove='',SRItemPackIDApprove='',SRItemOrderQtyApprove='' where tb_sritemdetail2.SRID = '$SRID';";
                Yii::$app->db->createCommand($sql_update)->query();
            } else {
                Yii::$app->db->createCommand('
                        CALL cmd_sr2_approve_okall(:SRID);')
                        ->bindParam(':SRID', $SRID)
                        ->execute();
                return true;
            }
        }
    }

    public function actionUpdatepha($id) {
        $model = Tbsr2::findOne($id);
        if (Yii::$app->request->post()) {
            $pos = Yii::$app->request->post('Tbsr2');
            $SRID = Yii::$app->request->post('srid');
            $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
            $DepartmentID = 1;
            $SectionID = 1;
            $SRTypeID = $pos['SRTypeID'];
            $SRExpectDate = date('Y-m-d');
            $SRIssue_stkID = $pos['SRIssue_stkID'];
            $SRReceive_stkID = $pos['SRReceive_stkID'];
            $SRCreateDate = date('Y-m-d');
            $SRCreateBy = Yii::$app->user->identity->profile->user_id;
            $SRNote = $pos['SRNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_approve_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,:SRExpectDate,
                    :SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote);')
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':SRDate', $SRDate)
                    ->bindParam(':DepartmentID', $DepartmentID)
                    ->bindParam(':SectionID', $SectionID)
                    ->bindParam(':SRTypeID', $SRTypeID)
                    ->bindParam(':SRExpectDate', $SRExpectDate)
                    ->bindParam(':SRIssue_stkID', $SRIssue_stkID)
                    ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                    ->bindParam(':SRCreateDate', $SRCreateDate)
                    ->bindParam(':SRCreateBy', $SRCreateBy)
                    ->bindParam(':SRNote', $SRNote)
                    ->execute();
            echo '1';
        } else {
            $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
            $searchModel = new Sritemdetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $model->SRDate = $model->SRDate;
            return $this->render('_waitokall', [
                        'model' => $model,
                        'section' => $section,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionApprovereq($id) {
        $model = Tbsr2::findOne($id);
        if (Yii::$app->request->post()) {
            $pos = Yii::$app->request->post('Tbsr2');
            $SRID = Yii::$app->request->post('srid');
            $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
            $DepartmentID = 1;
            $SectionID = 1;
            $SRTypeID = $pos['SRTypeID'];
            $SRExpectDate = date('Y-m-d');
            $SRIssue_stkID = $pos['SRIssue_stkID'];
            $SRReceive_stkID = $pos['SRReceive_stkID'];
            $SRCreateDate = date('Y-m-d');
            $SRCreateBy = Yii::$app->user->identity->profile->user_id;
            $SRNote = $pos['SRNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_approve_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,:SRExpectDate,
                    :SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote);')
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':SRDate', $SRDate)
                    ->bindParam(':DepartmentID', $DepartmentID)
                    ->bindParam(':SectionID', $SectionID)
                    ->bindParam(':SRTypeID', $SRTypeID)
                    ->bindParam(':SRExpectDate', $SRExpectDate)
                    ->bindParam(':SRIssue_stkID', $SRIssue_stkID)
                    ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                    ->bindParam(':SRCreateDate', $SRCreateDate)
                    ->bindParam(':SRCreateBy', $SRCreateBy)
                    ->bindParam(':SRNote', $SRNote)
                    ->execute();
            echo '1';
        } else {
            $section = ArrayHelper::map($this->getAmphur($model['DepartmentID']), 'id', 'name');
            $searchModel = new Sritemdetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $model->SRDate = $model->SRDate;
            return $this->render('_from_approve', [
                        'model' => $model,
                        'section' => $section,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCmd_sr2_approve() {
        $pos = Yii::$app->request->post('Tbsr2');
        $SRID = $SRID;
        $SRReceive_stkID = $pos['SRReceive_stkID'];
        $SRTypeID = $pos['SRTypeID'];
        $DepartmentID = $pos['DepartmentID'];
        $SectionID = $pos['SectionID'];
        $SRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['SRDate']);
        $stk_issue = $pos['SRIssue_stkID'];
        $SRCreateDate = date('Y-m-d');
        $SRExpectDate = date('Y-m-d');
        $SRCreatedBy = Yii::$app->user->id;
        $SRNote = $pos['SRNote'];
        Yii::$app->db->createCommand('
                    CALL cmd_sr2_savedraft(:SRID,:SRDate,:DepartmentID,:SectionID,:SRTypeID,
                    :SRExpectDate,:SRIssue_stkID,:SRReceive_stkID,:SRCreateDate,:SRCreateBy,:SRNote);')
                ->bindParam(':SRID', $SRID)
                ->bindParam(':SRDate', $SRDate)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':SRTypeID', $SRTypeID)
                ->bindParam(':SRExpectDate', $SRExpectDate)
                ->bindParam(':SRIssue_stkID', $stk_issue)
                ->bindParam(':SRReceive_stkID', $SRReceive_stkID)
                ->bindParam(':SRCreateDate', $SRCreateDate)
                ->bindParam(':SRCreateBy', $SRCreatedBy)
                ->bindParam(':SRNote', $SRNote)
                ->execute();
    }

    public function actionDetailedit() {
        $id = Yii::$app->request->get('id');
        $model = Tbsritemdetail2::findOne(['ids' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsritemdetail2');

            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackUnit' => !empty($pos['SRItemPackIDApprove']) ? $pos['SRItemPackIDApprove'] : '']);
            if ($itempack != null) {
                $itemp = $itempack->ItemPackID;
            } else {
                if (!empty($pos['SRItemPackIDApprove'])) {
                    $itemp = $pos['SRItemPackIDApprove'];
                } else {
                    $itemp = '';
                }
            }
            $ids = $pos['ids'];
            $SRNum = $pos['SRNum'];
            $SRID = $pos['SRID'];
            $ItemID = $pos['ItemID'];
            $SRPackQty = str_replace(',', '', $pos['SRPackQtyApprove']);
            $SRItemPackID = $itemp;
            $SRItemOrderQty = str_replace(',', '', $pos['SRItemOrderQtyApprove']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_item_save2(:ids,:SRNum,:SRID,:ItemID,:SRPackQty,
                    :SRItemPackID,:SRItemOrderQty,:SRCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':SRPackQty', $SRPackQty)
                    ->bindParam(':SRItemPackID', $SRItemPackID)
                    ->bindParam(':SRItemOrderQty', $SRItemOrderQty)
                    ->bindParam(':SRCreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $checkpack = VwItempack::findAll(['ItemID' => $model->ItemID]);
            if ($checkpack != null) {
                foreach ($checkpack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
                $btn = '';
            } else {
                $pack = '';
                $btn = '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>';
            }
            $itempackid = VwItempack::findOne(['ItemID' => $model->ItemID, 'ItemPackID' => $model->SRItemPackID]);
            if ($itempackid != null) {
                $itempackid = $itempackid;
            } else {
                $itempackid = new VwItempack;
            }
            $vwsr2detail = \app\modules\Inventory\models\Vwsr2detail2::findOne(['ids' => $id]);
            return $this->renderAjax('detail', [
                        'model' => $model,
                        'pack' => $pack,
                        'vwsr2detail' => $vwsr2detail,
                        'itempackid' => $itempackid
            ]);
        }
    }

    public function actionDetailselect2() {
        $modeledit = new Tbsritemdetail2();
        if ($modeledit->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('Tbsritemdetail2');

            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackUnit' => !empty($pos['SRItemPackID']) ? $pos['SRItemPackID'] : '']);
            if ($itempack != null) {
                $itemp = $itempack->ItemPackID;
            } else {
                if (!empty($pos['SRItemPackID'])) {
                    $itemp = $pos['SRItemPackID'];
                } else {
                    $itemp = null;
                }
            }
            $models = Tbsr2::findOne(['SRID' => $pos['SRID']]);
            $SRNum = empty($models->SRNum) ? $models->SRNum : '';
            $ids = "";
            $SRID = $pos['SRID'];
            $ItemID = $pos['ItemID'];
            $SRPackQty = str_replace(',', '', $pos['SRPackQty']);
            $SRItemPackID = $itemp;
            $SRItemOrderQty = str_replace(',', '', $pos['SRItemOrderQty']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sr2_item_save2(:ids,:SRNum,:SRID,:ItemID,:SRPackQty,
                    :SRItemPackID,:SRItemOrderQty,:SRCreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':SRID', $SRID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':SRPackQty', $SRPackQty)
                    ->bindParam(':SRItemPackID', $SRItemPackID)
                    ->bindParam(':SRItemOrderQty', $SRItemOrderQty)
                    ->bindParam(':SRCreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $pos = Yii::$app->request->post();
            if ($pos['type'] == '1') {
                $check = Tbsritemdetail2::findAll(['ItemID' => $pos['id'], 'SRID' => $pos['SRID']]);
            } else {
                $check = Tbsritemdetail2::findAll(['ItemID' => $pos['id'], 'SRID' => $pos['SRID']]);
            }
            if ($check != null) {
                return 'false';
            } else {

                if ($pos['type'] == '1') {
                    $Item = VwItemList::findOne(['ItemID' => $pos['id']]);
                    $modeledit['ItemID'] = $Item['ItemID'];
                    $modeledit['ItemName'] = $Item['ItemName'];
                    $DispUnit = $Item['DispUnit'];
                } else {
                    $Item = VwItemList::findOne(['ItemID' => $pos['id']]);
                    $modeledit['ItemID'] = $Item['ItemID'];
                    $modeledit['ItemName'] = $Item['ItemName'];
                    $DispUnit = $Item['DispUnit'];
                }
                $checkpack = VwItempack::findAll(['ItemID' => $pos['id']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>';
                }
                return $this->renderAjax('_form_sr_detail', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'DispUnit' => $DispUnit,
                            'btn' => $btn,
                            'SRID' => $pos['SRID'],
                            'balance' => $pos['balance']
                ]);
            }
        }
    }

    protected function findModel($id) {
        if (($model = TbSr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
