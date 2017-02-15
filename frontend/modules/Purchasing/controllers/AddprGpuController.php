<?php

namespace app\modules\Purchasing\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
#model
use app\modules\Purchasing\models\TbPr2TempSearch;
use app\modules\Purchasing\models\VwPr2Header2;
use app\modules\Purchasing\models\TbPr2Temp;
use app\modules\Purchasing\models\TbPr2Search;
use app\modules\Purchasing\models\Tbpritemdetail2tempSearch;
use app\modules\Purchasing\models\Tbpritemdetail2temp;
use app\models\TbPotype;
use app\modules\Purchasing\models\TbPrReasonselected;
use app\modules\Purchasing\models\TbPrReason;
use app\models\TbSection;
use app\models\TbItempack;
use app\models\TbPackunit;
use app\modules\Purchasing\models\VwPo2SubPohistory;
use app\modules\Purchasing\models\VwPricelistGpu;
use app\modules\Purchasing\models\VwItemListGpuplanAvalible;
use app\modules\Purchasing\models\VwPritemdetail2Temp;
use app\modules\Inventory\models\VwGpuplanDetailAvalible;
use app\modules\Inventory\models\VwItempackGpu;
use app\models\VwItemListGpu;
use app\modules\Purchasing\models\TbPr2;
use app\modules\Purchasing\models\TbPritemdetail2;
use app\modules\Inventory\models\VwItempack;
use app\modules\Purchasing\models\VwPritemdetail2;
use app\modules\Purchasing\models\TbPritemdetail2Search;
use app\modules\Purchasing\models\VwPurchasingplanStatus;
use app\modules\Purchasing\models\VwPurchasingPricelistSearch;
use app\modules\Purchasing\models\VwPurchasingHistorySearch;
use app\modules\Purchasing\models\VwGpustdCost;
use app\modules\Purchasing\models\VwPurchasingplanStatusSearch;
use app\modules\Purchasing\models\VwPurchasingplanStatus2Search;
use app\modules\Purchasing\models\VwStkStatusSearch;
use app\modules\Purchasing\models\VwQuPricelistSearch;

class AddprGpuController extends Controller {

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

    public function actionDashboard() {
        $request = Yii::$app->request;
        $post = $request->post();
        $searchModel = new VwPurchasingplanStatusSearch();

        $dataProvider = $searchModel->searchAll(Yii::$app->request->post());
        $dataProvider->pagination->pageSize = 100;
        return $this->render('dashboard', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $query['PRID']],
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
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':PRID' => $query['PRID']],
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

#

    public function actionIndex() {
        $searchModel = new TbPr2TempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        TbPr2Temp::deleteAll(['PRNum' => '', 'PRCreatedBy' => \Yii::$app->user->getId()]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('detail-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchDetailApprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('detail-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrreport() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $model->PRNum . '.pdf',
            'content' => $this->renderPartial('prreport', ['model' => $model]),
            'options' => [
                'title' => $model->PRNum . '.pdf',
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
            ],
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => FALSE,
        ]]);

        return $pdf->render();
    }

    public function actionPrreport2() {
        $PRID = Yii::$app->request->get('PRID');
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
        $pdf = new Pdf(['mode' => Pdf::MODE_UTF8,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => $model->PRNum . '.pdf',
            'content' => $this->renderPartial('prreport2', ['model' => $model]),
            'options' => [
                'title' => $model->PRNum . '.pdf',
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
        $model = VwPr2Header2::findOne(['PRID' => $PRID]);
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

    public function actionListApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchListApprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListWatingApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchListWaitingApprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-wating-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchListVerify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectVerify() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchListRejectVerify(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-reject-verify', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListRejectApprove() {
        $searchModel = new TbPr2Search();
        $dataProvider = $searchModel->SearchListRejectApprove(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('list-reject-approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($ids_PR_selected, $PRID, $view) {
        $post = Yii::$app->request->post();
        if (empty($PRID)) {
            $model = TbPr2Temp::findOne(['ids_PR_selected' => $ids_PR_selected]);
            $PRID = $model['PRID'];
            $modelPR = $this->findModel($PRID);
            $section = ArrayHelper::map($this->getDepartment($model->DepartmentID), 'id', 'name');
        } else {
            $modelPR = $this->findModel($PRID);
            $section = ArrayHelper::map($this->getDepartment($modelPR->DepartmentID), 'id', 'name');
        }

        if ($modelPR->load($post)) {
            $PRExtendedCost = Tbpritemdetail2temp::find()
                    ->where(['PRID' => $post['TbPr2Temp']['PRID']])
                    ->sum('PRExtendedCost');

            $POPriceLimit = TbPotype::find()
                    ->where(['POTypeID' => $post['TbPr2Temp']['POTypeID']])
                    ->sum('POPriceLimit');

            if ((!empty($PRExtendedCost)) && (!empty($POPriceLimit)) && ($PRExtendedCost > $POPriceLimit)) {
                return '1';
            } else {
                $PRID = empty($post['TbPr2Temp']['PRID']) ? '' : $post['TbPr2Temp']['PRID'];
                $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbPr2Temp']['PRDate']);
                $PRTypeID = 1;
                $PRStatusID = 1;
                $DepartmentID = empty($post['TbPr2Temp']['DepartmentID']) ? null : $post['TbPr2Temp']['DepartmentID'];
                $SectionID = empty($post['TbPr2Temp']['SectionID']) ? null : $post['TbPr2Temp']['SectionID'];
                $PRNum = empty($post['TbPr2Temp']['PRNum']) ? null : $post['TbPr2Temp']['PRNum'];
                $POTypeID = empty($post['TbPr2Temp']['POTypeID']) ? null : $post['TbPr2Temp']['POTypeID'];
                $PRReasonNote = empty($post['TbPr2Temp']['PRReasonNote']) ? null : $post['TbPr2Temp']['PRReasonNote'];
                $PRExpectDate = empty($post['TbPr2Temp']['PRExpectDate']) ? null : $post['TbPr2Temp']['PRExpectDate'];
                $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                $PRbudgetID = empty($post['TbPr2Temp']['PRbudgetID']) ? null : $post['TbPr2Temp']['PRbudgetID'];
                Yii::$app->db->createCommand('CALL cmd_pr2_savedraft(:PRDate,:PRTypeID,:PRStatusID,:DepartmentID,:SectionID,:POTypeID,:PRID,:PRReasonNote,:PRExpectDate,:PRCreatedBy,:PRbudgetID,:PRNum,:PRTotal);')
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
                        ->bindParam(':PRNum', $PRNum)
                        ->bindParam(':PRTotal', $PRExtendedCost)
                        ->execute();
                echo 'success';
            }
        } else {
            $searchModel = new Tbpritemdetail2tempSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $PRID);
            $dataProvider->pagination->pageSize = 10;

            $reason = $this->getReasonPR($PRID);

            return $this->render('create', [
                        'modelPR' => $modelPR,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'section' => $section,
                        'view' => $view,
                        'reason' => $reason,
            ]);
        }
    }

    private function getReasonPR($id) {
        $queryReason = TbPrReason::find()->where(['PRTypeID' => '1'])->orderBy('ids ASC')->all();
        $no = 1;
        $html = '<div>';
        foreach ($queryReason as $reason) {
            $ReasonSelected = TbPrReasonselected::find()->where(['PRreasonID' => $reason['ids'], 'PRID' => $id])->all();
            if (empty($ReasonSelected)) {
                $html .= '<div class="checkbox">'
                        . '<label><input type="checkbox"  name="PRReason' . $reason['PRReason'] . '" id="PRReason' . $reason['PRReason'] . '" value="' . $reason['ids'] . '" />';
                $html .= '<span class="text">' . $no . '.' . $reason['PRReason'] . '</span>'
                        . '</label>'
                        . '</div>';
                $no++;
            } else {
                $html .= '<div class="checkbox">'
                        . '<label><input type="checkbox" checked="checked" name="PRReason' . $reason['PRReason'] . '" id="PRReason' . $reason['PRReason'] . '" value="' . $reason['ids'] . '" />';
                $html .= '<span class="text">' . $no . '.' . $reason['PRReason'] . '</span>'
                        . '</label>'
                        . '</div>';
                $no++;
            }
        }
        $html .= '</div>';

        return $html;
    }

    public function actionChildDepartment() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = TbSection::find()->andWhere(['DepartmentID' => $id])->asArray()->all();
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

    public function actionViewDetailgpu() {
        if (isset($_POST['expandRowKey'])) {
            $id = $_POST['expandRowKey'];

            $model = Tbpritemdetail2temp::findOne($id);
            $packunit = TbItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $pack = TbPackunit::findOne($packunit['ItemPackUnit']);

            $records = VwPo2SubPohistory::find()->where(['TMTID_GPU' => $model['TMTID_GPU']])->all();
            $querygpu = VwPricelistGpu::find()->where(['TMTID_GPU' => $model['TMTID_GPU']])->all();

            $searchModel = new Tbpritemdetail2tempSearch();
            $dataProvider = $searchModel->searchdetailgpu(Yii::$app->request->queryParams, $id);
            $dataProvider->pagination->pageSize = 10;

            return Yii::$app->controller->renderPartial('viewdetailgpu', [
                        'model1' => $model,
                        'packunit' => $packunit,
                        'pack' => $pack,
                        'records' => $records,
                        'dataProvider' => $dataProvider,
                        'querygpu' => $querygpu,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    function actionGetdatagpu() {
        $Productmodel = VwItemListGpuplanAvalible::find()->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" style="width: 100%;" id="getdatagputable">
                            <thead class="bordered-success ">
                                <tr role="row">
                                   <th width="20px" style="text-align: center;">#</th>
                                    <th  style="text-align: center;" width="100px">รหัสยาสามัญ</th>
                                    <th  style="text-align: center;" >รายละเอียดยาสามัญ</th>
                                    <th  style="text-align: center;" width="120px">เลขที่แผนจัดซื้อ</th>
                                    <th  style="text-align: center;">จำนวน</th>
                                    <th  style="text-align: center;">หน่วย</th>
                                    <th  style="text-align: center;" width="90px">ขอซื้อแล้ว</th>
                                    <th  style="text-align: center;" width="90px">ขอซื้อได้</th>
                                    <th  style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .= '<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PCPlanNum'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['GPUOrderQty'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PRApprovedOrderQty'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['PRGPUAvalible'] . '</td>';
            $htl .= '<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(this);" data-id="' . $result->PCPlanNum . '" id="' . $result->TMTID_GPU . '"> Select</a></td>';
            $htl .= '</tr>';
            $no++;
        }
        $htl .= '</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }

    public function actionUpdateDetailgpu($id) {
        $modeledit = VwPritemdetail2Temp::findOne(['ids' => $id]);

        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['PackChin'] == 0) {
                $PackID = NULL;
            } else {
                $findpackid = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']]);
                $PackID = $findpackid['ItemPackID'];
            }
            $cmd = $_POST['cmd'];
            $PCPlanNum1 = (!empty($_POST['VwPritemdetail2Temp']['PCPlanNum']) ? $_POST['VwPritemdetail2Temp']['PCPlanNum'] : NULL);
            $ItemID = NULL;
            $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
            $TMTID_TPU = NULL;
            $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
            $PRItemStdCost = $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemStdCost']);
            $PRItemUnitCost = $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemUnitCost']);
            $PRItemOrderQty = $_POST['VwPritemdetail2Temp']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemOrderQty']);
            $PRApprovedOrderQtySum = $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum']);
            $PRItemAvalible = $_POST['VwPritemdetail2Temp']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemAvalible']);
            $PRUnitCost = $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
            $PROrderQty = $_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
            $PRExtendedCost = $_POST['VwPritemdetail2Temp']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
            $PRPackQty = $_POST['VwPritemdetail2Temp']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
            $ItemPackID = $PackID;
            $ItemPackCost = $_POST['VwPritemdetail2Temp']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
            $ids_PR_selected = (!empty($_POST['VwPritemdetail2Temp']['ids_PR_selected']) ? $_POST['VwPritemdetail2Temp']['ids_PR_selected'] : NULL);
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
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost,:PRItemOnPCPlan
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
                            ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
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
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost,:PRItemOnPCPlan
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
                        ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
                        ->execute();
                echo '1';
            }
        } else {
            $datagpu = VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
            $itempack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);
            $qty = VwItempackGpu::findOne(['ItemPackID' => $modeledit['ItemPackID']]);

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
                $pack = '';
            } else {
                foreach ($itempack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            }

            return $this->renderAjax('_update-detailgpu', [
                        'modeledit' => $modeledit,
                        'PCPlanNum' => $PCPlanNum,
                        'pack' => $pack,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'ItemName' => $modeledit['ItemName'],
                        'btn' => '',
                        'DispUnit' => $qty['DispUnit'],
                        'PackUnit' => $qty['ItemPackUnit'],
            ]);
        }
    }

    public function actionDeleteDetailgpu() {
        $delete = Tbpritemdetail2temp::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionGetQtygpu() {
        $qty = TbItempack::findOne([
                    'TMTID_GPU' => $_POST['TMTID_GPU'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 4),
                // /'qty' => number_format($_POST['qty'], 2),
        );
        return json_encode($arr);
    }

    public function actionGetdataPcplangpu() {
        $finddata = VwGpuplanDetailAvalible::findOne(['TMTID_GPU' => $_POST['TMTID_GPU'], 'PCPlanNum' => $_POST['PCPlanNum']]);

        $arr = array(
            'FSN_GPU' => $finddata['FSN_GPU'],
            'GPUStdCost' => number_format($finddata['GPUStdCost'], 4),
            'GPUUnitCost' => number_format($finddata['GPUUnitCost'], 4),
            'GPUOrderQty' => number_format($finddata['GPUOrderQty'], 4),
            'PRApprovedOrderQty' => number_format($finddata['PRApprovedOrderQty'], 4),
            'PRGPUAvalible' => number_format($finddata['PRGPUAvalible'], 4),
        );
        return json_encode($arr);
    }

    public function actionNewDetailgpu() {
        $modeledit = new VwPritemdetail2Temp();

        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 || $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0) {
                return 0;
            } else {
                if ($modeledit->validate()) {
                    if ($_POST['PackChin'] == 0) {
                        $PackID = NULL;
                    } else {
                        $findpackid = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2Temp']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2Temp']['ItemPackID']]);
                        $PackID = $findpackid['ItemPackID'];
                    }
                    $cmd = $_POST['cmd'];
                    $PCPlanNum1 = (!empty($_POST['VwPritemdetail2Temp']['PCPlanNum']) ? $_POST['VwPritemdetail2Temp']['PCPlanNum'] : NULL);
                    $ItemID = NULL;
                    $TMTID_GPU = $_POST['VwPritemdetail2Temp']['TMTID_GPU'];
                    $TMTID_TPU = NULL;
                    $ItemName = $_POST['VwPritemdetail2Temp']['ItemName'];
                    $PRItemStdCost = $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemStdCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemStdCost']);
                    $PRItemUnitCost = $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == 0 || $_POST['VwPritemdetail2Temp']['PRItemUnitCost'] == NULL ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemUnitCost']);
                    $PRItemOrderQty = $_POST['VwPritemdetail2Temp']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemOrderQty']);
                    $PRApprovedOrderQtySum = $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRApprovedOrderQtySum']);
                    $PRItemAvalible = $_POST['VwPritemdetail2Temp']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRItemAvalible']);
                    $PRUnitCost = $_POST['VwPritemdetail2Temp']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRUnitCost']);
                    $PROrderQty = $_POST['VwPritemdetail2Temp']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PROrderQty']);
                    $PRExtendedCost = $_POST['VwPritemdetail2Temp']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRExtendedCost']);
                    $PRPackQty = $_POST['VwPritemdetail2Temp']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['PRPackQty']);
                    $ItemPackID = $PackID;
                    $ItemPackCost = $_POST['VwPritemdetail2Temp']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2Temp']['ItemPackCost']);
                    $ids_PR_selected = (!empty($_POST['VwPritemdetail2Temp']['ids_PR_selected']) ? $_POST['VwPritemdetail2Temp']['ids_PR_selected'] : NULL);
                    $PRID = $_POST['VwPritemdetail2Temp']['PRID'];
                    $ids = $_POST['VwPritemdetail2Temp']['ids'];
                    $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                    $PRItemOnPCPlan = null;
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
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost,:PRItemOnPCPlan
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
                                    ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
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
                    :PRID,:ids,:PRCreatedBy,:PRLastUnitCost,:PRItemOnPCPlan
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
                                ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
                                ->execute();
                        echo '1';
                    }
                } else {
                    $modeledit->errors;
                }
            }
        } else {
            if ($_POST['plan'] == '' || empty($_POST['plan'])) {
                $check = Tbpritemdetail2temp::findAll(['TMTID_GPU' => $_POST['id'], 'PRID' => $_POST['PRID']]);
            } else {
                $check = Tbpritemdetail2temp::findAll(['TMTID_GPU' => $_POST['id'], 'PRID' => $_POST['PRID'], 'PCPlanNum' => $_POST['plan']]);
            }

            if (!empty($check)) {
                return 'false';
            } else {
                #get FSN_GPU on TbGenericproductuseGpu
                $Item = VwItemListGpu::findOne(['TMTID_GPU' => $_POST['id']]);
                $modeledit['ItemName'] = $Item['FSN_GPU'];

                #check Plan on VwGpuplanDetailAvalible
                $datagpu = VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $_POST['id']]);
                if (empty($datagpu)) {
                    $PCPlanNum = '';
                } else {
                    foreach ($datagpu as $data) {
                        $PCPlanNum[] = $data['PCPlanNum'];
                    }
                }

                #checkpack on tb_itempack
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $_POST['id']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $btn = '';
                } else {
                    $pack = '';
                    $btn = '';
                }
                return $this->renderAjax('_update-detailgpu', [
                            'modeledit' => $modeledit,
                            'PCPlanNum' => $PCPlanNum,
                            'pack' => $pack,
                            'ItemName' => $modeledit['ItemName'],
                            'ItemPackSKUQty' => '',
                            'btn' => $btn,
                            'DispUnit' => $Item['DispUnit'],
                            'PackUnit' => ''
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
        return $this->redirect('index');
    }

    public function actionCreatepridTemp() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $max = TbPr2::find()->max('PRID');
        $maxTemp = TbPr2Temp::find()->max('PRID');
        if ($max > $maxTemp) {
            $max = $max + 1;
        } elseif ($max < $maxTemp) {
            $max = $maxTemp + 1;
        } else {
            $max = $max + 1;
        }
        $PRTypeID = 1;
        $DepartmentID = '1';
        $SectionID = '1';
        $POTypeID = '';
        Yii::$app->db->createCommand('CALL cmd_pr2_create_PR(:x,:PRID,:PRTypeID,:DepartmentID,:SectionID,:POTypeID);')
                ->bindParam(':x', $userid)
                ->bindParam(':PRID', $max)
                ->bindParam(':PRTypeID', $PRTypeID)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':POTypeID', $POTypeID)
                ->execute();
        $modelPR = $this->findModel($max);
        $encode = base64_encode($max);
        return $this->redirect(['create', 'ids_PR_selected' => '', 'PRID' => $modelPR->PRID, 'view' => $encode]);
    }

    public function actionGetReasongpu() {
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

    public function actionSaveReason() {
        $PRID = $_POST['PRID'];
        $PRreasonIDStatus = '1';
        $find = TbPrReasonselected::findOne(['PRID' => $PRID]);
        if (!empty($find)) {
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

    public function actionDeleteTempgpu() {
        $id = $_POST['id'];
        $delete = TbPr2Temp::findOne($id);
        $delete->delete();
        $sql = "DELETE FROM tb_pritemdetail2_temp WHERE PRID = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionUpdateDetailVerify($id, $view) {
        $modelPR2 = TbPr2::findOne($id);
        $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
        $searchModel = new TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 10;
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

    public function actionUpdateDetailApprove($id, $view) {
        $modelPR2 = TbPr2::findOne($id);
        $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');

        $searchModel = new TbPritemdetail2Search();
        $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
        $dataProvider->pagination->pageSize = 10;

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

    public function actionViewDetailVerify($view) {
        if (isset($_POST['expandRowKey'])) {
            $model = TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = VwItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $packverify = VwItempack::findOne(['ItemPackID' => $model['ItemPackIDVerify']]);

            return $this->renderPartial('view_detail_verify', [
                        'model' => $model,
                        'packunit' => $packunit,
                        'view' => $view,
                        'packverify' => $packverify,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionViewDetailApprove() {
        if (isset($_POST['expandRowKey'])) {
            $model = TbPritemdetail2::findOne($_POST['expandRowKey']);
            $packunit = VwItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $packverify = VwItempack::findOne(['ItemPackID' => $model['ItemPackIDVerify']]);

            return $this->renderPartial('view_detail_approve', [
                        'model' => $model,
                        'packunit' => $packunit,
                        'packverify' => $packverify,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionUpdateVerify($id) {

        $modeledit = VwPritemdetail2::findOne(['ids' => $id]);
        $modelverify = TbPritemdetail2::findOne(['ids' => $id]);
        if (Yii::$app->request->post()) {
            if ($modelverify->validate()) {
                if ($_POST['PackChin'] == 0) {
                    $PackID = NULL;
                } else {
                    $findpackid = TbItempack::findOne([
                                'TMTID_GPU' => $_POST['VwPritemdetail2']['TMTID_GPU'],
                                'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID'],
                    ]);
                    $PackID = $findpackid['ItemPackID'];
                }
                $PCPlanNum1 = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : NULL);
                $PRItemAvalible = empty($_POST['VwPritemdetail2']['PRItemAvalible']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
                $PROrderQty = empty($_POST['VwPritemdetail2']['PROrderQty']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $PRItemUnitCost = empty($_POST['VwPritemdetail2']['PRItemUnitCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
                $PRUnitCost = empty($_POST['VwPritemdetail2']['PRUnitCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $PRItemStdCost = empty($_POST['VwPritemdetail2']['PRItemStdCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
                $PRExtendedCost = empty($_POST['VwPritemdetail2']['PRExtendedCost']) ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
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
                        $modelverify->PRExtendedCost = $PRExtendedCost;
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
                    $modelverify->PRExtendedCost = $PRExtendedCost;
                    $modelverify->save();
                    echo '1';
                }
            }
        } else {

            if (!empty($modelverify->PRPackQtyVerify) || !empty($modelverify->PRVerifyUnitCost)) {
                $qty = VwItempackGpu::findOne(['ItemPackID' => $modelverify['ItemPackIDVerify']]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);

                if (!empty($checkpack)) {
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
                            'ItemPackID' => $qty['ItemPackUnit']
                ]);
            } else {
                $qty = VwItempackGpu::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);

                if (!empty($checkpack)) {
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
                            'ItemPackID' => $qty['ItemPackUnit']
                ]);
            }
        }
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
            'title' => Yii::t('app', Html::encode(Yii::$app->user->identity->profile->VenderName)),
            'message' => Yii::t('app', Html::encode('Rejected' . ' ' . $_POST['PRNum'] . ' ' . 'Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('/Purchasing/addpr-gpu/detail-verify');
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
        return $this->redirect('index.php?r=Purchasing/addpr-gpu/detail-approve');
    }

    public function actionSavedraftVerify() {
        $PRID = $_POST['PRID'];
        $PRVerifyNote = $_POST['PRVerifyNote'];
        $PRbudgetID = $_POST['PRbudgetID'];
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

    public function actionDeleteDetailVerify() {
        $delete = TbPritemdetail2::findOne($_POST['id']);
        $delete->delete();
    }

    public function actionClearGpu() {
        $PRID = $_POST['PRID'];
        $sql = "
                DELETE FROM tb_pr2_temp WHERE PRID = $PRID;
                DELETE FROM tb_pr_reasonselected WHERE PRID = $PRID;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect('index.php?r=Purchasing/addpr-gpu/index');
    }

    public function actionUploadajax() {
// upload.php
// 'images' refers to your file input name attribute
        if (empty($_FILES['images'])) {
            echo json_encode(['error' => 'No files found for upload.']);
// or you can throw an exception 
            return; // terminate
        }

// get the files posted
        $images = $_FILES['images'];

// get user id posted
//$userid = empty($_POST['userid']) ? '' : $_POST['userid'];
// get user name posted
//$username = empty($_POST['username']) ? '' : $_POST['username'];
// a flag to see if everything is ok
        $success = null;

// file paths to store
        $paths = [];

// get file names
        $filenames = $images['name'];

// loop and process files
        for ($i = 0; $i < count($filenames); $i++) {
            $ext = explode('.', basename($filenames[$i]));
            $target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
            if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                $success = true;
                $paths[] = $target;
            } else {
                $success = false;
                break;
            }
        }

// check and process based on successful status 
        if ($success === true) {
// call the function to save all data to database
// code for the following function `save_data` is not 
// mentioned in this example
//save_data($userid, $username, $paths);
            save_data($paths);

// store a successful response (default at least an empty array). You
// could return any additional response info you need to the plugin for
// advanced implementations.
            $output = [];
// for example you can get the list of files uploaded this way
// $output = ['uploaded' => $paths];
        } elseif ($success === false) {
            $output = ['error' => 'Error while uploading images. Contact the system administrator'];
// delete any uploaded files
            foreach ($paths as $file) {
                unlink($file);
            }
        } else {
            $output = ['error' => 'No files were processed.'];
        }

// return a json encoded response for plugin to process successfully
        echo json_encode($output);
    }

    protected function sendMail($name, $mail) {
        Yii::$app->mailer->compose('@app/mail/layouts/register', [
                    'fullname' => $name,
                ])
                ->setFrom(['m-606jrp@hotmail.com' => 'Andaman Pattana'])
                ->setTo($mail)
                ->setSubject('รายการสั่งซื้อ')
                ->attach(Yii::getAlias('@webroot') . '/uploads/' . 'Order.pdf')
//->attach(Yii::getAlias('@webroot').'/attach/'.'Poster.pdf')
                ->send();
    }

    /* |*********************************************************************************|
      |================================ Resend Reject Verify ===========================|
      |*********************************************************************************| */

    public function actionUpdateResendVerify($id, $view) {

        $modelPR2 = TbPr2::findOne($id);
        if ($modelPR2->load(Yii::$app->request->post())) {

            $query = TbPritemdetail2::find();
            $query->where(['PRID' => $_POST['TbPr2']['PRID']]);
            $cost = $query->sum('PRExtendedCost');

            $query1 = TbPotype::find();
            $query1->where(['POTypeID' => $_POST['TbPr2']['POTypeID']]);
            $cost1 = $query1->sum('POPriceLimit');

            if (empty($cost1)) {
                $PRID = $_POST['TbPr2']['PRID'];
                $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPr2']['PRDate']);
                $PRTypeID = 1;
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
                if ($cost > $cost1) {
                    return "1";
                } else {
                    $PRID = $_POST['TbPr2']['PRID'];
                    $PRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbPr2']['PRDate']);
                    $PRTypeID = 1;
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
                }
            }
        } else {
            $section = ArrayHelper::map($this->getDepartment($modelPR2->DepartmentID), 'id', 'name');
            $searchModel = new TbPritemdetail2Search();
            $dataProvider = $searchModel->SearchDetailVerify(Yii::$app->request->queryParams, $id);
            $dataProvider->pagination->pageSize = 10;

            $Reason = TbPrReasonselected::find()->where(['PRID' => $modelPR2['PRID']])->all();

            if (empty($Reason)) {
                $ids = [];
                $modelcheck1 = TbPrReason::find()->where(['PRTypeID' => 1])->all();
            } else {

                foreach ($Reason as $data) {
                    $ids[] = $data['PRreasonID'];
                }
                $modelcheck1 = TbPrReason::find()
                        ->where(['NOT IN', 'ids', $ids])
                        ->andWhere('PRTypeID = :prtypeid', [':prtypeid' => 1])
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

    public function actionViewDetailgpuReject() {
        if (isset($_POST['expandRowKey'])) {
            $id = $_POST['expandRowKey'];
            $model = TbPritemdetail2::findOne($id);
            $packunit = TbItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            $pack = TbPackunit::findOne($packunit['ItemPackUnit']);

            $records = VwPo2SubPohistory::find()->where(['TMTID_GPU' => $model['TMTID_GPU']])->all();
            $querygpu = VwPricelistGpu::find()->where(['TMTID_GPU' => $model['TMTID_GPU']])->all();

            return Yii::$app->controller->renderPartial('viewdetailgpu', [
                        'model1' => $model,
                        'packunit' => $packunit,
                        'pack' => $pack,
                        'records' => $records,
                        'querygpu' => $querygpu,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionUpdateVerifyReject($id) {

        $modeledit = VwPritemdetail2::findOne(['ids' => $id]);
        if (Yii::$app->request->post()) {

            if ($_POST['PackChin'] == 0) {
                $PackID = NULL;
            } else {
                $findpackid = TbItempack::findOne([
                            'TMTID_GPU' => $_POST['VwPritemdetail2']['TMTID_GPU'],
                            'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID'],
                ]);
                $PackID = $findpackid['ItemPackID'];
            }

            $PCPlanNum1 = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : NULL);
            $PRItemAvalible = str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
            $PROrderQty = str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
            $PRItemUnitCost = str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
            $PRUnitCost = str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
            $PRItemStdCost = str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);

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
                    $ids = $_POST['VwPritemdetail2']['ids'];
                    $PCPlanNum = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : NULL);
                    $ItemID = NULL;
                    $TMTID_GPU = $_POST['VwPritemdetail2']['TMTID_GPU'] == NULL ? NULL : $_POST['VwPritemdetail2']['TMTID_GPU'];
                    $TMTID_TPU = NULL;
                    $ItemName = $_POST['VwPritemdetail2']['ItemName'];
                    $PRItemStdCost = $_POST['VwPritemdetail2']['PRItemStdCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
                    $PRItemUnitCost = $_POST['VwPritemdetail2']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
                    $PRItemOrderQty = $_POST['VwPritemdetail2']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemOrderQty']);
                    $PRApprovedOrderQtySum = $_POST['VwPritemdetail2']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRApprovedOrderQtySum']);
                    $PRItemAvalible = $_POST['VwPritemdetail2']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
                    $PRLastUnitCost = $_POST['VwPritemdetail2']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRLastUnitCost']);
                    $PRPackQty = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                    $ItemPackID = $PackID;
                    $ItemPackCost = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                    $PROrderQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                    $PRUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                    $PRExtendedCost = $_POST['VwPritemdetail2']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
                    $PRID = $_POST['VwPritemdetail2']['PRID'];
                    $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                    $data = Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
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
                $ids = $_POST['VwPritemdetail2']['ids'];
                $PCPlanNum = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : NULL);
                $ItemID = NULL;
                $TMTID_GPU = $_POST['VwPritemdetail2']['TMTID_GPU'] == NULL ? NULL : $_POST['VwPritemdetail2']['TMTID_GPU'];
                $TMTID_TPU = NULL;
                $ItemName = $_POST['VwPritemdetail2']['ItemName'];
                $PRItemStdCost = $_POST['VwPritemdetail2']['PRItemStdCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
                $PRItemUnitCost = $_POST['VwPritemdetail2']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
                $PRItemOrderQty = $_POST['VwPritemdetail2']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemOrderQty']);
                $PRApprovedOrderQtySum = $_POST['VwPritemdetail2']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRApprovedOrderQtySum']);
                $PRItemAvalible = $_POST['VwPritemdetail2']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
                $PRLastUnitCost = $_POST['VwPritemdetail2']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRLastUnitCost']);
                $PRPackQty = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                $ItemPackID = $PackID;
                $ItemPackCost = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $PROrderQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $PRUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $PRExtendedCost = $_POST['VwPritemdetail2']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
                $PRID = $_POST['VwPritemdetail2']['PRID'];
                $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                $data = Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
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
            $datagpu = VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);

            #GetPCPlan
            if (empty($datagpu)) {
                $PCPlanNum = '';
            } else {
                foreach ($datagpu as $data) {
                    $PCPlanNum[] = $data['PCPlanNum'];
                }
            }

            $qty = VwItempack::findOne(['ItemPackID' => $modeledit['ItemPackID']]);
            $checkpack = TbItempack::findAll(['TMTID_GPU' => $modeledit['TMTID_GPU']]);

            if (!empty($checkpack)) {
                foreach ($checkpack as $data) {
                    $pack[] = $data['ItemPackUnit'];
                }
            } else {
                $pack = '';
            }

            return $this->renderAjax('_form_update_reject', [
                        'modeledit' => $modeledit,
                        'pack' => $pack,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PRPackQty' => $modeledit['PRPackQty'],
                        'ItemPackCost' => $modeledit['ItemPackCost'],
                        'PROrderQty' => $modeledit['PROrderQty'],
                        'PRUnitCost' => $modeledit['PRUnitCost'],
                        'ItemPackID' => $qty['ItemPackUnit'],
                        'PCPlanNum' => $PCPlanNum,
                        'DispUnit' => $qty['DispUnit'],
                        'ItemName' => $modeledit['ItemName']
            ]);
        }
    }

    public function actionNewDetailgpuReject() {
        $modeledit = new VwPritemdetail2();
        if ($modeledit->load(Yii::$app->request->post())) {
            if ($_POST['VwPritemdetail2']['PROrderQty'] == 0 || $_POST['VwPritemdetail2']['PRUnitCost'] == 0) {
                return 0;
            } else {
                if ($_POST['PackChin'] == 0) {
                    $PackID = NULL;
                } else {
                    $findpackid = TbItempack::findOne(['TMTID_GPU' => $_POST['VwPritemdetail2']['TMTID_GPU'], 'ItemPackUnit' => $_POST['VwPritemdetail2']['ItemPackID']]);
                    $PackID = $findpackid['ItemPackID'];
                }
                $ids = $_POST['VwPritemdetail2']['ids'];
                $PCPlanNum = (!empty($_POST['VwPritemdetail2']['PCPlanNum']) ? $_POST['VwPritemdetail2']['PCPlanNum'] : NULL);
                $ItemID = NULL;
                $TMTID_GPU = $_POST['VwPritemdetail2']['TMTID_GPU'] == NULL ? NULL : $_POST['VwPritemdetail2']['TMTID_GPU'];
                $TMTID_TPU = NULL;
                $ItemName = $_POST['VwPritemdetail2']['ItemName'];
                $PRItemStdCost = $_POST['VwPritemdetail2']['PRItemStdCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemStdCost']);
                $PRItemUnitCost = $_POST['VwPritemdetail2']['PRItemUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemUnitCost']);
                $PRItemOrderQty = $_POST['VwPritemdetail2']['PRItemOrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemOrderQty']);
                $PRApprovedOrderQtySum = $_POST['VwPritemdetail2']['PRApprovedOrderQtySum'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRApprovedOrderQtySum']);
                $PRItemAvalible = $_POST['VwPritemdetail2']['PRItemAvalible'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRItemAvalible']);
                $PRLastUnitCost = $_POST['VwPritemdetail2']['PRLastUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRLastUnitCost']);
                $PRPackQty = $_POST['VwPritemdetail2']['PRPackQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRPackQty']);
                $ItemPackID = $PackID;
                $ItemPackCost = $_POST['VwPritemdetail2']['ItemPackCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['ItemPackCost']);
                $PROrderQty = $_POST['VwPritemdetail2']['PROrderQty'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PROrderQty']);
                $PRUnitCost = $_POST['VwPritemdetail2']['PRUnitCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRUnitCost']);
                $PRExtendedCost = $_POST['VwPritemdetail2']['PRExtendedCost'] == 0 ? NULL : str_replace(',', '', $_POST['VwPritemdetail2']['PRExtendedCost']);
                $PRID = $_POST['VwPritemdetail2']['PRID'];
                $PRCreatedBy = Yii::$app->user->identity->profile->user_id;
                if ($PCPlanNum != null) {
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
                        $data = Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
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
                    $data = Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
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
            $check = TbPritemdetail2::findAll(['TMTID_GPU' => $_POST['id'], 'PRID' => $_POST['PRID']]);

            if (!empty($check)) {
                return 'false';
            } else {
                #get FSN_GPU on TbGenericproductuseGpu
                $Item = VwItemListGpu::findOne(['TMTID_GPU' => $_POST['id']]);
                $ItemName = $Item['FSN_GPU'];
                $DispUnit = $Item['DispUnit'];

                #check Plan on VwGpuplanDetailAvalible
                $datagpu = VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $_POST['id']]);
                if (empty($datagpu)) {
                    $PCPlanNum = '';
                } else {
                    foreach ($datagpu as $data) {
                        $PCPlanNum[] = $data['PCPlanNum'];
                    }
                }

                #checkpack on tb_itempack
                $checkpack = TbItempack::findAll(['TMTID_GPU' => $_POST['id']]);
                if (!empty($checkpack)) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                } else {
                    $pack = '';
                    #$btn = '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>';
                }
                return $this->renderAjax('_form_update_reject', [
                            'modeledit' => $modeledit,
                            'pack' => $pack,
                            'ItemPackSKUQty' => NULL,
                            'PRPackQty' => NULL,
                            'ItemPackCost' => NULL,
                            'PROrderQty' => NULL,
                            'PRUnitCost' => NULL,
                            'ItemPackID' => NULL,
                            'PCPlanNum' => $PCPlanNum,
                            'DispUnit' => $DispUnit,
                            'ItemName' => $ItemName
                ]);
            }
        }
    }

    public function actionDeleteDetailgpureject() {
        $delete = TbPritemdetail2::findOne($_POST['id']);
        $delete->delete();
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

    private function checkOnplanverify($PRItemStdCost, $PRUnitCost, $PRItemUnitCost, $PROrderQty, $PRItemAvalible) {
        if ($PRUnitCost > $PRItemStdCost || $PRUnitCost > $PRItemUnitCost || $PROrderQty > $PRItemAvalible) {
            return '1';
        } else {
            return '2';
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

    public function actionVerifyApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPritemdetail2::find()->where(['PRVerifyQty' => null, 'PRID' => $request->post('PRID')])->all()) != null) {
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
            return $this->redirect('detail-verify');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
