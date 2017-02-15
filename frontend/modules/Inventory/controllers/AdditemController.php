<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\models\TbItem;
use app\models\TbItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Uploads;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\Model;
use yii\filters\AccessControl;
#models
use app\modules\Inventory\models\TbGenericproductuseGpuSearch;
use app\modules\Inventory\models\VwitempricelistsclSearch;
use app\modules\Inventory\models\TbGenericproductuseGpu;
use app\modules\Inventory\models\TbGenericproductGp;
use app\modules\Inventory\models\VwGenericproduct;
use app\models\TbMastertmt;
use app\models\TbContunit;
use app\models\TbDispunit;
use app\modules\Inventory\models\TbDrugsubclass;
use app\modules\Inventory\models\Tbdrugprandialadvice;
use app\modules\Inventory\models\VwMastertmt;
use app\modules\Inventory\models\TbDrugindication;
use app\modules\Inventory\models\TbDrugadminstration;
use app\modules\Inventory\models\TbDrugprecaution;
use app\modules\Inventory\models\VwDrugindication;
use app\modules\Inventory\models\VwDrugadminstration;
use app\modules\Inventory\models\VwDrugprecaution;
use app\modules\Inventory\models\VwItempack;
use app\modules\Inventory\models\VwStklevelinfo;
use app\modules\Inventory\models\Tbrxordercondition;
use app\models\TbItempack;
use app\modules\Inventory\models\TbStkLevelinfo;
use app\modules\Inventory\models\TbItemIDPrice;
use app\modules\Inventory\models\Vwgpulist;
use app\modules\Inventory\models\Vwgpustdcostlist;
use app\modules\Inventory\models\TbGpustdcost;
use app\modules\Inventory\models\VwItemidPrice;
use app\modules\Inventory\models\VwcreditItem;
use app\modules\Inventory\models\TbCreditItem;
use app\modules\Inventory\models\Vwlabeldruggpu;
use app\modules\Inventory\models\Vwlabeldrugtpu;
use app\modules\Inventory\models\Tbmedicalrightgroup;
use app\models\TbCreditItemSearch;
use app\modules\Inventory\models\Vwitempricelistscl;
use app\modules\Inventory\models\VwItempriceCrListSearch;
use app\modules\Inventory\models\TbItemidPriceCredit;
use app\modules\Inventory\models\TbDrugclass;
use app\modules\Inventory\models\TbIsed;

class AdditemController extends Controller {

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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPricelist() {
        $searchModel = new VwItempriceCrListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $ItemID = Yii::$app->request->post('editableKey');


            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '']);

            $posted = current($_POST['VwItempriceCrList']);
            $post = ['VwItempriceCrList' => $posted];

            $ItemName = empty($posted['ItemName']) ? null : $posted['ItemName'];
            if (!empty($ItemName)) {
                $item = TbItem::findOne($ItemID);
                $item->ItemName = $ItemName;
                $item->save();
                return Json::encode(['output' => $ItemName, 'message' => '']);
            }

            $Itemworkingcode = empty($posted['Item_workingcode']) ? null : $posted['Item_workingcode'];

            if (!empty($Itemworkingcode)) {
                $item = TbItem::findOne($ItemID);
                $item->Item_workingcode = $Itemworkingcode;
                $item->save();
                return Json::encode(['output' => $Itemworkingcode, 'message' => '']);
            }

            #กลุ่มยา
            $DrugClass = empty($posted['DrugClass']) ? null : $posted['DrugClass'];
            $TMTID_GP = empty($_POST['VwItempriceCrList']['TMTID_GP']) ? null : $_POST['VwItempriceCrList']['TMTID_GP'];

            if (($modelDrugClass = TbGenericproductGp::findOne($TMTID_GP)) !== null) {
                $modelDrugClass->Class_GP = $DrugClass;
                $modelDrugClass->save();
                $modelClass = TbDrugclass::findOne($DrugClass);
                return Json::encode(['output' => $modelClass['DrugClass'], 'message' => '']);
            }

            #กลุ่มยาย่อย
            $DrugSubClass = empty($posted['DrugSubClass']) ? null : $posted['DrugSubClass'];
            if (($modelDrugsubClass = TbGenericproductGp::findOne($TMTID_GP)) !== null) {
                $modelDrugsubClass->SubClass_GP = $DrugSubClass;
                $modelDrugsubClass->save();
                $modelClass = TbDrugsubclass::findOne($DrugSubClass);
                return Json::encode(['output' => $modelClass['DrugSubClass'], 'message' => '']);
            }

            #ISED
            $ISED = empty($posted['ISED']) ? null : $posted['ISED'];
            if (($modelISED = TbGenericproductGp::findOne($TMTID_GP)) !== null) {
                $modelISED->ISED_CatID = $ISED;
                $modelISED->save();
                $modelISEDDesc = TbIsed::findOne($ISED);
                return Json::encode(['output' => $modelISEDDesc['ISED'], 'message' => '']);
            }

            #ราคา
            $ItemPrice = empty($posted['ItemPrice']) ? null : $posted['ItemPrice'];

            if (!empty($ItemPrice) && ($modelItemPrice = TbItemIDPrice::findOne($ItemID)) !== null) {
                $modelItemPrice->ItemPrice = str_replace(',', '', $ItemPrice);
                $modelItemPrice->save();
                return Json::encode(['output' => $ItemPrice, 'message' => '']);
            }

            #ราคาตามสิทธิ์
            $crgrp1_op = empty($posted['crgrp1_op']) ? null : $posted['crgrp1_op'];
            $crgrp1_ip = empty($posted['crgrp1_ip']) ? null : $posted['crgrp1_ip'];

            $crgrp2_op = empty($posted['crgrp2_op']) ? null : $posted['crgrp2_op'];
            $crgrp2_ip = empty($posted['crgrp2_ip']) ? null : $posted['crgrp2_ip'];

            $crgrp3_op = empty($posted['crgrp3_op']) ? null : $posted['crgrp3_op'];
            $crgrp3_ip = empty($posted['crgrp3_ip']) ? null : $posted['crgrp3_ip'];

            $crgrp4_op = empty($posted['crgrp4_op']) ? null : $posted['crgrp4_op'];
            $crgrp4_ip = empty($posted['crgrp4_ip']) ? null : $posted['crgrp4_ip'];

            if ((!empty($crgrp1_op)) || (!empty($crgrp1_ip))) {
                $credit_group_id = '1';
            }

            if ((!empty($crgrp2_op)) || (!empty($crgrp2_ip))) {
                $credit_group_id = '2';
            }

            if ((!empty($crgrp3_op)) || (!empty($crgrp3_ip))) {
                $credit_group_id = '3';
            }

            if ((!empty($crgrp4_op)) || (!empty($crgrp4_ip))) {
                $credit_group_id = '4';
            }

            if (($query = TbItemidPriceCredit::findOne(['ItemID' => $ItemID, 'credit_group_id' => empty($credit_group_id) ? '' : $credit_group_id])) !== null) {
                $model = TbItemidPriceCredit::findOne($query['ids']);

                $model->cr_price_op = empty($crgrp1_op) ? $model->cr_price_op : str_replace(',', '', $crgrp1_op);
                $model->cr_price_ip = empty($crgrp1_ip) ? $model->cr_price_ip : str_replace(',', '', $crgrp1_ip);

                $model->cr_price_op = empty($crgrp2_op) ? $model->cr_price_op : str_replace(',', '', $crgrp2_op);
                $model->cr_price_ip = empty($crgrp2_ip) ? $model->cr_price_ip : str_replace(',', '', $crgrp2_ip);

                $model->cr_price_op = empty($crgrp3_op) ? $model->cr_price_op : str_replace(',', '', $crgrp3_op);
                $model->cr_price_ip = empty($crgrp3_ip) ? $model->cr_price_ip : str_replace(',', '', $crgrp3_ip);

                $model->cr_price_op = empty($crgrp4_op) ? $model->cr_price_op : str_replace(',', '', $crgrp4_op);
                $model->cr_price_ip = empty($crgrp4_op) ? $model->cr_price_ip : str_replace(',', '', $crgrp4_op);
                $model->save();
            } else {
                return Json::encode(['output' => '', 'message' => 'ไม่พบข้อมูล']);
            }
            $output = '';

            if (isset($posted['crgrp1_op']) && !empty($crgrp1_op) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_op, 2);
            }

            if (isset($posted['crgrp1_ip']) && !empty($crgrp1_ip) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_ip, 2);
            }

            if (isset($posted['crgrp2_op']) && !empty($crgrp2_op) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_op, 2);
            }

            if (isset($posted['crgrp2_ip']) && !empty($crgrp2_ip) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_ip, 2);
            }

            if (isset($posted['crgrp3_op']) && !empty($crgrp3_op) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_op, 2);
            }

            if (isset($posted['crgrp3_ip']) && !empty($crgrp3_ip) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_ip, 2);
            }

            if (isset($posted['crgrp4_op']) && !empty($crgrp4_op) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_op, 2);
            }

            if (isset($posted['crgrp4_ip']) && !empty($crgrp4_ip) && $query != null) {
                $output = Yii::$app->formatter->asDecimal($model->cr_price_ip, 2);
            }

            $out = Json::encode(['output' => $output, 'message' => '']);
            echo $out;
            return;
        }

        return $this->render('pricelist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex() {
        $searchModel = new TbItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = false;

        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        $sql = "DELETE FROM tb_item WHERE ItemStatusID = 4 and CreatedBy = $CreatedBy";
        $query = Yii::$app->db->createCommand($sql)->execute();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManagegpu() {
        $searchModel = new TbGenericproductuseGpuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('managegpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPricelisttpu() {
        $searchModel = new VwitempricelistsclSearch();
        $catid = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $catid);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('pricelisttpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($gpu, $itemid, $edit) {
        if (empty($gpu)) {
            $tbgpu = new TbGenericproductuseGpu();
            $tbgp = new TbGenericproductGp();
            $queryview = VwGenericproduct::findOne(['TMTID_GPU' => $gpu]);
            $querydatatpu = TbMastertmt::findOne(['TMTID_GPU' => $gpu]);
            if ($tbgpu->load(Yii::$app->request->post())) {
                $findcontunit = TbContunit::findOne(['ContUnit' => $_POST['TbGenericproductuseGpu']['CoutUnit_GPU']]);
                $finddisunit = TbDispunit::findOne(['DispUnit' => $_POST['TbGenericproductuseGpu']['DispUnit_GPU']]);
                $TMTID_GPU = $_POST['TbGenericproductuseGpu']['TMTID_GPU'];
                $FNS_GPU_label = $_POST['FNS_GPU_label'];
                $Dosageform_GPU = $_POST['TbGenericproductuseGpu']['Dosageform_GPU'];
                $StrNum_GPU = $_POST['TbGenericproductuseGpu']['StrNum_GPU'];
                $ContVal_GPU = $_POST['TbGenericproductuseGpu']['ContVal_GPU'];
                $CoutUnit_GPU = $findcontunit['ContUnitID'];
                $DispUnit_GPU = $finddisunit['DispUnitID'];
                $HighDrugAlertType = $_POST['HighDrugAlertType'];
                $Class_GP = $_POST['TbGenericproductGp']['Class_GP'];
                $SubClass_GP = (!empty($_POST['TbGenericproductGp']['SubClass_GP']) ? $_POST['TbGenericproductGp']['SubClass_GP'] : NULL);
                $DrugGroup_GP = $_POST['TbGenericproductGp']['DrugGroup_GP'];
                $ISED_CatID = $_POST['TbGenericproductGp']['ISED_CatID'];
                $PregCatID_GP = $_POST['TbGenericproductGp']['PregCatID_GP'];
                Yii::$app->db->createCommand('CALL cmd_update_genericproduct(:TMTID_GPU,:FNS_GPU_label,:Dosageform_GPU,:StrNum_GPU,:ContVal_GPU,:CoutUnit_GPU,:DispUnit_GPU,:HighDrugAlertType,:Class_GP,:SubClass_GP,:DrugGroup_GP,:ISED_CatID,:PregCatID_GP);')
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':FNS_GPU_label', $FNS_GPU_label)
                        ->bindParam(':Dosageform_GPU', $Dosageform_GPU)
                        ->bindParam(':StrNum_GPU', $StrNum_GPU)
                        ->bindParam(':ContVal_GPU', $ContVal_GPU)
                        ->bindParam(':CoutUnit_GPU', $CoutUnit_GPU)
                        ->bindParam(':DispUnit_GPU', $DispUnit_GPU)
                        ->bindParam(':HighDrugAlertType', $HighDrugAlertType)
                        ->bindParam(':Class_GP', $Class_GP)
                        ->bindParam(':SubClass_GP', $SubClass_GP)
                        ->bindParam(':DrugGroup_GP', $DrugGroup_GP)
                        ->bindParam(':ISED_CatID', $ISED_CatID)
                        ->bindParam(':PregCatID_GP', $PregCatID_GP)
                        ->execute();
                return 'success';
            } else {
                return $this->render('create', [
                            'tbgpu' => $tbgpu,
                            'tbgp' => $tbgp,
                            'subclassgp' => '',
                            'queryview' => $queryview,
                            'querydatatpu' => $querydatatpu,
                            'itemid' => $itemid,
                            'edit' => $edit,
                ]);
            }
        } else {
            $tbgpu = TbGenericproductuseGpu::findOne($gpu);
            $tbgp = TbGenericproductGp::findOne($tbgpu['TMTID_GP']);
            $queryview = VwGenericproduct::findOne(['TMTID_GPU' => $gpu]);
            $querydatatpu = TbMastertmt::findOne(['TMTID_GPU' => $gpu]);
            $subclassgp = ArrayHelper::map($this->getSubclass($tbgp->SubClass_GP), 'id', 'name');
            if ($tbgpu->load(Yii::$app->request->post())) {
                $findcontunit = TbContunit::findOne(['ContUnit' => $_POST['TbGenericproductuseGpu']['CoutUnit_GPU']]);
                $finddisunit = TbDispunit::findOne(['DispUnit' => $_POST['TbGenericproductuseGpu']['DispUnit_GPU']]);
                $TMTID_GPU = $_POST['TbGenericproductuseGpu']['TMTID_GPU'];
                $FNS_GPU_label = $_POST['FNS_GPU_label'];
                $Dosageform_GPU = $_POST['TbGenericproductuseGpu']['Dosageform_GPU'];
                $StrNum_GPU = $_POST['TbGenericproductuseGpu']['StrNum_GPU'];
                $ContVal_GPU = $_POST['TbGenericproductuseGpu']['ContVal_GPU'];
                $CoutUnit_GPU = $findcontunit['ContUnitID'];
                $DispUnit_GPU = $finddisunit['DispUnitID'];
                $HighDrugAlertType = $_POST['HighDrugAlertType'];
                $Class_GP = $_POST['TbGenericproductGp']['Class_GP'];
                $SubClass_GP = (!empty($_POST['TbGenericproductGp']['SubClass_GP']) ? $_POST['TbGenericproductGp']['SubClass_GP'] : NULL);
                $DrugGroup_GP = $_POST['TbGenericproductGp']['DrugGroup_GP'];
                $ISED_CatID = $_POST['TbGenericproductGp']['ISED_CatID'];
                $PregCatID_GP = $_POST['TbGenericproductGp']['PregCatID_GP'];
                Yii::$app->db->createCommand('CALL cmd_update_genericproduct(:TMTID_GPU,:FNS_GPU_label,:Dosageform_GPU,:StrNum_GPU,:ContVal_GPU,:CoutUnit_GPU,:DispUnit_GPU,:HighDrugAlertType,:Class_GP,:SubClass_GP,:DrugGroup_GP,:ISED_CatID,:PregCatID_GP);')
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':FNS_GPU_label', $FNS_GPU_label)
                        ->bindParam(':Dosageform_GPU', $Dosageform_GPU)
                        ->bindParam(':StrNum_GPU', $StrNum_GPU)
                        ->bindParam(':ContVal_GPU', $ContVal_GPU)
                        ->bindParam(':CoutUnit_GPU', $CoutUnit_GPU)
                        ->bindParam(':DispUnit_GPU', $DispUnit_GPU)
                        ->bindParam(':HighDrugAlertType', $HighDrugAlertType)
                        ->bindParam(':Class_GP', $Class_GP)
                        ->bindParam(':SubClass_GP', $SubClass_GP)
                        ->bindParam(':DrugGroup_GP', $DrugGroup_GP)
                        ->bindParam(':ISED_CatID', $ISED_CatID)
                        ->bindParam(':PregCatID_GP', $PregCatID_GP)
                        ->execute();
                return 'success';
            } else {
                return $this->render('create', [
                            'tbgpu' => $tbgpu,
                            'tbgp' => $tbgp,
                            'subclassgp' => $subclassgp,
                            'queryview' => $queryview,
                            'querydatatpu' => $querydatatpu,
                            'itemid' => $itemid,
                            'edit' => $edit,
                ]);
            }
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ItemID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete() {
        $id = $_POST['id'];
        $sql = "
                DELETE FROM tb_item WHERE ItemID = $id;
                DELETE FROM tb_itempack WHERE ItemID = $id;
                DELETE FROM tb_stk_levelinfo WHERE ItemID = $id;
              ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionGetSubclass() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getSubclass($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getSubclass($id) {
        $datas = TbDrugsubclass::find()->where(['DrugClassID' => $id])->all();
        return $this->MapData($datas, 'DrugSubClassID', 'DrugSubClass');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    /* GetDrugPrand */

    public function actionGetDrugroute() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $drugroute_id = $parents[0];
                $out = $this->getSubdrugroute($drugroute_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getSubdrugroute($id) {
        $datas = Tbdrugprandialadvice::find()->where(['DrugRouteID' => $id])->all();
        return $this->MapData1($datas, 'DrugPrandialAdviceID', 'DrugPrandialAdviceDesc');
    }

    protected function MapData1($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    protected function findModel($id) {
        if (($model = TbItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionGetdatagpu() {
        $data = TbMastertmt::find()
                ->select('tb_mastertmt.TMTID_TPU,tb_mastertmt.TMTID_GPU,tb_mastertmt.FSN_TMT')
                ->from('tb_mastertmt USE INDEX (TMTID_TPU)')
                ->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatagputable">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="20%" style="text-align: center;">รหัสยาการค้า</th>
                                    <th width="20%" style="text-align: center;">รหัสยาสามัญ</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดยาการค้า</th>
                                    <th width="100%" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($data as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_TMT'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="GetDetailTPU(' . $result->TMTID_TPU . ');" > Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    function actionGetdetailtpu() {
        $datatpu = VwMastertmt::findOne(['TMTID_TPU' => $_POST['id']]);
        $datagpu = VwGenericproduct::findOne(['TMTID_GPU' => $datatpu['TMTID_GPU']]);
        $arr = array(
            'TMTID_TPU' => $datatpu['TMTID_TPU'], #รหัสยาการค้า
            'TradeName_TMT' => $datatpu['TradeName_TMT'], #ชื่อยาการค้า
            'ActiveIngredient_TMT' => $datatpu['ActiveIngredient_TMT'], #ActiveIngredient_TMT
            'TMTID_GPU' => $datatpu['TMTID_GPU'], #รหัสยาสามัญ
            'FSN_TMT' => $datatpu['FSN_TMT'], #รายละเอียดยา
            'FSN_GPU' => $datagpu['FSN_GPU'], #รายละเอียดยาสามัญ
            'DrugClassID' => $datagpu['DrugClassID'], #กลุ่มยา
            'DrugSubClassID' => $datagpu['DrugSubClassID'], #กลุ่มยาย่อย
            'druggroupID' => $datagpu['druggroupID'], #บัญชียา
            'ISEDID' => $datagpu['ISEDID'], #บัญชียาหลัก
            'PregCatID' => $datagpu['PregCatID'], #ระดับผลการใช้ยาหญิงมีครรค์
            'HighDrugAlertType' => $datagpu['HighDrugAlertType'], #High Drug Alert
            'Dosageform_TMT' => $datatpu['Dosageform_TMT'], #รูปแบบยา
            'StrNum_TMT' => $datatpu['StrNum_TMT'], #ความแรงยา
            'Contval_TMT' => $datatpu['Contval_TMT'], #ขนาดบรรจุ
            'Contunit_TMT' => $datatpu['Contunit_TMT'], #หน่วยของขนาดบบรรจุ
            'DispUnit_TMT' => $datatpu['DispUnit_TMT'], #หน่วยการจ่าย
            'FNS_GPU_label' => $datatpu['FNS_GPU_label'], #ชื่อยาสามัญบนฉลากยา
        );
        return json_encode($arr);
    }

    function actionAddDrugin() {
        if (!empty($_GET['id'])) {
            $model = TbDrugindication::findOne($_GET['id']);
            $querygpu = TbGenericproductuseGpu::findOne($model['TMTID_GPU']);
            if ($model->load(Yii::$app->request->post())) {
                $ids = $_POST['TbDrugindication']['ids'];
                $TMTID_GPU = $_POST['TbDrugindication']['TMTID_GPU'];
                $DrugIndicationDesc = $_POST['TbDrugindication']['DrugIndicationDesc'];
                $DrugIndicationDesc_label = $_POST['TbDrugindication']['DrugIndicationDesc_label'];
                Yii::$app->db->createCommand('CALL cmd_drugindication_save(:ids,:TMTID_GPU,:DrugIndicationDesc,:DrugIndicationDesc_label);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':DrugIndicationDesc', $DrugIndicationDesc)
                        ->bindParam(':DrugIndicationDesc_label', $DrugIndicationDesc_label)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_drugin', [
                            'model' => $model,
                            'tmtid_gpu' => $model['TMTID_GPU'],
                            'fsn_gpu' => $querygpu['FSN_GPU'],
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ids = $_POST['TbDrugindication']['ids'];
                $TMTID_GPU = $_POST['TbDrugindication']['TMTID_GPU'];
                $DrugIndicationDesc = $_POST['TbDrugindication']['DrugIndicationDesc'];
                $DrugIndicationDesc_label = $_POST['TbDrugindication']['DrugIndicationDesc_label'];
                Yii::$app->db->createCommand('CALL cmd_drugindication_save(:ids,:TMTID_GPU,:DrugIndicationDesc,:DrugIndicationDesc_label);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':DrugIndicationDesc', $DrugIndicationDesc)
                        ->bindParam(':DrugIndicationDesc_label', $DrugIndicationDesc_label)
                        ->execute();
                return 'success';
            } else {
                $model = new TbDrugindication();
                return $this->renderAjax('_form_drugin', [
                            'model' => $model,
                            'tmtid_gpu' => $_GET['tmtid_gpu'],
                            'fsn_gpu' => $_GET['fsn_gpu'],
                ]);
            }
        }
    }

    function actionDeleteDrugin() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_drugindication WHERE ids = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionAdddrugadmin() {
        if (!empty($_GET['id'])) {
            $model = TbDrugadminstration::findOne($_GET['id']);
            $querygpu = TbGenericproductuseGpu::findOne($model['TMTID_GPU']);
            $drugroute = ArrayHelper::map($this->getSubdrugroute($model->DrugRouteID), 'id', 'name');
            if ($model->load(Yii::$app->request->post())) {
                $ids = $_POST['TbDrugadminstration']['ids'];
                $TMTID_GPU = $_POST['TbDrugadminstration']['TMTID_GPU'];
                $DrugRouteID = $_POST['TbDrugadminstration']['DrugRouteID'];
                $DrugPrandialAdviceID = $_POST['TbDrugadminstration']['DrugPrandialAdviceID'];
                $DrugRouteNote = $_POST['TbDrugadminstration']['DrugRouteNote'];
                Yii::$app->db->createCommand('CALL cmd_drugadministration_save(:ids,:TMTID_GPU,:DrugRouteID,:DrugPrandialAdviceID,:DrugRouteNote);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':DrugRouteID', $DrugRouteID)
                        ->bindParam(':DrugPrandialAdviceID', $DrugPrandialAdviceID)
                        ->bindParam(':DrugRouteNote', $DrugRouteNote)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_drugadmin', [
                            'model' => $model,
                            'tmtid_gpu' => $model['TMTID_GPU'],
                            'fsn_gpu' => $querygpu['FSN_GPU'],
                            'drugroute' => $drugroute,
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ids = $_POST['TbDrugadminstration']['ids'];
                $TMTID_GPU = $_POST['TbDrugadminstration']['TMTID_GPU'];
                $DrugRouteID = $_POST['TbDrugadminstration']['DrugRouteID'];
                $DrugPrandialAdviceID = $_POST['TbDrugadminstration']['DrugPrandialAdviceID'];
                $DrugRouteNote = $_POST['TbDrugadminstration']['DrugRouteNote'];

                $check = $this->checkDrugPrandialAdviceID($TMTID_GPU, $DrugRouteID, $DrugPrandialAdviceID);
                if (empty($check)) {
                    Yii::$app->db->createCommand('CALL cmd_drugadministration_save(:ids,:TMTID_GPU,:DrugRouteID,:DrugPrandialAdviceID,:DrugRouteNote);')
                            ->bindParam(':ids', $ids)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->bindParam(':DrugRouteID', $DrugRouteID)
                            ->bindParam(':DrugPrandialAdviceID', $DrugPrandialAdviceID)
                            ->bindParam(':DrugRouteNote', $DrugRouteNote)
                            ->execute();
                    return 'success';
                } else {
                    return 'false';
                }
            } else {
                $model = new TbDrugadminstration();
                return $this->renderAjax('_form_drugadmin', [
                            'model' => $model,
                            'tmtid_gpu' => $_GET['tmtid_gpu'],
                            'fsn_gpu' => $_GET['fsn_gpu'],
                            'drugroute' => '',
                ]);
            }
        }
    }

    function actionDeletedrugadmin() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_drugadminstration WHERE ids = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionAdddrugpre() {
        if (!empty($_GET['id'])) {
            $model = TbDrugprecaution::findOne($_GET['id']);
            $querygpu = TbGenericproductuseGpu::findOne($model['TMTID_GPU']);
            if ($model->load(Yii::$app->request->post())) {
                $ids = $_POST['TbDrugprecaution']['ids'];
                $TMTID_GPU = $_POST['TbDrugprecaution']['TMTID_GPU'];
                $DrugPrecaution_levelID = $_POST['TbDrugprecaution']['DrugPrecaution_levelID'];
                $DrugPrecautionNote = $_POST['TbDrugprecaution']['DrugPrecautionNote'];
                $DrugPrecaution_label = $_POST['TbDrugprecaution']['DrugPrecaution_label'];
                Yii::$app->db->createCommand('CALL cmd_drugprecaution_save(:ids,:TMTID_GPU,:DrugPrecaution_levelID,:DrugPrecautionNote,:DrugPrecaution_label);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':DrugPrecaution_levelID', $DrugPrecaution_levelID)
                        ->bindParam(':DrugPrecautionNote', $DrugPrecautionNote)
                        ->bindParam(':DrugPrecaution_label', $DrugPrecaution_label)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_drugpre', [
                            'model' => $model,
                            'tmtid_gpu' => $model['TMTID_GPU'],
                            'fsn_gpu' => $querygpu['FSN_GPU'],
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ids = $_POST['TbDrugprecaution']['ids'];
                $TMTID_GPU = $_POST['TbDrugprecaution']['TMTID_GPU'];
                $DrugPrecaution_levelID = $_POST['TbDrugprecaution']['DrugPrecaution_levelID'];
                $DrugPrecautionNote = $_POST['TbDrugprecaution']['DrugPrecautionNote'];
                $DrugPrecaution_label = $_POST['TbDrugprecaution']['DrugPrecaution_label'];
                Yii::$app->db->createCommand('CALL cmd_drugprecaution_save(:ids,:TMTID_GPU,:DrugPrecaution_levelID,:DrugPrecautionNote,:DrugPrecaution_label);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':DrugPrecaution_levelID', $DrugPrecaution_levelID)
                        ->bindParam(':DrugPrecautionNote', $DrugPrecautionNote)
                        ->bindParam(':DrugPrecaution_label', $DrugPrecaution_label)
                        ->execute();
                return 'success';
            } else {
                $model = new TbDrugprecaution();
                return $this->renderAjax('_form_drugpre', [
                            'model' => $model,
                            'tmtid_gpu' => $_GET['tmtid_gpu'],
                            'fsn_gpu' => $_GET['fsn_gpu'],
                ]);
            }
        }
    }

    function actionDeletedrugpre() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_drugprecaution WHERE ids = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionGettabledrugin() {
        $query = VwDrugindication::find()->where(['TMTID_GPU' => $_POST['gpu']])->all();
        $table = '<table width="100%"  class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_drugindication">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">สรรพคุณทางยา</th>
                                    <th  style="text-align: center;">ข้อความสรรพคุณทางยาบนฉลากยา</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($query as $result) {
            $table .= '<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td>' . $result['DrugIndicationDesc'] . '</td>';
            $table .= '<td>' . $result['DrugIndicationDesc_label'] . '</td>';
            $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateDrugin(' . $result->ids . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="Deletedrugin(' . $result->ids . ');" > Delete</a>
                    </td>';
            $table .= '</tr>';
            $no++;
        }
        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionGettabledrugadmins() {
        $query = VwDrugadminstration::find()->where(['TMTID_GPU' => $_POST['gpu']])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_drugadminstration">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">วิธีการให้ยา</th>
                                    <th  style="text-align: center;">คำแนะนำการให้ยา</th>
                                    <th  style="text-align: center;">หมายเหตุ</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($query as $result) {
            $table .= '<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td>' . $result['DrugRouteName'] . '</td>';
            $table .= '<td>' . $result['DrugPrandialAdviceDesc'] . '</td>';
            $table .= '<td>' . $result['DrugRouteNote'] . '</td>';
            $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateDrugadmins(' . $result->ids . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="DeleteDrugadmins(' . $result->ids . ');" > Delete</a>
                    </td>';
            $table .= '</tr>';
            $no++;
        }
        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionGettabledrugpre() {
        $query = VwDrugprecaution::find()->where(['TMTID_GPU' => $_POST['gpu']])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_drugprecaution">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">ระดับการเตือน</th>
                                    <th  style="text-align: center;">หมายเหตุ</th>
                                    <th  style="text-align: center;">ข้อความคำเตือนบนฉลากยา</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($query as $result) {
            $table .= '<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td>' . $result['DrugPrecaution_levelDesc'] . '</td>';
            $table .= '<td>' . $result['DrugPrecautionNote'] . '</td>';
            $table .= '<td>' . $result['DrugPrecaution_label'] . '</td>';
            $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateDrugpre(' . $result->ids . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="DeleteDrugpre(' . $result->ids . ');" > Delete</a>
                    </td>';
            $table .= '</tr>';
            $no++;
        }
        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionGettableitempack() {
        $query = VwItempack::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_itempack">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">ปริมาณบรรจุต่อแพค</th>
                                    <th  style="text-align: center;">หน่วยการจ่าย</th>
                                    <th  style="text-align: center;">หน่วยแพค</th>
                                    <th  style="text-align: center;">แพคหลัก</th>
                                    <th  style="text-align: center;">หมายเหตุ</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['ItemPackSKUQty'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['PackUnit'] . '</td>';
                $table .= '<td style="text-align: center">';
                if ($result['ItemPackDefault'] == 1) {
                    $table .= '<b><text class="success">Yes</text></b>';
                } else {
                    $table .= '<b><text class="danger">No</text></b>';
                }
                $table .= '</td>';
                $table .= '<td>' . $result['ItemPackNote'] . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateItempack(' . $result->ItemPackID . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="DeleteItempack(' . $result->ItemPackID . ');" > Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['ItemPackSKUQty'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['PackUnit'] . '</td>';
                $table .= '<td style="text-align: center">';
                if ($result['ItemPackDefault'] == 1) {
                    $table .= '<b><text class="success">Yes</text></b>';
                } else {
                    $table .= '<b><text class="danger">No</text></b>';
                }
                $table .= '</td>';
                $table .= '<td>' . $result['ItemPackNote'] . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" disabled="" onclick="(' . $result->ItemPackID . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" disabled="" onclick="(' . $result->ItemPackID . ');" > Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        }
        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionGettablestklevel() {
        $query = VwStklevelinfo::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_stk_levelinfo">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">คลังสินค้า</th>
                                    <th  style="text-align: center;">จุดสั่งซื้อสินค้า</th>
                                    <th  style="text-align: center;">เป้าหมายการจัดเก็บ</th>
                                    <th  style="text-align: center;">หน่วย</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        $querysum = VwStklevelinfo::find();
        $querysum->where(['ItemID' => $_POST['itemid']]);
        $sumreorder = $querysum->sum('ItemReorderLevel');
        $sumlevel = $querysum->sum('ItemTargetLevel');
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['StkName'] . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemReorderLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemTargetLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateStklevel(this);" data-id="' . $result->ItemID . '" id="' . $result->StkID . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="DeleteStklevel(this);" data-id="' . $result->ItemID . '" id="' . $result->StkID . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['StkName'] . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemReorderLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemTargetLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" disabled="" onclick="(' . $result->ItemID . ');"> Edit</a>
                    <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->StkID . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        }
        $table .= '</tr>
                 </tbody>
                 <tfoot>
                                       <tr>
                                         <td colspan="2" style="background-color:white;text-align: right"><strong>รวม</strong></td>
                                         <td style="text-align: center;background-color: white;">
                                         ' . number_format($sumreorder, 2) . '
                                         </td>
                                         <td style="text-align: center;background-color: white;">
                                         ' . number_format($sumlevel, 2) . '
                                         </td>
                                         <td colspan="2" style="background-color: white;"></td>
                                        </tr>
                                     </tfoot>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    private function checkDrugPrandialAdviceID($TMTID_GPU, $DrugRouteID, $DrugPrandialAdviceID) {
        $query = TbDrugadminstration::findOne(['TMTID_GPU' => $TMTID_GPU, 'DrugPrandialAdviceID' => $DrugPrandialAdviceID, 'DrugRouteID' => $DrugRouteID]);
        return $query;
    }

    private function checkDrugadmin($TMTID_GPU, $DrugRouteID, $DrugPrandialAdviceID) {
        $qurey = TbDrugadminstration::findOne($condition);
        if ($qurey != null) {
            
        }
    }

    function actionDeleteItempack() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_itempack WHERE ItemPackID = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionDeleteStklevel() {
        $id = $_POST['id'];
        $stk = $_POST['stk'];
        $sql = "DELETE FROM tb_stk_levelinfo WHERE ItemID = $id and StkID = $stk";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionCreateItemnew() {
        $querytpu = TbMastertmt::findOne($_POST['tpu']);
        //$querytpu = TbMastertmt::findOne($tpu);
        $querygpu = TbGenericproductuseGpu::findOne($querytpu['TMTID_GPU']);
        $posts = Yii::$app->db->createCommand("SELECT tb_item.ItemID FROM tb_item WHERE tb_item.ItemID LIKE '1%' ORDER BY tb_item.ItemID DESC LIMIT 1")
                ->queryOne();
        $ItemID = $posts['ItemID'] + 1;
        $ItemCatID = 1;
        $ItemName = $querygpu['FSN_GPU'];
        $TMTID_TPU = $_POST['tpu'];
        $TMTID_GPU = $querytpu['TMTID_GPU'];
        $TMTID_GP = $querygpu['TMTID_GP'];
        $itemdosageform = $querygpu['Dosageform_GPU'];
        $itemstmum = $querygpu['StrNum_GPU'];
        $itemContVal = $querygpu['ContVal_GPU'];
        $itemContUnit = $querygpu['CoutUnit_GPU'];
        $itemDispUnit = $querygpu['DispUnit_GPU'];
        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_create_newitem(:ItemID,:ItemCatID,:ItemName,:TMTID_TPU,:TMTID_GPU,:TMTID_GP,:itemdosageform,:itemstmum,:itemContVal,:itemContUnit,:itemDispUnit,:CreatedBy);')
                ->bindParam(':ItemID', $ItemID)
                ->bindParam(':ItemCatID', $ItemCatID)
                ->bindParam(':ItemName', $ItemName)
                ->bindParam(':TMTID_TPU', $TMTID_TPU)
                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                ->bindParam(':TMTID_GP', $TMTID_GP)
                ->bindParam(':itemdosageform', $itemdosageform)
                ->bindParam(':itemstmum', $itemstmum)
                ->bindParam(':itemContVal', $itemContVal)
                ->bindParam(':itemContUnit', $itemContUnit)
                ->bindParam(':itemDispUnit', $itemDispUnit)
                ->bindParam(':CreatedBy', $CreatedBy)
                ->execute();
        return $this->redirect(['createitem', 'itemid' => $ItemID, 'true' => 'yes']);
    }

    public function actionCreateitem($itemid, $true) {
        $modelrxorder = new Tbrxordercondition();
        $modelitem = TbItem::findOne($itemid);
        if ($modelitem->load(Yii::$app->request->post())) {
            // $modelitem->ItemPic1 = $modelitem->Upload($modelitem, 'ItemPic1');
            //$modelitem->ItemPic2 = $modelitem->Upload($modelitem, 'ItemPic2');
            $modelitem->ItemStatusID = 2;
            $modelitem->save();
            Yii::$app->session->setFlash('success', 'Save Completed!');
            /*
              Yii::$app->getSession()->setFlash('alert1', [
              'type' => 'success',
              'duration' => 6000,
              'icon' => 'fa fa-users',
              'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
              'message' => Yii::t('app', Html::encode('บันทึกข้อมูลเสร็จเรียบร้อย')),
              'positonY' => 'top',
              'positonX' => 'right'
              ]); */
            return $this->refresh();
        } else {
            $querytpu = TbMastertmt::findOne($modelitem['TMTID_TPU']);
            /*  ItemPic1 */
            if ($modelitem['ItemPic1'] == "") {
                $initialPreview = [];
                $initialPreviewConfig = [];
            } else {
                list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($modelitem->ItemPic1);
            }
            /*  ItemPic2 */
            if ($modelitem['ItemPic2'] == "") {
                $initialPreview1 = [];
                $initialPreviewConfig1 = [];
            } else {
                list($initialPreview1, $initialPreviewConfig1) = $this->getInitialPreview1($modelitem->ItemPic2);
            }
            return $this->render('_form_additem', [
                        'modelitem' => $modelitem,
                        'querytpu' => $querytpu,
                        // 'querygpu' => $querygpu,
                        'initialPreview' => $initialPreview,
                        'initialPreviewConfig' => $initialPreviewConfig,
                        'initialPreview1' => $initialPreview1,
                        'initialPreviewConfig1' => $initialPreviewConfig1,
                        'true' => $true,
                        'modelrxorder' => $modelrxorder
            ]);
        }
    }

    public function actionAdditemPack() {
        if (!empty($_GET['id'])) {
            $modelitempack = TbItempack::findOne($_GET['id']);
            if ($modelitempack->load(Yii::$app->request->post())) {
                $x = $_POST['TbItempack']['ItemPackID'];
                $ItemID = $_POST['TbItempack']['ItemID'];
                $ItemPackSKUQty = $_POST['TbItempack']['ItemPackSKUQty'];
                $ItemPackUnit = $_POST['TbItempack']['ItemPackUnit'];
                $ItemPackBarcode = $_POST['TbItempack']['ItemPackBarcode'];
                $ItemPackDefault = $_POST['TbItempack']['ItemPackDefault'];
                $ItemPackNote = $_POST['TbItempack']['ItemPackNote'];
                $TMTID_GPU = $_POST['TbItempack']['TMTID_GPU'];

                $findid = TbItempack::findOne(['ItemPackID' => $x, 'ItemPackUnit' => $ItemPackUnit, 'ItemID' => $ItemID]);
                $find_packdefault = TbItempack::findOne(['ItemPackID' => $x, 'ItemPackDefault' => $ItemPackDefault, 'ItemID' => $ItemID]);
                if ((!empty($findid) && !empty($find_packdefault))) {
                    Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                            ->bindParam(':x', $x)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                            ->bindParam(':ItemPackUnit', $ItemPackUnit)
                            ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                            ->bindParam(':ItemPackDefault', $ItemPackDefault)
                            ->bindParam(':ItemPackNote', $ItemPackNote)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->execute();
                    return 'success';
                } elseif (empty($findid) && !empty($find_packdefault)) {
                    $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                    if (empty($checkpack)) {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    } else {
                        return 'checkpack';
                    }
                } elseif (!empty($findid) && empty($find_packdefault)) {
                    $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                    if (empty($packdefault)) {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    } else {
                        return 'packdefault';
                    }
                } elseif (empty($findid) && empty($find_packdefault)) {
                    $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                    $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                    if (!empty($checkpack)) {
                        return 'checkpack';
                    } else if (!empty($packdefault)) {
                        return 'packdefault';
                    } else {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    }
                }
            } else {
                $querydispunit = VwItempack::findOne(['ItemPackID' => $_GET['id']]);
                $querygpu = TbGenericproductuseGpu::findOne(['TMTID_GPU' => $querydispunit['TMTID_GPU']]);
                return $this->renderAjax('_form_additempack', [
                            'modelitempack' => $modelitempack,
                            'DispUnit' => $querydispunit['DispUnit'],
                            'fsn_gpu' => $querygpu['FSN_GPU'],
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $x = $_POST['TbItempack']['ItemPackID'];
                $ItemID = $_POST['TbItempack']['ItemID'];
                $ItemPackSKUQty = $_POST['TbItempack']['ItemPackSKUQty'];
                $ItemPackUnit = $_POST['TbItempack']['ItemPackUnit'];
                $ItemPackBarcode = $_POST['TbItempack']['ItemPackBarcode'];
                $ItemPackDefault = $_POST['TbItempack']['ItemPackDefault'];
                $ItemPackNote = $_POST['TbItempack']['ItemPackNote'];
                $TMTID_GPU = $_POST['TbItempack']['TMTID_GPU'];
                $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                if (!empty($checkpack)) {
                    return 'checkpack';
                } else if (!empty($packdefault)) {
                    return 'packdefault';
                } else {
                    Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                            ->bindParam(':x', $x)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                            ->bindParam(':ItemPackUnit', $ItemPackUnit)
                            ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                            ->bindParam(':ItemPackDefault', $ItemPackDefault)
                            ->bindParam(':ItemPackNote', $ItemPackNote)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->execute();
                    return 'success';
                }
            } else {
                $modelitempack = new TbItempack();
                return $this->renderAjax('_form_additempack', [
                            'modelitempack' => $modelitempack,
                            'fsn_gpu' => '',
                            'DispUnit' => '',
                ]);
            }
        }
    }

    private function checkPack($ItemPackUnit, $ItemID) {
        $checkpack = TbItempack::findOne(['ItemPackUnit' => $ItemPackUnit, 'ItemID' => $ItemID]);
        return $checkpack;
    }

    private function checkPackdefault($ItemID, $ItemPackDefault) {
        if ($ItemPackDefault == 1) {
            $packdefault = TbItempack::findOne(['ItemID' => $ItemID, 'ItemPackDefault' => $ItemPackDefault]);
            return $packdefault;
        } else {
            return NULL;
        }
    }

    public function actionAddstklevel() {
        if (!empty($_GET['id'])) {
            $modelstk = TbStkLevelinfo::findOne(['ItemID' => $_GET['id'], 'StkID' => $_GET['stkid']]);
            if ($modelstk->load(Yii::$app->request->post())) {
                $ItemID = $_POST['TbStkLevelinfo']['ItemID'];
                $StkID = $_POST['TbStkLevelinfo']['StkID'];
                $ItemReorderLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemReorderLevel']);
                $ItemTargetLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemTargetLevel']);

                Yii::$app->db->createCommand('CALL cmd_stklevelinfo_save(:ItemID,:StkID,:ItemReorderLevel,:ItemTargetLevel);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':StkID', $StkID)
                        ->bindParam(':ItemReorderLevel', $ItemReorderLevel)
                        ->bindParam(':ItemTargetLevel', $ItemTargetLevel)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_addstklevel', [
                            'modelstk' => $modelstk,
                            'edit' => 'true'
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbStkLevelinfo']['ItemID'];
                $StkID = $_POST['TbStkLevelinfo']['StkID'];
                $ItemReorderLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemReorderLevel']);
                $ItemTargetLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemTargetLevel']);
                if ($ItemReorderLevel > $ItemTargetLevel) {
                    return 'false';
                } else {
                    $duplicate = $this->checkDuplicatestk($ItemID, $StkID);
                    if (!empty($duplicate)) {
                        return 'duplicate';
                    } else {
                        Yii::$app->db->createCommand('CALL cmd_stklevelinfo_save(:ItemID,:StkID,:ItemReorderLevel,:ItemTargetLevel);')
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':StkID', $StkID)
                                ->bindParam(':ItemReorderLevel', $ItemReorderLevel)
                                ->bindParam(':ItemTargetLevel', $ItemTargetLevel)
                                ->execute();
                        return 'success';
                    }
                }
            } else {
                $modelstk = new TbStkLevelinfo();
                return $this->renderAjax('_form_addstklevel', [
                            'modelstk' => $modelstk,
                            'edit' => 'false'
                ]);
            }
        }
    }

    private function checkDuplicatestk($ItemID, $StkID) {
        $sql = "SELECT * FROM tb_stk_levelinfo WHERE tb_stk_levelinfo.ItemID = $ItemID AND tb_stk_levelinfo.StkID = $StkID";
        $query = Yii::$app->db->createCommand($sql);
        $querysql = $query->queryOne();
        return $querysql;
    }

    function actionCheckitemidprice() {
        $query = TbItemIDPrice::findOne($_POST['ItemID']);
        return json_encode($query);
    }

    /* |*********************************************************************************|
      |================================ Upload Ajax ====================================|
      |*********************************************************************************| */

    private function getInitialPreview($ref) {
        $datas = TbItem::find()->where(['ItemPic1' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview, $this->getTemplatePreview($value));
            array_push($initialPreviewConfig, [
                'caption' => $value->ItemPic1,
                'width' => '120px',
                'url' => Url::to(['/Inventory/additem/deletefile-ajax']),
                'key' => $value->ItemID
            ]);
        }
        return [$initialPreview, $initialPreviewConfig];
    }

    private function getInitialPreview1($ref) {
        $datas = TbItem::find()->where(['ItemPic2' => $ref])->all();
        $initialPreview1 = [];
        $initialPreviewConfig1 = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview1, $this->getTemplatePreview1($value));
            array_push($initialPreviewConfig1, [
                'caption' => $value->ItemPic2,
                'width' => '120px',
                'url' => Url::to(['/Inventory/additem/deletefile-ajax1']),
                'key' => $value->ItemID
            ]);
        }
        return [$initialPreview1, $initialPreviewConfig1];
    }

    private function getTemplatePreview($model) {
        $file = Html::img($model->getPhotoViewer1(), ['class' => 'file-preview-image', 'width' => 280]);
        return $file;
    }

    private function getTemplatePreview1($model) {
        $file = Html::img($model->getPhotoViewer2(), ['class' => 'file-preview-image', 'width' => 280]);
        return $file;
    }

    public function actionDeletefileAjax() {
        $model = TbItem::findOne(Yii::$app->request->post('key'));
        if (!empty($model)) {
            $filename = $model->getUploadPath() . $model->ItemPic1;
            $filenametemp = $model->getUploadPath() . 'thumbnail/' . $model->ItemPic1;
            @unlink($filename);
            @unlink($filenametemp);
            $model->ItemPic1 = '';
            $model->save();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function actionDeletefileAjax1() {
        $model = TbItem::findOne(Yii::$app->request->post('key'));
        if (!empty($model)) {
            $filename = $model->getUploadPath() . $model->ItemPic2;
            @unlink($filename);
            $model->ItemPic2 = '';
            $model->save();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    function actionGpu() {
        $data = Vwgpulist::find()->all();
        $htl = '<table class="default kv-grid-table table table-hover table-bordered table-striped table-condensed" cellspacing="0" width="100%" id="vw_item_list_gpu">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">ลำดับ</th>
                                    <th  style="text-align: center;">รหัสสามัญ</th>
                                    <th  style="text-align: center;"> รายละเอียด</th>
                                    <th width="100px" style="text-align: center;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($data as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .= '<td style="text-align: center;" >'
                    . '<a class="btn btn-success btn-xs" onclick="Selectitem(' . $result->TMTID_GPU . ');" > Select</a>'
                    . '</td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    function actionGpustdcostlist() {
        $data = Vwgpustdcostlist::find()->all();
        $htl = '<table class="default kv-grid-table table table-hover table-bordered table-striped table-condensed" cellspacing="0" width="100%" id="vw_gpustdcost_list">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th  style="text-align: center;">รหัสยาสามัญ</th>
                                    <th  style="text-align: center;"> รายละเอียด</th>
                                    <th  style="text-align: center;">ราคากลาง</th>
                                    <th width="100px" style="text-align: center;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($data as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .= '<td style="text-align: right;">' . number_format($result['GPUStdCost'], 2) . '</td>';
            // $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';

            $htl .= '<td style="text-align: center;" >'
                    . '<a class="btn btn-success btn-xs" onclick="Edit(' . $result->ids . ');" > Edit</a>' . ' '
                    . '<a class="btn btn-danger btn-xs" onclick="Delete(' . $result->ids . ');" > Delete</a>'
                    . '</td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    function actionEditgpucost() {
        $query = Vwgpustdcostlist::findOne(['ids' => $_POST['id']]);

        $arr = array(
            'TMTID_GPU' => $query['TMTID_GPU'],
            'FSN_GPU' => $query['FSN_GPU'],
            'DispUnit' => $query['DispUnit'],
            'GPUStdCost' => number_format($query['GPUStdCost'], 4),
            'cost_ref' => number_format($query['cost_ref'], 4),
            'cost_ref_from' => $query['cost_ref_from'],
        );
        return json_encode($arr);
    }

    function actionDeleteStdgpucost() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_gpustdcost WHERE ids = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionStdgpu() {
        $model = new TbGpustdcost();
        if ($model->load(Yii::$app->request->post())) {
            $ids = $_POST['TbGpustdcost']['ids'];
            $TMTID_GPU = $_POST['TbGpustdcost']['TMTID_GPU'];
            $GPUStdCost = str_replace(',', '', $_POST['TbGpustdcost']['GPUStdCost']);
            $GPUStdCost_status = 2;
            $CreateBy = Yii::$app->user->identity->profile->user_id;
            $cost_ref = str_replace(',', '', $_POST['TbGpustdcost']['cost_ref']);
            $cost_ref_from = $_POST['TbGpustdcost']['cost_ref_from'];
            Yii::$app->db->createCommand('CALL cmd_gpustdcost_save(:ids,:TMTID_GPU,:GPUStdCost,:GPUStdCost_status,:CreateBy,:cost_ref,:cost_ref_from);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':GPUStdCost', $GPUStdCost)
                    ->bindParam(':GPUStdCost_status', $GPUStdCost_status)
                    ->bindParam(':CreateBy', $CreateBy)
                    ->bindParam(':cost_ref', $cost_ref)
                    ->bindParam(':cost_ref_from', $cost_ref_from)
                    ->execute();
            return 'success';
        } else {

            return $this->render('stdgpu', [
                        'model' => $model,
            ]);
        }
    }

    function actionSelectitem() {
        $check = Vwgpustdcostlist::findOne(['TMTID_GPU' => $_POST['id']]);
        if (!empty($check)) {
            $arr = array(
                'check' => 'true',
            );
            return json_encode($arr);
        } else {
            $query = VwGpuList::findOne(['TMTID_GPU' => $_POST['id']]);
            $arr = array(
                'MTID_GPU' => $query['TMTID_GPU'],
                'FSN_GPU' => $query['FSN_GPU'],
                'DispUnit' => $query['DispUnit'],
                'check' => 'false',
            );
            return json_encode($arr);
        }
    }

    function actionGetitemprice() {
        $query = VwItemidPrice::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_itemid_price">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">ราคาขาย</th>
                                    <th  style="text-align: center;">หน่วย</th>
                                    <th  style="text-align: center;">วันเริ่มใช้</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" onclick="UpdateItemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="Deleteitemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;">
                    <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionGetcredititem() {
        $query = VwcreditItem::find()->where(['ItemID' => $_POST['itemid'], 'cr_status' => 2])->all();
        $table = '<table width="100%" class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_credititem">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th style="text-align: center;">ประเภทสิทธิ</th>
                                    <th  style="text-align: center;">เบิกได้ตามสิทธิการรักษา</th>
                                    <th  style="text-align: center;">วันเริ่มใช้</th>
                                    <th width="160px" style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . $result['medical_right_group'] . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['cr_price'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['cr_effectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;"></td>';
                /*
                  $table .='<td style="text-align: center;">
                  <a class="btn btn-info btn-xs" onclick="UpdateCredititem(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Edit</a>
                  <a class="btn btn-danger btn-xs" onclick="DeleteCredititem(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Delete</a>
                  </td>';
                 */

                $table .= '</tr>';

                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . $result['medical_right_group'] . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['cr_price'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['cr_effectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;"></td>';
                /*
                  $table .='<td style="text-align: center;">
                  <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Edit</a>
                  <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Delete</a>
                  </td>';
                 */
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    public function actionGetrxorder() {
        $query = Tbrxordercondition::findOne(['TMTID_GPU' => $_POST['gpu']]);
        $gp = TbGenericproductGp::findOne(['TMTID_GP' => $_POST['gp']]);
        $arr = array(
            'DrugGroup_GP' => $gp['DrugGroup_GP'],
            'ISED_CatID' => $gp['ISED_CatID'],
            'Narcotics' => $query['Narcotics_required'],
            'NED' => $query['NED_required'],
            'DUE' => $query['DUE_required'],
            'due_id' => $query['due_id'],
            'Drug2' => $query['Drug2MDApprove_required'],
            'OCPA' => $query['OCPA_required'],
            'CPR' => $query['CPR_required'],
            'id' => $query['order_condition_id'],
        );
        return json_encode($arr);
    }

    public function actionSaverxorderitem() {
        $id = $_POST['id'];
        $TMTID_GPU = $_POST['gpu'];
        $Narcotics_required = $_POST['narcotics'];
        $NED_required = $_POST['ned'];
        $DUE_required = $_POST['due'];
        $due_id = $_POST['due_id'];
        $Drug2MDApprove_required = $_POST['drug2'];
        $OCPA_required = $_POST['ocpa'];
        $CPR = $_POST['cpr'];
        $jor2 = $_POST['jor2'];
        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_rxordercondition_save(:TMTID_GPU,:Narcotics_required,:NED_required,:Drug2MDApprove_required,:DUE_required,:due_id,:OCPA_required,:CPR,:CreatedBy,:order_condition_id,:Jor2_required);')
                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                ->bindParam(':Narcotics_required', $Narcotics_required)
                ->bindParam(':NED_required', $NED_required)
                ->bindParam(':Drug2MDApprove_required', $Drug2MDApprove_required)
                ->bindParam(':DUE_required', $DUE_required)
                ->bindParam(':due_id', $due_id)
                ->bindParam(':OCPA_required', $OCPA_required)
                ->bindParam(':CPR', $CPR)
                ->bindParam(':CreatedBy', $CreatedBy)
                ->bindParam(':order_condition_id', $id)
                ->bindParam(':Jor2_required', $jor2)
                ->execute();
        return 'success';
    }

    function actionDeleteRxorder() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_rxorder_condition WHERE order_condition_id = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionAdditemprice() {
        if (!empty($_GET['id'])) {
            $model = TbItemIDPrice::findOne(['ItemID' => $_GET['id']]);
            $modelprice = VwItemidPrice::findOne(['ItemID' => $_GET['id'], 'ItemPriceEffectiveDate' => $_GET['date']]);
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbItemIDPrice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['TbItemIDPrice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbItemIDPrice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_itemidprice', [
                            'model' => $model,
                            'ItemName' => $modelprice['ItemName'],
                            'DispUnit' => $modelprice['DispUnit'],
                            'itemprice' => number_format($model['ItemPrice'], 2),
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbItemIDPrice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['TbItemIDPrice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbItemIDPrice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                $model = new TbItemIDPrice();
                return $this->renderAjax('_form_itemidprice', [
                            'model' => $model,
                            'ItemName' => '',
                            'DispUnit' => '',
                            'itemprice' => '',
                ]);
            }
        }
    }

    function actionDeleteItemprice() {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $sql = "DELETE FROM tb_ItemID_Price WHERE ItemID = $id and ItemPriceEffectiveDate = '$date'";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionAddcredititem() {
        if (!empty($_GET['id'])) {
            $model = TbCreditItem::findOne(['ItemID' => $_GET['id'], 'medical_right_group_id' => $_GET['maininscl_id']]);
            $modelcredit = VwcreditItem::findOne(['ItemID' => $_GET['id'], 'medical_right_group_id' => $_GET['maininscl_id']]);
            if ($model->load(Yii::$app->request->post())) {
                $ids = $_POST['TbCreditItem']['ids'];
                $ItemID = $_POST['TbCreditItem']['ItemID'];
                $maininscl_id = $_POST['TbCreditItem']['medical_right_group_id'];
                $cr_price = str_replace(',', '', $_POST['TbCreditItem']['cr_price']);
                $cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbCreditItem']['cr_effectiveDate']);
                $cr_status = 2;
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemcredit_save(:ids,:ItemID,:maininscl_id,:cr_price,:cr_effectiveDate,:cr_status,:CreatedBy);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':maininscl_id', $maininscl_id)
                        ->bindParam(':cr_price', $cr_price)
                        ->bindParam(':cr_effectiveDate', $cr_effectiveDate)
                        ->bindParam(':cr_status', $cr_status)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_credititem', [
                            'model' => $model,
                            'ItemName' => $modelcredit['ItemName'],
                            'DispUnit' => $modelcredit['DispUnit'],
                            'cr_price' => number_format($model['cr_price'], 2),
                            'edit' => 'true'
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ids = $_POST['TbCreditItem']['ids'];
                $ItemID = $_POST['TbCreditItem']['ItemID'];
                $maininscl_id = $_POST['TbCreditItem']['medical_right_group_id'];
                $cr_price = str_replace(',', '', $_POST['TbCreditItem']['cr_price']);
                $cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbCreditItem']['cr_effectiveDate']);
                $cr_status = 2;
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                $check = $this->checkdupcredit($ItemID, $maininscl_id);
                if (!empty($check)) {
                    return 'false';
                } else {
                    Yii::$app->db->createCommand('CALL cmd_itemcredit_save(:ids,:ItemID,:maininscl_id,:cr_price,:cr_effectiveDate,:cr_status,:CreatedBy);')
                            ->bindParam(':ids', $ids)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':maininscl_id', $maininscl_id)
                            ->bindParam(':cr_price', $cr_price)
                            ->bindParam(':cr_effectiveDate', $cr_effectiveDate)
                            ->bindParam(':cr_status', $cr_status)
                            ->bindParam(':CreatedBy', $CreatedBy)
                            ->execute();
                    return 'success';
                }
            } else {
                $model = new TbCreditItem();
                return $this->renderAjax('_form_credititem', [
                            'model' => $model,
                            'ItemName' => '',
                            'DispUnit' => '',
                            'cr_price' => '',
                            'edit' => 'false'
                ]);
            }
        }
    }

    private function checkdupcredit($ItemID, $maininscl_id) {
        $query = TbCreditItem::findOne(['ItemID' => $ItemID, 'medical_right_group_id' => $maininscl_id]);
        return $query;
    }

    function actionDeleteCredititem() {
        $id = $_POST['id'];
        $maininscl_id = $_POST['maininscl_id'];
        $sql = "DELETE FROM tb_credit_item WHERE ItemID = $id and medical_right_group_id = '$maininscl_id'";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionGetdruglabel() {
        $query = Vwlabeldruggpu::findOne(['TMTID_GPU' => $_POST['gpu']]);
        $arr = array(
            'label' => $query['DrugLabel'],
            'drugadmin' => $query['DrugAdministration'],
            'druglabel1' => $query['Druglabel1'],
            'druglabel2' => $query['Druglabel2'],
        );
        return json_encode($arr);
    }

    function actionDiscontinus() {
        $ItemID = $_POST['ItemID'];
        Yii::$app->db->createCommand('CALL cmd_item_discontinue(:ItemID);')
                ->bindParam(':ItemID', $ItemID)
                ->execute();
    }

    function actionGetdruglabeltpu() {
        $query = Vwlabeldrugtpu::findOne(['ItemID' => $_POST['itemid']]);
        $arr = array(
            'label' => $query['DrugLabel'],
            'drugadmin' => $query['DrugAdministration'],
            'druglabel1' => $query['Druglabel1'],
            'druglabel2' => $query['Druglabel2'],
        );
        return json_encode($arr);
    }

    function actionEditprice($id) {
        if (isset($id)) {
            $query = VwItemidPrice::findOne(['ItemID' => $id]);
            $creditprice = VwcreditItem::findAll(['ItemID' => $id]);
            $itemprice = VwItemidPrice::find()->where(['ItemID' => $id])->all();
            return $this->renderPartial('_price-details', [
                        'creditprice' => $creditprice,
                        'itemprice' => $itemprice,
                        'dataitem' => $query
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionAddEditItemprice() {
        if (!empty($_GET['id'])) {
            $model = TbItemIDPrice::findOne(['ItemID' => $_GET['id'], 'ItemPriceEffectiveDate' => $_GET['date']]);
            $modelprice = VwItemidPrice::findOne(['ItemID' => $_GET['id'], 'ItemPriceEffectiveDate' => $_GET['date']]);
            if ($model->load(Yii::$app->request->post())) {
                $ItemID = $_POST['TbItemIDPrice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['TbItemIDPrice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbItemIDPrice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_addedit_itemprice', [
                            'model' => $model,
                            'ItemName' => $modelprice['ItemName'],
                            'DispUnit' => $modelprice['DispUnit'],
                            'itemprice' => number_format($model['ItemPrice'], 2),
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbItemIDPrice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['TbItemIDPrice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbItemIDPrice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                $model = new TbItemIDPrice();
                return $this->renderAjax('_form_addedit_itemprice', [
                            'model' => $model,
                            'ItemName' => '',
                            'DispUnit' => '',
                            'itemprice' => '',
                ]);
            }
        }
    }

    function actionGetitempriceedit() {
        $query = VwItemidPrice::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table width="100%" class="table table-bordered table-hover dt-responsive " id="table_tb_itemid_price">
                            <thead >
                                <tr>
                            <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#</th>
                            <th  style="text-align: center;color:black;background-color: #ddd">ราคาขาย</th>
                            <th  style="text-align: center;color:black;background-color: #ddd">หน่วย</th>
                            <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
                            <th  style="text-align: center;color:black;background-color: #ddd">Actios</th>
                        </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
                    <a class="btn btn-info btn-xs" onclick="UpdateItemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="Deleteitemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
                    <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    public function actionAddcredititemprice() {
        if (!empty($_GET['id'])) {
            $model = TbCreditItem::findOne(['ItemID' => $_GET['id'], 'medical_right_group_id' => $_GET['maininscl_id']]);
            $modelcredit = VwcreditItem::findOne(['ItemID' => $_GET['id'], 'medical_right_group_id' => $_GET['maininscl_id']]);
            if ($model->load(Yii::$app->request->post())) {
                $ItemID = $_POST['TbcreditItem']['ItemID'];
                $maininscl_id = $_POST['TbcreditItem']['medical_right_group_id'];
                $cr_price = str_replace(',', '', $_POST['TbcreditItem']['cr_price']);
                $cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbcreditItem']['cr_effectiveDate']);
                $cr_status = 2;
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemcredit_save(:ItemID,:maininscl_id,:cr_price,:cr_effectiveDate,:cr_status,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':maininscl_id', $maininscl_id)
                        ->bindParam(':cr_price', $cr_price)
                        ->bindParam(':cr_effectiveDate', $cr_effectiveDate)
                        ->bindParam(':cr_status', $cr_status)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_add_creditprice', [
                            'model' => $model,
                            'ItemName' => $modelcredit['ItemName'],
                            'DispUnit' => $modelcredit['DispUnit'],
                            'cr_price' => number_format($model['cr_price'], 2),
                            'edit' => 'true'
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbcreditItem']['ItemID'];
                $maininscl_id = $_POST['TbcreditItem']['medical_right_group_id'];
                $cr_price = str_replace(',', '', $_POST['TbcreditItem']['cr_price']);
                $cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($_POST['TbcreditItem']['cr_effectiveDate']);
                $cr_status = 2;
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                $check = $this->checkdupcredit($ItemID, $maininscl_id);
                if (!empty($check)) {
                    return 'false';
                } else {
                    Yii::$app->db->createCommand('CALL cmd_itemcredit_save(:ItemID,:maininscl_id,:cr_price,:cr_effectiveDate,:cr_status,:CreatedBy);')
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':maininscl_id', $maininscl_id)
                            ->bindParam(':cr_price', $cr_price)
                            ->bindParam(':cr_effectiveDate', $cr_effectiveDate)
                            ->bindParam(':cr_status', $cr_status)
                            ->bindParam(':CreatedBy', $CreatedBy)
                            ->execute();
                    return 'success';
                }
            } else {
                $model = new \app\modules\Inventory\models\TbcreditItem();
                return $this->renderAjax('_form_add_creditprice', [
                            'model' => $model,
                            'ItemName' => '',
                            'DispUnit' => '',
                            'cr_price' => '',
                            'edit' => 'false'
                ]);
            }
        }
    }

    function actionGetcredititemprice() {
        $query = VwcreditItem::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table width="100%" class="table table-bordered table-hover dt-responsive" id="table_tb_credititem">
                            <thead >
                                <tr>
                        <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#</th>
                        <th  style="text-align: center;color:black;background-color: #ddd">ประเภทสิทธิ</th>
                        <th  style="text-align: center;color:black;background-color: #ddd">เบิกได้ตามสิทธิการรักษา</th>
                        <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
                        <th  style="text-align: center;color:black;background-color: #ddd">Actios</th>
                    </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['medical_right_group'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['cr_price'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['cr_effectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
                    <a class="btn btn-info btn-xs" onclick="UpdateCredititem(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="DeleteCredititem(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['medical_right_group'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['cr_price'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['cr_effectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
                    <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Edit</a>
                    <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->medical_right_group_id . '"> Delete</a>
                    </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    private function updateCreditPrice($itemid) {
        $medical = TbCreditItem::find()->where(['ItemID' => $itemid, 'cr_status' => 2])->all();
        if (!empty($medical)) {
            foreach ($medical as $data) {
                $medicalid[] = $data['medical_right_group_id']; #query หา medical_right_group_id ที่บันทึกแล้ว แล้วเก็บ id ไว้ใน []
            }
            $querynotsave = Tbmedicalrightgroup::find()
                    ->where(['NOT IN', 'medical_right_group_id', $medicalid]) #query หา medical_right_group_id ที่ยังไม่ได้บันทึก
                    //->andWhere('cr_status = :prtypeid', [':prtypeid' => 2])
                    ->all();
            if (!empty($querynotsave)) { #ถ้า Query เจอ
                foreach ($querynotsave as $data) {
                    $medicalkeys[] = $data['medical_right_group_id']; #loop เอา id ที่ยังไม่ได้บันทึก
                }
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                foreach ($medicalkeys as $value) { #insert ลง tabel
                    if ($value == 9) {
                        $status = 3;
                    } else {
                        $status = 2;
                    }
                    $sql = "
                            REPLACE INTO tb_credit_item
                                SET
                                    ItemID= '$itemid',
                                    medical_right_group_id= $value,
                                    cr_status = '$status',
                                    cr_effectiveDate = NOW(),
                                    CreatedBy = $CreatedBy     
                                ";
                    $query = Yii::$app->db->createCommand($sql)->execute();
                }
            }
        } else {
            $CreatedBy = Yii::$app->user->identity->profile->user_id;
            $findallmedical = Tbmedicalrightgroup::find()->all();
            foreach ($findallmedical as $data) {
                $medicalkeys[] = $data['medical_right_group_id']; #loop เอา id ที่ยังไม่ได้บันทึก
            }
            #insert
            foreach ($medicalkeys as $value) { #insert ลง tabel
                if ($value == 9) {
                    $status = 3;
                } else {
                    $status = 2;
                }
                $sql = "
                            REPLACE INTO tb_credit_item
                                SET
                                    ItemID= '$itemid',
                                    medical_right_group_id= $value,
                                    cr_status = '$status',
                                    cr_effectiveDate = NOW(),
                                    CreatedBy = $CreatedBy     
                                ";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }

    public function actionEditCredit() {
        $itemid = $_GET['id'];
        $this->updateCreditPrice($itemid);
        $sourceModel = new TbCreditItemSearch();
        $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams(), $itemid);
        $models = $dataProvider->getModels();
        $model1 = Vwitempricelistscl::findOne(['ItemID' => $itemid]);
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $Itemprice = str_replace(',', '', $_POST['Vwitempricelistscl']['ItemPrice']);
            $sql = ""
                    . "UPDATE tb_itemid_price
                        SET 
                            ItemPrice='$Itemprice'
                        WHERE tb_itemid_price.ItemID= '$itemid'
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $count = 0;
            foreach ($models as $index => $model) {
                $model->cr_status = 2;
                $model->CreatedBy = 2;
                $model->cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($model->cr_effectiveDate);
                $model->cr_price = str_replace(',', '', $model->cr_price);
                // populate and save records for each model
                if ($model->save()) {
                    $count++;
                }
            }
            //Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            //return $this->refresh();
            return 'success';
        } else {
            return $this->renderAjax('_pricelists', [
                        'model' => $sourceModel,
                        'dataProvider' => $dataProvider,
                        'model1' => $model1,
                        'itemid' => $itemid,
            ]);
        }
    }

    public function actionAddcreditPrice() {
        $id = $_POST['id'];
        $itemid = $_POST['itemid'];
        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        $check = TbCreditItem::findOne(['ItemID' => $itemid, 'medical_right_group_id' => $id]);
        if (!empty($check)) {
            $sql = "
            UPDATE tb_credit_item
                SET
                    cr_status= 2
            WHERE ItemID = '$itemid' AND medical_right_group_id = $id;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            return 'duplicate';
        } else {
            $sql = "
            REPLACE INTO tb_credit_item
                SET
                    ItemID= '$itemid',
                    medical_right_group_id= '$id',
                    cr_status= 2,
                    cr_effectiveDate=NOW(),
                    CreatedBy= '$CreatedBy'
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            return 'success';
        }
    }

    public function actionUnCredit() {
        $id = $_POST['id'];
        $itemid = $_POST['itemid'];
        $sql = "
            UPDATE tb_credit_item
                SET
                    cr_status= 3
            WHERE ItemID = '$itemid' AND medical_right_group_id = $id;
                    ";
        $query = Yii::$app->db->createCommand($sql)->execute();
        return 'success';
    }

    public function actionDeletecreditOnselect() {
        $key = $_POST['id'];
        $i = 0;
        foreach ($key[$i] as $data) {
            $sql = "
                DELETE FROM tb_credit_item 
                WHERE tb_credit_item.ids = ($data);
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $i++;
        }
    }

    public function actionAddcreditPriceItem() {
        $itemid = $_GET['id'];
        $this->updateCreditPrice($itemid);
        $sourceModel = new TbCreditItemSearch();
        $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams(), $itemid);
        $models = $dataProvider->getModels();
        $model1 = Vwitempricelistscl::findOne(['ItemID' => $itemid]);
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $Itemprice = str_replace(',', '', $_POST['Vwitempricelistscl']['ItemPrice']);
            $sql = ""
                    . "UPDATE tb_itemid_price
                        SET 
                            ItemPrice='$Itemprice'
                        WHERE tb_itemid_price.ItemID= '$itemid'
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $count = 0;
            foreach ($models as $index => $model) {
                $model->cr_status = 2;
                $model->CreatedBy = 2;
                $model->cr_effectiveDate = Yii::$app->dateconvert->convertThaiToMysqlDate2($model->cr_effectiveDate);
                $model->cr_price = str_replace(',', '', $model->cr_price);
                if ($model->save()) {
                    $count++;
                }
            }
            return 'success';
        } else {
            return $this->renderAjax('_form_credit_price_item', [
                        'model' => $sourceModel,
                        'dataProvider' => $dataProvider,
                        'model1' => $model1,
                        'itemid' => $itemid,
            ]);
        }
    }
    
    public function actionSaveimage() {
        $data = $_POST['im'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data); // Decode image using base64_decode
        $file = 'uploads/' . uniqid() . '.png'; //Now you can put this image data to your desired file using file_put_contents function like below:
        $success = file_put_contents($file, $data);
        $model = TbItem::findOne(\Yii::$app->request->post('ItemID'));
        if(\Yii::$app->request->post('Type') == 1){
            $model->ItemPic1 = $file;
        }elseif (\Yii::$app->request->post('Type') == 2) {
            $model->ItemPic2 = $file;
        }elseif (\Yii::$app->request->post('Type') == 3) {
            $model->ItemPic3 = $file;
        }elseif (\Yii::$app->request->post('Type') == 4) {
            $model->ItemPic4 = $file;
        }
        $model->save();
        echo $file;
    }
    
    public function actionDeleteimage() {
        $file = Yii::$app->request->post('imgsrc');
        $path = str_replace('/km4/', '', $file);
        $model = TbItem::findOne(\Yii::$app->request->post('ItemID'));
        if(\Yii::$app->request->post('Type') == 1){
            $model->ItemPic1 = null;
        }elseif (\Yii::$app->request->post('Type') == 2) {
            $model->ItemPic2 = null;
        }elseif (\Yii::$app->request->post('Type') == 3) {
            $model->ItemPic3 = null;
        }elseif (\Yii::$app->request->post('Type') == 4) {
            $model->ItemPic4 = null;
        }
        $model->save();
        if (!unlink($path)) {
            return true;
        } else {
            return false;
        }
    }

}
