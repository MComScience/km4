<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\models\TbPcplan2;
use app\models\TbPcplanSearch2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TbSection;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\TbPcplantpudetail;
use app\models\VwItemListTpu;
use app\models\Profile;
use app\modules\Purchasing\models\Viewplandrugdetail;
use app\modules\Purchasing\models\Vwtpuplandetailavalible;
use app\modules\Purchasing\models\Vwpc2tpudetail;

class PlansaleTpuController extends Controller {

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

    public function actionCreatePlanGpuHeader() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $result = TbPcplan2::find()->max('PCPlanNum');
        $auto = substr($result, 5) + 1;
        $dat = substr(date('Y') + 543, 2, 4);
        $auto = sprintf("%04d", $auto);
        $auto = 'PC' . $dat . '-' . $auto;
        $cmd = Yii::$app->db->createCommand('CALL cmd_plangpu_create_header(:userid,:PCPlanNum);')->bindParam(':userid', $userid)->bindParam(':PCPlanNum', $auto)->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'PCPlanNum' => $auto]);
    }

    public function actionForm_main() {
        $pos = Yii::$app->request->post('TbPcplan2');
        $b = Yii::$app->db;
        // $model = new TbPcplan2();
        $model = TbPcplan2::findOne($pos['PCPlanNum']);
        if ($model->load(Yii::$app->request->post())) {
//            $models = TbPcplan2::findOne($pos['PCPlanNum']);
//            if ($models != "") {
            $model = $this->findModel($pos['PCPlanNum']);
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
//            } else {
//                $result = TbPcplan2::find()->count();
//                $auto = $result + 1;
//                $dat = substr(date('Y') + 543, 2, 4);
//                $auto = sprintf("%04d", $auto);
//                $auto = 'PC' . $dat . '-' . $auto;
//                $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
//                $totalall = $cmd['sum'];
//            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPOContactID = $pos['PCPOContactID'];
            $model->PCVendorID = $pos['PCVendorID'];
            $model->PCPlanTypeID = 5;
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->PCPlanTotal = $totalall;
            $model->Pcplandrugandnondrug = 4;
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
                $TbPrgpudetail->PCPlanStatusID = 6;
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
            Yii::$app->logger->savelog("อนุมัติสัญญาจะชื้อจะขายยาการค้า", $id);
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
            Yii::$app->logger->savelog("ส่งสัญญาจะชื้อจะขายยาการค้าไปอนุมัติ", $id);
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
    }

    function actionDatavwtpuplandetailavalible() {
        $tbgenericproductusegpu = Vwtpuplandetailavalible::find()->all();
        $data = array();
        $i = 1;
        foreach ($tbgenericproductusegpu as $person) {
            $row = array();
            $row[] = $i;
            $row[] = $person->TMTID_TPU;
            $row[] = $person->ItemName;
            $row[] = number_format($person->TPUUnitCost, 2);
            $row[] = number_format($person->TPUOrderQty, 2);
            $row[] = $person->DispUnit;
            $row[] = number_format($person->TPUExtendedCost);
            $row[] = $person->PRApprovedOrderQty;
            $row[] = $person->PRGPUAvalible;
            $row[] = $person->Stkbalance;
            $row[] = $person->ItemOnPO;
            $data[] = $row;
            $i++;
        }
        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    function actionCheckpcplan() {
        $rs = TbPcplan2::find()->where(['PCPlanTypeID' => '1', 'Pcplandrugandnondrug' => '3', 'PCPlanStatusID' => ['1', '2', '4', '5']])->all();
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

    function actionFindsave() {
        $begindate = date("Y");
        $datas = TbPcplan2::find()->where([' YEAR(PCPlanBeginDate)' => $begindate, 'Pcplandrugandnondrug' => '3'])->all();
        if ($datas != null) {
            return "1";
        } else {
            return "0";
        }
    }

    public function actionDatapcplandrug() {
        $Productmodel = Vwitemlisttpu::find()->all();
        $data = '<table id="pcplandrugtable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center">รหัสยาการค้า</th>
                    <th style="text-align:center">ชื่อยาการค้า</th>
                    <th style="text-align:center">รายละเอียดยาการค้า</th>
                    <th style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($Productmodel as $person) {
            $data .= '<tr>';
            $data .= '<td style="text-align:center">' . $person->TMTID_TPU . '</td>';
            $data .= '<td >' . $person->TradeName_TMT . '</td>';
            $data .= '<td >' . $person->FSN_TMT . '</td>';
            $data .= '<td style="text-align:center"><a href="#" id="editabledatatable_new" class="btn btn-success btn-sm" onclick="myFunpcplanbydrug(' . $person->TMTID_TPU . ');"> select</a>' . '</td>';
            $data .= '</tr>';
        }
        $data .= '</tbody>
        </table>';
        return $data;
    }

    public function actionDatavender() {
        $Productmodel = Profile::find()->where(['UserCatID' => '2'])->all();

        $data = '<table id="vender_select" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center">รหัสผู้ขาย</th>
                    <th style="text-align:center">ชื่อผู้ขาย</th>
                    <th style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($Productmodel as $person) {
            $data .= '<tr>';
            $data .= '<td style="text-align:center">' . $person->VendorID . '</td>';
            $data .= '<td style="text-align:center">' . $person->VenderName . '</td>';
            $data .= '<td style="text-align:center">' . \yii\helpers\Html::a('Select', '#', ['class' => 'btn btn-sm btn-success', 'id' => $person->VendorID, 'onclick' => 'test(this);']) . '</td>';
            //$data .= '<td style="text-align:center">' . '<a class="btn btn-success" onclick="test(' . $person->VendorID . ')">select</a>' . '</td>';
            $data .= '</tr>';
        }
        $data .= '</tbody>
        </table>';

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function actionGetvender() {
        $rs = Profile::findOne(['VendorID' => Yii::$app->request->post('id')]);
        $data = array(
            'venderid' => $rs->VendorID,
            'vendername' => $rs->VenderName
        );
        echo json_encode($data);
    }

    public function actionGetdata() {
        $TbPcplantpudetail = TbPcplantpudetail::find()->where(['TMTID_TPU' => Yii::$app->request->post('id'), 'PCPlanNum' => Yii::$app->request->post('prnums')])->one();
        if ($TbPcplantpudetail == null) {
            $employee = Vwitemlisttpu::find()->where(['TMTID_TPU' => Yii::$app->request->post('id')])->one();
            $arr = array(
                'TMTID_GPU' => $employee['TMTID_TPU'],
                'FSN_GPU' => $employee['FSN_TMT'],
                'itemDispUnit' => $employee['DispUnit']
            );
            return json_encode($arr);
        } else {
            $arr = array('ale' => 'รายการนี้ถูกเลือกแล้ว');
            return json_encode($arr);
        }
    }

    public function actionGetsection() {
        $pos = Yii::$app->request->post();
        $out = [];
        if (isset($pos['depdrop_parents'])) {
            $parents = $pos['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
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

    public function actionSavedata() {
        $post = Yii::$app->request->post();
        $TbPcplangpudetail = TbPcplantpudetail::findOne(['PCPlanNum' => 'PC60-0043']);
        if ($post['ids'] == "") {
            $TbPcplangpudetail = new TbPcplantpudetail();
            $TbPcplangpudetail->PCPlanNum = empty($post['prnum']) ? null : $post['prnum'];
            $TbPcplangpudetail->TMTID_TPU = empty($post['tmtgpu']) ? null : $post['tmtgpu'];
            $TbPcplangpudetail->TPUUnitCost = empty($post['gpuunitCost']) ? null : str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->TPUOrderQty = empty($post['gpuorderqty']) ? null : str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->TPUExtendedCost = empty($post['gpuextended']) ? null : str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanItemEffectDate = empty($post['effectivedate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['effectivedate']);
            $TbPcplangpudetail->PCPlanItemStatusID = '2';
            $TbPcplangpudetail->save();
            $ff = "Save Complete!";
        } else {
            $TbPcplangpudetail = TbPcplantpudetail::findOne($post['ids']);
            $TbPcplangpudetail->PCPlanNum = empty($post['prnum']) ? null : $post['prnum'];
            $TbPcplangpudetail->TMTID_TPU = empty($post['tmtgpu']) ? null : $post['tmtgpu'];
            $TbPcplangpudetail->TPUUnitCost = empty($post['gpuunitCost']) ? null : str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->TPUOrderQty = empty($post['gpuorderqty']) ? null : str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->TPUExtendedCost = empty($post['gpuextended']) ? null : str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanItemEffectDate = empty($post['effectivedate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['effectivedate']);
            $TbPcplangpudetail->PCPlanItemStatusID = '2';
            $TbPcplangpudetail->save();
            $ff = "Save Complete!";
        }
        $htl = Yii::$app->headertable->headertableplandrugdetail();
        $result = Viewplandrugdetail::findAll(['PCPlanNum' => $post['prnum']]);
        $htl .= Yii::$app->finddata->finddatadetailplandrug($result);
        $arr = array(
            'htn' => $htl,
            'ff' => $ff
        );
        return json_encode($arr);
    }

    public function actionDeletelistdrug() {
        $postt = Yii::$app->request->post();
        $post = TbPcplantpudetail::findOne($postt['ids']); // assuming there is a post whose ID is 10
        $post->delete();
        $ff = "ลบรายการเรียบร้อยแล้ว";
        $result = Viewplandrugdetail::findAll(['PCPlanNum' => $postt['prnums']]);
        if ($result != null) {
            $htl = Yii::$app->headertable->headertableplandrugdetail();
            $htl .= Yii::$app->finddata->finddatadetailplandrug($result);
            $ar = array(
                'htn' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
        } else {
            $htl = '';
            $ff = "ลบรายการเรียบร้อยแล้ว";
            $ar = array(
                'htn' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
        }
    }

    public function actionEditlistdrug() {
        $post = Yii::$app->request->post();
        $result = TbPcplantpudetail::findOne($post['id']);
        $ar = array(
            'PCPlanNum' => $result->PCPlanNum,
            'TMTID_GPU' => $result->TMTID_TPU,
            'GPUUnitCost' => number_format($result->TPUUnitCost, 2),
            'GPUOrderQty' => number_format($result->TPUOrderQty, 2),
            'GPUExtendedCost' => number_format($result->TPUUnitCost * $result->TPUOrderQty, 2),
            'PCPlanGPUItemEffectDate' => Yii::$app->componentdate->convertMysqlToThaiDate($result->PCPlanItemEffectDate),
            'PCPlanGPUItemStatusID' => $result->PCPlanItemStatusID,
            'ids' => $result->ids,
            'fsngpu' => $result->mastertmt->FSN_TMT,
            'itemDispUnit' => $result->mastertmt->DispUnit
        );
        return json_encode($ar);
    }

    public function actionIndex() {
        $searchModel = new TbPcplanSearch2();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        //  $model = Vwpc2header::findOne(['PCPlanNum' => $id]);
        $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
        $tbpcplangpu = Vwpc2tpudetail::findAll(['PCPlanNum' => $id]);
        $Productmodel = Profile::find()->where(['VendorID' => $model->PCVendorID])->one();
        return $this->render('_view', [
                    'model' => $model,
                    'tbpcplangpu' => $tbpcplangpu,
                    'section' => $section,
                    'vendername' => $Productmodel['VenderName']
        ]);
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
        return json_encode($data);
    }

    public function actionCreate($PCPlanNum = null) {//savedata to db
        $pos = Yii::$app->request->post('TbPcplan2');
        $b = Yii::$app->db;
        //   $model = new TbPcplan2();
        $model = TbPcplan2::findOne(['PCPlanNum' => $PCPlanNum]);
        if ($model->load(Yii::$app->request->post())) {
//            $models = TbPcplan2::findOne($pos['PCPlanNum']);
//
//            if ($models != "") {
            $model = $this->findModel($pos['PCPlanNum']);
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
//            } else {
//                $result = TbPcplan2::find()->count();
//                $auto = $result + 1;
//                $dat = substr(date('Y') + 543, 2, 4);
//                $auto = sprintf("%04d", $auto);
//                $auto = 'PC' . $dat . '-' . $auto;
//                $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
//                $totalall = $cmd['sum'];
//            }
            $PCPlanNum = $pos['PCPlanNum'];
            $PCPOContactID = empty($pos['PCPOContactID']) ? null : $pos['PCPOContactID'];
            $PCVendorID = empty($pos['PCVendorID']) ? null : $pos['PCVendorID'];
            $PCPlanDate = empty($pos['PCPlanDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']);
            $PCPlanBeginDate = empty($pos['PCPlanBeginDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $PCPlanEndDate = empty($pos['PCPlanEndDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $PCPlanCreatedBy = Yii::$app->user->id;
            $DepartmentID = empty($pos['DepartmentID']) ? null : $pos['DepartmentID'];
            $SectionID = empty($pos['SectionID']) ? null : $pos['SectionID'];
            $sql = "
                 UPDATE
                        tb_pcplan
                    SET 
                        PCPOContactID = '$PCPOContactID',
                        PCVendorID = '$PCVendorID',
                        DepartmentID = '$DepartmentID',
                        SectionID = '$SectionID',
                        PCPlanTypeID = 5,
                        PCPlanDate = '$PCPlanDate',
                        PCPlanBeginDate = '$PCPlanBeginDate',
                        PCPlanEndDate = '$PCPlanEndDate',
                        PCPlanStatusID = PCPlanStatusID,
                        PCPlanCreatedBy = PCPlanCreatedBy,
                        PCPlanCreatedDate = NOW(),
                        PCPlanCreatedTime = NOW(),
                        PCPlanTotal = '$totalall',
                        Pcplandrugandnondrug = 4
                    WHERE PCPlanNum = '$PCPlanNum';
                 ";
            Yii::$app->db->createCommand($sql)->execute();
            echo '1';
            /*
              Yii::$app->db->createCommand($sql)->execute();
              $model->PCPlanNum = $pos['PCPlanNum'];
              $model->PCPOContactID = $pos['PCPOContactID'];
              $model->PCVendorID = $pos['PCVendorID'];
              $model->PCPlanTypeID = 5;
              $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
              $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
              $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
              $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
              $model->PCPlanCreatedBy = Yii::$app->user->id;
              $model->PCPlanCreatedDate = date('Y-m-d');
              $model->PCPlanCreatedTime = date('H:i');
              $model->PCPlanTotal = $totalall;
              $model->Pcplandrugandnondrug = 4;
              if ($model->save()) {
              //Yii::$app->logger->savelog("บันทึกสัญญาจะชื้อจะขายยาการค้า",$pos['PCPlanNum']);
              echo 1;
              } else {
              echo 0;
              } */
        } else {
//            $result = TbPcplan2::find()->count();
//            $auto = $result + 1;
//            $dat = substr(date('Y') + 543, 2, 4);
//            $auto = sprintf("%04d", $auto);
//            $auto = 'PC' . $dat . '-' . $auto;
//            $find = TbPcplantpudetail::find()->where(['PCPlanNum' => $auto])->all();
//            //$find = TbPcplan2gpudetail::find($auto);
//            if ($find != null) {
//                foreach ($find as $r) {
//                    $mo = TbPcplantpudetail::find()->where(['ids' => $r->ids])->one();
//                    $mo->delete();
//                }
//            }
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            $tbpcplangpu = Viewplandrugdetail::findAll(['PCPlanNum' => $PCPlanNum]);
            if ($tbpcplangpu == null) {
                $tbpcplangpu = "";
            }

            $model->PCPlanStatusID = 1;
            return $this->render('create', [
                        'model' => $model,
                        'tbpcplangpu' => $tbpcplangpu,
                        'types' => 'plandrug',
                        'section' => $section
            ]);
        }
    }

    public function actionPrimacyaprove($id) {
        $type = Yii::$app->componentdate->aes128Decrypt($id, Yii::$app->request->get('type'));
        $b = Yii::$app->db;
        $pos = Yii::$app->request->post('TbPcplan2');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->PCPOContactID = $pos['PCPOContactID'];
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 4;
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
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
            $tbpcplangpu = Viewplandrugdetail::findAll(['PCPlanNum' => $id]);
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
        $b = Yii::$app->db;
        $pos = Yii::$app->request->post('TbPcplan2');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->PCPOContactID = $pos['PCPOContactID'];
            $model->PCPlanDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 4;
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                Yii::$app->logger->savelog("แก้ไขสัญญาจะชื้อจะขายยาการค้า", $pos['PCPlanNum']);
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $model->PCPlanDate = $model->PCPlanDate;
            $model->PCPlanBeginDate = $model->PCPlanBeginDate;
            $model->PCPlanEndDate = $model->PCPlanEndDate;
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            $tbpcplangpu = Viewplandrugdetail::findAll(['PCPlanNum' => $id]);
            $Productmodel = Profile::find()->where(['VendorID' => $model->PCVendorID])->one();
            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'vendername' => $Productmodel['VenderName']
            ]);
        }
    }

    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->PCPlanStatusID = '3';
        $model->save();

        $mo = TbPcplantpudetail::findAll(['PCPlanNum' => $id]);
        foreach ($mo as $r) {
            $mol = TbPcplantpudetail::findOne($r['ids']);
            $mol->PCPlanItemStatusID = 3;
            $mol->save();
        }
        Yii::$app->logger->savelog("ลบสัญญาจะชื้อจะขายยาการค้า", $id);
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = TbPcplan2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
