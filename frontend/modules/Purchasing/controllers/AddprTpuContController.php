<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
#models
use app\modules\Purchasing\models\TbPr2Temp;
use app\modules\Purchasing\models\Tbpritemdetail2tempSearch;
use app\modules\Purchasing\models\TbPrReasonselected;
use app\modules\Purchasing\models\TbPrReason;
use app\models\TbSection;
use app\modules\Purchasing\models\VwPritemdetail2Temp;
use app\models\TbItempack;
use app\models\TbPackunit;
use app\modules\Purchasing\models\VwPo2SubPohistory;
use app\models\TbPcplan;
use app\modules\Purchasing\models\VwItemListTpuplanAvalible;
use app\modules\Inventory\models\VwTpuplanDetailAvalible;
use app\modules\Inventory\models\VwItempackGpu;
use app\models\TbMastertmt;
use app\modules\Purchasing\models\Tbpritemdetail2temp;
use app\models\VwItemListTpu;
use app\modules\Purchasing\models\TbPr2;
use app\modules\Purchasing\models\TbPritemdetail2Search;
use app\modules\Purchasing\models\TbPritemdetail2;
use app\modules\Inventory\models\VwItempack;
use app\modules\Purchasing\models\VwPritemdetail2;
use app\models\Profile;
use app\modules\Purchasing\models\VwStkStatusSearch;
use app\modules\Purchasing\models\VwQuPricelistSearch;
use app\modules\Purchasing\models\VwPurchasingHistorySearch;
use app\modules\Purchasing\models\VwGpustdCost;

class AddprTpuContController extends Controller {

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

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => TbPr2Temp::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($ids_PR_selected, $PRID, $view) {
        if (empty($PRID)) {
            $model = TbPr2Temp::findOne(['ids_PR_selected' => $ids_PR_selected]);
            $PRID = $model['PRID'];
            $modelPR = $this->findModel($PRID);
            $section = ArrayHelper::map($this->getDepartment($model->DepartmentID), 'id', 'name');
        } else {
            $modelPR = $this->findModel($PRID);
            $section = ArrayHelper::map($this->getDepartment($modelPR->DepartmentID), 'id', 'name');
        }

        if ($modelPR->load(Yii::$app->request->post())) {
            $PRNum = empty($_POST['TbPr2Temp']['PRNum']) ? null : $_POST['TbPr2Temp']['PRNum'];
            $PRID = $_POST['TbPr2Temp']['PRID'];
            $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPr2Temp']['PRDate']);
            $PRTypeID = 4;
            $PRStatusID = 1;
            $DepartmentID = empty($_POST['TbPr2Temp']['DepartmentID']) ? null : $_POST['TbPr2Temp']['DepartmentID'];
            $SectionID = empty($_POST['TbPr2Temp']['SectionID']) ? null : $_POST['TbPr2Temp']['SectionID'];
            $POTypeID = empty($_POST['TbPr2Temp']['POTypeID']) ? null : $_POST['TbPr2Temp']['POTypeID'];
            $PRReasonNote = empty($_POST['TbPr2Temp']['PRReasonNote']) ? null : $_POST['TbPr2Temp']['PRReasonNote'];
            $PRExpectDate = empty($_POST['TbPr2Temp']['PRExpectDate']) ? null : $_POST['TbPr2Temp']['PRExpectDate'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRbudgetID = null;
            $data = Yii::$app->db->createCommand('CALL cmd_pr2_savedraft(:PRDate,:PRNum,:PRTypeID,:PRStatusID,:DepartmentID,:SectionID,:POTypeID,:PRID,:PRReasonNote,:PRExpectDate,:PRCreatedBy,:PRbudgetID);')
                    ->bindParam(':PRDate', $PRDate)
                    ->bindParam(':PRNum', $PRNum)
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
            $ContactNum = empty($_POST['TbPr2Temp']['POContactNum']) ? null : $_POST['TbPr2Temp']['POContactNum'];
            $vendorid = empty($_POST['VendorID']) ? null : $_POST['VendorID'];
            $sql = "
                    UPDATE tb_pr2_temp
                     SET 
                     POContactNum = '$ContactNum',
                     VendorID = $vendorid
                     WHERE tb_pr2_temp.PRID= $PRID
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();

            $modelPR = $this->findModel($PRID);
            echo $modelPR['PRNum'];
        } else {
            $searchModel = new Tbpritemdetail2tempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $PRID);

            $Reason = TbPrReasonselected::find()->where(['PRID' => $modelPR['PRID']])->all();
            if (empty($Reason)) {
                $ids = [];
                $modelcheck1 = TbPrReason::find()->where(['PRTypeID' => 4])->all();
            } else {
                foreach ($Reason as $data) {
                    $ids[] = $data['PRreasonID'];
                }
                $modelcheck1 = TbPrReason::find()
                        ->where(['NOT IN', 'ids', $ids])
                        ->andWhere('PRTypeID = :prtypeid', [':prtypeid' => 4])
                        ->all();
            }
            $no = 1;

            $modelcheck = TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            foreach ($modelcheck as $rm) {
                $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" checked="checked" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
            }
            $htl_checkbox .= '</div>';

            $htl_checkbox1 = '<div>';
            foreach ($modelcheck1 as $rm) {
                $htl_checkbox1 .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '"  data-toggle="checkbox-x"/>';
                $htl_checkbox1 .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
            }
            $htl_checkbox1 .= '</div>';
            return $this->render('create', [
                        'modelPR' => $modelPR,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'htl_checkbox' => $htl_checkbox,
                        'htl_checkbox1' => $htl_checkbox1,
                        'view' => $view,
                        'section' => $section,
            ]);
        }
    }

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

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = TbPr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetDepartment() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DepartmentID = $parents[0];
                $out = $this->getDepartment($DepartmentID);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDepartment($id) {
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

    public function actionViewDetailtpu() {
        if (isset($_POST['expandRowKey'])) {
            $id = $_POST['expandRowKey'];
            $model = VwPritemdetail2Temp::findOne(['ids' => $id]);
            $packunit = TbItempack::findOne(['TMTID_GPU' => $model['TMTID_GPU'], 'ItemPackUnit' => $model['ItemPackID']]);
            $pack = TbPackunit::findOne($packunit['ItemPackUnit']);

            $records = VwPo2SubPohistory::find()->where(['TMTID_TPU' => $model['TMTID_TPU']])->all();

            $searchModel = new Tbpritemdetail2tempSearch();
            $dataProvider = $searchModel->searchdetailgpu(Yii::$app->request->queryParams, $id);
            return $this->renderPartial('viewdetailtpucont', [
                        'model1' => $model,
                        'packunit' => $packunit,
                        'pack' => $pack,
                        'records' => $records,
                        'dataProvider' => $dataProvider
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    function actionGetdatatpu() {
        $queryplannum = TbPcplan::findOne(['PCPOContactID' => $_GET['id']]);
        $query = VwItemListTpuplanAvalible::find()->where(['PCPlanNum' => $queryplannum['PCPlanNum']])->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatatpuconttable">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="20px" style="text-align: center;">#</th>
                                    <th width="90px"  style="text-align: center;">รหัสยาการค้า</th>
                                    <th width="150px"  style="text-align: center;">รายละเอียดยา</th>
                                    <th width="140px" style="text-align: center;">เลขที่แผนจัดซื้อ</th>
                                    <th  style="text-align: center;">จำนวน</th>
                                    <th  style="text-align: center;">หน่วย</th>
                                    <th  style="text-align: center;">ขอซื้อแล้ว</th>
                                    <th  style="text-align: center;">ขอซื้อได้</th>
                                    <th  style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($query as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PCPlanNum'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TPUOrderQty'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PRApprovedOrderQty'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PRTPUAvalible'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectTPU(this);" data-id="' . $result->PCPlanNum . '" id="' . $result->TMTID_TPU . '"> Select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionUpdateDetailtpu($id) {
        $modeledit = VwPritemdetail2Temp::findOne(['ids' => $id]);

        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['PackChin'] == 0) {
                $PackID = NULL;
            } else {
                $findpackunit = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']]);
                $PackID = $findpackunit['ItemPackID'];
            }
            $cmd = $_POST['cmd'];
            $PCPlanNum1 = (!empty($_POST['VwPritemdetail2Temp']['PCPlanNum']) ? $_POST['VwPritemdetail2Temp']['PCPlanNum'] : '');
            $ItemID = $_POST['VwPritemdetail2Temp']['ItemID'];
            $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPritemdetail2Temp']['TMTID_TPU'];
            $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
            $PRItemStdCost = $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemStdCost']);
            $PRItemUnitCost = $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemUnitCost']);
            $PRItemOrderQty = $_POST['VwPritemdetail2Temp']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemOrderQty']);
            $PRApprovedOrderQtySum = $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum']);
            $PRItemAvalible = $_POST['VwPritemdetail2Temp']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemAvalible']);
            $PRUnitCost = $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
            $PROrderQty = $_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
            $PRExtendedCost = $_POST['VwPritemdetail2Temp']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
            $PRPackQty = $_POST['VwPritemdetail2Temp']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
            $ItemPackID = $PackID;
            $ItemPackCost = $_POST['VwPritemdetail2Temp']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
            $ids_PR_selected = $_POST['VwPritemdetail2Temp']['ids_PR_selected'] == 0 ? NULL : $_POST['VwPritemdetail2Temp']['ids_PR_selected'];
            $PRID = $_POST['VwPritemdetail2Temp']['PRID'];
            $ids = $_POST['VwPritemdetail2Temp']['ids'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRLastUnitCost = $_POST['VwPritemdetail2Temp']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRLastUnitCost']);
            if (!empty($PCPlanNum1)) {
                $checkoverall = $this->checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost);
                $checkstd = $this->checkStdcost($PRItemStdCost, $PRUnitCost); #เช็คราคากลางก่อน
                $checkunitover = $this->checkOverunicost($PRItemUnitCost, $PRUnitCost);
                $checkover = $this->checkOveravalible($PRItemAvalible, $PROrderQty);

                if ($checkoverall == 'overall' && $_POST['checkover'] == '') {
                    return 'overall';
                } else if ($checkstd == 'over' && $_POST['checkover'] == '') {
                    return 'stdover';
                } elseif ($checkunitover == 'over' && $_POST['checkover'] == '') {
                    return 'unitover';
                } elseif ($checkover == 'over' && $_POST['checkover'] == '') {
                    return 'over';
                } else {
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
                }
            } else {
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
            }
        } else {
            $datagpu = VwTpuplanDetailAvalible::findAll(['TMTID_TPU' => $modeledit['TMTID_TPU'], 'PCPlanTypeID' => '5']);
            $itempack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
            $qty = TbItempack::findOne(['ItemPackUnit' => $modeledit['ItemPackID']]);
            #GetPCPlan
            if (empty($datagpu)) {
                $PCPlanNum = '';
            } else {
                foreach ($datagpu as $data) {
                    $PCPlanNum[] = $data['PCPlanNum'];
                }
            }
            #GetPack
            if (empty($itempack)) {
                $itempack = TbPackunit::find()->all();
                foreach ($itempack as $data) {
                    $pack[] = $data['PackUnitID'];
                }
            } else {
                foreach ($itempack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            }

            return $this->renderAjax('_update-detailtpu', [
                        'modeledit' => $modeledit,
                        'PCPlanNum' => $PCPlanNum,
                        'pack' => $pack,
                        'ItemPackSKUQty' => $modeledit['ItemPackSKUQty'],
                        'ItemName' => $modeledit['ItemName'],
                        'btn' => '',
                        'DispUnit' => $modeledit['DispUnit'],
                        'TMTID_GPU' => $modeledit['TMTID_GPU'],
                        'ItemID' => $modeledit['ItemID'],
            ]);
        }
    }

    public function actionGetdataPcplantpu() {
        $finddata = VwTpuplanDetailAvalible::findOne([
                    'TMTID_TPU' => $_POST['TMTID_TPU'],
                    'PCPlanNum' => $_POST['PCPlanNum'],
        ]);
        $arr = array(
            'ItemName' => $finddata['ItemName'],
            'GPUStdCost' => number_format($finddata['GPUStdCost'], 4),
            'TPUUnitCost' => number_format($finddata['TPUUnitCost'], 4),
            'TPUOrderQty' => number_format($finddata['TPUOrderQty'], 4),
            'PRApprovedOrderQty' => number_format($finddata['PRApprovedOrderQty'], 4),
            'PRTPUAvalible' => number_format($finddata['PRTPUAvalible'], 4),
        );
        return json_encode($arr);
    }

    public function actionGetQtytpu() {
        $find = TbMastertmt::findOne(['TMTID_TPU' => $_POST['TMTID_TPU']]);
        $qty = VwItempackGpu::findOne([
                    'TMTID_GPU' => $find['TMTID_GPU'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 4),
            //'qty' => $_POST['qty'],
        );
        return json_encode($arr);
    }

    public function actionDeleteDetailtpu() {
        $delete = Tbpritemdetail2temp::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionClearTpu() {
        $PRID = $_POST['PRID'];
        $sql = "
                DELETE FROM tb_pr2_temp WHERE PRID = $PRID;
                DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/addpr-gpu/index');
    }

    public function actionSaveReason() {
        $PRID = $_POST['PRID'];
        $PRreasonIDStatus = '1';
        $find = TbPrReasonselected::findOne(['PRID' => $PRID]);
        if (!empty($find)) {
            $sql = "DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        if (isset($_POST['reasonid'])) {
            if (!empty($_POST['reasonid'])) {
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send To Verify Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/index');
    }

    public function actionNewDetailtpu() {
        $modeledit = new VwPritemdetail2Temp();
        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 || $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0) {
                return 0;
            } else {
                if ($_POST['PackChin'] == 0) {
                    $PackID = NULL;
                } else {
                    $findpackunit = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']]);
                    $PackID = $findpackunit['ItemPackID'];
                }

                $cmd = $_POST['cmd'];
                $PCPlanNum1 = (!empty($_POST['VwPritemdetail2Temp']['PCPlanNum']) ? $_POST['VwPritemdetail2Temp']['PCPlanNum'] : '');
                $ItemID = $_POST['VwPritemdetail2Temp']['ItemID'];
                $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
                $TMTID_TPU = $_POST['VwPritemdetail2Temp']['TMTID_TPU'];
                $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
                $PRItemStdCost = $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemStdCost']);
                $PRItemUnitCost = $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemUnitCost']);
                $PRItemOrderQty = $_POST['VwPritemdetail2Temp']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemOrderQty']);
                $PRApprovedOrderQtySum = $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum']);
                $PRItemAvalible = $_POST['VwPritemdetail2Temp']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemAvalible']);
                $PRUnitCost = $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
                $PROrderQty = $_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
                $PRExtendedCost = $_POST['VwPritemdetail2Temp']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
                $PRPackQty = $_POST['VwPritemdetail2Temp']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
                $ItemPackID = $PackID;
                $ItemPackCost = $_POST['VwPritemdetail2Temp']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
                $ids_PR_selected = $_POST['VwPritemdetail2Temp']['ids_PR_selected'] == 0 ? NULL : $_POST['VwPritemdetail2Temp']['ids_PR_selected'];
                $PRID = $_POST['VwPritemdetail2Temp']['PRID'];
                $ids = $_POST['VwPritemdetail2Temp']['ids'];
                $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                $PRLastUnitCost = $_POST['VwPritemdetail2Temp']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRLastUnitCost']);
                if (!empty($PCPlanNum1)) {
                    $checkoverall = $this->checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost);
                    $checkstd = $this->checkStdcost($PRItemStdCost, $PRUnitCost); #เช็คราคากลางก่อน
                    $checkunitover = $this->checkOverunicost($PRItemUnitCost, $PRUnitCost);
                    $checkover = $this->checkOveravalible($PRItemAvalible, $PROrderQty);

                    if ($checkoverall == 'overall' && $_POST['checkover'] == '') {
                        return 'overall';
                    } else if ($checkstd == 'over' && $_POST['checkover'] == '') {
                        return 'stdover';
                    } elseif ($checkunitover == 'over' && $_POST['checkover'] == '') {
                        return 'unitover';
                    } elseif ($checkover == 'over' && $_POST['checkover'] == '') {
                        return 'over';
                    } else {
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
                    }
                } else {
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
                }
            }
        } else {
            $check = Tbpritemdetail2temp::findAll(['TMTID_TPU' => $_POST['id'], 'PRID' => $_POST['PRID']]);
            if (!empty($check)) {
                return 'false';
            } else {
                #get FSN_GPU on TbGenericproductuseGpu
                $Item = VwItemListTpu::findOne(['TMTID_TPU' => $_POST['id']]);
                $modeledit['ItemName'] = $Item['FSN_TMT'];
                $modeledit['DispUnit'] = $Item['DispUnit'];

                #check Plan on VwGpuplanDetailAvalible
                $datagpu = VwTpuplanDetailAvalible::findAll(['TMTID_TPU' => $_POST['id'], 'PCPlanTypeID' => '5']);
                if (empty($datagpu)) {
                    $PCPlanNum = '';
                } else {
                    foreach ($datagpu as $data) {
                        $PCPlanNum[] = $data['PCPlanNum'];
                    }
                }

                #checkpack on tb_itempack
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '';
                }
                return $this->renderAjax('_update-detailtpu', [
                            'modeledit' => $modeledit,
                            'PCPlanNum' => $PCPlanNum,
                            'pack' => $pack,
                            'ItemName' => $modeledit['ItemName'],
                            'ItemPackSKUQty' => '',
                            'btn' => $btn,
                            'DispUnit' => $modeledit['DispUnit'],
                            'TMTID_GPU' => $Item['TMTID_GPU'],
                            'ItemID' => $Item['ItemID'],
                ]);
            }
        }
    }

    private function checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost) {
        if ($PRItemStdCost > '0') {
            if ($PRUnitCost > $PRItemStdCost && $PRUnitCost > $PRItemUnitCost && $PROrderQty > $PRItemAvalible) {
                return 'overall';
            }
        } else {
            return null;
        }
    }

    private function checkOveravalible($PRItemAvalible, $PROrderQty) {
        if ($PROrderQty > $PRItemAvalible) {
            return 'over';
        } else {
            return 'notover';
        }
    }

    private function checkOverunicost($PRItemUnitCost, $PRUnitCost) {
        if ($PRUnitCost > $PRItemUnitCost) {
            return 'over';
        } else {
            return 'unitnotover';
        }
    }

    private function checkStdcost($PRItemStdCost, $PRUnitCost) {
        if ($PRItemStdCost > '0') {
            if ($PRUnitCost > $PRItemStdCost) {
                return 'over';
            } else {
                return 'stdnotover';
            }
        } else {
            return null;
        }
    }

    public function actionUpdateDetailVerify($id, $view) {
        $modelPR2 = TbPr2::findOne($id);
        $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
        $searchModel = new TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $Reason = TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();
        if (empty($Reason)) {
            $htl_checkbox = '-';
        } else {
            foreach ($Reason as $data) {
                $ids[] = $data['PRreasonID'];
            }
            $modelcheck = TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            $no = 1;
            foreach ($modelcheck as $rm) {
                $htl_checkbox .= '<div class="checkbox">';
                $htl_checkbox .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
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
            $model = TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = VwItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $packverify = VwItempack::findOne(['ItemPackID' => $model['ItemPackIDVerify']]);

            return $this->renderPartial('view_detail_verify', [
                        'model' => $model,
                        'packunit' => $packunit,
                        'packverify' => $packverify,
                        'view' => $view
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionOkVerify() {
        Yii::$app->db->createCommand('CALL cmd_pr2_itemdetail_verify(:x);')
                ->bindParam(':x', $_POST['id'])->execute();
    }

    public function actionUpdateVerify($id) {
        $modeledit = VwPritemdetail2::findOne(['ids' => $id]);
        $modelverify = TbPritemdetail2::findOne(['ids' => $id]);
        if (Yii::$app->request->post()) {
            if ($_POST['PackChin'] == 0) {
                $PackID = NULL;
            } else {
                $findpackunit = TbItempack::findOne(['TMTID_GPU' => $modelverify['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID']]);
                $PackID = $findpackunit['ItemPackID'];
            }

            $PCPlanNum1 = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : '');
            $PRItemAvalible = empty($_POST['VwPritemdetail2']['PRItemAvalible']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
            $PROrderQty = empty($_POST['VwPritemdetail2']['PROrderQty']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
            $PRItemUnitCost = empty($_POST['VwPritemdetail2']['PRItemUnitCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
            $PRUnitCost = empty($_POST['VwPritemdetail2']['PRUnitCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
            $PRItemStdCost = empty($_POST['VwPritemdetail2']['PRItemStdCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
            $PRItemOnPCPlan = $this->checkOnplanverify($PRItemStdCost, $PRUnitCost, $PRItemUnitCost, $PROrderQty, $PRItemAvalible);
            if (!empty($PCPlanNum1)) {
                $checkoverall = $this->checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost);
                $checkstd = $this->checkStdcost($PRItemStdCost, $PRUnitCost); #เช็คราคากลางก่อน
                $checkunitover = $this->checkOverunicost($PRItemUnitCost, $PRUnitCost);
                $checkover = $this->checkOveravalible($PRItemAvalible, $PROrderQty);

                if ($checkoverall == 'overall' && $_POST['checkover'] == '') {
                    return 'overall';
                } else if ($checkstd == 'over' && $_POST['checkover'] == '') {
                    return 'stdover';
                } elseif ($checkunitover == 'over' && $_POST['checkover'] == '') {
                    return 'unitover';
                } elseif ($checkover == 'over' && $_POST['checkover'] == '') {
                    return 'over';
                } else {
                    $modelverify->PRPackQtyVerify = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                    $modelverify->ItemPackIDVerify = $PackID;
                    $modelverify->ItemPackCostVerify = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                    $modelverify->PRVerifyQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                    $modelverify->PRVerifyUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                    $modelverify->PRItemOnPCPlan = $PRItemOnPCPlan;
                    $modelverify->save();
                    echo '1';
                }
            } else {
                $modelverify->PRPackQtyVerify = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                $modelverify->ItemPackIDVerify = $PackID;
                $modelverify->ItemPackCostVerify = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $modelverify->PRVerifyQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $modelverify->PRVerifyUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $modelverify->PRItemOnPCPlan = $PRItemOnPCPlan;
                $modelverify->save();
                echo '1';
            }
        } else {
            if (isset($modelverify->PRPackQtyVerify) || !empty($modelverify->PRVerifyUnitCost)) {
                $qty = VwItempackGpu::findOne(['ItemPackID' => $modelverify['ItemPackIDVerify']]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
                if (empty($checkpack)) {
                    $pack = '';
                } else {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                }

                return $this->renderAjax('_form_update_verify', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                            'PRPackQty' => $modelverify['PRPackQtyVerify'],
                            'ItemPackCost' => $modelverify['ItemPackCostVerify'],
                            'PROrderQty' => $modelverify['PRVerifyQty'],
                            'PRUnitCost' => $modelverify['PRVerifyUnitCost'],
                            'ItemPackID' => $qty['ItemPackUnit']
                ]);
            } else {
                $qty = VwItempackGpu::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);

                if (empty($checkpack)) {
                    $pack = '';
                } else {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                }

                return $this->renderAjax('_form_update_verify', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                            'PRPackQty' => $modelverify['PRPackQty'],
                            'ItemPackCost' => $modelverify['ItemPackCost'],
                            'PROrderQty' => $modelverify['PROrderQty'],
                            'PRUnitCost' => $modelverify['PRUnitCost'],
                            'ItemPackID' => $qty['ItemPackUnit']
                ]);
            }
        }
    }

    private function checkOnplanverify($PRItemStdCost, $PRUnitCost, $PRItemUnitCost, $PROrderQty, $PRItemAvalible) {
        if ($PRUnitCost > $PRItemStdCost || $PRUnitCost > $PRItemUnitCost || $PROrderQty > $PRItemAvalible) {
            return '1';
        } else {
            return '2';
        }
    }

    public function actionDeleteDetailVerify() {
        $delete = TbPritemdetail2::findOne($_POST['id']);
        $delete->delete();
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Rejected' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-verify');
    }

    public function actionSavedraftVerify() {
        $PRID = $_POST['PRID'];
        $PRVerifyNote = $_POST['PRVerifyNote'];
        $PRbudgetID = null;
        Yii::$app->db->createCommand('CALL cmd_pr2_verify_savedraft(:x,:PRVerifyNote,:PRbudgetID);')
                ->bindParam(':x', $PRID)
                ->bindParam(':PRVerifyNote', $PRVerifyNote)
                ->bindParam(':PRbudgetID', $PRbudgetID)
                ->execute();
    }

    public function actionSendToApprove() {
        Yii::$app->db->createCommand('CALL cmd_pr2_send_to_approve(:x);')
                ->bindParam(':x', $_POST['PRID'])
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send' . ' ' . $_POST['PRNum'] . ' ' . 'To Approve Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-verify');
    }

    public function actionUpdateDetailApprove($id, $view) {
        $modelPR2 = TbPr2::findOne($id);
        $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
        $searchModel = new TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $Reason = TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();
        if (empty($Reason)) {
            $htl_checkbox = '-';
        } else {
            foreach ($Reason as $data) {
                $ids[] = $data['PRreasonID'];
            }
            $modelcheck = TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            $no = 1;
            foreach ($modelcheck as $rm) {
                $htl_checkbox .= '<div class="checkbox">';
                $htl_checkbox .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
            }
            $htl_checkbox .= '</div>';
        }

        $prdetail = TbPritemdetail2::findAll(['PRID' => $id]);
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

    public function actionViewDetailApprove() {
        if (isset($_POST['expandRowKey'])) {
            $model = TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = VwItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $packverify = VwItempack::findOne(['ItemPackID' => $model['ItemPackIDVerify']]);

            return $this->renderPartial('view_detail_approve', [
                        'model' => $model,
                        'packunit' => $packunit,
                        'packverify' => $packverify
            ]);
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Rejected' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-approve');
    }

    public function actionApprovePr() {
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Approve' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-approve');
    }

    public function actionCreatepridTemp() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $max = TbPr2::find()
                ->select('max(PRID)')
                ->scalar();
        $maxTemp = TbPr2Temp::find()
                ->select('max(PRID)')
                ->scalar();
        if ($max > $maxTemp) {
            $max = $max + 1;
        } elseif ($max < $maxTemp) {
            $max = $maxTemp + 1;
        }

        $PRTypeID = 4;
        $DepartmentID = '1';
        $SectionID = '1';
        $POTypeID = '3';
        Yii::$app->db->createCommand('CALL cmd_pr2_create_PR(:x,:PRID,:PRTypeID,:DepartmentID,:SectionID,:POTypeID);')
                ->bindParam(':x', $userid)
                ->bindParam(':PRID', $max)
                ->bindParam(':PRTypeID', $PRTypeID)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':POTypeID', $POTypeID)
                ->execute();
        $find = TbPr2Temp::findOne($max);
        $encode = base64_encode($max);
        return $this->redirect(['create', 'ids_PR_selected' => '', 'PRID' => $find->PRID, 'view' => $encode]);
    }

    public function actionGetReasontpu() {
        $Reason = TbPrReason::find()->where(['PRTypeID' => $_POST['PRType']])->all();
        if (!empty($Reason)) {
            foreach ($Reason as $data) {
                $PRTypeID[] = $data['PRTypeID'];
            }
            $modelcheck = TbPrReason::find()->where(['PRTypeID' => $PRTypeID])->all();
            $htl = '<div>';
            $no = 1;
            foreach ($modelcheck as $rm) {
                $htl .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
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

    public function actionDeleteTemp($id) {
        $sql = "
                DELETE FROM tb_pr2_temp WHERE PRID = $id
                DELETE FROM tb_pr_reasonselected WHERE PRID = $id
               ";
        $query = Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 6000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Delete complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        $this->redirect('index.php?r=Purchasing/addpr-gpu/index');
    }

    public function actionGetvdnameByplannum() {
        $query = TbPcplan::findOne(['PCPOContactID' => $_POST['id']]);
        $queryname = Profile::findOne(['VendorID' => $query['PCVendorID']]);
        $arr = array(
            'VendorName' => $queryname['VenderName'],
            'VendorID' => $query['PCVendorID'],
        );
        return json_encode($arr);
    }

    function actionUpdatecontactnum() {
        $PRID = $_POST['PRID'];
        $POContactNum = $_POST['POContactNum'];
        $sql = "
                UPDATE tb_pr2_temp
                    SET
                        POContactNum = '$POContactNum'
                    WHERE PRID = $PRID;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionUpdateResendVerify($id, $view) {
        $modelPR2 = TbPr2::findOne($id);
        if ($modelPR2->load(Yii::$app->request->post())) {
            $PRID = $_POST['TbPr2']['PRID'];
            $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPr2']['PRDate']);
            $PRTypeID = 4;
            $PRStatusID = 4;
            $DepartmentID = $_POST['TbPr2']['DepartmentID'];
            $SectionID = $_POST['TbPr2']['SectionID'];
            $POTypeID = $_POST['TbPr2']['POTypeID'];
            $PRReasonNote = $_POST['TbPr2']['PRReasonNote'];
            $PRExpectDate = $_POST['TbPr2']['PRExpectDate'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $data = Yii::$app->db->createCommand('CALL cmd_pr2_savedraft_reject(:PRDate,:PRTypeID,:PRStatusID,:DepartmentID,:SectionID,:POTypeID,:PRID,:PRReasonNote,:PRExpectDate,:PRCreatedBy);')
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
                    ->execute();
            return 'success';
        } else {
            $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
            $searchModel = new TbPritemdetail2Search();
            $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
            $Reason = TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();
            if (empty($Reason)) {
                $ids = [];
                $modelcheck1 = TbPrReason::find()->where(['PRTypeID' => 4])->all();
            } else {
                foreach ($Reason as $data) {
                    $ids[] = $data['PRreasonID'];
                }
                $modelcheck1 = TbPrReason::find()
                        ->where(['NOT IN', 'ids', $ids])
                        ->andWhere('PRTypeID = :prtypeid', [':prtypeid' => 4])
                        ->all();
            }
            $no = 1;

            $modelcheck = TbPrReason::find()->where(['ids' => $ids])->all();
            $htl_checkbox = '<div>';
            foreach ($modelcheck as $rm) {
                $htl_checkbox .= '<div class="checkbox"><label><input type="checkbox" checked="checked" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '" />';
                $htl_checkbox .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
            }
            $htl_checkbox .= '</div>';

            $htl_checkbox1 = '<div>';
            foreach ($modelcheck1 as $rm) {
                $htl_checkbox1 .= '<div class="checkbox"><label><input type="checkbox" class="colored-success" name="PRReason' . $rm['PRReason'] . '" id="PRReason' . $rm['PRReason'] . '" value="' . $rm['ids'] . '"  data-toggle="checkbox-x"/>';
                $htl_checkbox1 .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['PRReason'] . '</span></label></div>';
                $no++;
            }
            $htl_checkbox1 .= '</div>';

            return $this->render('_form_resend_verify', [
                        'modelPR2' => $modelPR2,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'section' => $section,
                        'htl_checkbox' => $htl_checkbox,
                        'htl_checkbox1' => $htl_checkbox1,
                        'view' => $view
            ]);
        }
    }

    public function actionViewDetailtpuReject() {
        if (isset($_POST['expandRowKey'])) {
            $id = $_POST['expandRowKey'];
            $model = VwPritemdetail2::findOne(['ids' => $id]);
            $packunit = TbItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $pack = TbPackunit::findOne($packunit['ItemPackUnit']);

            $records = VwPo2SubPohistory::find()->where(['TMTID_TPU' => $model['TMTID_TPU']])->all();

            return $this->renderPartial('viewdetailtpucont', [
                        'model1' => $model,
                        'packunit' => $packunit,
                        'pack' => $pack,
                        'records' => $records,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionDeleteDetailtpuReject() {
        $delete = TbPritemdetail2::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionUpdateDetailtpuReject($id) {
        $modeledit = VwPritemdetail2::findOne(['ids' => $id]);
        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['PackChin'] == 0) {
                $PackID = NULL;
            } else {
                $findpackunit = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID']]);
                $PackID = $findpackunit['ItemPackID'];
            }
            $cmd = $_POST['cmd'];
            $PCPlanNum = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : '');
            $ItemID = $_POST['VwPritemdetail2']['ItemID'];
            $TMTID_GPU = $_POST['VwPritemdetail2']['TMTID_GPU'];
            $TMTID_TPU = $_POST['VwPritemdetail2']['TMTID_TPU'];
            $ItemName = $_POST['VwPritemdetail2']['ItemName'];
            $PRItemStdCost = $_POST['VwPritemdetail2']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
            $PRItemUnitCost = $_POST['VwPritemdetail2']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
            $PRItemOrderQty = $_POST['VwPritemdetail2']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemOrderQty']);
            $PRApprovedOrderQtySum = $_POST['VwPritemdetail2']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRApprovedOrderQtySum']);
            $PRItemAvalible = $_POST['VwPritemdetail2']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
            $PRUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
            $PROrderQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
            $PRExtendedCost = $_POST['VwPritemdetail2']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
            $PRPackQty = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
            $ItemPackID = $PackID;
            $ItemPackCost = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
            $ids_PR_selected = $_POST['VwPritemdetail2']['ids_PR_selected'] == 0 ? NULL : $_POST['VwPritemdetail2']['ids_PR_selected'];
            $PRID = $_POST['VwPritemdetail2']['PRID'];
            $ids = $_POST['VwPritemdetail2']['ids'];
            $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $PRLastUnitCost = $_POST['VwPritemdetail2']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRLastUnitCost']);
            if (!empty($PCPlanNum)) {
                $checkoverall = $this->checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost);
                $checkstd = $this->checkStdcost($PRItemStdCost, $PRUnitCost); #เช็คราคากลางก่อน
                $checkunitover = $this->checkOverunicost($PRItemUnitCost, $PRUnitCost);
                $checkover = $this->checkOveravalible($PRItemAvalible, $PROrderQty);

                if ($checkoverall == 'overall' && $_POST['checkover'] == '') {
                    return 'overall';
                } else if ($checkstd == 'over' && $_POST['checkover'] == '') {
                    return 'stdover';
                } elseif ($checkunitover == 'over' && $_POST['checkover'] == '') {
                    return 'unitover';
                } elseif ($checkover == 'over' && $_POST['checkover'] == '') {
                    return 'over';
                } else {
                    Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
                                    . ':ids,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:PRItemStdCost,:PRItemUnitCost'
                                    . ',:PRItemOrderQty,:PRApprovedOrderQtySum,:PRItemAvalible,:PRLastUnitCost,:PRPackQty,:ItemPackID,:ItemPackCost'
                                    . ',:PROrderQty,:PRUnitCost,:PRExtendedCost,:PRID,:PRCreatedBy);')
                            ->bindParam(':ids', $ids)
                            ->bindParam(':PCPlanNum', $PCPlanNum)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->bindParam(':TMTID_TPU', $TMTID_TPU)
                            ->bindParam(':ItemName', $ItemName)
                            ->bindParam(':PRItemStdCost', $PRItemStdCost)
                            ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                            ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                            ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                            ->bindParam(':PRItemAvalible', $PRItemAvalible)
                            ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                            ->bindParam(':PRPackQty', $PRPackQty)
                            ->bindParam(':ItemPackID', $ItemPackID)
                            ->bindParam(':ItemPackCost', $ItemPackCost)
                            ->bindParam(':PROrderQty', $PROrderQty)
                            ->bindParam(':PRUnitCost', $PRUnitCost)
                            ->bindParam(':PRExtendedCost', $PRExtendedCost)
                            ->bindParam(':PRID', $PRID)
                            ->bindParam(':PRCreatedBy', $PRCreatedBy)
                            ->execute();
                    echo '1';
                }
            } else {
                Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
                                . ':ids,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:PRItemStdCost,:PRItemUnitCost'
                                . ',:PRItemOrderQty,:PRApprovedOrderQtySum,:PRItemAvalible,:PRLastUnitCost,:PRPackQty,:ItemPackID,:ItemPackCost'
                                . ',:PROrderQty,:PRUnitCost,:PRExtendedCost,:PRID,:PRCreatedBy);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':PCPlanNum', $PCPlanNum)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':TMTID_TPU', $TMTID_TPU)
                        ->bindParam(':ItemName', $ItemName)
                        ->bindParam(':PRItemStdCost', $PRItemStdCost)
                        ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                        ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                        ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                        ->bindParam(':PRItemAvalible', $PRItemAvalible)
                        ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                        ->bindParam(':PRPackQty', $PRPackQty)
                        ->bindParam(':ItemPackID', $ItemPackID)
                        ->bindParam(':ItemPackCost', $ItemPackCost)
                        ->bindParam(':PROrderQty', $PROrderQty)
                        ->bindParam(':PRUnitCost', $PRUnitCost)
                        ->bindParam(':PRExtendedCost', $PRExtendedCost)
                        ->bindParam(':PRID', $PRID)
                        ->bindParam(':PRCreatedBy', $PRCreatedBy)
                        ->execute();
                echo '1';
            }
        } else {
            $datagpu = VwTpuplanDetailAvalible::findAll(['TMTID_TPU' => $modeledit['TMTID_TPU'], 'PCPlanTypeID' => '5']);
            $itempack = VwItempackGpu::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
            $qty = VwItempackGpu::findOne([
                        'ItemPackID' => $modeledit['ItemPackID']
            ]);
            #GetPCPlan
            if (empty($datagpu)) {
                $PCPlanNum = '';
            } else {
                foreach ($datagpu as $data) {
                    $PCPlanNum[] = $data['PCPlanNum'];
                }
            }
            #GetPack
            if (empty($itempack)) {
                //$itempack = TbPackunit::find()->all();
                foreach ($itempack as $data) {
                    $pack[] = $data['PackUnitID'];
                }
            } else {
                foreach ($itempack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            }

            return $this->renderAjax('_form_update_reject', [
                        'modeledit' => $modeledit,
                        'PCPlanNum' => $PCPlanNum,
                        'pack' => $pack,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'ItemName' => $modeledit['ItemName'],
                        'btn' => '',
                        'DispUnit' => $modeledit['DispUnit'],
                        'TMTID_GPU' => $modeledit['TMTID_GPU'],
                        'ItemID' => $modeledit['ItemID'],
            ]);
        }
    }

    public function actionNewDetailtpuReject() {
        $modeledit = new VwPritemdetail2();
        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['VwPritemdetail2']['PROrderQty'] == 0 || $_POST['VwPritemdetail2']['PRUnitCost'] == 0) {
                return 0;
            } else {
                if ($_POST['PackChin'] == 0) {
                    $PackID = NULL;
                } else {
                    $findpackunit = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID']]);
                    $PackID = $findpackunit['ItemPackID'];
                }

                $cmd = $_POST['cmd'];
                $PCPlanNum = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : '');
                $ItemID = $_POST['VwPritemdetail2']['ItemID'];
                $TMTID_GPU = $_POST['VwPritemdetail2']['TMTID_GPU'];
                $TMTID_TPU = $_POST['VwPritemdetail2']['TMTID_TPU'];
                $ItemName = $_POST['VwPritemdetail2']['ItemName'];
                $PRItemStdCost = $_POST['VwPritemdetail2']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
                $PRItemUnitCost = $_POST['VwPritemdetail2']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
                $PRItemOrderQty = $_POST['VwPritemdetail2']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemOrderQty']);
                $PRApprovedOrderQtySum = $_POST['VwPritemdetail2']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRApprovedOrderQtySum']);
                $PRItemAvalible = $_POST['VwPritemdetail2']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
                $PRUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $PROrderQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $PRExtendedCost = $_POST['VwPritemdetail2']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
                $PRPackQty = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                $ItemPackID = $PackID;
                $ItemPackCost = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $ids_PR_selected = $_POST['VwPritemdetail2']['ids_PR_selected'] == 0 ? NULL : $_POST['VwPritemdetail2']['ids_PR_selected'];
                $PRID = $_POST['VwPritemdetail2']['PRID'];
                $ids = $_POST['VwPritemdetail2']['ids'];
                $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                $PRLastUnitCost = $_POST['VwPritemdetail2']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRLastUnitCost']);
                if (!empty($PCPlanNum)) {
                    $checkoverall = $this->checkAll($PRItemStdCost, $PRItemUnitCost, $PRItemAvalible, $PROrderQty, $PRUnitCost);
                    $checkstd = $this->checkStdcost($PRItemStdCost, $PRUnitCost); #เช็คราคากลางก่อน
                    $checkunitover = $this->checkOverunicost($PRItemUnitCost, $PRUnitCost);
                    $checkover = $this->checkOveravalible($PRItemAvalible, $PROrderQty);

                    if ($checkoverall == 'overall' && $_POST['checkover'] == '') {
                        return 'overall';
                    } else if ($checkstd == 'over' && $_POST['checkover'] == '') {
                        return 'stdover';
                    } elseif ($checkunitover == 'over' && $_POST['checkover'] == '') {
                        return 'unitover';
                    } elseif ($checkover == 'over' && $_POST['checkover'] == '') {
                        return 'over';
                    } else {
                        Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
                                        . ':ids,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:PRItemStdCost,:PRItemUnitCost'
                                        . ',:PRItemOrderQty,:PRApprovedOrderQtySum,:PRItemAvalible,:PRLastUnitCost,:PRPackQty,:ItemPackID,:ItemPackCost'
                                        . ',:PROrderQty,:PRUnitCost,:PRExtendedCost,:PRID,:PRCreatedBy);')
                                ->bindParam(':ids', $ids)
                                ->bindParam(':PCPlanNum', $PCPlanNum)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->bindParam(':TMTID_TPU', $TMTID_TPU)
                                ->bindParam(':ItemName', $ItemName)
                                ->bindParam(':PRItemStdCost', $PRItemStdCost)
                                ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                                ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                                ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                                ->bindParam(':PRItemAvalible', $PRItemAvalible)
                                ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                                ->bindParam(':PRPackQty', $PRPackQty)
                                ->bindParam(':ItemPackID', $ItemPackID)
                                ->bindParam(':ItemPackCost', $ItemPackCost)
                                ->bindParam(':PROrderQty', $PROrderQty)
                                ->bindParam(':PRUnitCost', $PRUnitCost)
                                ->bindParam(':PRExtendedCost', $PRExtendedCost)
                                ->bindParam(':PRID', $PRID)
                                ->bindParam(':PRCreatedBy', $PRCreatedBy)
                                ->execute();
                        echo '1';
                    }
                } else {
                    Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
                                    . ':ids,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:PRItemStdCost,:PRItemUnitCost'
                                    . ',:PRItemOrderQty,:PRApprovedOrderQtySum,:PRItemAvalible,:PRLastUnitCost,:PRPackQty,:ItemPackID,:ItemPackCost'
                                    . ',:PROrderQty,:PRUnitCost,:PRExtendedCost,:PRID,:PRCreatedBy);')
                            ->bindParam(':ids', $ids)
                            ->bindParam(':PCPlanNum', $PCPlanNum)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->bindParam(':TMTID_TPU', $TMTID_TPU)
                            ->bindParam(':ItemName', $ItemName)
                            ->bindParam(':PRItemStdCost', $PRItemStdCost)
                            ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                            ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                            ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                            ->bindParam(':PRItemAvalible', $PRItemAvalible)
                            ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                            ->bindParam(':PRPackQty', $PRPackQty)
                            ->bindParam(':ItemPackID', $ItemPackID)
                            ->bindParam(':ItemPackCost', $ItemPackCost)
                            ->bindParam(':PROrderQty', $PROrderQty)
                            ->bindParam(':PRUnitCost', $PRUnitCost)
                            ->bindParam(':PRExtendedCost', $PRExtendedCost)
                            ->bindParam(':PRID', $PRID)
                            ->bindParam(':PRCreatedBy', $PRCreatedBy)
                            ->execute();
                    echo '1';
                }
            }
        } else {
            $check = TbPritemdetail2::findAll(['TMTID_TPU' => $_POST['id'], 'PRID' => $_POST['PRID']]);
            if (!empty($check)) {
                return 'false';
            } else {
                #get FSN_GPU on TbGenericproductuseGpu
                $Item = VwItemListTpu::findOne(['TMTID_TPU' => $_POST['id']]);
                $modeledit['ItemName'] = $Item['FSN_TMT'];
                $modeledit['DispUnit'] = $Item['DispUnit'];

                #check Plan on VwGpuplanDetailAvalible
                $datagpu = VwTpuplanDetailAvalible::findAll(['TMTID_TPU' => $_POST['id'], 'PCPlanTypeID' => '5']);
                if (empty($datagpu)) {
                    $PCPlanNum = '';
                } else {
                    foreach ($datagpu as $data) {
                        $PCPlanNum[] = $data['PCPlanNum'];
                    }
                }

                #checkpack on tb_itempack
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $Item['TMTID_GPU']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '';
                    //$btn = '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>';
                }
                return $this->renderAjax('_form_update_reject', [
                            'modeledit' => $modeledit,
                            'PCPlanNum' => $PCPlanNum,
                            'pack' => $pack,
                            'ItemName' => $modeledit['ItemName'],
                            'ItemPackSKUQty' => '',
                            'btn' => $btn,
                            'DispUnit' => $modeledit['DispUnit'],
                            'TMTID_GPU' => $Item['TMTID_GPU'],
                            'ItemID' => $Item['ItemID'],
                ]);
            }
        }
    }

    public function actionSendtoverifyReject() {
        $PRID = $_POST['PRID'];
        $PRNum = $_POST['PRNum'];
        $sql = "
                 update tb_pr2
                    set 
                        PRStatusID = 2
                 where PRID = $PRID;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Send ' . $PRNum . ' To Verify Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/index');
    }

    public function actionVerifyApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPritemdetail2::find()->where(['PRVerifyQty' =>null, 'PRID' => $request->post('PRID')])->all()) != null) {
                return 'มี ' . TbPritemdetail2::find()->where(['PRVerifyQty' => null, 'PRID' => $request->post('PRID')])->count('ids') . ' รายการ ที่ยังไม่ได้ถูก Update หรือ OK';
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
            $PRExtendedCost = TbPritemdetail2::find()
                    ->where(['PRID' => $request->post('PRID'), 'PRItemNumStatusID' => 2])
                    ->sum('PRExtendedCost');
            $PRApprovalID = Yii::$app->user->getId();
            $PRTotal = $PRExtendedCost;
            $PRID = $request->post('PRID');
            Yii::$app->db->createCommand('CALL cmd_pr2_approve(:x,:PRTotal,:PRApprovalID);')
                    ->bindParam(':x', $PRID)
                    ->bindParam(':PRTotal', $PRTotal)
                    ->bindParam(':PRApprovalID', $PRApprovalID)
                    ->execute();
            return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-verify');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancelVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPritemdetail2::findOne($request->post('id'));
            $model->PRPackQtyVerify = null;
            $model->ItemPackIDVerify = null;
            $model->ItemPackCostVerify = null;
            $model->PRVerifyQty = null;
            $model->PRVerifyUnitCost = null;
            $model->save();
            return 'Cancel Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDetails() {
        if (isset($_POST['expandRowKey'])) {
            $query = Tbpritemdetail2temp::findOne($_POST['expandRowKey']);
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
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'],':PRID' => $query['PRID']],
            ]);
            /*
            $searchModel1 = new VwPurchasingplanStatus2Search();
            $dataProvider1 = $searchModel1->searchDetailsPR(Yii::$app->request->queryParams, $query['TMTID_GPU'],$query['PRID']);
            */
            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_gpu(Yii::$app->request->queryParams, $query['TMTID_GPU']);

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

    public function actionDetailsVerifyApprove() {
        if (isset($_POST['expandRowKey'])) {
            $query = TbPritemdetail2::findOne($_POST['expandRowKey']);
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
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'],':PRID' => $query['PRID']],
            ]);
            /*
            $searchModel1 = new VwPurchasingplanStatus2Search();
            $dataProvider1 = $searchModel1->searchDetailsPR(Yii::$app->request->queryParams, $query['TMTID_GPU'],$query['PRID']);
            */
            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsPR1(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_gpu(Yii::$app->request->queryParams, $query['TMTID_GPU']);

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

}
