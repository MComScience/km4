<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\models\TbPcplan;
use app\models\TbPcplanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TbSection;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\TbPcplantpudetail;
use app\models\VwItemListTpu;
use app\modules\Purchasing\models\Viewplandrugdetail;
use app\modules\Purchasing\models\Vwtpuplandetailavalible;
use app\modules\Purchasing\models\Vwpc2tpudetail;

class PlanTpuController extends Controller {

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
        $result = TbPcplan::find()->max('PCPlanNum');
        $auto = substr($result, 5) + 1;
        $dat = substr(date('Y') + 543, 2, 4);
        $auto = sprintf("%04d", $auto);
        $auto = 'PC' . $dat . '-' . $auto;
        $cmd = Yii::$app->db->createCommand('CALL cmd_plangpu_create_header(:userid,:PCPlanNum);')->bindParam(':userid', $userid)->bindParam(':PCPlanNum', $auto)->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'PCPlanNum' => $auto]);
    }

    public function actionForm_main() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = new TbPcplan();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan::findOne($pos['PCPlanNum']);

            if ($models != "") {
                $model = $this->findModel($pos['PCPlanNum']);
                $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
                $totalall = $cmd['sum'];
            } else {
                $result = TbPcplan::find()->count();
                $auto = $result + 1;
                $dat = substr(date('Y') + 543, 2, 4);
                $auto = sprintf("%04d", $auto);
                $auto = 'PC' . $dat . '-' . $auto;
                $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
                $totalall = $cmd['sum'];
            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanTypeID = $pos['PCPlanTypeID'];
            $model->SectionID = $pos['SectionID'];
            $model->DepartmentID = $pos['DepartmentID'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->PCPlanTotal = $totalall;
            $model->Pcplandrugandnondrug = 3;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    function actionDatavwtpuplandetailavalible() {
        $tbgenericproductusegpu = Vwtpuplandetailavalible::find()->all();
        return $tbgenericproductusegpu;
    }

    function actionCheckpcplan() {
        $rs = TbPcplan::find()->where(['PCPlanTypeID' => '7', 'Pcplandrugandnondrug' => '3', 'PCPlanStatusID' => ['1', '2', '4', '5']])->all();
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
        $datas = TbPcplan::find()->where([' YEAR(PCPlanBeginDate)' => $begindate, 'Pcplandrugandnondrug' => '3'])->all();
        if ($datas != null) {
            return "1";
        } else {
            return "0";
        }
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
            Yii::$app->finddata->setmessage("Plan " . $id . " Send to Approve Success  fully");
            Yii::$app->logger->savelog("ส่งแผนจัดชื้อยาการค้าไปอนุมัติ",$id);
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
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
            Yii::$app->finddata->setmessage("Plan " . $id . "Approve Success  fully");
            Yii::$app->logger->savelog("อนุมัติแผนจัดชื้อยาการค้า",$id);
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
    }

    public function actionDatapcplandrug() {
        $Productmodel = VwItemListTpu::find()->all();
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
            $data .='<td style="text-align:center">' . $person->TMTID_TPU . '</td>';
            $data .='<td>' . $person->TradeName_TMT . '</td>';
            $data .='<td >' . $person->FSN_TMT . '</td>';
            $data .= '<td style="text-align:center"><a href="#" id="editabledatatable_new" class="btn btn-success btn-sm" onclick="myFunpcplanbydrug(' . $person->TMTID_TPU . ');"> select</a>';
            $data .= '</tr>';
        }
        $data .= '</tbody>
        </table>';
        return $data;
    }

    public function actionGetdata() {
        $TbPcplantpudetail = TbPcplantpudetail::find()->where(['TMTID_TPU' => Yii::$app->request->post('id'), 'PCPlanNum' => Yii::$app->request->post('prnums')])->one();
        if ($TbPcplantpudetail == null) {
            $employee = VwItemListTpu::find()->where(['TMTID_TPU' => Yii::$app->request->post('id')])->one();
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
        $post = Yii::$app->request->post();
        $out = [];
        if (isset($post['depdrop_parents'])) {
            $parents = $post['depdrop_parents'];
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
        $TbPcplangpudetail = TbPcplantpudetail::findOne(['PCPlanNum' => $post['prnum']]);
        if ($post['ids'] == "") {
            $TbPcplangpudetail = new TbPcplantpudetail();
            $TbPcplangpudetail->PCPlanNum = $post['prnum'];
            $TbPcplangpudetail->TMTID_TPU = $post['tmtgpu'];
            $TbPcplangpudetail->TPUUnitCost = str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->TPUOrderQty = str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->TPUExtendedCost = str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate($post['effectivedate']);
            $TbPcplangpudetail->PCPlanItemStatusID = '2';
            $TbPcplangpudetail->save();
            $ff = "Save Complete!";
        } else {
            $TbPcplangpudetail = TbPcplantpudetail::findOne($post['ids']);
            $TbPcplangpudetail->PCPlanNum = $post['prnum'];
            $TbPcplangpudetail->TMTID_TPU = $post['tmtgpu'];
            $TbPcplangpudetail->TPUUnitCost = str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->TPUOrderQty = str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->TPUExtendedCost = str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate($post['effectivedate']);
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
        //   $post['id']
        $result = TbPcplantpudetail::findOne($post['id']);
        // print_r($result);
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
        $datavalid = $this->actionDatavwtpuplandetailavalible();
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->search3(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'datavalid' => $datavalid
        ]);
    }

    public function actionView($id) {
        $model = TbPcplan::findOne(['PCPlanNum' => $id]);
        $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
        $tbpcplangpu = Vwpc2tpudetail::findAll(['PCPlanNum' => $id]);
        return $this->render('_view', [
                    'model' => $model,
                    'section' => $section,
                    'tbpcplangpu' => $tbpcplangpu
        ]);
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

    public function actionCreate($PCPlanNum = null) {//savedata to db
        $pos = Yii::$app->request->post('TbPcplan');
        // $model = new TbPcplan();
        $model = TbPcplan::findOne(['PCPlanNum' => $PCPlanNum]);
        $b = Yii::$app->db;
        if ($model->load(Yii::$app->request->post())) {
//            $models = TbPcplan::findOne($pos['PCPlanNum']);
//
//            if ($models != "") {
            $model = $this->findModel($pos['PCPlanNum']);
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
//            } else {
//                $result = TbPcplan::find()->count();
//                $auto = $result + 1;
//                $dat = substr(date('Y') + 543, 2, 4);
//                $auto = sprintf("%04d", $auto);
//                $auto = 'PC' . $dat . '-' . $auto;
//                $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
//                $totalall = $cmd['sum'];
//            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanTypeID = $pos['PCPlanTypeID'];
            $model->SectionID = $pos['SectionID'];
            $model->DepartmentID = $pos['DepartmentID'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->PCPlanTotal = $totalall;
            $model->Pcplandrugandnondrug = 3;
            if ($model->save()) {
                Yii::$app->logger->savelog("บันทึกแผนจัดชื้อยาการค้า",$pos['PCPlanNum']);
                echo 1;
            } else {
                echo 0;
            }
        } else {
//            $result = TbPcplan::find()->count();
//            $auto = $result + 1;
//            $dat = substr(date('Y') + 543, 2, 4);
//            $auto = sprintf("%04d", $auto);
//            $auto = 'PC' . $dat . '-' . $auto;
//            $find = TbPcplantpudetail::find()->where(['PCPlanNum' => $auto])->all();
//            if ($find != null) {
//                foreach ($find as $r) {
//                    $mo = TbPcplantpudetail::find()->where(['ids' => $r->ids])->one();
//                    $mo->delete();
//                }
//            }
            $tbpcplangpu = Viewplandrugdetail::findAll(['PCPlanNum' => $PCPlanNum]);
            if ($tbpcplangpu == null) {
                $tbpcplangpu = "";
            }

            $model->PCPlanStatusID = 1;
            return $this->render('create', [
                        'model' => $model,
                        'tbpcplangpu' => $tbpcplangpu,
                        'types' => 'plandrug'
            ]);
        }
    }

    public function actionUpdate($id) {
        $b = Yii::$app->db;
        $pos = Yii::$app->request->post('TbPcplan');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 3;
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                 Yii::$app->logger->savelog("แก้ไขแผนจัดชื้อยาการค้า",$pos['PCPlanNum']);
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
            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu
            ]);
        }
    }

    public function actionPrimacyaprove($id) {
        $type = Yii::$app->componentdate->aes128Decrypt($id, Yii::$app->request->get('type'));
        $b = Yii::$app->db;
        $pos = Yii::$app->request->post('TbPcplan');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 3;
            $cmd = $b->createCommand('CALL sumtpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $model->PCPlanDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanDate);
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanBeginDate);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanEndDate);
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            $tbpcplangpu = Viewplandrugdetail::findAll(['PCPlanNum' => $id]);
            return $this->render('_form_primacy', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'type' => $type
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
          Yii::$app->logger->savelog("ลบแผนจัดชื้อยาการค้า",$id);
        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = TbPcplan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
