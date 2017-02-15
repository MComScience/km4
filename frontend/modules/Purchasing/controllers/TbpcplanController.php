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
use app\models\TbPcplangpudetail;
use app\modules\Purchasing\models\Viewpcplandetail;
use app\modules\Purchasing\models\Vwgpuplandetailavalible;
use app\modules\Purchasing\models\Vwpc2gpudetail;
use kartik\mpdf\Pdf;

class TbpcplanController extends Controller {

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

    function actionAngura() {
         return $this->render('testangura');
       
    }


    function actionUpdatedate() {
        $rs = TbPcplan::find()->all();
        foreach ($rs as $r) {
            $model = TbPcplan::findOne(['PCPlanNum' => $r['PCPlanNum']]);
            $model->PCPlanDate = $this->convertToMysql($r['PCPlanDate']);
            $model->PCPlanBeginDate = $this->convertToMysql($r['PCPlanBeginDate']);
            $model->PCPlanEndDate = $this->convertToMysql($r['PCPlanEndDate']);
            $model->save();
        }
        echo 'full';
    }

    public function beforeAction($action) {
        if ($action->id == 'test-submitangura') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    function actionAng() {
        return $this->render('testnagura2');
    }

    public function actionTestSubmitangura() {

        // get posted data
//$postdata = file_get_contents("php://input");
//$request = json_decode($postdata);
// @$email = $request->name;
//echo $email;
//$data = json_decode(file_get_contents("php://input"));
//echo @$data->name;
// set product property values
//$product->name = $data->name;
//$product->price = $data->price;
//$product->description = $data->description;
//$product->created = date('Y-m-d H:i:s');
        //return $data->name;
    }

    public function convertToMysql($date) {
        $arr = explode("-", $date);
        $y = $arr[0] - 543;
        $m = $arr[1];
        $d = $arr[2];
        return "$y-$m-$d";
    }

    function actionWailtApprove() {
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->searchprimacy(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('wait-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    function actionWailtManagerApprove() {
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->searchmanager(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('wailt-manager-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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

    public function actionPrreport() {
        $PRID = '210'; //Yii::$app->request->get('PRID');
        $model = \app\modules\Purchasing\models\VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderAjax('prreport', ['model' => $model]),
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => FALSE,
        ]]);
        return $pdf->render();
    }

    public function actionPrreportnondrug() {
        $PRID = Yii::$app->request->get('PRID');
        $model = \app\modules\Purchasing\models\VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('prreportnondrug', ['model' => $model]),
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => FALSE,
        ]]);

        return $pdf->render();
    }

    function actionPrimacyaprove($id) {
        $type = Yii::$app->componentdate->aes128Decrypt($id, Yii::$app->request->get('type'));
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 1;
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
            $tbpcplangpu = Viewpcplandetail::findAll(['PCPlanNum' => $id]);


            return $this->render('_form_primacy', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu,
                        'type' => $type
            ]);
        }
    }

    function actionCheckpcplan() {
        $rs = TbPcplan::find()->where(['PCPlanTypeID' => '1', 'Pcplandrugandnondrug' => '1', 'PCPlanStatusID' => ['1', '2', '4', '5']])->all();

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
                'data' => 'Send To Approve Success'
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

    function actionFindsave() {
        $begindate = date("Y");
        $datas = TbPcplan::find()->where(['YEAR(PCPlanBeginDate)' => $begindate, 'Pcplandrugandnondrug' => '1'])->all();
        if ($datas != null) {
            return "1";
        } else {
            return "0";
        }
    }

    function actionDatavwgpuplandetailavalible() {
        $tbgenericproductusegpu = Vwgpuplandetailavalible::find()->all();
        return $tbgenericproductusegpu;
    }

    public function actionDatapcplanbydrug() {
        $tbgenericproductusegpu = \app\models\VwItemListTpu::find()->all();
        $data = '<table id="pcplanbydrugtable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align:center">รหัสยาสามัญ</th>
                    <th style="text-align:center">รายละเอียดยาสามัญ</th>
                    <th style="text-align:center">Actions</th>
                </tr>
            </thead>
            <tbody>';


        foreach ($tbgenericproductusegpu as $person) {
            $data .= '<tr>';
            $data .='<td style="text-align:center">' . $person->TMTID_GPU . '</td>';
            $data .='<td >' . $person->FSN_TMT . '</td>';
            $data .= '<td style="text-align:center"><a  id="editabledatatable_new" class="btn btn-success btn-sm ladda-button" data-style= "expand-left" href="javascript:myFunpcplanbydrug(' . $person->TMTID_GPU . ');" > select</a></td>';
            $data .= '</tr>';
        }

        $data .= '</tbody>
        </table>';
        return $data;
    }

    public function actionGetdata() {
        $TbPcplangpudetail = TbPcplangpudetail::find()->where(['TMTID_GPU' => Yii::$app->request->post('id'), 'PCPlanNum' => Yii::$app->request->post('prnums')])->one();
        if ($TbPcplangpudetail == null) {
            $employee = \app\models\VwItemListTpu::find()->where(['TMTID_GPU' => Yii::$app->request->post('id')])->one();
            $aa = array(
                'TMTID_GPU' => $employee['TMTID_GPU'],
                'FSN_GPU' => $employee['FSN_TMT'],
                'itemDispUnit' => $employee['DispUnit']
            );
            return json_encode($aa);
        } else {
            $bb = array(
                'TMTID_GPU' => null,
                'ale' => 'รายการนี้ถูกเลือกแล้ว'
            );
            return json_encode($bb);
        }
    }

    public function actionSavedata() {
        $post = Yii::$app->request->post();
        $TbPcplangpudetail = TbPcplangpudetail::findOne(['PCPlanNum' => $post['prnum']]);
        if ($post['ids'] == "") {
            $TbPcplangpudetail = new TbPcplangpudetail();
            $TbPcplangpudetail->PCPlanNum = $post['prnum'];
            $TbPcplangpudetail->TMTID_GPU = $post['tmtgpu'];
            $TbPcplangpudetail->GPUUnitCost = str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->GPUOrderQty = str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->GPUExtendedCost = str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanGPUItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['effectivedate']);
            $TbPcplangpudetail->PCPlanGPUItemStatusID = '2';
            $TbPcplangpudetail->save();
            $ff = "Save Complete!";
        } else {
            $TbPcplangpudetail = TbPcplangpudetail::findOne($post['ids']);
            $TbPcplangpudetail->PCPlanNum = $post['prnum'];
            $TbPcplangpudetail->TMTID_GPU = $post['tmtgpu'];
            $TbPcplangpudetail->GPUUnitCost = str_replace(',', '', $post['gpuunitCost']);
            $TbPcplangpudetail->GPUOrderQty = str_replace(',', '', $post['gpuorderqty']);
            $TbPcplangpudetail->GPUExtendedCost = str_replace(',', '', $post['gpuextended']);
            $TbPcplangpudetail->PCPlanGPUItemEffectDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['effectivedate']);
            $TbPcplangpudetail->PCPlanGPUItemStatusID = "2";
            $TbPcplangpudetail->save();
            $ff = "Save Complete!";
        }
        $htl = Yii::$app->headertable->headertablepcplandetail();
        $users = Viewpcplandetail::findAll(['PCPlanNum' => $post['prnum']]);
        $htl .= Yii::$app->finddata->finddatadetailpcplan($users);
        $arr = array(
            'htn' => $htl,
            'ff' => $ff
        );
        return json_encode($arr);
    }

    public function actionEditlistdrug() {
        $post = Yii::$app->request->post();
        $result = TbPcplangpudetail::findOne($post['id']);
        $ar = array(
            'PCPlanNum' => $result->PCPlanNum,
            'TMTID_GPU' => $result->TMTID_GPU,
            'GPUUnitCost' => number_format($result->GPUUnitCost, 2),
            'GPUOrderQty' => number_format($result->GPUOrderQty, 2),
            'GPUExtendedCost' => number_format($result->GPUExtendedCost, 2),
            'PCPlanGPUItemEffectDate' => Yii::$app->componentdate->convertMysqlToThaiDate2($result->PCPlanGPUItemEffectDate),
            'PCPlanGPUItemStatusID' => $result->PCPlanGPUItemStatusID,
            'ids' => $result->ids,
            'fsngpu' => $result->gpu->FSN_GPU,
            'noii' => $result->gpu->DispUnit
        );
        return json_encode($ar);
    }

    public function actionDeletelistdrug() {
        $postt = Yii::$app->request->post();
        $post = TbPcplangpudetail::findOne($postt['ids']);
        $post->delete();
        $ff = "ลบข้อมูลเรียบร้อยแล้ว";
        $result = Viewpcplandetail::findAll(['PCPlanNum' => $postt['prnums']]);
        if ($result != null) {
            $htl = Yii::$app->headertable->headertablepcplandetail();
            $htl .= Yii::$app->finddata->finddatadetailpcplan($result);
            $ar = array(
                'htn' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
        } else {
            $htl = '';
            $ff = "ลบข้อมูลเรียบร้อยแล้ว";
            $ar = array(
                'htn' => $htl,
                'ff' => $ff
            );
            return json_encode($ar);
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

    public function actionTest() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {
            $model = Viewpcplandetail::findAll(['PCPlanNum' => $pos['expandRowKey']]);
            return $this->renderPartial('_expand-row-details', ['tbpcplangpu' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionIndex() {
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewnew($id) {
        $model = $this->findModel($id);
        $model->PCPlanDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanDate);
        $model->PCPlanBeginDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanBeginDate);
        $model->PCPlanEndDate = Yii::$app->componentdate->convertMysqlToThaiDate($model->PCPlanEndDate);
        $tbpcplangpu = Viewpcplandetail::findAll(['PCPlanNum' => $id]);
        return $this->renderAjax('view', [
                    'model' => $model,
                    'tbpcplangpu' => $tbpcplangpu
        ]);
    }

    public function actionForm_main() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = new TbPcplan();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan::findOne($pos['PCPlanNum']);
            if ($models != "") {
                $model = $this->findModel($pos['PCPlanNum']);
                $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
                $totalall = $cmd['sum'];
            } else {
                $result = TbPcplan::find()->count();
                $auto = $result + 1;
                $dat = substr(date('Y') + 543, 2, 4);
                $auto = sprintf("%04d", $auto);
                $auto = 'PC' . $dat . '-' . $auto;
                $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
                $totalall = $cmd['sum'];
            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = 1;
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 1;
            $model->PCPlanTotal = $totalall;
            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function actionCreate() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = new TbPcplan();
        if ($model->load(Yii::$app->request->post())) {
            $models = TbPcplan::findOne($pos['PCPlanNum']);
            if ($models != "") {
                $model = $this->findModel($pos['PCPlanNum']);
                $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
                $totalall = $cmd['sum'];
            } else {
                $result = TbPcplan::find()->count();
                $auto = $result + 1;
                $dat = substr(date('Y') + 543, 2, 4);
                $auto = sprintf("%04d", $auto);
                $auto = 'PC' . $dat . '-' . $auto;
                $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $auto)->queryOne();
                $totalall = $cmd['sum'];
            }
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanDate = $pos['PCPlanDate']; //convert to thai
            $model->PCPlanBeginDate = $pos['PCPlanBeginDate'];
            $model->PCPlanEndDate = $pos['PCPlanEndDate'];
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : '';
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 1;
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
            $find = TbPcplangpudetail::find()->where(['PCPlanNum' => $auto])->all();
            if ($find != null) {
                foreach ($find as $r) {
                    $mo = TbPcplangpudetail::find()->where(['ids' => $r->ids])->one();
                    $mo->delete();
                }
            }
            $tbpcplangpu = Viewpcplandetail::findAll(['PCPlanNum' => $auto]);
            if ($tbpcplangpu == null) {
                $tbpcplangpu = "";
            }
            $model->PCPlanStatusID = 1;
            return $this->render('create', [
                        'model' => $model,
                        'tbpcplangpu' => $tbpcplangpu,
                        'types' => 'pcplan'
            ]);
        }
    }

    public function actionUpdate($id) {
        $pos = Yii::$app->request->post('TbPcplan');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $b = Yii::$app->db;
            $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']); //convert to thai
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 1;
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
            $tbpcplangpu = Viewpcplandetail::findAll(['PCPlanNum' => $id]);

            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        'tbpcplangpu' => $tbpcplangpu
            ]);
        }
    }

    public function actionView($id) {
        $model = TbPcplan::findOne(['PCPlanNum' => $id]);
        $attribute = new Vwpc2gpudetail();
        $attributes = $attribute->attributeLabels();
        $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
        $tbpcplangpu = \app\modules\Purchasing\models\FmReportGpuplanDetail::findAll(['PCPlanNum' => $id]);

        return $this->render('_view', [
                    'model' => $model,
                    'section' => $section,
                    'tbpcplangpu' => $tbpcplangpu,
                    'attribute' => $attributes
        ]);
    }

    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->PCPlanStatusID = '3';
        $model->save();
        $mo = TbPcplangpudetail::findAll(['PCPlanNum' => $id]);
        foreach ($mo as $r) {
            $mol = TbPcplangpudetail::findOne($r['ids']);
            $mol->PCPlanGPUItemStatusID = 3;
            $mol->save();
        }
    }

    protected function findModel($id) {
        if (($model = TbPcplan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
