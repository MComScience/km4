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
use app\modules\pharmacy\models\VwPtInfo;
use kartik\icons\Icon;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;
use app\modules\pharmacy\models\VwCpoeRxDetail2;
use app\modules\pharmacy\models\VwCpoeRxHeader;
use yii\data\ActiveDataProvider;

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
        $dataProvider2 = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider->sort->sortParam = false;

        return $this->render('order-status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionHistory() {
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search_history(Yii::$app->request->queryParams);

        return $this->render('history', [
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
    public function actionCreate($data, $type, $schd) {
        $userid = Yii::$app->user->identity->id;
        $maxid = TbCpoe::find()->max('cpoe_id') + 1;
        Yii::$app->db->createCommand('CALL cmd_pt_rxorder_create(:pt_vn_number,:userid,:cpoe_id,:cpoe_type,:cpoe_schedule_type);')
                ->bindParam(':pt_vn_number', $data)
                ->bindParam(':userid', $userid)
                ->bindParam(':cpoe_id', $maxid)
                ->bindParam(':cpoe_type', $type)
                ->bindParam(':cpoe_schedule_type', $schd)
                ->execute();
        return $this->redirect(['update', 'id' => $maxid]);
    }

    public function actionCreateHistory($data, $type, $schd, $cpoeids) {
        $userid = Yii::$app->user->identity->id;

        Yii::$app->db->createCommand('CALL cmd_pt_rx_create_remed(:pt_vn_number,:userid,:cpoe_type,:cpoe_schedule_type,:xcpoe_ids);')
                ->bindParam(':pt_vn_number', $data)
                ->bindParam(':userid', $userid)
                ->bindParam(':cpoe_type', $type)
                ->bindParam(':cpoe_schedule_type', $schd)
                ->bindParam(':xcpoe_ids', $cpoeids)
                ->execute();
        $maxid = TbCpoe::find()->max('cpoe_id');
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
                $dataProvider->pagination->pageSize = false;
                $dataProvider->sort->defaultOrder = ['cpoe_seq' => SORT_ASC];
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
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
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
            $groupid = [];
            foreach ($querygroupid as $data) {
                $groupid[] = $data['credit_group_id'];
            }
            return $groupid;
        } else {
            $groupid = [];
            return $groupid;
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

    public function actionCreateIv($type, $cpoe_id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = TbCpoeDetail::find()->max('cpoe_ids') + 1;
            if ($type == 40) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_create_premed(:cpoe_id,:cpoe_ids);')
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_ids', $id)
                        ->execute();
            } else {
                Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_create(:cpoe_id,:cpoe_ids);')
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_ids', $id)
                        ->execute();
            }

            $model = TbCpoeDetail::findOne($id);
            $Item = VwCpoeDrugDefault::findOne($model['ItemID']);
            $ItemOP = VwCpoeDruglistOp::findOne($model['ItemID']);
            $adviceid = ArrayHelper::map($this->getDrugadvice($model['cpoe_route_id'], $model['cpoe_drugprandialadviceid']), 'id', 'name');
            $query1 = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [41]])
                    ->all();
            $query2 = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [42]])
                    ->all();
            $from = $this->renderAjax('_iv_from', [
                'Item' => $Item,
                'model' => $model,
                'ItemOP' => $ItemOP,
                'Itemtype' => $type,
                'adviceid' => $adviceid,
                'query1' => $query1,
                'query2' => $query2,
            ]);
            return $from;
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
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [41]])
                    ->all();
            $query2 = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $id, 'cpoe_Itemtype' => [42]])
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
            $list = TbDrugprandialadvice::find()->andWhere(['DrugRouteID' => $id, /* 'TMTID_GPU' => $_POST['depdrop_all_params']['input-tmtid-gpu'] */])->asArray()->all();
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
            $cpoe_seq = !empty($post['TbCpoeDetail']['cpoe_seq']) ? $post['TbCpoeDetail']['cpoe_seq'] : Yii::$app->db->createCommand('SELECT ifnull((SELECT tb_cpoe_detail.cpoe_seq FROM tb_cpoe_detail WHERE tb_cpoe_detail.cpoe_id = :cpoe_id ORDER BY tb_cpoe_detail.cpoe_seq DESC LIMIT 1),0)+1')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->queryScalar();
            $cpoe_drugset_id = null;
            if ($cpoe_Itemtype == 21) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_kvosolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_seq,'
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
                        ->bindParam(':cpoe_seq', $cpoe_seq)
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
                                . ':cpoe_seq,'
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
                        ->bindParam(':cpoe_seq', $cpoe_seq)
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
            } elseif ($cpoe_Itemtype == 41 || $cpoe_Itemtype == 51) {
                $cpoe = TbCpoeDetail::findOne($Acpoe_ids);
                $seq = $cpoe['cpoe_seq'];
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_basesolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
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
                                . ':Item_comment4);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
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
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 42 || $cpoe_Itemtype == 52) {
                $cpoe = TbCpoeDetail::findOne($Acpoe_ids);
                $seq = $cpoe['cpoe_seq'];
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_additive('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':cpoe_doseqty,'
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
                        ->bindParam(':Acpoe_seq', $seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
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
                                . ':cpoe_seq,'
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
                        ->bindParam(':cpoe_seq', $cpoe_seq)
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
                                . ':cpoe_seq,'
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
                        ->bindParam(':cpoe_seq', $cpoe_seq)
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
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => $request->post('ItemType')])
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
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', false, ['class' => 'btn btn-xs btn-success', 'onclick' => 'EditByType(this);', 'ids' => $result['cpoe_ids'], 'item-type' => 41, 'title-modal' => 'Base Solution']) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
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
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => $request->post('ItemType')])
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
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', false, ['class' => 'btn btn-xs btn-success', 'onclick' => 'EditByType(this);', 'ids' => $result['cpoe_ids'], 'item-type' => 42, 'title-modal' => 'Additive']) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
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

    public function actionSearchHn($schedule_type) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => '<i class="glyphicon glyphicon-search"></i> ค้นหาผู้ป่วย',
                'content' => $this->renderAjax('search_hn', [
                    'schedule_type' => $schedule_type,
                ]),
                    //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
            ];
        }
    }

    public function actionQueryArdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (VwPtInfo::findAll(['pt_hospital_number' => $request->get('HN')]) == null) {
                return 'No data';
            } else {
                $Profile = VwPtServiceListOp::findOne(['pt_hospital_number' => $request->get('HN')]);
                $data = VwPtAr::find()->where(['pt_hospital_number' => $request->get('HN')])->all();
                $table = '<table id="details" class="table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>สิทธิการรักษา</th>
                                    <th>เลขที่ใบส่งตัว</th>
                                    <th>วันเริ่มใบส่งตัว</th>
                                    <th>วันสิ้นสุดใบส่งตัว</th>
                                    <th>ใช้สิทธิ</th>
                                </tr>
                            </thead>
                            <tbody>';
                $no = 1;
                foreach ($data as $v) {
                    $table .= '<tr>';
                    $table .= '<td style="text-align:center;">' . $no . '</td>';
                    $table .= '<td>' . $v['ar_name'] . '</td>';
                    $table .= '<td style="text-align:center;">' . $v['refer_hsender_doc_id'] . '</td>';
                    $table .= '<td style="text-align:center;">' . Yii::$app->formatter->asDate($v['refer_hsender_doc_start'], 'dd/MM/yyyy') . '</td>';
                    $table .= '<td style="text-align:center;">' . Yii::$app->formatter->asDate($v['refer_hsender_doc_expdate'], 'dd/MM/yyyy') . '</td>';
                    $table .= '<td>' . $v['pt_ar_usage'] . '</td>';
                    $table .= '</tr>';
                    $no++;
                }
                $table .= '</tbody></table>';
                $name = $Profile['pt_name'] . ' ' . 'อายุ ' . $Profile['pt_age_registry_date'] . ' ' . 'ปี HN ' . $Profile['pt_hospital_number'] . ' ' . ' VN ' . $Profile['pt_visit_number'];
                $arr = [
                    'name' => $name,
                    'table' => $table,
                    'vn' => $Profile['pt_visit_number'],
                ];
                return $arr;
            }
        }
    }

    public function actionQueryArdetail2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $Profile = VwPtServiceListOp::findOne(['pt_visit_number' => $request->get('VN')]);
            $data = VwPtAr::find()->where(['pt_visit_number' => $request->get('VN')])->all();
            $table = '<table id="details" class="table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>สิทธิการรักษา</th>
                                    <th>เลขที่ใบส่งตัว</th>
                                    <th>วันเริ่มใบส่งตัว</th>
                                    <th>วันสิ้นสุดใบส่งตัว</th>
                                    <th>ใช้สิทธิ</th>
                                </tr>
                            </thead>
                            <tbody>';
            $no = 1;
            foreach ($data as $v) {
                $table .= '<tr>';
                $table .= '<td style="text-align:center;">' . $no . '</td>';
                $table .= '<td>' . $v['ar_name'] . '</td>';
                $table .= '<td style="text-align:center;">' . $v['refer_hsender_doc_id'] . '</td>';
                $table .= '<td style="text-align:center;">' . Yii::$app->formatter->asDate($v['refer_hsender_doc_start'], 'dd/MM/yyyy') . '</td>';
                $table .= '<td style="text-align:center;">' . Yii::$app->formatter->asDate($v['refer_hsender_doc_expdate'], 'dd/MM/yyyy') . '</td>';
                $table .= '<td>' . $v['pt_ar_usage'] . '</td>';
                $table .= '</tr>';
                $no++;
            }
            $table .= '</tbody></table>';
            $name = $Profile['pt_name'] . ' ' . 'อายุ ' . $Profile['pt_age_registry_date'] . ' ' . 'ปี HN ' . $Profile['pt_hospital_number'] . ' ' . ' VN ' . $Profile['pt_visit_number'];
            $arr = [
                'name' => $name,
                'table' => $table,
                'vn' => $Profile['pt_visit_number'],
            ];
            return $arr;
        }
    }

    public function actionQueryTabledetails() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($request->post('cpoe_id'));
            if ($model['cpoe_type'] == '1012') {
                $Button = Html::a(Icon::show('plus', [], Icon::BSG) . 'เปิดเส้น', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'เปิดเส้น', 'onclick' => 'CreateByType(this);', 'item-type' => '21', 'style' => 'font-size:11pt;']) . ' ' .
                        Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed', false, ['class' => 'btn btn-info autosave btn-grid', 'title-modal' => 'Premedication', 'onclick' => 'CreateByType(this);', 'item-type' => '22', 'style' => 'font-size:11pt;']) . ' ' .
                        Html::a(Icon::show('plus', [], Icon::BSG) . 'Premed IV', 'javascript:void(0);', ['class' => 'btn btn-info autosave btn-grid', 'title-modal' => 'Premed IV Solution', 'onclick' => 'CreateIVSolution(this);', 'item-type' => '40', 'cpoe_id' => $model['cpoe_id'], 'style' => 'font-size:11pt;']) . ' ' .
                        Html::a(Icon::show('plus', [], Icon::BSG) . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple autosave btn-grid', 'title-modal' => 'Chemo IV Solution', 'onclick' => 'CreateIVSolution(this);', 'item-type' => '50', 'cpoe_id' => $model['cpoe_id'], 'style' => 'font-size:11pt;']) . ' ' .
                        Html::a(Icon::show('plus', [], Icon::BSG) . 'Injection', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'Chemo Injection', 'onclick' => 'CreateByType(this);', 'item-type' => '53', 'style' => 'font-size:11pt;']) . ' ' .
                        Html::a(Icon::show('plus', [], Icon::BSG) . 'Homemed', false, ['class' => 'btn btn-success autosave btn-grid', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10', 'style' => 'font-size:11pt;']);
            } elseif ($model['cpoe_type'] == '1011') {
                $Button = Html::a('<i class="glyphicon glyphicon-plus"></i>Homemed', false, ['class' => 'btn btn-success btn-sm autosave', 'title-modal' => 'กำหนดรายการ', 'onclick' => 'CreateByType(this);', 'item-type' => '10', 'style' => 'font-size:11pt;']);
            }
            $searchModel = new VwCpoeRxDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $request->post('cpoe_id'));
            $dataProvider->pagination->pageSize = false;
            $table = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'responsive' => true,
                        'layout' => '<div class="pull-right">{toolbar}</div>
                            <div class="clearfix"></div><p></p>
                            {items}
                            <div class="clearfix"></div>
                            <div class="pull-left">{summary}</div>
                            <div class="pull-right">{pager}</div>
                            <div class="clearfix"></div>',
                        'showPageSummary' => true,
                        'striped' => false,
                        'condensed' => true,
                        'hover' => true,
                        'bordered' => true,
                        'headerRowOptions' => [
                            'class' => GridView::TYPE_DEFAULT
                        ],
                        'export' => false,
                        'toggleData' => false,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'panel' => [
                            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details ',
                            //. Html::a(Icon::show('move', [], Icon::BSG) . 'Sort', ['sort', 'data' => $model['cpoe_id']], ['class' => 'btn btn-warning btn-sm', 'style' => 'color:white;', 'role' => 'modal-remote']) . '</h3>',
                            'type' => GridView::TYPE_PRIMARY,
                            'before' =>
                            $Button,
                            'after' => false,
                        ],
                        'columns' => [
                            [
                                'header' => 'ลำดับ',
                                'attribute' => 'cpoe_seq',
                                'contentOptions' => ['class' => 'text-center',],
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'value' => function($model, $key, $index) {
                                    return $model->cpoe_seq;
                                },
                            ],
                            [
                                'header' => 'ประเภท',
                                'attribute' => 'cpoe_Itemtype',
                                'contentOptions' => ['style' => 'height:46px;text-align:center;font-size: 13pt;vertical-align: middle;background-color: #f5f5f5;color: #53a93f;',],
                                'headerOptions' => ['style' => 'color:black;'],
                                'value' => function($model, $key, $index) {
                                    return $model->cpoe_Itemtype == '41' || $model->cpoe_Itemtype == '42' ? '' : $model->cpoe_itemtype_decs;
                                },
                                'hAlign' => 'center',
                                'noWrap' => true,
                                'group' => true, // enable grouping,
                                'groupedRow' => true, // move grouped column to a single grouped row
                                'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                                'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                            ],
                            [
                                'header' => 'cpoe_parentid',
                                'attribute' => 'cpoe_parentid',
                                'contentOptions' => ['class' => 'text-left'],
                                'hidden' => true,
                                'headerOptions' => ['style' => 'color:black;'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->cpoe_parentid) ? '' : $model->cpoe_parentid;
                                },
                                'group' => true, // enable grouping
                                'subGroupOf' => 1 // supplier column index is the parent group
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'attribute' => 'ItemID',
                                'contentOptions' => ['class' => 'text-center',],
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->ItemID) ? '' : $model->ItemID;
                                },
                            ],
                            [
                                'header' => 'รายการ',
                                'attribute' => 'ItemDetail',
                                'contentOptions' => ['class' => 'text-left'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->ItemDetail) ? '' : $model->ItemDetail;
                                },
                            ],
                            [
                                'header' => 'จำนวน',
                                'attribute' => 'ItemQty1',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'noWrap' => true,
                                'value' => function($model, $key, $index) {
                                    return empty($model->ItemQty1) ? '' : $model->ItemQty1;
                                },
                            ],
                            [
                                'header' => 'ราคา/หน่วย',
                                'attribute' => 'ItemPrice',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'pageSummary' => 'รวม',
                                'format' => ['decimal', 2],
                                'noWrap' => true,
                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->ItemPrice) ? '' : $model->ItemPrice;
                                },
                            ],
                            [
                                'header' => 'จำนวนเงิน',
                                'attribute' => 'Item_Amt',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'noWrap' => true,
                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                                },
                            ],
                            [
                                'header' => 'เบิกได้',
                                'attribute' => 'Item_Cr_Amt_Sum',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'pageSummary' => true,
                                'noWrap' => true,
                                'format' => ['decimal', 2],
                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                                },
                            ],
                            [
                                'header' => 'เบิกไม่ได้',
                                'attribute' => 'Item_Pay_Amt_Sum',
                                'contentOptions' => ['class' => 'text-right'],
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'pageSummary' => true,
                                'noWrap' => true,
                                'format' => ['decimal', 2],
                                'pageSummaryOptions' => ['style' => 'text-align:right'],
                                'value' => function($model, $key, $index) {
                                    return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                                },
                            ],
                            [
                                'class' => '\kartik\grid\ActionColumn',
                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                'template' => '{print} {update} {delete}',
                                'noWrap' => true,
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'header' => 'Actions',
                                'buttons' => [
                                    'update' => function ($key, $model) {
                                        if ($model['cpoe_Itemtype'] == 21) {
                                            /* $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                                              return Html::a('Edit', $url, [
                                              'title' => 'Edit',
                                              'class' => 'btn btn-info btn-xs',
                                              'role' => 'modal-remote',
                                              ]); */
                                            return Html::a('Edit', false, [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'onclick' => 'EditByType(this);',
                                                        'title-modal' => 'เปิดเส้น',
                                                        'ids' => $model['cpoe_ids'],
                                                        'item-type' => $model['cpoe_Itemtype'],
                                            ]);
                                        }

                                        if ($model['cpoe_Itemtype'] == 22) {
                                            return Html::a('Edit', false, [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'onclick' => 'EditByType(this);',
                                                        'title-modal' => 'Premedication',
                                                        'ids' => $model['cpoe_ids'],
                                                        'item-type' => $model['cpoe_Itemtype'],
                                            ]);
                                        }

                                        if ($model['cpoe_Itemtype'] == '50' || $model['cpoe_Itemtype'] == '40') {
                                            return Html::a('Edit', 'javascript:void(0);', [
                                                        'title' => 'Edit',
                                                        'onclick' => 'EditIVSolution(' . $model['cpoe_ids'] . ');',
                                                        'class' => 'btn btn-info btn-xs'
                                            ]);
                                        } else if ($model['cpoe_Itemtype'] == '53') {
                                            return Html::a('Edit', false, [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'onclick' => 'EditByType(this);',
                                                        'title-modal' => 'Chemo Injection',
                                                        'ids' => $model['cpoe_ids'],
                                                        'item-type' => $model['cpoe_Itemtype'],
                                            ]);
                                        }

                                        if ($model['cpoe_Itemtype'] == 54) {
                                            $url = ['edit-by-type', 'ids' => $model['cpoe_ids']];
                                            return Html::a('Edit', $url, [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'role' => 'modal-remote',
                                            ]);
                                        } else if ($model['cpoe_Itemtype'] == 10 || $model['cpoe_Itemtype'] == 20) {
                                            return Html::a('Edit', false, [
                                                        'title' => 'Edit',
                                                        'class' => 'btn btn-info btn-xs',
                                                        'onclick' => 'EditByType(this);',
                                                        'ids' => $model['cpoe_ids'],
                                                        'item-type' => $model['cpoe_Itemtype'],
                                                        'title-modal' => 'Homemed',
                                            ]);
                                        }
                                    },
                                    'print' => function ($url, $model) {
                                        if ($model['cpoe_Itemtype'] == 41 || $model['cpoe_Itemtype'] == 42) {
                                            return '';
                                        } else {
                                            return Html::a('Print', '#', [
                                                        'title' => 'Print',
                                                        'data-toggle' => 'modal',
                                                        'class' => 'btn btn-default btn-xs btn-printlabel',
                                                        'onclick' => 'PrintdetailLabel(' . $model['cpoe_ids'] . ');',
                                            ]);
                                        }
                                    },
                                    'delete' => function ($url, $model) {
                                        if ($model['cpoe_Itemtype'] == 41 || $model['cpoe_Itemtype'] == 42) {
                                            return '';
                                        } else {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        'data-toggle' => 'modal',
                                                        'onclick' => 'DeleteCpoeDetails(' . $model['cpoe_ids'] . ');',
                                            ]);
                                        }
                                    },
                                ],
                            ],
                        ],
            ]);
            return $table;
        }
    }

    public function actionSavecpoeHeaderauto() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $posted = $request->post('TbCpoe');
            $model = $this->findModel($posted['cpoe_id']);
            $model->cpoe_num = empty($posted['cpoe_num']) ? null : $posted['cpoe_num'];
            $model->cpoe_date = empty($posted['cpoe_date']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['cpoe_date']);
            $model->cpoe_order_by = empty($posted['cpoe_order_by']) ? null : $posted['cpoe_order_by'];
            $model->pt_trp_regimen_paycode = empty($posted['pt_trp_regimen_paycode']) ? null : $posted['pt_trp_regimen_paycode'];
            $model->chemo_cycle_seq = empty($posted['chemo_cycle_seq']) ? null : $posted['chemo_cycle_seq'];
            $model->chemo_cycle_day = empty($posted['chemo_cycle_day']) ? null : $posted['chemo_cycle_day'];
            $model->pt_trp_regimen_name = empty($posted['pt_trp_regimen_name']) ? null : $posted['pt_trp_regimen_name'];
            $model->pt_cpr_number = empty($posted['pt_cpr_number']) ? null : $posted['pt_cpr_number'];
            $model->pt_ocpa_number = empty($posted['pt_ocpa_number']) ? null : $posted['pt_ocpa_number'];
            $model->cpoe_comment = empty($posted['cpoe_comment']) ? null : $posted['cpoe_comment'];
            $model->save();
            return 'Success!';
        }
    }

    public function actionSavedraftCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_id = $post['TbCpoe']['cpoe_id'];
            $cpoe_type = !empty($post['TbCpoe']['cpoe_type']) ? $post['TbCpoe']['cpoe_type'] : null;
            $cpoe_date = empty($post['TbCpoe']['cpoe_date']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbCpoe']['cpoe_date']);
            $cpoe_order_section = !empty($post['TbCpoe']['cpoe_order_section']) ? $post['TbCpoe']['cpoe_order_section'] : null;
            $cpoe_comment = !empty($post['TbCpoe']['cpoe_comment']) ? $post['TbCpoe']['cpoe_comment'] : null;
            $cpoe_order_by = !empty($post['TbCpoe']['cpoe_order_by']) ? $post['TbCpoe']['cpoe_order_by'] : null;
            $pt_trp_regimen_name = !empty($post['TbCpoe']['pt_trp_regimen_name']) ? $post['TbCpoe']['pt_trp_regimen_name'] : null;
            $chemo_cycle_seq = !empty($post['TbCpoe']['chemo_cycle_seq']) ? $post['TbCpoe']['chemo_cycle_seq'] : null;
            $chemo_cycle_day = !empty($post['TbCpoe']['chemo_cycle_day']) ? $post['TbCpoe']['chemo_cycle_day'] : null;
            $pt_trp_regimen_paycode = !empty($post['TbCpoe']['pt_trp_regimen_paycode']) ? $post['TbCpoe']['pt_trp_regimen_paycode'] : null;
            $pt_cpr_number = !empty($post['TbCpoe']['pt_cpr_number']) ? $post['TbCpoe']['pt_cpr_number'] : null;
            $pt_ocpa_number = !empty($post['TbCpoe']['pt_ocpa_number']) ? $post['TbCpoe']['pt_ocpa_number'] : null;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsavedrafe_pharma(:cpoe_id, :cpoe_type,:cpoe_date,:cpoe_order_section,:cpoe_comment,:cpoe_order_by,:pt_trp_regimen_name,:chemo_cycle_seq,:chemo_cycle_day,:pt_trp_regimen_paycode,:pt_cpr_number,:pt_ocpa_number);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':cpoe_type', $cpoe_type)
                    ->bindParam(':cpoe_date', $cpoe_date)
                    ->bindParam(':cpoe_order_section', $cpoe_order_section)
                    ->bindParam(':cpoe_comment', $cpoe_comment)
                    ->bindParam(':cpoe_order_by', $cpoe_order_by)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':pt_trp_regimen_paycode', $pt_trp_regimen_paycode)
                    ->bindParam(':pt_cpr_number', $pt_cpr_number)
                    ->bindParam(':pt_ocpa_number', $pt_ocpa_number)
                    ->execute();
            $model = $this->findModel($cpoe_id);
            return $model['cpoe_num'];
        }
    }

    public function actionSaveCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_id = $post['TbCpoe']['cpoe_id'];
            $cpoe_type = !empty($post['TbCpoe']['cpoe_type']) ? $post['TbCpoe']['cpoe_type'] : null;
            $cpoe_date = empty($post['TbCpoe']['cpoe_date']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbCpoe']['cpoe_date']);
            $cpoe_order_section = !empty($post['TbCpoe']['cpoe_order_section']) ? $post['TbCpoe']['cpoe_order_section'] : null;
            $cpoe_comment = !empty($post['TbCpoe']['cpoe_comment']) ? $post['TbCpoe']['cpoe_comment'] : null;
            $cpoe_order_by = !empty($post['TbCpoe']['cpoe_order_by']) ? $post['TbCpoe']['cpoe_order_by'] : null;
            $pt_trp_regimen_name = !empty($post['TbCpoe']['pt_trp_regimen_name']) ? $post['TbCpoe']['pt_trp_regimen_name'] : null;
            $chemo_cycle_seq = !empty($post['TbCpoe']['chemo_cycle_seq']) ? $post['TbCpoe']['chemo_cycle_seq'] : null;
            $chemo_cycle_day = !empty($post['TbCpoe']['chemo_cycle_day']) ? $post['TbCpoe']['chemo_cycle_day'] : null;
            $pt_trp_regimen_paycode = !empty($post['TbCpoe']['pt_trp_regimen_paycode']) ? $post['TbCpoe']['pt_trp_regimen_paycode'] : null;
            $pt_cpr_number = !empty($post['TbCpoe']['pt_cpr_number']) ? $post['TbCpoe']['pt_cpr_number'] : null;
            $pt_ocpa_number = !empty($post['TbCpoe']['pt_ocpa_number']) ? $post['TbCpoe']['pt_ocpa_number'] : null;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsave_pharma(:cpoe_id, :cpoe_type,:cpoe_date,:cpoe_order_section,:cpoe_comment,:cpoe_order_by,:pt_trp_regimen_name,:chemo_cycle_seq,:chemo_cycle_day,:pt_trp_regimen_paycode,:pt_cpr_number,:pt_ocpa_number);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':cpoe_type', $cpoe_type)
                    ->bindParam(':cpoe_date', $cpoe_date)
                    ->bindParam(':cpoe_order_section', $cpoe_order_section)
                    ->bindParam(':cpoe_comment', $cpoe_comment)
                    ->bindParam(':cpoe_order_by', $cpoe_order_by)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':pt_trp_regimen_paycode', $pt_trp_regimen_paycode)
                    ->bindParam(':pt_cpr_number', $pt_cpr_number)
                    ->bindParam(':pt_ocpa_number', $pt_ocpa_number)
                    ->execute();
            return 'success';
        }
    }

    public function actionCheckPrintLabel() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = \app\modules\pharmacy\models\TbPrintDruglabel::findAll(['orderid' => $request->post('ids'), 'orderstatus' => 1]);
            return $model != null ? 'duplicate' : 'print';
        } else {
            return false;
        }
    }

    public function actionPrintSingleLabel() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $cpoe_ids = $request->post('ids');
            Yii::$app->db->createCommand('CALL cmd_cpoe_rx_print(:cpoe_ids);')
                    ->bindParam(':cpoe_ids', $cpoe_ids)
                    ->execute();
            return 'Print Success!';
        } else {
            return false;
        }
    }

    public function actionExportDownload($id, $type) {
        $model = $this->findModel($id);
        $searchModel = new VwCpoeRxDetail2Search();
        $dataProvider = $searchModel->search_order(Yii::$app->request->queryParams, $id);
        $header = VwPtServiceListOp::findOne($model['pt_vn_number']);
        $ptar = VwPtAr::find()->where(['pt_visit_number' => $model['pt_vn_number']])->all();
        $query11 = VwCpoeRxDetail2::find()->where(['cpoe_id' => $id, 'cpoe_Itemtype' => [10, 20, 21, 22, 40, 50, 53, 54]])->asArray('cpoe_Itemtype')->groupBy('cpoe_Itemtype')->orderBy('cpoe_seq')->all();
        if ($type == 'A4') {
            $content = $this->renderPartial('_form_print', [
                'dataProvider' => $dataProvider,
                'type' => 'A4_content',
                'model' => $model,
                'header' => $header,
                'ptar' => $ptar,
                'query11' => $query11,
            ]);
            $marginTop = 70;
            $marginLeft = 10;
            $marginRight = 10;
            $marginBottom = false;
            $marginHeader = 5;
            $marginFooter = 5;
        } elseif ($type == 'Tabloid') {
            $content = $this->renderPartial('_form_print', [
                'dataProvider' => $dataProvider,
                'type' => 'slip_content',
                'model' => $model,
                'header' => $header,
                'ptar' => $ptar,
            ]);
            $marginTop = 55;
            $marginLeft = 3;
            $marginRight = 3;
            $marginBottom = 25;
            $marginHeader = 5;
            $marginFooter = 5;
        }
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => $type == 'Tabloid' ? [80, 150] : $type, //[60, 30], //กำหนดขนาด
            'marginTop' => $marginTop,
            'marginLeft' => $marginLeft,
            'marginRight' => $marginRight,
            'marginBottom' => $marginBottom,
            'marginHeader' => $marginHeader,
            'marginFooter' => $marginFooter,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'filename' => 'ใบสรุปรายการยา.pdf',
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'ใบสรุปรายการยา',
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => $this->renderPartial('_form_print', [
                    'model' => $model,
                    'header' => $header,
                    'ptar' => $ptar,
                    'type' => $type,
                    'query11' => $query11,
                ]),
                'SetFooter' => $this->renderPartial('_form_print', [
                    'type' => 'footer',
                    'model' => $model,
                    'header' => $header,
                    'ptar' => $ptar,
                    'query11' => $query11,
                ]),
            ]
        ]);

        echo $pdf->render();
    }

    public function actionCpoeDetails($cpoeid) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($cpoeid);
            $searchModel = new VwCpoeRxDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $cpoeid);
            $dataProvider->pagination->pageSize = false;
            $dataProvider->sort->defaultOrder = ['cpoe_seq' => SORT_ASC, 'cpoe_Itemtype' => SORT_ASC];
            return [
                'title' => 'ใบสั่งยาเลขที่ ' . $model['cpoe_num'],
                'content' => $this->renderAjax('view', [
                    'dataProvider' => $dataProvider,
                    'modelCpoe' => $model
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
            ];
        }
    }

    public function actionUpdateHistory($id) {
        $modelCpoe = $this->findModel($id);

        if (($profile = VwPtServiceListOp::findOne($modelCpoe['pt_vn_number'])) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
            $TitleModal = $profile->getHeadermodalOP($modelCpoe['pt_vn_number']);
            $provider = new ActiveDataProvider([
                'query' => VwCpoeRxHeader::find()
                        ->where(['pt_vn_number' => $modelCpoe['pt_vn_number']])
                        ->andWhere(['IN', 'cpoe_status', [5]])
                        ->orderBy('cpoe_id DESC'),
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'cpoe_id' => SORT_DESC,
                    ]
                ],
            ]);
            return $this->render('update-history', [
                        'modelCpoe' => $modelCpoe,
                        'ptar' => $ptar,
                        'profile' => $profile,
                        'TitleModal' => $TitleModal,
                        'dataProvider' => $provider,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCheckDoseqty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $ItemID = $request->post('ItemID');
            $Disunit = Yii::$app->db->createCommand('SELECT func_cal_cpoe_doseqtycheck(:ItemID) AS Disunit;')
                    ->bindParam(':ItemID', $ItemID)
                    ->queryScalar();
            return $Disunit;
        }
    }

    public function actionConvertmg() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $ItemID = $request->post('ItemID');
            $cpoe_doseqty = $request->post('doseqty');
            $Qty = Yii::$app->db->createCommand('SELECT func_cal_cpoe_doseqty(:ItemID,:cpoe_doseqty) AS Qty;')
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                    ->queryScalar();
            return $Qty == null ? '0.00' : $Qty;
        }
    }

}
