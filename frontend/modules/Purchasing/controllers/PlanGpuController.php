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
use yii\web\Response;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use yii\helpers\Html;

class PlanGpuController extends Controller {

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

    public function actionForm2() {
        return $this->render('form2', [
        ]);
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

    public function beforeAction($action) {
        if ($action->id == 'test-submitangura') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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

    function actionFinddatatoarray() {
        $model = TbPcplan::find()->select('PCPlanNum')->all();
        foreach ($model as $r) {
            $array[] = $r['PCPlanNum'];
        }

        print_r($array);
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
            Yii::$app->finddata->setmessage("Plan " . $id . "Approve Success fully");
            Yii::$app->logger->savelog("อนุมัติแผนจัดชื้อยาสามัญ", $id);
        } else {
            $data = array(
                'status' => '0',
                'data' => 'กรุณา Save Draf ก่อน'
            );
        }
        return json_encode($data);
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
        $rs = TbPcplan::find()->where(['PCPlanTypeID' => '1', 'Pcplandrugandnondrug' => '1', 'PCPlanStatusID' => ['1', '2', '4', '5']])->
                        andWhere('PCPlanEndDate > :PCPlanEndDate', [':PCPlanEndDate' => date('Y-m-d')])->max('PCPlanNum');
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
        $TbPrgpudetail = TbPcplan::findOne(['PCPlanNum' => $id]);
        if ($TbPrgpudetail != null) {
            $TbPrgpudetail->PCPlanStatusID = 4;
            $TbPrgpudetail->save();
            $data = array(
                'status' => '1',
                'data' => 'Send To Approve Success'
            );
            Yii::$app->finddata->setmessage("Plan " . $id . " Send to Approve Success fully");
            Yii::$app->logger->savelog("ส่งแผนอนุมัติยาสามัญ", $id);
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
        $tbgenericproductusegpu = \app\models\VwGenericproductuseGpu::find()->all();
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
            $data .= '<td style="text-align:center">' . $person->TMTID_GPU . '</td>';
            $data .= '<td >' . $person->FSN_GPU . '</td>';
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
            $employee = \app\models\VwGenericproductuseGpu::find()->where(['TMTID_GPU' => Yii::$app->request->post('id')])->one();
            $aa = array(
                'TMTID_GPU' => $employee['TMTID_GPU'],
                'FSN_GPU' => $employee['FSN_GPU'],
                'itemDispUnit' => $employee['DispUnit'],
                'data' => $this->renderAjax('_form_detail')
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
        if (!empty($result->TMTID_GPU)) {
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
                'noii' => $result->gpu->DispUnit,
                'data' => $this->renderAjax('_form_detail')
            );
            return json_encode($ar);
        } else {
            return json_encode('');
        }
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

    public function actionIndex() {

        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionForm_main() {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = $this->findModel($pos['PCPlanNum']);
        if ($model->load(Yii::$app->request->post())) {
            $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
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

    public function actionCreate($PCPlanNum = null) {
        $pos = Yii::$app->request->post('TbPcplan');
        $b = Yii::$app->db;
        $model = TbPcplan::findOne(['PCPlanNum' => $PCPlanNum]);
        if ($model->load(Yii::$app->request->post())) {
            // $model = $this->findModel($pos['PCPlanNum']);
            $cmd = $b->createCommand('CALL sumgpuextendedcost(:x);')->bindParam(':x', $pos['PCPlanNum'])->queryOne();
            $totalall = $cmd['sum'];
            $model->PCPlanNum = $pos['PCPlanNum'];
            $model->PCPlanDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanDate']);
            $model->PCPlanBeginDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanBeginDate']);
            $model->PCPlanEndDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['PCPlanEndDate']);
            $model->PCPlanStatusID = $pos['PCPlanStatusID'] != null ? $pos['PCPlanStatusID'] : '';
            $model->PCPlanCreatedBy = Yii::$app->user->id;
            $model->PCPlanCreatedDate = date('Y-m-d');
            $model->PCPlanCreatedTime = date('H:i');
            $model->Pcplandrugandnondrug = 1;
            $model->PCPlanTotal = $totalall;

            if ($model->save()) {
                Yii::$app->logger->savelog("บันทึกแผนจัดชื้อยาสามัญ", $PCPlanNum);
                echo 1;
            } else {
                echo 0;
            }
        } else {

            $tbpcplangpu = Viewpcplandetail::findAll(['PCPlanNum' => $PCPlanNum]);
//            if ($tbpcplangpu == null) {
//                $tbpcplangpu = "";
//            }
            $section = ArrayHelper::map($this->getAmphur($model->DepartmentID), 'id', 'name');
            return $this->render('create', [
                        'model' => $model,
                        'tbpcplangpu' => $tbpcplangpu,
                        'types' => 'pcplan',
                        'section' => $section,
            ]);
        }
    }

    public function actionUpdate($id) {
        $pos = Yii::$app->request->post('TbPcplan');
        //$model = $this->findModel($id);
        $model = TbPcplan::findOne(['PCPlanNum' => $id]);
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
                Yii::$app->logger->savelog("แก้ไขแผนจัดชื้อยาสามัญ", $id);
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
        Yii::$app->logger->savelog("ลบแผนจัดชื้อยาสามัญ", $id);
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

    public function actionChildDepartment() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = \app\modules\pharmacy\models\TbSection::find()->andWhere(['DepartmentID' => $id])->asArray()->all();
            $selected = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['SectionID'], 'name' => $account['SectionDecs']];
                    if ($i == 0) {
                        $selected = $account['SectionID'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGettableDetails() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $dataProvider = new ActiveDataProvider([
                'query' => Viewpcplandetail::find()->where(['PCPlanNum' => $request->post('PCPlanNum')]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            $table = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => false,
                        'showPageSummary' => true,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'id' => 'tabledata', 'width' => '100%'],
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['style' => 'text-align:center'],
                                'width' => '36px',
                                'header' => '',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                            ],
                            [
                                'header' => 'รหัสยาสามัญ',
                                'attribute' => 'TMTID_GPU',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:center;'],
                                'value' => function ($model) {
                                    return empty($model->TMTID_GPU) ? '-' : $model->TMTID_GPU;
                                },
                            ],
                            [
                                'header' => 'ชื่อยาสามัญในแผน',
                                'attribute' => 'ItemName_plan',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'value' => function ($model) {
                                    return empty($model->ItemName_plan) ? '-' : $model->ItemName_plan;
                                },
                            ],
                            [
                                'header' => 'ขื่อยาสามัญมาตรฐาน',
                                'attribute' => 'FSN_GPU',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'value' => function ($model) {
                                    return empty($model->FSN_GPU) ? '-' : $model->FSN_GPU;
                                },
                            ],
                            [
                                'header' => 'ราคาต่อหน่วย',
                                'attribute' => 'GPUUnitCost',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model->GPUUnitCost) ? '' : $model->GPUUnitCost;
                                },
                            ],
                            [
                                'header' => 'จำนวน',
                                'attribute' => 'GPUOrderQty',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model->GPUOrderQty) ? '' : $model->GPUOrderQty;
                                },
                            ],
                            [
                                'header' => 'หน่วย',
                                'attribute' => 'DispUnit',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:center;'],
                                'pageSummary' => 'รวมเป็นเงิน',
                                'pageSummaryOptions' => ['style' => 'white-space: nowrap;'],
                                'value' => function ($model) {
                                    return empty($model->DispUnit) ? '' : $model->DispUnit;
                                },
                            ],
                            [
                                'header' => 'รวมเป็นเงิน',
                                'attribute' => 'Unicost',
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'pageSummaryOptions' => ['style' => 'white-space: nowrap;'],
                                'value' => function ($model) {
                                    return $model['GPUUnitCost'] * $model['GPUOrderQty'];
                                },
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Actions',
                                'noWrap' => true,
                                'headerOptions' => ['style' => 'text-align:center;background-color: white;'],
                                'contentOptions' => ['style' => 'text-align:center;'],
                                'pageSummary' => 'บาท',
                                'template' => '{edit} {delete}',
                                'buttons' => [
                                    'edit' => function ($url, $model, $key) {
                                        return Html::a('Edit', false, [
                                                    'class' => 'btn btn-primary btn-xs',
                                                    'title' => 'Edit',
                                                    'onclick' => 'editlistdrugpcplan(' . $model['ids'] . ');',
                                        ]);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('Delete', false, [
                                                    'class' => 'btn btn-danger btn-xs',
                                                    'title' => 'Edit',
                                                    'onclick' => 'deletelistdrug(' . $model['ids'] . ');',
                                        ]);
                                    },
                                ],
                            ],
                        ],
            ]);
            return $table;
        }
    }

}
