<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\Tbdruginteraction;
use app\modules\Inventory\TbdruginteractionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DruginteracController implements the CRUD actions for Tbdruginteraction model.
 */
class DruginteracController extends Controller {

    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Tbdruginteraction models.
     * @return mixed
     */
    public function actionIndex() {
        $modeldrug = new Tbdruginteraction();
        $modeldruglevel = new \app\modules\Inventory\models\TbDruginteractionLevel();
        //$searchModel = new TbdruginteractionSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($modeldrug->load(Yii::$app->request->post())) {
            if ($_POST['Tbdruginteraction']['DDI_id'] == null) {
                $max = Tbdruginteraction::find()
                        ->select('max(DDI_id)')
                        ->scalar();
                $max = $max + 1;
                $userid = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_ddi_create(:userid,:maxid);')
                        ->bindParam(':userid', $userid)
                        ->bindParam(':maxid', $max)
                        ->execute();
            } else {
                $max = $_POST['Tbdruginteraction']['DDI_id'];
            }
            $query = \app\modules\Inventory\models\Tbdruginteraction::findOne(['Drug1' => $_POST['Tbdruginteraction']['Drug1'], 'Drug2' => $_POST['Tbdruginteraction']['Drug2']]);
            if ($query['DDI_id'] == $max) {
                $DDI_Effect_decs = $_POST['TbDruginteractionLevel']['DDI_Effect_decs'];
                $DDI_Serverity = $_POST['TbDruginteractionLevel']['DDI_Serverity'];
                $DDI_instruction = $_POST['TbDruginteractionLevel']['DDI_instruction'];
                $ItemStatus = 2;
                $TMTID_VTM1 = $_POST['Tbdruginteraction']['Drug1'];
                $TMTID_VTM2 = $_POST['Tbdruginteraction']['Drug2'];
                Yii::$app->db->createCommand('CALL cmd_ddi_save(:DDI_id,:DDI_Effect_decs,:DDI_Serverity,:ItemStatus,:userid,:TMTID_VTM1,:TMTID_VTM2,:DDI_instruction);')
                        ->bindParam(':DDI_id', $max)
                        ->bindParam(':DDI_Effect_decs', $DDI_Effect_decs)
                        ->bindParam(':DDI_Serverity', $DDI_Serverity)
                        ->bindParam(':ItemStatus', $ItemStatus)
                        ->bindParam(':userid', $userid)
                        ->bindParam(':TMTID_VTM1', $TMTID_VTM1)
                        ->bindParam(':TMTID_VTM2', $TMTID_VTM2)
                        ->bindParam(':DDI_instruction', $DDI_instruction)
                        ->execute();
                return 'success';
            } elseif ($query['DDI_id'] != $max) {
                if ($query != null) {
                    return 'duplicate';
                } else {
                    $DDI_Effect_decs = $_POST['TbDruginteractionLevel']['DDI_Effect_decs'];
                    $DDI_Serverity = $_POST['TbDruginteractionLevel']['DDI_Serverity'];
                    $DDI_instruction = $_POST['TbDruginteractionLevel']['DDI_instruction'];
                    $ItemStatus = 2;
                    $TMTID_VTM1 = $_POST['Tbdruginteraction']['Drug1'];
                    $TMTID_VTM2 = $_POST['Tbdruginteraction']['Drug2'];
                    Yii::$app->db->createCommand('CALL cmd_ddi_save(:DDI_id,:DDI_Effect_decs,:DDI_Serverity,:ItemStatus,:userid,:TMTID_VTM1,:TMTID_VTM2,:DDI_instruction);')
                            ->bindParam(':DDI_id', $max)
                            ->bindParam(':DDI_Effect_decs', $DDI_Effect_decs)
                            ->bindParam(':DDI_Serverity', $DDI_Serverity)
                            ->bindParam(':ItemStatus', $ItemStatus)
                            ->bindParam(':userid', $userid)
                            ->bindParam(':TMTID_VTM1', $TMTID_VTM1)
                            ->bindParam(':TMTID_VTM2', $TMTID_VTM2)
                             ->bindParam(':DDI_instruction', $DDI_instruction)
                            ->execute();
                    return 'success';
                }
            }
        } else {
            return $this->render('index', [
                        'modeldrug' => $modeldrug,
                        'modeldruglevel' => $modeldruglevel,
                            //'searchModel' => $searchModel,
                            //'dataProvider' => $dataProvider,
            ]);
        }
    }

    function actionQuerydruginterac() {
        $records = \app\modules\Inventory\models\Vwddilist::find()->all();
        $htl = '<table class="table table-striped table-bordered dt-responsive norap dataTable dtr-inline" cellspacing="0" width="100%" id="tb_druginteraction">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th  style="text-align: center;">รหัสตัวยา 1</th>
                                    <th  style="text-align: center;">รายละเอียดตัวยา 1</th>
                                    <th  style="text-align: center;">รหัสตัวยา 2</th>
                                    <th  style="text-align: center;">รายละเอียดตัวยา 2</th>
                                    <th  style="text-align: center;">ระดับผลกระทบ</th>
                                    <th  style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($records as $result) {
            $htl .='<tr data-key="' . $result->DDI_id . '">';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Drug1'] . '</td>';
            $htl .= '<td>' . $result['FNS_VTM1'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Drug2'] . '</td>';
            $htl .= '<td>' . $result['FNS_VTM2'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DDI_Serverity_decs'] . '</td>';
            $htl .='<td style="text-align: center;">
                    <a class="btn btn-success btn-xs" onclick="Editdruginterac(this);" data-id="' . $result->DDI_id . '">Edit</a>
                    <a class="btn btn-danger btn-xs" onclick="Delete(this);" data-id="' . $result->DDI_id . '">Delete</a>
                    </td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    function actionTpudata() {
        $records = \app\modules\Inventory\models\Vwgpulist::find()->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="tb_itemlisttpu">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="36px" style="text-align: center;">#</th>
                                    <th  style="text-align: center;">รายละเอียดตัวยา</th>
                                    <th  style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($records as $result) {
            $htl .='<tr data-key="' . $no . '" >';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            //$htl .= '<td>' . $result['FSN_TMT'] . '</td>';
            $htl .='<td style="text-align: center;">
                    <a class="btn btn-success btn-xs" onclick="SelectandPostdata(this);" data-id="' . $result->TMTID_GPU . '" id="' . $no . '">Select</a>
                    </td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        $arr = array(
            'table' => $htl,
        );
        return json_encode($arr);
    }

    /**
     * Displays a single Tbdruginteraction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tbdruginteraction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Tbdruginteraction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->DDI_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tbdruginteraction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->DDI_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tbdruginteraction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tbdruginteraction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tbdruginteraction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Tbdruginteraction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    function actionGetdataonselect() {
        $query = \app\modules\Inventory\models\Vwgpulist::findOne(['TMTID_GPU' => $_POST['id']]);
       // $querytradename = \app\models\VwItemListTpu::findOne(['TMTID_VTM' => $_POST['id']]);
        $arr = array(
            'fsn_vtm' => $query['FSN_GPU'],
            'TMTID_VTM' => $query['TMTID_VTM'],
        );
        return json_encode($arr);
    }

    public function actionEditdruginterac() {
        $modeldrug = Tbdruginteraction::findOne(['DDI_id' => $_POST['id']]);
        $Drug1 = \app\modules\Inventory\models\Tbvtm::findOne(['TMTID_VTM' => $modeldrug['Drug1']]);
        $Drug2 = \app\modules\Inventory\models\Tbvtm::findOne(['TMTID_VTM' => $modeldrug['Drug2']]);
        $modeldruglevel = \app\modules\Inventory\models\TbDruginteractionLevel::findOne(['DDI_Effect_id' => $modeldrug['DDI_Effect_id']]);
        $arr = array(
            'drug1' => $modeldrug['Drug1'],
            'drug2' => $modeldrug['Drug2'],
            'detaildrug1' => $Drug1['FSN_VTM'],
            'detaildrug2' => $Drug2['FSN_VTM'],
            'serverity' => $modeldruglevel['DDI_Serverity'],
            'effectdecs' => $modeldruglevel['DDI_Effect_decs'],
            'DDI_instruction' => $modeldruglevel['DDI_instruction'],
        );
        return json_encode($arr);
    }

    function actionDeletedrug() {
        $DDI_id = $_POST['id'];
        Yii::$app->db->createCommand('CALL cmd_ddi_delete(:DDI_id);')
                        ->bindParam(':DDI_id', $DDI_id)
                        ->execute();
//        $key = $_POST['id'];
//        $sql = "DELETE FROM tb_druginteraction WHERE DDI_id = $key";
//        $query = Yii::$app->db->createCommand($sql)->execute();
    }

}
