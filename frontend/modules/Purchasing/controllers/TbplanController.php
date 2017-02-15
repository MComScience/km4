<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\models\TbPcplan;
use app\models\TbPcplanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TbSection;
use app\models\TbPcplannddetail;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\Vwitemlistnmd;
use app\modules\Purchasing\models\Viewplannddetail;
use app\modules\Purchasing\models\VwndplandetailavalibleSearch;
use app\modules\Purchasing\models\Vwndplandetailavalible;
use app\modules\Purchasing\models\Vwpc2nddetail;

/**
 * TbplanController implements the CRUD actions for TbPcplan model.
 */
class TbplanController extends Controller {

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

    public function actionForm_main() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = new TbPcplan();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan::findOne(['PCPlanNum' => $pos['PCPlanNum']]);
            if ($models != "") {
                $model = $this->findModel($pos['PCPlanNum']);
                $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
                $totalall = $cmd['sum'];
            } else {
                $result = TbPcplan::find()->count();
                $auto = $result + 1;
                $dat = substr(date('Y') + 543, 2, 4);
                $auto = sprintf("%04d", $auto);
                $auto = 'PC' . $dat . '-' . $auto;
                $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
                $totalall = $cmd['sum'];
            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 2;
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    function actionApprove() {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $datas = TbPcplan::find()->where(['PCPlanNum' => $id])->all();
        if ($datas != null) {
            $TbPrgpudetail = TbPcplan::findOne(['PCPlanNum' => $id]);
             if ($post['type'] == '1') {
                $TbPrgpudetail->PCPlanApproveBy = Yii::$app->user->id;
                $TbPrgpudetail->PCPlanApproveDate = date('Y-m-d');
                $TbPrgpudetail->PCPlanApproveTime = date('H:i:s');
                $TbPrgpudetail->PCPlanManagerApproveBy = Yii::$app->user->id;
                $TbPrgpudetail->PCPlanManagerApproveDate = date('Y-m-d');
                $TbPrgpudetail->PCPlanManagerApproveTime = date('H:i:s');
                $TbPrgpudetail->PCPlanStatusID = 5;
            } else {
                $TbPrgpudetail->PCPlanManagerApproveBy = Yii::$app->user->id;
                $TbPrgpudetail->PCPlanManagerApproveDate = date('Y-m-d');
                $TbPrgpudetail->PCPlanManagerApproveTime = date('H:i:s');
                $TbPrgpudetail->PCPlanStatusID = 5;
            }
            $TbPrgpudetail->save();
            $data = array(
                'status' => '1',
                'data' => 'Aprove Success'
            );
            Yii::$app->finddata->setmessage("Plan " . $id . "Approve Success fully");
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
    }

    public function actionPrimacyaprove($id) {
        $type = Yii::$app->componentdate->aes128Decrypt($id,Yii::$app->request->get('type'));
        $pos = Yii::$app->request->post('TbPcplan');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model = TbPcplan::findOne(['PCPlanNum' => $pos['PCPlanNum']]);
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanEndDate']);
            $model->PCPlanTypeID = $pos['PCPlanTypeID'];
            $model->DepartmentID = $pos['DepartmentID'];
            $model->SectionID = $pos['SectionID'];
            $model->Pcplandrugandnondrug = 2;
            $model->PCPlanTotal = $totalall;

            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $model->PCPlanDate = $model->PCPlanDate;
            $model->PCPlanBeginDate = $model->PCPlanBeginDate;
            $model->PCPlanEndDate = $model->PCPlanEndDate;
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            $tbpcplangpu = Viewplannddetail::findAll(['PCPlanNum' => $id]);

            return $this->render('_form_primacy', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'type' => $type
            ]);
        }
    }

    function actionDatavwndplandetailavalible() {
        $tbgenericproductusegpu = Vwndplandetailavalible::find()->all();
        return $tbgenericproductusegpu;
    }

    function actionCheckpcplan() {
        $rs = TbPcplan::find()->where(['PCPlanTypeID' => '3', 'Pcplandrugandnondrug' => '2', 'PCPlanStatusID' => ['1', '2', '4', '5']])->all();
        if ($rs != null) {
            $data = array(
                'status' => '0'
            );
        } else {
            $data = array(
                'status' => '1'
            );
        }
        return json_encode($data);
    }

    function actionSendToApprove() {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $datas = TbPcplan::find()->where(['PCPlanNum' => $id])->all();
        if ($datas != null) {
            $TbPrgpudetail = TbPcplan::findOne(['PCPlanNum' => $id]);
            $TbPrgpudetail->PCPlanStatusID = 4;
            $TbPrgpudetail->save();
            $data = array(
                'status' => '1',
                'data' => 'Send To Success'
            );
            Yii::$app->finddata->setmessage("Plan " . $id . " Send to Approve Success fully");
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
    }

    function actionSaveactive() {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $datas = TbPcplan::find()->where(['PCPlanNum' => $id])->all();

        if ($datas != null) {
            $TbPrgpudetail = TbPcplan::findOne(['PCPlanNum' => $id]);
            $TbPrgpudetail->PCPlanStatusID = 2;
            $TbPrgpudetail->save();
            $data = array(
                'status' => '1',
                'data' => 'Save Active Success'
            );
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
//        
        return json_encode($data);
    }

    /**
     * Lists all TbPcplan models.
     * @return mixed
     */
    function actionFindsave() {
        $begindate = date("Y");
        $datas = TbPcplan::find()->where([' YEAR(PCPlanBeginDate)' => $begindate, 'Pcplandrugandnondrug' => '2'])->all();
        if ($datas != null) {
            return "1";
        } else {
            return "0";
        }
    }

    public function actionIndex() {
        $datavwn = $this->actionDatavwndplandetailavalible();
        $searchModel2 = new VwndplandetailavalibleSearch();
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'searchModel2' => $searchModel2,
                    'dataProvider2' => $dataProvider2,
                    'datavwn' => $datavwn
        ]);
    }

    public function actionAddnondrug() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = new TbPcplan();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan::findOne(['PCPlanNum' => $pos['PCPlanNum']]);
            if ($models != "") {
                $model = $this->findModel($pos['PCPlanNum']);
                $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
                $totalall = $cmd['sum'];
            } else {
                $result = TbPcplan::find()->count();
                $auto = $result + 1;
                $dat = substr(date('Y') + 543, 2, 4);
                $auto = sprintf("%04d", $auto);
                $auto = 'PC' . $dat . '-' . $auto;
                $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
                $totalall = $cmd['sum'];
            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 2;
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $result = TbPcplan::find()->count();
            $auto = $result + 1;
            $dat = substr(date('Y') + 543, 2, 4);
            $auto = sprintf("%04d", $auto);
            $auto = 'PC' . $dat . '-' . $auto;
            $find = TbPcplannddetail::find()->where(['PCPlanNum' => $auto])->all();
            //$find = TbPcplangpudetail::find($auto);
            if ($find != null) {
                foreach ($find as $r) {
                    $mo = TbPcplannddetail::find()->where(['ids' => $r->ids])->one();
                    $mo->delete();
                }
            }
            $tbpcplangpu = Viewplannddetail::findAll(['PCPlanNum' => $auto]);
            if ($tbpcplangpu == null) {
                $tbpcplangpu = "";
            }

            $model->PCPlanStatusID = 1;
            return $this->render('addnondrug', [
                        'model' => $model,
                        "tbpcplangpu" => $tbpcplangpu,
                        'types' => ''
            ]);
        }
    }

    public function actionGetAmphur() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DepartmentID = $parents[0];
                $out = $this->getAmphur($DepartmentID);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getAmphur($id) {
        $datas = TbSection::find()->where(['DepartmentID' => $id])->all();
        return $this->MapData($datas, 'SectionID', 'SectionDecs');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionUpdate($id) {
        $pos = Yii::$app->request->post('TbPcplan');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model = TbPcplan::findOne(['PCPlanNum' => $pos['PCPlanNum']]);
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanTypeID = $pos['PCPlanTypeID'];
            $model->DepartmentID = $pos['DepartmentID'];
            $model->SectionID = $pos['SectionID'];
            $model->Pcplandrugandnondrug = 2;
            $model->PCPlanTotal = $totalall;

            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $model->PCPlanDate = $model->PCPlanDate;
            $model->PCPlanBeginDate = $model->PCPlanBeginDate;
            $model->PCPlanEndDate = $model->PCPlanEndDate;
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            $tbpcplangpu = Viewplannddetail::findAll(['PCPlanNum' => $id]);

            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu
            ]);
        }
    }

    public function actionView($id) {
        $model = TbPcplan::findOne(['PCPlanNum' => $id]);
        $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
        $tbpcplangpu = Vwpc2nddetail::findAll(['PCPlanNum' => $id]);
        return $this->render('_view', [
                    'model' => $model,
                    'section' => $section,
                    'tbpcplangpu' => $tbpcplangpu
        ]);
    }

    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->PCPlanStatusID = '3';
        $model->save();
        $mo = TbPcplannddetail::findAll(['PCPlanNum' => $id]);
        foreach ($mo as $r) {
            $mol = TbPcplannddetail::findOne($r['ids']);
            $mol->PCPlanItemStatusID = 3;
            $mol->save();
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = TbPcplan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSave() {
        $pc = Yii::$app->request->post();
        $pcnon = TbPcplannddetail::findOne(['PCPlanNum' => $pc['PCPlanNum']]);
        if ($pc['PCDetailID'] == "") {
            $pcnon = new TbPcplannddetail();
            $pcnon->PCPlanNum = $pc['PCPlanNum'];
            $pcnon->ItemID = $pc['ItemID'];
            $pcnon->PCPlanNDUnitCost = str_replace(',', '', $pc['NonDrugUnitCost']);
            $pcnon->PCPlanNDQty = str_replace(',', '', $pc['NonDrugOrderQty']);
            $pcnon->PCPlanNDExtendedCost = str_replace(',', '', $pc['NonDrugExtendedCost']);
            $pcnon->PCPlanNDItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate($pc['PCPlanNonDrugItemEffectDate']);
            $pcnon->PCPlanItemStatusID = 2;
            $pcnon->save();
            $ff = "Save Complete!";
        } else {
            $pcnon = TbPcplannddetail::findOne($pc['PCDetailID']);
            $pcnon->PCPlanNum = $pc['PCPlanNum'];
            $pcnon->ItemID = $pc['ItemID'];
            $pcnon->PCPlanNDUnitCost = str_replace(',', '', $pc['NonDrugUnitCost']);
            $pcnon->PCPlanNDQty = str_replace(',', '', $pc['NonDrugOrderQty']);
            $pcnon->PCPlanNDExtendedCost = str_replace(',', '', $pc['NonDrugExtendedCost']);
            $pcnon->PCPlanNDItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate($pc['PCPlanNonDrugItemEffectDate']);
            $pcnon->PCPlanItemStatusID = 2;
            $pcnon->save();
            $ff = "Save Complete!";
        }
        $htl = Yii::$app->headertable->headertableplandetail();
        $users = Viewplannddetail::findAll(['PCPlanNum' => $pc['PCPlanNum']]);
        $htl .= Yii::$app->finddata->finddatadetailplan($users);
        $arr = array(
            'htn' => $htl,
            'ff' => $ff
        );
        return json_encode($arr);
    }

    public function actionEditlistnondrug() {
        $pc = Yii::$app->request->post();
        $result = TbPcplannddetail::findOne($pc['id']);
        $ar = array(
            'PCPlanNum' => $result->PCPlanNum,
            'ItemID' => $result->ItemID,
            'ItemName' => $result->item->ItemName,
            'itemDispUnit' => $result->item->DispUnit,
            'NonDrugUnitCost' => number_format($result->PCPlanNDUnitCost, 2),
            'NonDrugOrderQty' => number_format($result->PCPlanNDQty, 2),
            'NonDrugExtendedCost' => number_format($result->PCPlanNDExtendedCost, 2),
            'PCPlanNonDrugItemEffectDate' => Yii::$app->componentdate->convertMysqlToThaiDate($result->PCPlanNDItemEffectDate),
            'PCDetailID' => $result->ids,
        );

        return json_encode($ar);
    }

    public function actionDeletedetailnondrug() {
        $pc = Yii::$app->request->post();
        $post = TbPcplannddetail::findOne($pc['ids']); // assuming there is a post whose ID is 10
        $post->delete();
        $ff = "ลบรายการ เรียบร้อยแล้ว";
        $result = Viewplannddetail::findAll(['PCPlanNum' => $pc['prnums']]);
        if ($result != null) {
            $htl = Yii::$app->headertable->headertableplandetail();
            $htl .= Yii::$app->finddata->finddatadetailplan($result);
            $ar = array(
                'htl' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
        } else {
            $htl = '';
            $ff = "ลบรายการ เรียบร้อยแล้ว";
            $ar = array(
                'htl' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
        }
    }

    function actionData1() {
        $Productmodel = Vwitemlistnmd::find()->all();
        $data = '<table id="pcplanbydrugtable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center" width="30%">รหัสสินค้า</th>
                    <th style="text-align:center" width="30%">หมวดเวชภัณฑ์</th>
                    <th style="text-align:center">ชื่อสินค้า</th>
                    <th style="text-align:center" width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($Productmodel as $person) {
            $data .= '<tr>';
            $data .='<td style="text-align:center">' . $person->ItemID . '</td>';
            $data .='<td >' . $person->ItemNDMedSupply . '</td>';
            $data .='<td >' . $person->ItemName . '</td>';
            $data .='<td style="text-align:center">' . '<a href="#" class="btn btn-success btn-sm" onclick="myFunselectdata(' . $person->ItemID . ');"> select</a></td>';

            $data .= '</tr>';
        }
        $data .= '</tbody>
        </table>';
        return $data;
    }

    public function actionGetdata() {
        $TbPcplannondrugdetail = TbPcplannddetail::find()->where(['ItemID' => Yii::$app->request->post('id'), 'PCPlanNum' => Yii::$app->request->post('prnums')])->one();
        if ($TbPcplannondrugdetail == null) {
            $id = Yii::$app->request->post('id');
            $item = Vwitemlistnmd::find()->where(['ItemID' => $id])->one();
            $arr = array(
                'ItemID' => $item['ItemID'],
                'ItemName' => $item['ItemName'],
                'itemDispUnit' => $item['DispUnit'],
            );
            return json_encode($arr);
        } else {
            $arr = array('ale' => "รายการนี้ถูกเลือกแล้ว");
            return json_encode($arr);
        }
    }

}
