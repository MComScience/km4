<?php

namespace app\modules\pharmacy\controllers;

use Yii;
use app\modules\pharmacy\models\TbCpoe;
use app\modules\pharmacy\models\TbCpoeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
#models
use app\modules\pharmacy\models\VwCpoeRxHeader;
use app\modules\pharmacy\models\VwPtAr;
use app\modules\pharmacy\models\VwCpoeRxDetail2Search;
use app\modules\pharmacy\models\VwPtServiceListOp;
use app\modules\pharmacy\models\TbCpoeDetail;

/**
 * RxIssueController implements the CRUD actions for TbCpoe model.
 */
class RxIssueController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TbCpoe models.
     * @return mixed
     */
    public function actionIndex() {
        $model = VwCpoeRxHeader::find()->where(['cpoe_status' => 2])->all();
        /*
          $searchModel = new TbCpoeSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         */
        return $this->render('index', [
                    'model' => $model,
                        /* 'searchModel' => $searchModel,
                          'dataProvider' => $dataProvider, */
        ]);
    }

    public function actionVerifyList() {
        $model = VwCpoeRxHeader::find()->where(['cpoe_status' => 2])->all();
        $action = 'verify-list';
        $title = 'ใบสั่งยารอจัดยา';
        return $this->render('index', [
                    'model' => $model,
                    'action' => $action,
                    'title' => $title,
        ]);
    }

    public function actionCheckList() {
        $model = VwCpoeRxHeader::find()->where(['cpoe_status' => 2])->all();
        $action = 'check-list';
        $title = 'ใบสั่งยารอตรวจสอบ';
        return $this->render('index', [
                    'model' => $model,
                    'action' => $action,
                    'title' => $title,
        ]);
    }

    public function actionIssueList() {
        $model = VwCpoeRxHeader::find()->where(['cpoe_status' => 2])->all();
        $action = 'issue-list';
        $title = 'ใบสั่งยารอจ่ายยา';
        return $this->render('index', [
                    'model' => $model,
                    'action' => $action,
                    'title' => $title,
        ]);
    }

    public function actionVerify($id) {
        $modelCpoe = $this->findModel($id);
        if (($header = VwCpoeRxHeader::findOne($id)) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
            $searchModel = new VwCpoeRxDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $count = $dataProvider->getTotalCount();
            return $this->render('verify', [
                        'ptar' => $ptar,
                        'modelCpoe' => $modelCpoe,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'header' => $header,
                        'count' => $count,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCheck($id) {
        $modelCpoe = $this->findModel($id);
        if (($header = VwCpoeRxHeader::findOne($id)) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
            $searchModel = new VwCpoeRxDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $count = $dataProvider->getTotalCount();
            return $this->render('check', [
                        'ptar' => $ptar,
                        'modelCpoe' => $modelCpoe,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'header' => $header,
                        'count' => $count,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIssue($id) {
        $modelCpoe = $this->findModel($id);
        if (($header = VwCpoeRxHeader::findOne($id)) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
            $searchModel = new VwCpoeRxDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $count = $dataProvider->getTotalCount();
            return $this->render('issue', [
                        'ptar' => $ptar,
                        'modelCpoe' => $modelCpoe,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'header' => $header,
                        'count' => $count,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionArdetail($vn) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = VwPtAr::find()->where(['pt_visit_number' => $request->get('vn')])->all();
                $headerdetail = VwPtServiceListOp::findOne(['pt_visit_number' => $vn]);
                $headermodal = $headerdetail->getHeadermodalOP($request->get('vn'));
                return [
                    'title' => 'สิทธิการรักษา ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_ardetails', [
                        'ardetails' => $ardetails,
                        'profile' => $headerdetail,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionView() {
        $command = (new \yii\db\Query())
                ->select(['ItemID', 'credit_group_id', 'Itemdetail', 'ItemQtyAvalible', 'DispUnit', 'ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt', 'NED_required', 'Jor2_required', 'TMTID_GPU'])
                ->from('vw_cpoe_druglist_op')
                ->where(['IN', 'credit_group_id', 1])
                ->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $htl = '<table class="table table-bordered table-striped table-hover table-condensed" id="tbrxdetails" width="100%">
                            <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>' . Html::encode('รหัสสินค้า') . '</th>
                                        <th>' . Html::encode('รายการ') . '</th>
                                        <th>' . Html::encode('ยอดใช้ได้') . '</th>
                                        <th>' . Html::encode('หน่วย') . '</th>
                                        <th>' . Html::encode('ราคา/หน่วย') . '</th>
                                        <th>' . Html::encode('เบิกได้') . '</th>
                                        <th>' . Html::encode('เบิกไม่ได้') . '</th>
                                        <th>' . Html::encode('Actions') . '</th>
                                    </tr>
                                </thead>
                            <tbody>';
        foreach ($command as $result) {
            $htl .= '<tr id="' . $result['ItemID'] . '">';
            $htl .= '<td style="text-align: center;">' . '<div id="icon' . $result['ItemID'] . $result['credit_group_id'] . '" class="icon select"></div>' . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['Itemdetail'] . '</td>';
            $htl .= '<td style="text-align: center;">' . number_format($result['ItemQtyAvalible'], 2) . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Item_Cr_Amt'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Item_Pay_Amt'] . '</td>';
            $htl .= '<td style="text-align: center;">'
                    .
                    Html::a('Select', FALSE, [
                        'onclick' => 'SelectItemDrug' . '(this)',
                        'class' => 'btn btn-xs btn-success',
                        'data-toggle' => $result['credit_group_id'],
                        'ned' => $result['NED_required'],
                        'gp' => $result['Jor2_required'],
                        'data-id' => $result['TMTID_GPU'],
                        'id' => $result['ItemID'],
                        'detail' => $result['Itemdetail'],
                        'DispUnit' => $result['DispUnit'],
                        'ItemPrice' => $result['ItemPrice'],
                    ])
                    . '</td>';
            $htl .= '</tr>';
        }
        $htl .= '</tr></tbody>
                </table>
            ';
        return $htl;
        /* $view = $this->renderAjax('view', [
          'model' => $this->findModel(Yii::$app->request->post('id')),
          ]);
          return $view; */
    }

    /**
     * Creates a new TbCpoe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbCpoe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cpoe_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbCpoe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cpoe_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbCpoe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbCpoe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbCpoe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbCpoe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOkVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbCpoeDetail::findOne($request->post('id'));
            $model->cpoe_ItemStatus = 2;
            $model->cpoe_verifyby = \Yii::$app->user->getId();
            $model->cpoe_verifydate = date('Y-m-d H:i:s');
            $model->cpoe_adj_note = 'OK';
            $model->save();
            return 'Success';
        }
    }

    public function actionCencelVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbCpoeDetail::findOne($request->post('id'));
            $model->cpoe_ItemStatus = 1;
            $model->cpoe_verifyby = null;
            $model->cpoe_verifydate = '0000-00-00 00:00:00';
            $model->cpoe_adj_note = null;
            $model->cpoe_adj_request = null;
            $model->save();
            return 'Success';
        }
    }

    public function actionVerifyOkAll() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            TbCpoeDetail::updateAll([
                'cpoe_ItemStatus' => 2,
                'cpoe_verifyby' => \Yii::$app->user->getId(),
                'cpoe_verifydate' => date('Y-m-d H:i:s'),
                'cpoe_adj_note' => 'OK',
                    ], 'cpoe_id = :cpoe_id', [':cpoe_id' => $request->post('cpoeid')]);
        }
    }

    public function actionSaveAdjustNote() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbCpoeDetail::findOne($request->post('ids'));
            $model->cpoe_adj_note = $request->post('RequestNote');
            $model->cpoe_adj_request = 'Y';
            $model->save();
            return 'Success';
        }
    }

    public function actionAdjRequestion() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $cpoeid = $request->post('cpoeid');
            $sql = "
                 UPDATE tb_cpoe set
                    tb_cpoe.cpoe_status=6
                    WHERE tb_cpoe.cpoe_id=$cpoeid;

                    UPDATE tb_fi_inv set
                    tb_fi_inv.inv_status=1
                    WHERE tb_fi_inv.cpoe_id=$cpoeid;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
            return 'Success';
        }
    }

    public function actionOrderVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $count = TbCpoeDetail::find()->where(['cpoe_id' => $request->post('cpoeid'), 'cpoe_verifyby' => null])->count('cpoe_ids');
            if ($count > 0) {
                return 'มี ' . $count . ' รายการ ที่ยังไม่ได้ Check!';
            } else {
                $cpoeid = $request->post('cpoeid');
                $userid = \Yii::$app->user->getId();
                $sql = "
                UPDATE tb_cpoe set
                tb_cpoe.cpoe_status=2
                WHERE tb_cpoe.cpoe_id=$cpoeid;

                UPDATE tb_cpoe_detail set
                tb_cpoe_detail.cpoe_ItemStatus=2,
                tb_cpoe_detail.cpoe_verifyby=$userid,
                tb_cpoe_detail.cpoe_verifydate=now()

                WHERE tb_cpoe_detail.cpoe_id=$cpoeid;


                UPDATE tb_fi_inv set
                tb_fi_inv.inv_status=2
                WHERE tb_fi_inv.cpoe_id=$cpoeid;
                 ";
                Yii::$app->db->createCommand($sql)->execute();
                return 'Success';
            }
        }
    }

    public function actionOrderCheck() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $count = TbCpoeDetail::find()->where(['cpoe_id' => $request->post('cpoeid'), 'cpoe_checkby' => null])->count('cpoe_ids');
            if ($count > 0) {
                return 'มี ' . $count . ' รายการ ที่ยังไม่ได้ Check!';
            } else {
                $model = TbCpoe::findOne($request->post('cpoeid'));
                $model->cpoe_status = 7;
                $model->save();
                return 'Success';
            }
        }
    }

    public function actionRxIssue() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $count = TbCpoeDetail::find()->where(['cpoe_id' => $request->post('cpoeid'), 'cpoe_checkby' => null])->count('cpoe_ids');
            if ($count > 0) {
                return 'มี ' . $count . ' รายการ ที่ยังไม่ได้ Check!';
            } else {
                $model = TbCpoe::findOne($request->post('cpoeid'));
                $model->cpoe_status = 7;
                $model->save();
                return 'Success';
            }
        }
    }

    public function actionSaveCheck() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbCpoeDetail::findOne($request->post('ids'));
            $model->cpoe_checkby = Yii::$app->user->getId();
            $model->save();
            return 'Success';
        }
    }

    public function actionCheckCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
           if(($model = TbCpoe::findOne($request->post('cpoeid'))) !== null){
               return true;
               //return $this->redirect(['check', 'id' => $model->cpoe_id]);
           } else {
               return false;
           }
        }
    }
    
    public function actionSaveIssue() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbCpoeDetail::findOne($request->post('ids'));
            $model->cpoe_issueby = Yii::$app->user->getId();
            $model->save();
            return 'Success';
        }
    }

}
