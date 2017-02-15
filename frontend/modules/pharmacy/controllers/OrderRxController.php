<?php

namespace app\modules\pharmacy\controllers;

use Yii;
use app\modules\pharmacy\models\TbCpoe;
use app\modules\pharmacy\models\TbCpoeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pharmacy\models\VwPtServiceListOp;
use app\modules\pharmacy\models\VwPtAr;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\modules\pharmacy\models\VwProtocolForCr;
use app\modules\pharmacy\models\VwCpoeRxDetail2Search;
use app\modules\pharmacy\models\TbIsedReason;
use app\modules\pharmacy\models\TbPtAr;
use app\modules\pharmacy\models\VwCpoeDrugDefault;
use app\modules\pharmacy\models\TbCpoeDetail;
use yii\helpers\Json;
use app\modules\pharmacy\models\VwCpoeDrugadmitDefault;
use app\modules\pharmacy\models\VwSigCode;
use app\modules\pharmacy\models\VwCpoeDruglistOp;
use app\modules\pharmacy\models\TbDrugprandialadvice;
use app\modules\pharmacy\models\VwCpoeRxHeaderSearch;
use app\modules\pharmacy\models\VwIvsolutionDetail;
use app\modules\pharmacy\models\TbFiInvDetail;
/**
 * OrderRxController implements the CRUD actions for TbCpoe model.
 */
class OrderRxController extends Controller {

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
        $query = VwPtServiceListOp::find()->select(['HNVN', 'pt_name', 'pt_right', 'pt_visit_number'])->all();
        /*
          $searchModel = new TbCpoeSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         */
        return $this->render('index', [
                    'query' => $query,
                        /*
                          'searchModel' => $searchModel,
                          'dataProvider' => $dataProvider,
                         */
        ]);
    }

    public function actionOrderStatus() {
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order-status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbCpoe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbCpoe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($data, $type) {
        $userid = Yii::$app->user->identity->id;
        $maxid = TbCpoe::find()->max('cpoe_id') + 1;
        if ($type == 'chemo') {
            $cpoetype = '1012';
        } elseif ($type == 'homemed') {
            $cpoetype = '1011';
        }
        Yii::$app->db->createCommand('CALL cmd_pt_rxorder_create(:pt_vn_number,:userid,:cpoe_id,:cpoe_type);')
                ->bindParam(':pt_vn_number', $data)
                ->bindParam(':userid', $userid)
                ->bindParam(':cpoe_id', $maxid)
                ->bindParam(':cpoe_type', $cpoetype)
                ->execute();
        return $this->redirect(['update', 'id' => $maxid]);
    }

    /**
     * Updates an existing TbCpoe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelCpoe = $this->findModel($id);

        if ($modelCpoe->load(Yii::$app->request->post()) && $modelCpoe->save()) {
            return $this->redirect(['view', 'id' => $modelCpoe->cpoe_id]);
        } else {
            if (($profile = VwPtServiceListOp::findOne($modelCpoe['pt_vn_number'])) !== null) {
                $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
                $TitleModal = $profile->getHeadermodalOP($modelCpoe['pt_vn_number']);
                $searchModel = new VwCpoeRxDetail2Search();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
                return $this->render('update', [
                            'modelCpoe' => $modelCpoe,
                            'ptar' => $ptar,
                            'profile' => $profile,
                            'TitleModal' => $TitleModal,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
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

    public function actionDeleteDetails() {
        $id = Yii::$app->request->post('id');
        TbCpoeDetail::findOne($id)->delete();
        TbFiInvDetail::deleteAll('cpoe_ids = :cpoe_ids', [':cpoe_ids' => $id]);
        if (($model = TbCpoeDetail::find()->where(['cpoe_parentid' => $id])->all()) !== null) {
            TbCpoeDetail::deleteAll('cpoe_parentid = :cpoe_parentid', [':cpoe_parentid' => $id]);
        }
        return true;
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

    public function actionArdetail($vn) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = VwPtAr::find()->where(['pt_visit_number' => $request->get('vn')])->all();
                $profile = VwPtServiceListOp::findOne(['pt_visit_number' => $vn]);
                $TitleModal = $profile->getHeadermodalOP($request->get('vn'));
                return [
                    'title' => 'สิทธิการรักษา ' . ' <span class="pull-right"> ' . $TitleModal . ' </span> ',
                    'content' => $this->renderAjax('_ardetails', [
                        'ardetails' => $ardetails,
                        'profile' => $profile,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSelectProtocol() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = VwProtocolForCr::find()->all();
            return [
                'title' => 'เลือกรหัสเบิกจ่าย',
                'content' => $this->renderAjax('_protocol', [
                    'query' => $query,
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
            ];
        }
    }

    public function actionGetFromIsed() {
        $posted = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $IsedModel = TbIsedReason::find()->all();
        $from = $this->renderAjax('_from_ised', [
            'IsedModel' => $IsedModel,
        ]);
        return $from;
    }

    public function actionGetTableByvn() {
        $credit = $this->getCreditGroup(Yii::$app->request->post('vn'));
        $command = (new \yii\db\Query())
                ->select(['ItemID', 'credit_group_id', 'Itemdetail', 'ItemQtyAvalible', 'DispUnit', 'ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt', 'NED_required', 'Jor2_required', 'TMTID_GPU'])
                ->from('vw_cpoe_druglist_op')
                ->where(['IN', 'credit_group_id', $credit])
                ->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $htl = '<table class="table table-bordered table-striped table-hover table-condensed" id="tbrxdetails" width="100%">
                            <thead>
                                    <tr>
                                        ' . Html::tag('th', Html::encode('รหัสสินค้า'), []) . '
                                        ' . Html::tag('th', Html::encode('รายการ'), []) . '
                                        ' . Html::tag('th', Html::encode('ยอดใช้ได้'), []) . '
                                        ' . Html::tag('th', Html::encode('หน่วย'), []) . '
                                        ' . Html::tag('th', Html::encode('ราคา/หน่วย'), []) . '
                                        ' . Html::tag('th', Html::encode('เบิกได้'), []) . '
                                        ' . Html::tag('th', Html::encode('เบิกไม่ได้'), []) . '
                                        ' . Html::tag('th', Html::encode('Actions'), []) . '
                                    </tr>
                                </thead>
                            <tbody>';
        foreach ($command as $result) {
            $htl .= '<tr id="' . $result['ItemID'] . '">';
            $htl .= Html::tag('td', $result['ItemID'], ['style' => 'text-align: center;']);
            $htl .= Html::tag('td', $result['Itemdetail'], ['style' => 'text-align: left;']);
            $htl .= Html::tag('td', number_format($result['ItemQtyAvalible'], 2), ['style' => 'text-align: center;']);
            $htl .= Html::tag('td', $result['DispUnit'], ['style' => 'text-align: center;']);
            $htl .= Html::tag('td', number_format($result['ItemPrice'], 2), ['style' => 'text-align: center;']);
            $htl .= Html::tag('td', $result['Item_Cr_Amt'], ['style' => 'text-align: center;']);
            $htl .= Html::tag('td', $result['Item_Pay_Amt'], ['style' => 'text-align: center;']);
            $Button = Html::a('Select', FALSE, [
                        'onclick' => 'SelectItemDrug' . '(this)',
                        'class' => 'btn btn-xs btn-success ladda-button',
                        'data-style' => 'slide-right',
                        'data-toggle' => $result['credit_group_id'],
                        'ned' => $result['NED_required'],
                        'gp' => $result['Jor2_required'],
                        'data-id' => $result['TMTID_GPU'],
                        'id' => $result['ItemID'],
                        'detail' => $result['Itemdetail'],
                        'DispUnit' => $result['DispUnit'],
                        'ItemPrice' => $result['ItemPrice'],
            ]);
            $htl .= Html::tag('td', $Button, ['style' => 'text-align: center;']);
            $htl .= '</tr>';
        }
        $htl .= '</tr></tbody>
                </table>
            ';
        return $htl;
    }

    private function getCreditGroup($vn) {
        if (!empty($vn)) {
            $querygroupid = TbPtAr::find()->where(['pt_visit_number' => $vn])->all();
            foreach ($querygroupid as $data) {
                $groupid[] = $data['credit_group_id'];
            }
            return $groupid;
        } else {
            return NULL;
        }
    }

    public function actionDetailsFrom() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new TbCpoeDetail();
            $Item = VwCpoeDrugDefault::findOne($request->post('ItemID'));
            $ItemOP = VwCpoeDruglistOp::findOne($request->post('ItemID'));
            $from = $this->renderAjax('_details_from', [
                'Item' => $Item,
                'model' => $model,
                'ItemOP' => $ItemOP,
                'Itemtype' => $request->post('ItemType'),
                'adviceid' => null,
            ]);
            return $from;
        }
    }

    public function actionEditByType() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbCpoeDetail::findOne($request->post('ids'));
            $Item = VwCpoeDrugDefault::findOne($model['ItemID']);
            $ItemOP = VwCpoeDruglistOp::findOne($model['ItemID']);
            $adviceid = ArrayHelper::map($this->getDrugadvice($model['cpoe_route_id'], $model['cpoe_drugprandialadviceid']), 'id', 'name');
            $from = $this->renderAjax('_details_from', [
                'Item' => $Item,
                'model' => $model,
                'ItemOP' => $ItemOP,
                'Itemtype' => $model['cpoe_Itemtype'],
                'adviceid' => $adviceid,
            ]);
            $arr = [
                'from' => $from,
                'confirmed' => $model['cpoe_narcotics_confirmed'],
                'ised_reason' => $model['ised_reason'],
                'ItemDetail' => $Item['ItemDetail'],
            ];
            return $arr;
        }
    }

    public function actionEditIvsolution($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbCpoeDetail::findOne($id);
            $Item = VwCpoeDrugDefault::findOne($model['ItemID']);
            $ItemOP = VwCpoeDruglistOp::findOne($model['ItemID']);
            $adviceid = ArrayHelper::map($this->getDrugadvice($model['cpoe_route_id'], $model['cpoe_drugprandialadviceid']), 'id', 'name');
            $query1 = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [51]])
                    ->all();
            $query2 = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [52]])
                    ->all();
            $from = $this->renderAjax('_iv_from', [
                'Item' => $Item,
                'model' => $model,
                'ItemOP' => $ItemOP,
                'Itemtype' => $model['cpoe_Itemtype'],
                'adviceid' => $adviceid,
                'query1' => $query1,
                'query2' => $query2,
            ]);
            return $from;
        }
    }

    private function getTitleModal($type) {
        if ($type == 21) {
            return 'Keep Vein Open';
        } elseif ($type == 22) {
            return 'Premedication';
        } elseif ($type == 53) {
            return 'Chemo Injection';
        } elseif ($type == 'homemed' || $type == 10 || $type == 20) {
            return 'กำหนดรายการ';
        } elseif ($type == 54) {
            return 'Chemo P.O.';
        }
    }

    public function actionChildRouteAdvice() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = VwCpoeDrugadmitDefault::find()->andWhere(['DrugRouteID' => $id, 'TMTID_GPU' => $_POST['depdrop_all_params']['input-tmtid-gpu']])->asArray()->all();
            $selected = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['DrugPrandialAdviceID'], 'name' => $account['DrugPrandialAdviceDesc']];
                    if ($i == 0) {
                        $selected = $account['DrugPrandialAdviceID'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionChangestateSigcode() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $model = VwSigCode::findOne($request->post('id'));
            $arr = array(
                'cpoe_stat' => $model->cpoe_stat,
                'period_value' => $model->cpoe_period_value,
                'period_unit' => $model->cpoe_period_unit,
                'cpoe_frequency' => $model->cpoe_frequency,
                'frequency_value' => $model->cpoe_frequency_value,
                'frequency_unit' => $model->cpoe_frequency_unit,
            );
            return json_encode($arr);
        } else {
            return json_encode('');
        }
    }

    public function actionCalculateQty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $pt_visit_number = $post['pt_visit_number'];
            $ItemID = !empty($post['TbCpoeDetail']['ItemID']) ? $post['TbCpoeDetail']['ItemID'] : '';
            $cpoe_once = !empty($post['TbCpoeDetail']['cpoe_once']) ? $post['TbCpoeDetail']['cpoe_once'] : '';
            $cpoe_repeat = !empty($post['TbCpoeDetail']['cpoe_repeat']) ? $post['TbCpoeDetail']['cpoe_repeat'] : '';
            $cpoe_doseqty = !empty($post['TbCpoeDetail']['cpoe_doseqty']) ? $post['TbCpoeDetail']['cpoe_doseqty'] : '';
            $cpoe_sig_code = !empty($post['TbCpoeDetail']['cpoe_sig_code']) ? $post['TbCpoeDetail']['cpoe_sig_code'] : '';
            $cpoe_period_value = !empty($post['TbCpoeDetail']['cpoe_period_value']) ? $post['TbCpoeDetail']['cpoe_period_value'] : '';
            $cpoe_period_unit = !empty($post['TbCpoeDetail']['cpoe_period_unit']) ? $post['TbCpoeDetail']['cpoe_period_unit'] : '';
            $cpoe_frequency = !empty($post['TbCpoeDetail']['cpoe_frequency']) ? $post['TbCpoeDetail']['cpoe_frequency'] : '';
            $cpoe_frequency_value = !empty($post['TbCpoeDetail']['cpoe_frequency_value']) ? $post['TbCpoeDetail']['cpoe_frequency_value'] : '';
            $cpoe_frequency_unit = !empty($post['TbCpoeDetail']['cpoe_frequency_unit']) ? $post['TbCpoeDetail']['cpoe_frequency_unit'] : '';
            $cpoe_dayrepeat = !empty($post['TbCpoeDetail']['cpoe_dayrepeat']) ? $post['TbCpoeDetail']['cpoe_dayrepeat'] : '';
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
            $command = Yii::$app->db->createCommand('select func_cal_drugdispenqty('
                            . ':cpoe_once,'
                            . ':cpoe_repeat,'
                            . ':cpoe_doseqty,'
                            . ':cpoe_sig_code,'
                            . ':cpoe_period_value,'
                            . ':cpoe_period_unit,'
                            . ':cpoe_frequency,'
                            . ':cpoe_frequency_value,'
                            . ':cpoe_frequency_unit,'
                            . ':cpoe_dayrepeat,'
                            . ':cpoe_dayrepeat_mon,'
                            . ':cpoe_dayrepeat_tue,'
                            . ':cpoe_dayrepeat_wed,'
                            . ':cpoe_dayrepeat_thu,'
                            . ':cpoe_dayrepeat_fri,'
                            . ':cpoe_dayrepeat_sat,'
                            . ':cpoe_dayrepeat_sun) as Qty;')
                    ->bindParam(":cpoe_once", $cpoe_once)
                    ->bindParam(":cpoe_repeat", $cpoe_repeat)
                    ->bindParam(":cpoe_doseqty", $cpoe_doseqty)
                    ->bindParam(":cpoe_sig_code", $cpoe_sig_code)
                    ->bindParam(":cpoe_period_value", $cpoe_period_value)
                    ->bindParam(":cpoe_period_unit", $cpoe_period_unit)
                    ->bindParam(":cpoe_frequency", $cpoe_frequency)
                    ->bindParam(":cpoe_frequency_value", $cpoe_frequency_value)
                    ->bindParam(":cpoe_frequency_unit", $cpoe_frequency_unit)
                    ->bindParam(":cpoe_dayrepeat", $cpoe_dayrepeat)
                    ->bindParam(":cpoe_dayrepeat_mon", $cpoe_dayrepeat_mon)
                    ->bindParam(":cpoe_dayrepeat_tue", $cpoe_dayrepeat_tue)
                    ->bindParam(":cpoe_dayrepeat_wed", $cpoe_dayrepeat_wed)
                    ->bindParam(":cpoe_dayrepeat_thu", $cpoe_dayrepeat_thu)
                    ->bindParam(":cpoe_dayrepeat_fri", $cpoe_dayrepeat_fri)
                    ->bindParam(":cpoe_dayrepeat_sat", $cpoe_dayrepeat_sat)
                    ->bindParam(":cpoe_dayrepeat_sun", $cpoe_dayrepeat_sun);
            $qty = $command->queryOne();


            $query = Yii::$app->db->createCommand('CALL cmd_cal_itemdrugprice_op2 (:ItemID, :ItemQty, :pt_visit_number,@Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt);'
                            . 'select  @Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt;')
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemQty', $qty['Qty'])
                    ->bindParam(':pt_visit_number', $pt_visit_number)
                    ->execute();
            $Item_Total_Amt = Yii::$app->db->createCommand("select @Item_Total_Amt;")->queryScalar();
            $Item_Cr_Amt = Yii::$app->db->createCommand("select @Item_Cr_Amt;")->queryScalar();
            $Item_Pay_Amt = Yii::$app->db->createCommand("select @Item_Pay_Amt;")->queryScalar();
            $result = array(
                'Item_Total_Amt' => number_format($Item_Total_Amt, 2),
                'Item_Cr_Amt' => number_format($Item_Cr_Amt, 2),
                'Item_Pay_Amt' => number_format($Item_Pay_Amt, 2),
                'Qty' => number_format($qty['Qty'], 2),
            );
            return json_encode($result);
        } else {
            return Json::encode('');
        }
    }

    public function actionSaveCpoedetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_ids = !empty($post['TbCpoeDetail']['cpoe_ids']) ? $post['TbCpoeDetail']['cpoe_ids'] : TbCpoeDetail::find()->max('cpoe_ids') + 1;
            $cpoe_detail_date = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
            $cpoe_detail_time = date('H:i:s', time());
            $cpoe_id = !empty($post['TbCpoeDetail']['cpoe_id']) ? $post['TbCpoeDetail']['cpoe_id'] : null;
            $cpoe_Itemtype = !empty($post['TbCpoeDetail']['cpoe_Itemtype']) ? $post['TbCpoeDetail']['cpoe_Itemtype'] : null;
            $cpoe_rxordertype = !empty($post['TbCpoeDetail']['cpoe_rxordertype']) ? $post['TbCpoeDetail']['cpoe_rxordertype'] : null;
            $ItemID = empty($post['TbCpoeDetail']['ItemID']) ? null : $post['TbCpoeDetail']['ItemID'];
            $ItemQty = !empty($post['TbCpoeDetail']['ItemQty']) ? str_replace(',', '', $post['TbCpoeDetail']['ItemQty']) : null;
            $ItemPrice = !empty($post['TbCpoeDetail']['ItemPrice']) ? str_replace(',', '', $post['TbCpoeDetail']['ItemPrice']) : null;
            $Item_Amt = $ItemQty * $ItemPrice;
            $ised = !empty($post['TbCpoeDetail']['ised_reason']) ? '1' : null;
            $ised_reason = !empty($post['TbCpoeDetail']['ised_reason']) ? $post['TbCpoeDetail']['ised_reason'] : null;
            $cpoe_narcotics_confirmed = !empty($post['TbCpoeDetail']['cpoe_narcotics_confirmed']) ? $post['TbCpoeDetail']['cpoe_narcotics_confirmed'] : null;
            $cpoe_ocpa = NULL;
            $cpoe_cpr = NULL;
            $Item_comment1 = !empty($post['TbCpoeDetail']['Item_comment1']) ? $post['TbCpoeDetail']['Item_comment1'] : null;
            $Item_comment2 = !empty($post['TbCpoeDetail']['Item_comment2']) ? $post['TbCpoeDetail']['Item_comment2'] : null;
            $Item_comment3 = !empty($post['TbCpoeDetail']['Item_comment3']) ? $post['TbCpoeDetail']['Item_comment3'] : null;
            $Item_comment4 = !empty($post['TbCpoeDetail']['Item_comment4']) ? $post['TbCpoeDetail']['Item_comment4'] : null;
            $cpoe_route_id = !empty($post['TbCpoeDetail']['cpoe_route_id']) ? $post['TbCpoeDetail']['cpoe_route_id'] : null;
            $cpoe_sig_code = !empty($post['TbCpoeDetail']['cpoe_sig_code']) ? $post['TbCpoeDetail']['cpoe_sig_code'] : null;
            $cpoe_iv_driprate = !empty($post['TbCpoeDetail']['cpoe_iv_driprate']) ? $post['TbCpoeDetail']['cpoe_iv_driprate'] : null;
            $cpoe_doseqty = !empty($post['TbCpoeDetail']['cpoe_doseqty']) ? $post['TbCpoeDetail']['cpoe_doseqty'] : null;
            $cpoe_prn_with_stat = null;
            $cpoe_prn_reason = !empty($post['TbCpoeDetail']['cpoe_prn_reason']) ? $post['TbCpoeDetail']['cpoe_prn_reason'] : null;
            $cpoe_stat = !empty($post['TbCpoeDetail']['cpoe_stat']) ? $post['TbCpoeDetail']['cpoe_stat'] : null;
            $cpoe_period = null;
            $cpoe_period_value = !empty($post['TbCpoeDetail']['cpoe_period_value']) ? $post['TbCpoeDetail']['cpoe_period_value'] : null;
            $cpoe_period_unit = !empty($post['TbCpoeDetail']['cpoe_period_unit']) ? $post['TbCpoeDetail']['cpoe_period_unit'] : null;
            $cpoe_frequency = !empty($post['TbCpoeDetail']['cpoe_frequency']) ? $post['TbCpoeDetail']['cpoe_frequency'] : null;
            $cpoe_frequency_value = !empty($post['TbCpoeDetail']['cpoe_frequency_value']) ? $post['TbCpoeDetail']['cpoe_frequency_value'] : null;
            $cpoe_frequency_unit = !empty($post['TbCpoeDetail']['cpoe_frequency_unit']) ? $post['TbCpoeDetail']['cpoe_frequency_unit'] : null;
            $cpoe_dayrepeat = !empty($post['TbCpoeDetail']['cpoe_dayrepeat']) ? $post['TbCpoeDetail']['cpoe_dayrepeat'] : null;
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
            $cpoe_begindate = !empty($post['TbCpoeDetail']['cpoe_begindate']) ? Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbCpoeDetail']['cpoe_begindate']) : null;
            $cpeo_begintime = !empty($post['TbCpoeDetail']['cpeo_begintime']) ? $post['TbCpoeDetail']['cpeo_begintime'] : null;
            $cpoe_enddate = !empty($post['TbCpoeDetail']['cpoe_enddate']) ? Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbCpoeDetail']['cpoe_enddate']) : null;
            $cpoe_endtime = !empty($post['TbCpoeDetail']['cpoe_endtime']) ? $post['TbCpoeDetail']['cpoe_endtime'] : null;
            $cpoe_repeat = !empty($post['TbCpoeDetail']['cpoe_repeat']) ? $post['TbCpoeDetail']['cpoe_repeat'] : null;
            $cpoe_once = !empty($post['TbCpoeDetail']['cpoe_once']) ? $post['TbCpoeDetail']['cpoe_once'] : null;
            $cpoe_drugprandialadviceid = !empty($post['TbCpoeDetail']['cpoe_drugprandialadviceid']) ? $post['TbCpoeDetail']['cpoe_drugprandialadviceid'] : null;
            $cpoe_seq_mindelay = !empty($post['TbCpoeDetail']['cpoe_seq_mindelay']) ? $post['TbCpoeDetail']['cpoe_seq_mindelay'] : null;
            $chemo_regimen_ids = !empty($post['TbCpoeDetail']['chemo_regimen_ids']) ? $post['TbCpoeDetail']['chemo_regimen_ids'] : null;
            $Acpoe_ids = !empty($post['TbCpoeDetail']['cpoe_parentid']) ? $post['TbCpoeDetail']['cpoe_parentid'] : null;
            $Acpoe_seq = !empty($post['TbCpoeDetail']['cpoe_seq']) ? $post['TbCpoeDetail']['cpoe_seq'] : null;
            $cpoe_level = !empty($post['TbCpoeDetail']['cpoe_level']) ? $post['TbCpoeDetail']['cpoe_level'] : null;
            $cpoe_drugset_id = null;
            if ($cpoe_Itemtype == 21) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_kvosolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 22) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_premed('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 51) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_basesolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $Acpoe_seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 52) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_additive('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $Acpoe_seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->execute();
                $model = TbCpoeDetail::findOne($cpoe_ids);
                $model->chemo_regimen_ids = $chemo_regimen_ids;
                $model->save();
                return true;
            } elseif ($cpoe_Itemtype == 50 || $cpoe_Itemtype == 40) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_itemsave('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 53) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_chemoinj('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay,'
                                . ':chemo_regimen_ids);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 10 || $cpoe_Itemtype == 20) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave2('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 54) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_chemopo('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay,'
                                . ':chemo_regimen_ids);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            }
        }
    }

    public function actionSort($data) {
        $request = Yii::$app->request;
        $model = new TbCpoeDetail();
        if ($request->isAjax) {
            $items = [];
            $query = TbCpoeDetail::find()
                    ->where(['cpoe_id' => $data])
                    ->andWhere(['NOT IN', 'cpoe_Itemtype', [51, 52]])
                    ->orderBy('cpoe_seq')
                    ->all();
            foreach ($query as $v) {
                $items[$v->cpoe_ids] = [
                    'content' => empty($v->itemType->cpoe_itemtype_decs) ? '' : '<i class="glyphicon glyphicon-hand-up"></i> ' . $v->itemType->cpoe_itemtype_decs . ' ' . $v->ItemID,
                        //'options' => ['data' => ['id' => $p->id]],
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => '<i class="glyphicon glyphicon-move"></i> Sort',
                    'content' => $this->renderAjax('_sort', [
                        'model' => $model,
                        'items' => $items,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionSaveSort() {
        $posted = Yii::$app->request->post();
        if ($posted) {
            $i = 1;
            $j = null;
            $ids = explode(',', $posted['TbCpoeDetail']['cpoe_seq']);
            foreach ($ids as $key) {
                $model = TbCpoeDetail::findOne($key);
                if ($model['cpoe_Itemtype'] == 40 || $model['cpoe_Itemtype'] == 50) {
                    $model->cpoe_seq = $i;
                    $model->save();
                    $j = $this->saveParentSort($key, ($i + 1));
                    $i = $j++;
                } else {
                    $model->cpoe_seq = $i;
                    $model->save();
                    $i++;
                }
            }
            return json_encode($j);
        }
    }

    private function saveParentSort($key, $i) {
        $model = TbCpoeDetail::find()->where(['cpoe_parentid' => $key])->all();
        foreach ($model as $v) {
            $modalParent = TbCpoeDetail::findOne($v['cpoe_ids']);
            $modalParent->cpoe_seq = $i;
            $modalParent->save();
            $i++;
        }
        return $i;
    }

    protected function getDrugadvice($id, $adviceid) {
        $datas = TbDrugprandialadvice::find()->where(['DrugRouteID' => $id, 'DrugPrandialAdviceID' => $adviceid])->all();
        return $this->MapData($datas, 'DrugPrandialAdviceID', 'DrugPrandialAdviceDesc');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }
    
    public function actionGettbBasesolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => [51]])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbBasesolution">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    
                    <th class="text-center">รายการ</th>
                    <th class="text-center">ปริมาณ</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center">เบิกได้</th>
                    <th class="text-center">เบิกไม่ได้</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', false, ['class' => 'btn btn-xs btn-success', 'onclick' => 'EditByType(this);','ids' => $result['cpoe_ids'],'item-type' => 51]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }
    
    public function actionGettbDrugadditive() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 52])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbDrugAdditive">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    
                    <th class="text-center">รายการ</th>
                    <th class="text-center">ปริมาณ</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center">เบิกได้</th>
                    <th class="text-center">เบิกไม่ได้</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                //$table .= '<td class="text-center">' . $result->cpoe_itemtype_decs . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-additive', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }

}
