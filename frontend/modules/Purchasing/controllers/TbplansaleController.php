<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\models\TbPcplan2;
use app\models\TbPcplanSearch2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TbSection;
use app\models\TbPcplannddetail;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\Vwitemlistnmd;
use app\models\Profile;
use app\modules\Purchasing\models\Viewplannddetail;
use app\modules\Purchasing\models\Vwndplandetailavalible;
use app\modules\Purchasing\models\Vwpc2nddetail;
use app\modules\Purchasing\models\Vwpc2header;

/**
 * TbplanController implements the CRUD actions for TbPcplan model.
 */
class TbplansaleController extends Controller {

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
        $post = Yii::$app->request->post('TbPcplan2');
        $model = new TbPcplan2();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan2::findOne($post['PCPlanNum']);
            if ($models != "") {
                $model = TbPcplan2::findOne($post['PCPlanNum']);
            }
            $model->PCPlanNum = $post['PCPlanNum'];
            $model->PCPOContactID = $post['PCPOContactID'];
            $model->PCVendorID = $post['PCVendorID'];
            $model->PCPlanTypeID = 6;
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanEndDate']);
            $model->PCPlanStatusID = $post['PCPlanStatusID'] != null ? $post['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 5;
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
        $datas = TbPcplan2::find()->where(['PCPlanNum' => $id])->all();
        if ($datas != null) {
            $TbPrgpudetail = TbPcplan2::findOne(['PCPlanNum' => $id]);
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

    function actionSendToApprove() {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $datas = TbPcplan2::find()->where(['PCPlanNum' => $id])->all();
        if ($datas != null) {
            $TbPrgpudetail = TbPcplan2::findOne(['PCPlanNum' => $id]);
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

    function actionDatavwndplandetailavalible() {
        $tbgenericproductusegpu = Vwndplandetailavalible::find()->all();
        $data = array();
        $i = 1;
        foreach ($tbgenericproductusegpu as $person) {
            $row = array();
            $row[] = $i;
            $row[] = $person->ItemID;
            $row[] = $person->ItemName;
            $row[] = $person->PCPlanNDUnitCost;
            $row[] = $person->PCPlanNDQty;
            $row[] = $person->DispUnit;
            $row[] = $person->PCPlanNDExtendedCost;
            $row[] = $person->PRApprovedQtySUM;
            $row[] = $person->PRNDAvalible;
            $row[] = $person->Stkbalance;
            $row[] = $person->ItemOnPO;
            $data[] = $row;
            $i++;
        }
        $output = array(
            "data" => $data,
        );
        //    print_r($output);
        echo json_encode($output);
    }

    function actionCheckpcplan() {
        $rs = TbPcplan2::find()->where(['PCPlanTypeID' => '3', 'Pcplandrugandnondrug' => '2', 'PCPlanStatusID' => ['1', '2']])->all();
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

    function actionSaveactive() {
        $post = Yii::$app->request->post();
        $id = $post['id'];
        $datas = TbPcplan2::find()->where(['PCPlanNum' => $id])->all();

        if ($datas != null) {
            $TbPrgpudetail = TbPcplan2::findOne(['PCPlanNum' => $id]);
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
        $searchModel = new TbPcplanSearch2();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionView($id) {
//        $model = $this->findModel($id);
//        $model->PCPlanDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanDate);
//        $model->PCPlanBeginDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanBeginDate);
//        $model->PCPlanEndDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanEndDate);
//        $tbpcplangpu = Viewplannddetail::findAll(['PCPlanNum' => $id]);
//        return $this->renderAjax('view', [
//                    'model' => $model,
//                    'tbpcplangpu' => $tbpcplangpu
//        ]);
//    }

    public function actionAddnondrug() {
        $post = Yii::$app->request->post('TbPcplan2');
        $model = new TbPcplan2();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan2::findOne($post['PCPlanNum']);
            if ($models != "") {
                $model = TbPcplan2::findOne($post['PCPlanNum']);
            }
            $model->PCPlanNum = $post['PCPlanNum'];
            $model->PCPOContactID = $post['PCPOContactID'];
            $model->PCVendorID = $post['PCVendorID'];
            $model->PCPlanTypeID = 6;
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanEndDate']);
            $model->PCPlanStatusID = $post['PCPlanStatusID'] != null ? $post['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 5;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $result = TbPcplan2::find()->count();
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
        $post = Yii::$app->request->post();
        $out = [];
        if (isset($post['depdrop_parents'])) {
            $parents = $post['depdrop_parents'];
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

    public function actionPrimacyaprove($id) {
        $type = Yii::$app->componentdate->aes128Decrypt($id, Yii::$app->request->get('type'));
        $post = Yii::$app->request->post('TbPcplan2');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model = TbPcplan2::findOne($id);
            $model->PCPlanNum = $post['PCPlanNum'];
            $model->PCPOContactID = $post['PCPOContactID'];
            $model->PCVendorID = $post['PCVendorID'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate($post['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate($post['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate($post['PCPlanEndDate']);
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 5;
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
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
            $Productmodel = Profile::find()->where(['VendorID' => $model->PCVendorID])->one();
            return $this->render('_form_primacy', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'vendername' => $Productmodel['VenderName'],
                        'type' => $type
            ]);
        }
    }

    public function actionUpdate($id) {
        $post = Yii::$app->request->post('TbPcplan2');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model = TbPcplan2::findOne($id);
            $model->PCPlanNum = $post['PCPlanNum'];
            $model->PCPOContactID = $post['PCPOContactID'];
            $model->PCVendorID = $post['PCVendorID'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['PCPlanEndDate']);
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 5;
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumndextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
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
            $Productmodel = Profile::find()->where(['VendorID' => $model->PCVendorID])->one();
            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'vendername' => $Productmodel['VenderName']
            ]);
        }
    }

    public function actionView($id) {
        $model = TbPcplan2::findOne(['PCPlanNum' => $id]);
        $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
        $tbpcplangpu = Vwpc2nddetail::findAll(['PCPlanNum' => $id]);
        $Productmodel = Profile::find()->where(['VendorID' => $model->PCVendorID])->one();
        return $this->render('_view', [
                    'model' => $model,
                    'section' => $section,
                    'tbpcplangpu' => $tbpcplangpu,
                    'vendername' => $Productmodel['VenderName']
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
        if (($model = TbPcplan2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionSavetest() {
        $pcnon = new TbPcplannddetail();
        $pcnon->PCPlanNum = '1';
        $pcnon->ItemID = 1;
        $pcnon->PCPlanNDUnitCost = 10;
        $pcnon->PCPlanNDQty = 10;
        // $pcnon->PCPlanNDItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate($pc['PCPlanNonDrugItemEffectDate']);
        $pcnon->save();
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
            'NonDrugExtendedCost' => number_format($result->PCPlanNDUnitCost * $result->PCPlanNDQty, 2),
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
        $data = array();
        foreach ($Productmodel as $person) {
            $row = array();
            $row[] = $person->ItemID;
            $row[] = $person->ItemNDMedSupply;
            $row[] = $person->ItemName;
            $row[] = '<a href="#" class="btn btn-success btn-sm" onclick="myFunselectdata(' . $person->ItemID . ');"> select</a>';
            $data[] = $row;
        }
        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
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
