<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use app\modules\Purchasing\models\TbPr2Temp;
use app\modules\Purchasing\models\TbPr2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * NewPrGpuController implements the CRUD actions for TbPr2Temp model.
 */
class NewPrGpuController extends Controller {

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
     * Lists all TbPr2Temp models.
     * @return mixed
     */
    public function actionIndex() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $searchModel = new TbPr2TempSearch();
        $dataProvider = $searchModel->SearchNewPR(Yii::$app->request->queryParams);
        $find = \app\modules\Purchasing\models\TbPr2Temp::find()->where(['PRNum' => ""])->all();

        if ($find != null) {
            foreach ($find as $data) {
                $PRID[] = $data['PRID'];
            }
            foreach ($PRID as $key) {
                $sql = "DELETE FROM tb_pr2_temp WHERE PRID = $key AND PRCreatedBy = $userid";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbPr2Temp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbPr2Temp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ids_PR_selected, $PRID, $view) {
        if ($PRID == null) {
            $model = \app\modules\Purchasing\models\TbPr2Temp::findOne(['ids_PR_selected' => $ids_PR_selected]);
            $PRID = $model['PRID'];
            $modelPR = $this->findModel($PRID);
            $section = \yii\helpers\ArrayHelper::map($this->getDepartment($model->DepartmentID), 'id', 'name');
        } else {
            $modelPR = $this->findModel($PRID);
            $section = \yii\helpers\ArrayHelper::map($this->getDepartment($modelPR->DepartmentID), 'id', 'name');
        }
        $searchModel = new \app\modules\Purchasing\models\Tbpritemdetail2tempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $PRID);

        if ($modelPR->load(Yii::$app->request->post())) {
            $PRID = $_POST['TbPr2Temp']['PRID'];
            $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPr2Temp']['PRDate']);
            $PRTypeID = 6;
            $PRStatusID = 1;
            $DepartmentID = $_POST['TbPr2Temp']['DepartmentID'];
            $SectionID = $_POST['TbPr2Temp']['SectionID'];
            $POTypeID = $_POST['TbPr2Temp']['POTypeID'];
            $PRReasonNote = $_POST['TbPr2Temp']['PRReasonNote'];
            $PRExpectDate = $_POST['TbPr2Temp']['PRExpectDate'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRbudgetID = $_POST['TbPr2Temp']['PRbudgetID'];
            $data = Yii::$app->db->createCommand('CALL cmd_pr2_savedraft(:PRDate,:PRTypeID,:PRStatusID,:DepartmentID,:SectionID,:POTypeID,:PRID,:PRReasonNote,:PRExpectDate,:PRCreatedBy,:PRbudgetID);')
                    ->bindParam(':PRDate', $PRDate)
                    ->bindParam(':PRTypeID', $PRTypeID)
                    ->bindParam(':PRStatusID', $PRStatusID)
                    ->bindParam(':DepartmentID', $DepartmentID)
                    ->bindParam(':SectionID', $SectionID)
                    ->bindParam(':POTypeID', $POTypeID)
                    ->bindParam(':PRID', $PRID)
                    ->bindParam(':PRReasonNote', $PRReasonNote)
                    ->bindParam(':PRExpectDate', $PRExpectDate)
                    ->bindParam(':PRCreatedBy', $PRCreatedBy)
                    ->bindParam(':PRbudgetID', $PRbudgetID)
                    ->execute();
            $modelPR = $this->findModel($PRID);
            echo $modelPR['PRNum'];
//echo 1;
//            Yii::$app->getSession()->setFlash('alert1', [
//                ]);
//            $this->refresh();
//            $modelPR->PRDate = date('Y-m-d');
//            $modelPR->PRExpectDate = date('Y-m-d');
//            if ($modelPR->save()) {
//                echo 1;
//            }
//return $this->redirect(['view', 'id' => $model->PRID]);
        } else {
            $Reason = \app\modules\Purchasing\models\TbPrReasonselected::find()->where(['PRID' => $modelPR['PRID']])->all();
            if ($Reason == null) {
                $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['PRTypeID' => 1])->all();
                $htl_checkbox = '<div>';
                $no = 1;
                $null = ' ';
                foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                    $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                    $htl_checkbox .= '' . $no . '.' . $null . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
                    $no++;
                }
                $htl_checkbox .= '</div>';
            } else {
                foreach ($Reason as $data) {
                    $ids[] = $data['PRreasonID'];
                }
                $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['ids' => $ids])->all();
                $htl_checkbox = '<div>';
                $no = 1;
                $null = ' ';
                foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                    $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" checked="checked" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                    $htl_checkbox .= '' . $no . '.' . $null . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
                    $no++;
                }
                $htl_checkbox .= '</div>';
            }
            return $this->render('create', [
                        'modelPR' => $modelPR,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'section' => $section,
                        'view' => $view,
                        'htl_checkbox' => $htl_checkbox,
            ]);
        }
    }

    /**
     * Updates an existing TbPr2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PRID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbPr2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }
//    
    public function actionDeletePr($id) {
        $delete = TbPr2Temp::findOne($id);
        $delete->delete();
        $sql = "DELETE FROM tb_pritemdetail2_temp WHERE PRID = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode('Delete complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/new-pr-gpu/index');
    }

    public function actionCreatePridtemp() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $PRTypeID = 6;
        $DepartmentID = '1';
        $SectionID = '1';
        $POTypeID = '';
        $max = \app\modules\Purchasing\models\TbPr2::find()
                ->select('max(PRID)')
                ->scalar();
        $maxTemp = \app\modules\Purchasing\models\TbPr2Temp::find()
                ->select('max(PRID)')
                ->scalar();
        if ($max > $maxTemp) {
            $max = $max + 1;
        } elseif ($max < $maxTemp) {
            $max = $maxTemp + 1;
        }

        Yii::$app->db->createCommand('CALL cmd_pr2_create_PR(:x,:PRID,:PRTypeID,:DepartmentID,:SectionID,:POTypeID);')
                ->bindParam(':x', $userid)
                ->bindParam(':PRID', $max)
                ->bindParam(':PRTypeID', $PRTypeID)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':POTypeID', $POTypeID)
                ->execute();
        $model = $this->findModel($max);
        return $this->redirect(['create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => '']);
    }

    public function actionGetDepartment() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DepartmentID = $parents[0];
                $out = $this->getDepartment($DepartmentID);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDepartment($id) {
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

    function actionGetdatagpu() {
        $Productmodel = \app\models\VwGpuList::find()->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatagputable">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="50%" style="text-align: center;">รหัสยาสามัญ</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดยาสามัญ</th>
                                    <th width="100%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->TMTID_GPU . ');" > select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionNewDetailgpu() {
        $modeledit = new \app\modules\Purchasing\models\VwPritemdetail2Temp();
        if ($modeledit->load(Yii::$app->request->post())) {
            $modeleditpack = \app\models\TbItempack::find()->where(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'],'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']])->one();
            $cmd = $_POST['cmd'];
            $PCPlanNum1 = "";
            $ItemID = "";
            $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
            $TMTID_TPU = "";
            $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
            $PRItemStdCost = '';
            $PRItemUnitCost = "";
            $PRItemOrderQty = "";
            $PRApprovedOrderQtySum = "";
            $PRItemAvalible = "";
            $PRUnitCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
            $PROrderQty = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
            $PRExtendedCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
            $PRPackQty = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
            $ItemPackID = $modeleditpack['ItemPackID'];
            $ItemPackCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
            $ids_PR_selected = $_POST['VwPritemdetail2Temp']['ids_PR_selected'];
            $PRID = $_POST['VwPritemdetail2Temp']['PRID'];
            $ids = $_POST['VwPritemdetail2Temp']['ids'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRLastUnitCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRLastUnitCost']);
            Yii::$app->db->createCommand('
                    CALL cmd_pr2_item_save(
                    :cmd,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,
                    :ItemName,:PRItemStdCost,:PRItemUnitCost,:PRItemOrderQty,
                    :PRApprovedOrderQtySum,:PRItemAvalible,:PRUnitCost,:PROrderQty,
                    :PRExtendedCost,:PRPackQty,:ItemPackID,:ItemPackCost,:ids_PR_selected,
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost
                    );')
                    ->bindParam(':cmd', $cmd)
                    ->bindParam(':PCPlanNum', $PCPlanNum1)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':PRItemStdCost', $PRItemStdCost)
                    ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                    ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                    ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                    ->bindParam(':PRItemAvalible', $PRItemAvalible)
                    ->bindParam(':PRUnitCost', $PRUnitCost)
                    ->bindParam(':PROrderQty', $PROrderQty)
                    ->bindParam(':PRExtendedCost', $PRExtendedCost)
                    ->bindParam(':PRPackQty', $PRPackQty)
                    ->bindParam(':ItemPackID', $ItemPackID)
                    ->bindParam(':ItemPackCost', $ItemPackCost)
                    ->bindParam(':ids_PR_selected', $ids_PR_selected)
                    ->bindParam(':PRID', $PRID)
                    ->bindParam(':ids', $ids)
                    ->bindParam(':PRCreatedBy', $PRCreatedBy)
                    ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                    ->execute();
            echo '1';
//            if($modeledit->save()){
//                echo '1';
//            }  else {
//                echo '0';    
//            }
//return $this->redirect(['view', 'id' => $model->PRID]);
        } else {
            $check = \app\modules\Purchasing\models\Tbpritemdetail2temp::findAll(['TMTID_GPU' => $_POST['id'], 'PRID' => $_POST['PRID']]);
            $checkitem = \app\models\VwItemListGpu::findAll(['TMTID_GPU' => $_POST['id']]);
            if ($check != null) {
                return 'false';
            }
            else if ($checkitem != null) {
                return 'itemalready';
            }else{
//get FSN_GPU on TbGenericproductuseGpu
                $Item = \app\models\VwGpuList::findOne(['TMTID_GPU' => $_POST['id']]);
                $modeledit['ItemName'] = $Item['FSN_GPU'];

//check Plan on VwGpuplanDetailAvalible
//                $datagpu = \app\modules\Inventory\models\VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $_POST['id']]);
//                if ($datagpu == null) {
//                    $PCPlanNum = '';
//                } else {
//                    foreach ($datagpu as $data) {
//                        $PCPlanNum[] = $data['PCPlanNum'];
//                    }
//                }
//checkpack on tb_itempack
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $_POST['id']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '<font color="red">*** รายการนี้ยังไม่ได้บันทึกขนาดแพค ***</font>';
                }
//                $itempack = \app\models\TbPackunit::find()->all();
//                foreach ($itempack as $data) {
//                    $pack[] = $data['PackUnitID'];
//                }
                return $this->renderAjax('_update_detailgpu', [
                            'modeledit' => $modeledit,
                            //'PCPlanNum' => $PCPlanNum,
                            'pack' => $pack,
                            'ItemName' => $modeledit['ItemName'],
                            'ItemPackSKUQty' => '',
                            'btn' => $btn,
                            'DispUnit' => $Item['DispUnit'],
                ]);
            }
        }
    }

    public function actionViewDetailgpu() {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\modules\Purchasing\models\Tbpritemdetail2temp::findOne($_POST['expandRowKey']);
            $packunit = \app\models\TbItempack::findOne(['TMTID_GPU' => $model['TMTID_GPU'], 'ItemPackID' => $model['ItemPackID']]);
            $pack = \app\models\TbPackunit::findOne($packunit['ItemPackUnit']);
            return $this->renderPartial('view_detail_gpu', ['model' => $model, 'packunit' => $packunit, 'pack' => $pack]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionUpdateDetailgpu($id) {
        $modeledit = \app\modules\Purchasing\models\VwPritemdetail2Temp::findOne(['ids' => $id]);
        if ($modeledit->load(Yii::$app->request->post())) {
            $modeleditpack = \app\models\TbItempack::find()->where(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'],'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']])->one();
            $cmd = $_POST['cmd'];
            $PCPlanNum1 = "";
            $ItemID = '';
            $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
            $TMTID_TPU = '';
            $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
            $PRItemStdCost = '';
            $PRItemUnitCost = "";
            $PRItemOrderQty = "";
            $PRApprovedOrderQtySum = "";
            $PRItemAvalible = "";
            $PRUnitCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
            $PROrderQty = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
            $PRExtendedCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
            $PRPackQty = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
            $ItemPackID = $modeleditpack['ItemPackID'];
            $ItemPackCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
            $ids_PR_selected = $_POST['VwPritemdetail2Temp']['ids_PR_selected'];
            $PRID = $_POST['VwPritemdetail2Temp']['PRID'];
            $ids = $_POST['VwPritemdetail2Temp']['ids'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRLastUnitCost = str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRLastUnitCost']);
            Yii::$app->db->createCommand('
                    CALL cmd_pr2_item_save(
                    :cmd,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,
                    :ItemName,:PRItemStdCost,:PRItemUnitCost,:PRItemOrderQty,
                    :PRApprovedOrderQtySum,:PRItemAvalible,:PRUnitCost,:PROrderQty,
                    :PRExtendedCost,:PRPackQty,:ItemPackID,:ItemPackCost,:ids_PR_selected,
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost
                    );')
                    ->bindParam(':cmd', $cmd)
                    ->bindParam(':PCPlanNum', $PCPlanNum1)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':TMTID_GPU', $TMTID_GPU)
                    ->bindParam(':TMTID_TPU', $TMTID_TPU)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':PRItemStdCost', $PRItemStdCost)
                    ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                    ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                    ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                    ->bindParam(':PRItemAvalible', $PRItemAvalible)
                    ->bindParam(':PRUnitCost', $PRUnitCost)
                    ->bindParam(':PROrderQty', $PROrderQty)
                    ->bindParam(':PRExtendedCost', $PRExtendedCost)
                    ->bindParam(':PRPackQty', $PRPackQty)
                    ->bindParam(':ItemPackID', $ItemPackID)
                    ->bindParam(':ItemPackCost', $ItemPackCost)
                    ->bindParam(':ids_PR_selected', $ids_PR_selected)
                    ->bindParam(':PRID', $PRID)
                    ->bindParam(':ids', $ids)
                    ->bindParam(':PRCreatedBy', $PRCreatedBy)
                    ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                    ->execute();
            echo '1';
//            if($modeledit->save()){
//                echo '1';
//            }  else {
//                echo '0';    
//            }
//return $this->redirect(['view', 'id' => $model->PRID]);
        } else {
            $itemdisp = \app\models\VwGpuList::findOne(['TMTID_GPU'=> $modeledit['TMTID_GPU']]);
            $datagpu = \app\modules\Inventory\models\VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
            $itempack = \app\modules\Inventory\models\VwItempackGpu::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
           $qty = \app\modules\Inventory\models\VwItempackGpu::findOne([
                        //'TMTID_GPU' => $modeledit['TMTID_GPU'],
                        'ItemPackID' => $modeledit['ItemPackID']
            ]);
            if ($qty != null) {
                $DispUnit = $qty['DispUnit'];
            } else {
                $DispUnit = '';
            }
//GetPCPlan
            if ($datagpu == null) {
                $PCPlanNum = '';
            } else {
                foreach ($datagpu as $data) {
                    $PCPlanNum[] = $data['PCPlanNum'];
                }
            }
//GetPack
            if ($itempack == null) {
                $itempack = \app\models\TbPackunit::find()->all();
                foreach ($itempack as $data) {
                    $pack[] = $data['PackUnitID'];
                }
            } else {
                foreach ($itempack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            }

            return $this->renderAjax('_update_detailgpu', [
                        'modeledit' => $modeledit,
                        'PCPlanNum' => $PCPlanNum,
                        'pack' => $pack,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'ItemName' => $modeledit['ItemName'],
                        'btn' => '',
                        'DispUnit' => $itemdisp['DispUnit']
            ]);
        }
    }

    public function actionDeleteDetailgpu() {
        $delete = \app\modules\Purchasing\models\Tbpritemdetail2temp::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionSaveReason() {
        $PRID = $_POST['PRID'];
        $PRreasonIDStatus = '1';
        $find = \app\modules\Purchasing\models\TbPrReasonselected::findOne(['PRID' => $PRID]);
        if ($find != null) {
            $sql = "DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        if (isset($_POST['reasonid'])) {
            foreach ($_POST['reasonid'] as $data) {
                $reasonid = $data;
                Yii::$app->db->createCommand('CALL cmd_pr2_prreason_save(:PRID,:PRreasonID,:PRreasonIDStatus);')
                        ->bindParam(':PRID', $PRID)
                        ->bindParam(':PRreasonID', $reasonid)
                        ->bindParam(':PRreasonIDStatus', $PRreasonIDStatus)
                        ->execute();
            }
        }
    }

    public function actionClearGpu() {
        $PRID = $_POST['PRID'];
        $sql = "
                DELETE FROM tb_pr2_temp WHERE PRID = $PRID;
                DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/new-pr-gpu/index');
    }

    public function actionSendtoverify() {
        $PRID = $_POST['PRID'];
        $PRNum = $_POST['PRNum'];
        Yii::$app->db->createCommand('CALL cmd_pr2_send_to_verify(:x);')
                ->bindParam(':x', $PRID)->execute();
        $sql = "
                 DELETE FROM tb_pr2_temp WHERE tb_pr2_temp.PRID=$PRID;
                 DELETE FROM tb_pritemdetail2_temp WHERE tb_pritemdetail2_temp.PRID=$PRID;
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
        return $this->redirect('index.php?r=Purchasing/new-pr-gpu/index');
    }

    public function actionGetQtygpu() {
        $qty = \app\models\TbItempack::findOne([
                    'TMTID_GPU' => $_POST['TMTID_GPU'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
            'qty' => number_format($_POST['qty'], 2),
        );
        return json_encode($arr);
    }

    public function actionGetdataPcplangpu() {
        $finddata = \app\modules\Inventory\models\VwGpuplanDetailAvalible::findOne([
                    'TMTID_GPU' => $_POST['TMTID_GPU'],
                    'PCPlanNum' => $_POST['PCPlanNum']
        ]);
        $arr = array(
            'FSN_GPU' => $finddata['FSN_GPU'],
            'GPUStdCost' => number_format($finddata['GPUStdCost'], 2),
            'GPUUnitCost' => number_format($finddata['GPUUnitCost'], 2),
            'GPUOrderQty' => number_format($finddata['GPUOrderQty'], 2),
            'PRApprovedOrderQty' => number_format($finddata['PRApprovedOrderQty'], 2),
            'PRGPUAvalible' => number_format($finddata['PRGPUAvalible'], 2),
        );
        return json_encode($arr);
    }

    public function actionGetReasongpu() {
        $Reason = \app\modules\Purchasing\models\TbPrReason::find()->where(['PRTypeID' => $_POST['PRType']])->all();
        if ($Reason != null) {
            foreach ($Reason as $data) {
                $PRTypeID[] = $data['PRTypeID'];
            }
            $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['PRTypeID' => $PRTypeID])->all();
            $htl = '<div>';
            $no = 1;
            $null = ' ';
            foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                $htl .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl .= '' . $no . '.' . $null . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
                $no++;
//$htl .= '</label>';
            }
            $htl .= '</div>';
            $arr = array(
                'htl' => $htl,
            );
            return json_encode($arr);
        } else {
            $arr = array(
                'htl' => '',
            );
            return json_encode($arr);
        }
    }

    public function actionDetailVerify() {
        $searchModel = new \app\modules\Purchasing\models\TbPr2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $x = '11.25';
//        echo $x . "=>" . Yii::$app->componentdate->convert($x);

        return $this->render('detail-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateDetailVerify($id, $view) {
        $modelPR2 = \app\modules\Purchasing\models\TbPr2::findOne($id);
        $section = \yii\helpers\ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
        $searchModel = new \app\modules\Purchasing\models\TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $Reason = \app\modules\Purchasing\models\TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();
        if ($Reason == null) {
            $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['PRTypeID' => 1])->all();
            $htl_checkbox = '<div>';
            foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
            }
            $htl_checkbox .= '</div>';
        } else {
            foreach ($Reason as $data) {
                $ids[] = $data['PRreasonID'];
            }
            $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            $no = 1;
            $null = ' ';
            foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                $htl_checkbox .= '<div class="checkbox">';
//$htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" checked="checked" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '' . $no . '.' . $null . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
                $no++;
            }
            $htl_checkbox .= '</div>';
        }
        return $this->render('_form_detail_verify', [
                    'modelPR2' => $modelPR2,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'section' => $section,
                    'htl_checkbox' => $htl_checkbox,
                    'view' => $view
        ]);
    }

    public function actionViewDetailVerify($view) {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\modules\Purchasing\models\TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = \app\models\TbItempack::findOne(['TMTID_GPU' => $model['TMTID_GPU'], 'ItemPackUnit' => $model['ItemPackID']]);
            $pack = \app\models\TbPackunit::findOne($packunit['ItemPackUnit']);
            return $this->renderPartial('view_detail_verify', ['model' => $model, 'packunit' => $packunit, 'pack' => $pack['PackUnit'], 'view' => $view]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionUpdateVerify($id) {
        $modeledit = \app\modules\Purchasing\models\VwPritemdetail2::findOne(['ids' => $id]);
        $modelverify = \app\modules\Purchasing\models\TbPritemdetail2::findOne(['ids' => $id]);
        if (Yii::$app->request->post()) {
            if ($_POST['ItemPackSKUQty'] == "0.00") {
                $modelverify->PRPackQtyVerify = str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                //$modelverify->ItemPackIDVerify = $_POST['VwPritemdetail2']['ItemPackID'];
                $modelverify->ItemPackCostVerify = str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $modelverify->PRVerifyQty = str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $modelverify->PRVerifyUnitCost = str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $modelverify->save();
                echo 1;
            } else {
                $modelverify->PRPackQtyVerify = str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                $modelverify->ItemPackIDVerify = $_POST['VwPritemdetail2']['ItemPackID'];
                $modelverify->ItemPackCostVerify = str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $modelverify->PRVerifyQty = str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $modelverify->PRVerifyUnitCost = str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $modelverify->save();
                echo 1;
            }
//                   
        } else {
            if ($modelverify->PRPackQtyVerify != null) {
                $qty = \app\modules\Inventory\models\VwItempackGpu::findOne([
                            'TMTID_GPU' => $modelverify['TMTID_GPU'],
                            'ItemPackUnit' => $modelverify['ItemPackIDVerify']
                ]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                return $this->renderAjax('_form_update_verify', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                            'PRPackQty' => $modelverify['PRPackQtyVerify'],
                            'ItemPackCost' => $modelverify['ItemPackCostVerify'],
                            'PROrderQty' => $modelverify['PRVerifyQty'],
                            'PRUnitCost' => $modelverify['PRVerifyUnitCost'],
                            'ItemPackID' => $modelverify['ItemPackIDVerify']
                ]);
            } else {
                $qty = \app\modules\Inventory\models\VwItempackGpu::findOne([
                            'TMTID_GPU' => $modeledit['TMTID_GPU'],
                            'ItemPackUnit' => $modeledit['ItemPackID']
                ]);
                $checkpack = \app\models\TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                }
                return $this->renderAjax('_form_update_verify', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                            'PRPackQty' => $modeledit['PRPackQty'],
                            'ItemPackCost' => $modeledit['ItemPackCost'],
                            'PROrderQty' => $modeledit['PROrderQty'],
                            'PRUnitCost' => $modeledit['PRUnitCost'],
                            'ItemPackID' => $modelverify['ItemPackID']
                ]);
            }
        }
    }

    public function actionDeleteDetailVerify() {
        $delete = \app\modules\Purchasing\models\TbPritemdetail2::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionOkVerify() {
        Yii::$app->db->createCommand('CALL cmd_pr2_itemdetail_verify(:x);')
                ->bindParam(':x', $_POST['id'])->execute();
    }

    public function actionRejectedVerify() {
        Yii::$app->db->createCommand('CALL cmd_pr2_rejected_verify(:x,:PRRejectReason);')
                ->bindParam(':x', $_POST['PRID'])
                ->bindParam(':PRRejectReason', $_POST['PRRejectReason'])
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode('Rejected' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('detail-verify');
    }

    public function actionSavedraftVerify() {
        $PRID = $_POST['PRID'];
        Yii::$app->db->createCommand('CALL cmd_pr2_verify_savedraft(:x);')
                ->bindParam(':x', $PRID)
                ->execute();
//        $find = \app\modules\Purchasing\models\TbPrReasonselected::findAll(['PRID' => $PRID]);
//        if ($find != null) {
//            $sql = "DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID";
//            $query = Yii::$app->db->createCommand($sql)->execute();
//        }
    }

    public function actionSendToApprove() {

        Yii::$app->db->createCommand('CALL cmd_pr2_send_to_approve(:x);')
                ->bindParam(':x', $_POST['PRID'])
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode('Send' . ' ' . $_POST['PRNum'] . ' ' . 'To Approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('detail-verify');
    }

    public function actionDetailApprove() {
        $searchModel = new \app\modules\Purchasing\models\TbPr2Search();
        $dataProvider = $searchModel->searchapprove(Yii::$app->request->queryParams);
//        $x = '11.25';
//        echo $x . "=>" . Yii::$app->componentdate->convert($x);

        return $this->render('detail-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateDetailApprove($id, $view) {
        $modelPR2 = \app\modules\Purchasing\models\TbPr2::findOne($id);
        $section = \yii\helpers\ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
        $searchModel = new \app\modules\Purchasing\models\TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $Reason = \app\modules\Purchasing\models\TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();
        if ($Reason == null) {
            $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['PRTypeID' => 1])->all();
            $htl_checkbox = '<div>';
            foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
            }
            $htl_checkbox .= '</div>';
        } else {
            foreach ($Reason as $data) {
                $ids[] = $data['PRreasonID'];
            }
            $modelcheck = \app\modules\Purchasing\models\TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            $no = 1;
            $null = ' ';
            foreach ($modelcheck as $rm) {
//$htl .= '<label>';
                $htl_checkbox .= '<div class="checkbox">';
//$htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" checked="checked" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '' . $no . '.' . $null . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
//$htl .= '</label>';
                $no++;
            }
            $htl_checkbox .= '</div>';
        }
        $prdetail = \app\modules\Purchasing\models\TbPritemdetail2::findAll(['PRID' => $id]);
        $cost = '0';
        foreach ($prdetail as $result) {
            $cost = ($result['PRVerifyUnitCost'] * $result['PRVerifyQty']) + $cost;
        }
        return $this->render('_form_detail_approve', [
                    'modelPR2' => $modelPR2,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'section' => $section,
                    'htl_checkbox' => $htl_checkbox,
                    'cost' => $cost,
                    'view' => $view,
        ]);
    }

    public function actionViewDetailApprove($view) {
        if (isset($_POST['expandRowKey'])) {
            $model = \app\modules\Purchasing\models\TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = \app\models\TbItempack::findOne(['TMTID_GPU' => $model['TMTID_GPU'], 'ItemPackUnit' => $model['ItemPackID']]);
            $pack = \app\models\TbPackunit::findOne($packunit['ItemPackUnit']);
            return $this->renderPartial('view_detail_approve', ['model' => $model, 'packunit' => $packunit, 'pack' => $pack['PackUnit'], 'view' => $view]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionRejectedApprove() {
        Yii::$app->db->createCommand('CALL cmd_pr2_rejected_approve(:x,:PRRejectReason);')
                ->bindParam(':x', $_POST['PRID'])
                ->bindParam(':PRRejectReason', $_POST['PRRejectReason'])
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode('Rejected' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('detail-approve');
    }

    public function actionSaveApprove() {
        $PRApprovalID = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_pr2_approve(:x,:PRTotal,:PRApprovalID);')
                ->bindParam(':x', $_POST['PRID'])
                ->bindParam(':PRTotal', $_POST['PRTotal'])
                ->bindParam(':PRApprovalID', $PRApprovalID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode('Approve' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('detail-approve');
    }

    /**
     * Finds the TbPr2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbPr2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbPr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
