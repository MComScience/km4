<?php

namespace app\modules\pharmacy\controllers;

use Yii;
use app\modules\pharmacy\models\TbPtTrpChemo;
use app\modules\pharmacy\models\TbPtTrpChemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
#models
use app\modules\pharmacy\models\VwPtServiceListIpSearch;
use app\modules\pharmacy\models\VwCpoeRxHeaderSearch;
use app\modules\pharmacy\models\VwPtServiceListIp;
use app\modules\pharmacy\models\VwPtAr;
use app\modules\pharmacy\models\VwPtTrpChemo;
use app\modules\pharmacy\models\VwPtTrpChemoSearch;
use app\modules\pharmacy\models\VwPtTrpChemoDetail2Search;
use app\modules\pharmacy\models\TbDrugset;
use app\modules\pharmacy\models\VwDrugsetDetailSearch;
use app\modules\pharmacy\models\TbDrugsetDetail;
use app\modules\pharmacy\models\TbIsedReason;
use app\modules\pharmacy\models\VwCpoeDrugadmitDefault;
use app\modules\pharmacy\models\VwCpoeDruglistIp;
use app\modules\pharmacy\models\VwSigCode;
use app\modules\pharmacy\models\VwCpoeDrugDefault;
use app\modules\pharmacy\models\VwIvsolutionDrugsetDetail;
use app\modules\pharmacy\models\TbDrugprandialadvice;
use app\modules\pharmacy\models\TbCpoeItemtype;
use app\modules\pharmacy\models\TbCpoe;
use app\modules\pharmacy\models\TbCpoeDetail;

/**
 * IpController implements the CRUD actions for TbPtTrpChemo model.
 */
class IpController extends Controller {

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
     * Lists all TbPtTrpChemo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VwPtServiceListIpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrderStatus() {
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order_status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPatient($data) {
        if (($header = VwPtServiceListIp::findOne($data)) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $data])->all();
            return $this->render('patient', [
                        'header' => $header,
                        'ptar' => $ptar,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single TbPtTrpChemo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbPtTrpChemo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbPtTrpChemo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pt_trp_chemo_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbPtTrpChemo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pt_trp_chemo_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbPtTrpChemo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }
    
    public function actionDeleteDrugset() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        TbDrugset::findOne($id)->delete();
        TbDrugsetDetail::deleteAll(['drugset_id' => $id]);
        return true;
    }

    /**
     * Finds the TbPtTrpChemo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbPtTrpChemo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbPtTrpChemo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionArdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = VwPtAr::find()->where(['pt_visit_number' => $request->get('vn')])->all();
                $headerdetail = VwPtServiceListIp::findOne(['pt_visit_number' => $request->get('vn')]);
                $headermodal = $this->getHeadermodal($request->get('vn'));
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

    private function getHeadermodal($vn) {
        $modelheader = VwPtServiceListIp::findOne($vn);
        $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                ' <span class="success">VN</span> ' . $modelheader->pt_visit_number . ' | ' .
                ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
        return $headermodal;
    }

    public function actionTreatment($data) {
        if (($header = VwPtServiceListIp::findOne($data)) !== null) {

            $searchModel = new VwPtTrpChemoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $data);

            $ptar = VwPtAr::find()->where(['pt_visit_number' => $data])->all();
            $checkplan = $this->checkPlan($data);
            return $this->render('treatment', [
                        'header' => $header,
                        'ptar' => $ptar,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'checkplan' => $checkplan,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function checkPlan($vn) {
        $model = VwPtTrpChemo::find()
                ->where(['pt_visit_number' => $vn, 'pt_trp_regimen_status' => 2])
                ->all();
        if (!empty($model)) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public function actionNewTreatmentPlan($vn) {
        $request = Yii::$app->request;
        $model = $this->CreatePttrp($vn);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                #setModal
                return [
                    'title' => 'Treatment Plan ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_form_headertreatment', [
                        'model' => $model,
                    ]),
                ];
            }
        }
    }

    public function actionUpdateTreatmentPlan($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $headermodal = $this->getHeadermodal($model->pt_visit_number);
            #setModal
            return [
                'title' => 'Treatment Plan ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_form_headertreatment', [
                    'model' => $model,
                ]),
            ];
        }
    }

    private function CreatePttrp($vn) {
        $pt_trp_chemo_id = TbPtTrpChemo::find()->max('pt_trp_chemo_id') + 1;
        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_pt_trp_create(:pt_trp_chemo_id,:pt_visit_number,:userid);')
                ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                ->bindParam(':pt_visit_number', $vn)
                ->bindParam(':userid', $userid)
                ->execute();
        $headermodel = $this->findModel($pt_trp_chemo_id);
        return $headermodel;
    }

    public function actionSavetreatmentHeader() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $pt_trp_chemo_id = $post['TbPtTrpChemo']['pt_trp_chemo_id'];
            $pt_trp_regimen_name = $post['TbPtTrpChemo']['pt_trp_regimen_name'];
            $medical_right_id = $post['TbPtTrpChemo']['medical_right_id'];
            $pt_trp_cpr_number = $post['TbPtTrpChemo']['pt_trp_cpr_number'];
            $pt_trp_ocpa_number = $post['TbPtTrpChemo']['pt_trp_ocpa_number'];
            $pt_trp_regimen_paycode = $post['TbPtTrpChemo']['pt_trp_regimen_paycode'];
            $pt_trp_comment = $post['TbPtTrpChemo']['pt_trp_comment'];
            $pt_trp_regimen_status = $post['TbPtTrpChemo']['pt_trp_regimen_status'];
            Yii::$app->db->createCommand('CALL cmd_cpoe_trp_save(:pt_trp_chemo_id,:pt_trp_regimen_name,:medical_right_id,:pt_trp_cpr_number,:pt_trp_ocpa_number,:pt_trp_regimen_paycode,:pt_trp_comment,:pt_trp_regimen_status);')
                    ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':medical_right_id', $medical_right_id)
                    ->bindParam(':pt_trp_cpr_number', $pt_trp_cpr_number)
                    ->bindParam(':pt_trp_ocpa_number', $pt_trp_ocpa_number)
                    ->bindParam(':pt_trp_regimen_paycode', $pt_trp_regimen_paycode)
                    ->bindParam(':pt_trp_comment', $pt_trp_comment)
                    ->bindParam(':pt_trp_regimen_status', $pt_trp_regimen_status)
                    ->execute();
            return 'success';
        }
    }

    public function actionTreatmentDetails() {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new VwPtTrpChemoDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $_POST['expandRowKey']);
            return $this->renderAjax('_treatment-details', ['dataProvider' => $dataProvider, 'chemoid' => $_POST['expandRowKey'], 'searchModel' => $searchModel]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionCreateChemoadd($chemoid) {
        $userid = Yii::$app->user->identity->id;
        $drugset_id = TbDrugset::find()->max('drugset_id') + 1;

        Yii::$app->db->createCommand('CALL cmd_pt_trplan_chemo_add2(:userid,:pt_trp_chemo_id,:drugset_id);')
                ->bindParam(':userid', $userid)
                ->bindParam(':pt_trp_chemo_id', $chemoid)
                ->bindParam(':drugset_id', $drugset_id)
                ->execute();
        return $this->redirect(['orderset', 'chemoid' => $chemoid, 'drugsetid' => $drugset_id]);
    }

    public function actionOrderset($chemoid, $drugsetid) {
        $modelChemo = $this->findModel($chemoid);
        if (empty($drugsetid)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $modelDrugset = TbDrugset::findOne($drugsetid);
        $header = VwPtServiceListIp::findOne($modelChemo->pt_visit_number);
        $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelChemo->pt_visit_number])->all();
        $headermodal = $this->getHeadermodal($modelChemo->pt_visit_number);

        $searchModel = new VwDrugsetDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $drugsetid);
        $dataProvider->pagination->pageSize = 100;

        return $this->render('orderset', [
                    'header' => $header,
                    'ptar' => $ptar,
                    'modelChemo' => $modelChemo,
                    'modelDrugset' => $modelDrugset,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'headermodal' => $headermodal,
        ]);
    }

    public function actionCreateKeepVein($vn, $drugsetid) {
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetid,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditKeepVein($ids) {
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $query_vn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetModel['drugset_id'],
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreatePremedication($vn, $drugsetid) {
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetid,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditPremedication($ids) {
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $query_vn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetModel['drugset_id'],
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionIvsolutionPremed() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset_ids = TbDrugsetDetail::find()->max('drugset_ids') + 1;
                ;
                $drugset_id = $request->get('drugset_id');
                $vn = $request->get('vn');

                $this->CreateIvsolutionPremed($drugset_id, $drugset_ids);
                $invmodel = VwIvsolutionDrugsetDetail::find()->where(['cpoe_parentid' => $drugset_ids])->all();
                $drugsetModel = TbDrugsetDetail::findOne($drugset_ids);

                $creditgroup = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup])->all();
                $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetModel->cpoe_drugprandialadviceid), 'id', 'name');
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'drugset_ids' => $drugset_ids,
                            'drugset_id' => $drugset_id,
                            'drugsetModel' => $drugsetModel,
                            'vn' => $vn,
                            'druglistop' => $druglistop,
                            'route' => $queryroute,
                            'adviceid' => $adviceid,
                ]);
            }
        }
    }

    public function actionEditIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $drugset_ids = $request->post('drugset_ids');
            $drugsetModel = TbDrugsetDetail::findOne($drugset_ids);
            $invmodel = VwIvsolutionDrugsetDetail::find()->where(['cpoe_parentid' => $drugset_ids])->all();

            $creditgroup = $this->getCreditGroup($request->post('vn_number'));
            $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup])->all();
            $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetModel->cpoe_drugprandialadviceid), 'id', 'name');
            $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
            return $this->renderAjax('_formiv', [
                        'invmodel' => $invmodel,
                        'drugset_ids' => $drugset_ids,
                        'drugset_id' => $drugsetModel['drugset_id'],
                        'drugsetModel' => $drugsetModel,
                        'vn' => $request->post('vn_number'),
                        'druglistop' => $druglistop,
                        'route' => $queryroute,
                        'adviceid' => $adviceid,
            ]);
        }
    }

    public function actionCreateBase($drugset_id, $vn, $parentid) {
        #parentid = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $seq = TbDrugsetDetail::findOne($parentid);
                $creditgroup = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '157'])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'parentid' => $parentid,
                        'seq' => $seq['cpoe_seq'],
                        'route' => $route,
                    ]),
                ];
            }
        }
    }

    public function actionEditBasesolution($id) {
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $queryvn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($queryvn['pt_visit_number']);
                $seq = TbDrugsetDetail::findOne($drugsetModel['cpoe_parentid']);
                $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '157'])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugsetModel['drugset_id'],
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'parentid' => $drugsetModel['cpoe_parentid'],
                        'route' => $route,
                        'seq' => $seq['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionCreateAdditive($drugset_id, $vn, $parentid) {
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $seq = TbDrugsetDetail::findOne($parentid);
                $creditgroup = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '101'])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'parentid' => $parentid,
                        'route' => $route,
                        'seq' => $seq['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionEditAdditive($id) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $queryvn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($queryvn['pt_visit_number']);
                $seq = TbDrugsetDetail::findOne($drugsetModel['cpoe_parentid']);
                $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '101'])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugsetModel['drugset_id'],
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'parentid' => $drugsetModel['cpoe_parentid'],
                        'route' => $route,
                        'seq' => $seq['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset_ids = TbDrugsetDetail::find()->max('drugset_ids') + 1;
                $drugset_id = $request->get('drugset_id');
                $vn = $request->get('vn');

                $this->CreateIvsolution($drugset_id, $drugset_ids);
                $invmodel = VwIvsolutionDrugsetDetail::find()->where(['cpoe_parentid' => $drugset_ids])->all();
                $drugsetModel = TbDrugsetDetail::findOne($drugset_ids);

                $creditgroup = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroup])->all();
                $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetModel->cpoe_drugprandialadviceid), 'id', 'name');
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'drugset_ids' => $drugset_ids,
                            'drugset_id' => $drugset_id,
                            'drugsetModel' => $drugsetModel,
                            'vn' => $vn,
                            'druglistop' => $druglistop,
                            'route' => $queryroute,
                            'adviceid' => $adviceid,
                ]);
            }
        }
    }

    public function actionCreateInj($vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetid,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditInj($ids) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $query_vn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetModel['drugset_id'],
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateMedication($vn, $drugsetid) {
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetid,
                        'cpoetype' => $cpoetype,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditMedication($ids) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $query_vn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetModel['drugset_id'],
                        'cpoetype' => $cpoetype,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateChemopo($vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetModel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetid,
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditChemopo($ids) {
        $request = Yii::$app->request;
        $drugsetModel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset = TbDrugset::findOne($drugsetModel['drugset_id']);
                $query_vn = TbPtTrpChemo::findOne($drugset['std_trp_chemo_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistIp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetModel' => $drugsetModel,
                        'isedModel' => $isedModel,
                        'drugsetid' => $drugsetModel['drugset_id'],
                        'route' => $route,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    private function CreateIvsolution($drugset_id, $drugset_ids) {
        $regimen_ids = null;
        Yii::$app->db->createCommand('CALL cmd_drugset_ivsolution_create(:drugset_id,:drugset_ids,:chemo_regimen_ids);')
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':drugset_ids', $drugset_ids)
                ->bindParam(':chemo_regimen_ids', $regimen_ids)
                ->execute();
        return $drugset_ids;
    }

    private function CreateIvsolutionPremed($drugset_id, $drugset_ids) {
        $regimen_ids = null;
        Yii::$app->db->createCommand('CALL cmd_drugset_ivsolution_create_premed(:drugset_id,:drugset_ids,:chemo_regimen_ids);')
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':drugset_ids', $drugset_ids)
                ->bindParam(':chemo_regimen_ids', $regimen_ids)
                ->execute();
        return $drugset_ids;
    }

    private function getCreditGroup($vn) {
        if (!empty($vn)) {
            $querygroupid = VwPtAr::find()->where(['pt_visit_number' => $vn])->all();
            foreach ($querygroupid as $data) {
                if (!empty($data['credit_group_id'])) {
                    $groupid[] = $data['credit_group_id'];
                }
            }
            return $groupid;
        } else {
            return NULL;
        }
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

    public function actionSelectitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            //$checkned = $this->Checknedgp($request->get('id'));
            $query_drugdefault = VwCpoeDrugDefault::findOne($request->get('id'));
            //$query_druglistop = VwCpoeDruglistOp::findOne($request->get('id'));
            $arr = array(
                //'ned' => $checkned->NED_required,
                //'gp' => $checkned->Jor2_required,
                'itemdetail' => $query_drugdefault->ItemDetail,
                'comment1' => $query_drugdefault->DrugAdminstration,
                'comment2' => $query_drugdefault->DrugPrecaution_lable,
                'comment3' => $query_drugdefault->DrugIndication_lable,
                'cpoe_doseqty' => $query_drugdefault->cpoe_doseqty,
                'RouteID' => $query_drugdefault->DrugRouteID,
                'AdviceID' => $query_drugdefault->DrugPrandialAdviceID,
                'RouteName' => $query_drugdefault->DrugRouteName,
                'AdviceName' => $query_drugdefault->DrugPrandialAdviceDesc,
                'TMTID_GPU' => $query_drugdefault->TMTID_GPU,
                    //'ItemPrice' => $query_druglistop->ItemPrice
            );
            return $arr;
        }
    }

    public function actionGetrouteSelect() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data1 = VwCpoeDrugadmitDefault::find()->where(['TMTID_GPU' => $request->get('gpu')])->all();
            $result = '<select id="cat-id" class="form-control">';
            $result .= '<option value="">Select Options</option>';
            foreach ($data1 as $datas) {
                $result .= '<option value="' . $datas['DrugRouteID'] . '">' . $datas['DrugRouteName'] . '</option>';
            }
            $result .= '</select>';

            $data2 = VwCpoeDrugadmitDefault::find()->where(['TMTID_GPU' => $request->get('gpu'), 'DrugRouteID' => $request->get('routeid')])->all();
            $result1 = '<select id="subcat-id" class="form-control">';
            $result1 .= '<option value="">Select Options</option>';
            foreach ($data2 as $datas) {
                $result1 .= '<option value="' . $datas['DrugPrandialAdviceID'] . '">' . $datas['DrugPrandialAdviceDesc'] . '</option>';
            }
            $result1 .= '</select>';

            $arr = array(
                'result' => $result,
                'result1' => $result1,
            );
            return Json::encode($arr);
        } else {
            $arr = array(
                'result' => '',
                'result1' => '',
            );
            return Json::encode($arr);
        }
    }

    public function actionCalculateQty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $pt_visit_number = $post['pt_visit_number'];
            $ItemQty = !empty($post['TbDrugsetDetail']['ItemQty']) ? $post['TbDrugsetDetail']['ItemQty'] : '';
            $ItemID = !empty($post['TbDrugsetDetail']['ItemID']) ? $post['TbDrugsetDetail']['ItemID'] : '';
            $cpoe_once = !empty($post['TbDrugsetDetail']['cpoe_once']) ? $post['TbDrugsetDetail']['cpoe_once'] : '';
            $cpoe_repeat = !empty($post['TbDrugsetDetail']['cpoe_repeat']) ? $post['TbDrugsetDetail']['cpoe_repeat'] : '';
            $cpoe_doseqty = !empty($post['TbDrugsetDetail']['cpoe_doseqty']) ? $post['TbDrugsetDetail']['cpoe_doseqty'] : '';
            $cpoe_sig_code = !empty($post['TbDrugsetDetail']['cpoe_sig_code']) ? $post['TbDrugsetDetail']['cpoe_sig_code'] : '';
            $cpoe_period_value = !empty($post['TbDrugsetDetail']['cpoe_period_value']) ? $post['TbDrugsetDetail']['cpoe_period_value'] : '';
            $cpoe_period_unit = !empty($post['TbDrugsetDetail']['cpoe_period_unit']) ? $post['TbDrugsetDetail']['cpoe_period_unit'] : '';
            $cpoe_frequency = !empty($post['TbDrugsetDetail']['cpoe_frequency']) ? $post['TbDrugsetDetail']['cpoe_frequency'] : '';
            $cpoe_frequency_value = !empty($post['TbDrugsetDetail']['cpoe_frequency_value']) ? $post['TbDrugsetDetail']['cpoe_frequency_value'] : '';
            $cpoe_frequency_unit = !empty($post['TbDrugsetDetail']['cpoe_frequency_unit']) ? $post['TbDrugsetDetail']['cpoe_frequency_unit'] : '';
            $cpoe_dayrepeat = !empty($post['TbDrugsetDetail']['cpoe_dayrepeat']) ? $post['TbDrugsetDetail']['cpoe_dayrepeat'] : '';
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

    public function actionCalculateDrugprice() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $ItemID = $request->post('ItemID');
            $ItemQty = $request->post('ItemQty');
            $pt_visit_number = $request->post('pt_visit_number');

            $query = Yii::$app->db->createCommand('CALL cmd_cal_itemdrugprice_op2 (:ItemID, :ItemQty, :pt_visit_number,@Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt);'
                            . 'select  @Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt;')
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemQty', $ItemQty)
                    ->bindParam(':pt_visit_number', $pt_visit_number)
                    ->execute();
            $Item_Total_Amt = Yii::$app->db->createCommand("select @Item_Total_Amt;")->queryScalar();
            $Item_Cr_Amt = Yii::$app->db->createCommand("select @Item_Cr_Amt;")->queryScalar();
            $Item_Pay_Amt = Yii::$app->db->createCommand("select @Item_Pay_Amt;")->queryScalar();
            $result = array(
                'Item_Total_Amt' => number_format($Item_Total_Amt, 2),
                'Item_Cr_Amt' => number_format($Item_Cr_Amt, 2),
                'Item_Pay_Amt' => number_format($Item_Pay_Amt, 2),
            );
            return json_encode($result);
        } else {
            return json_encode('');
        }
    }

    public function actionSaveDrugsetdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $drugset_ids = !empty($post['TbDrugsetDetail']['drugset_ids']) ? $post['TbDrugsetDetail']['drugset_ids'] : TbDrugsetDetail::find()->max('drugset_ids') + 1;
            $cpoe_detail_date = new Expression('NOW()');
            $cpoe_detail_time = new Expression('NOW()');
            $drugset_id = !empty($post['TbDrugsetDetail']['drugset_id']) ? $post['TbDrugsetDetail']['drugset_id'] : NULL;
            $cpoe_Itemtype = !empty($post['TbDrugsetDetail']['cpoe_Itemtype']) ? $post['TbDrugsetDetail']['cpoe_Itemtype'] : NULL;
            $cpoe_rxordertype = !empty($post['TbDrugsetDetail']['cpoe_rxordertype']) ? $post['TbDrugsetDetail']['cpoe_rxordertype'] : NULL;
            $ItemID = !empty($post['TbDrugsetDetail']['ItemID']) ? $post['TbDrugsetDetail']['ItemID'] : NULL;
            $ItemQty = !empty($post['TbDrugsetDetail']['ItemQty']) ? $this->strNumber($post['TbDrugsetDetail']['ItemQty']) : NULL;
            $ItemPrice = !empty($post['TbDrugsetDetail']['ItemPrice']) ? $this->strNumber($post['TbDrugsetDetail']['ItemPrice']) : NULL;
            $Item_Amt = $ItemQty * $ItemPrice;
            $ised = !empty($post['TbDrugsetDetail']['ised']) ? $post['TbDrugsetDetail']['ised'] : NULL;
            $ised_reason = !empty($post['TbDrugsetDetail']['ised_reason']) ? $post['TbDrugsetDetail']['ised_reason'] : NULL;
            $cpoe_narcotics_confirmed = !empty($post['TbDrugsetDetail']['cpoe_narcotics_confirmed']) ? $post['TbDrugsetDetail']['cpoe_narcotics_confirmed'] : NULL;
            $cpoe_ocpa = NULL;
            $cpoe_cpr = NULL;
            $Item_comment1 = !empty($post['TbDrugsetDetail']['Item_comment1']) ? $post['TbDrugsetDetail']['Item_comment1'] : NULL;
            $Item_comment2 = !empty($post['TbDrugsetDetail']['Item_comment2']) ? $post['TbDrugsetDetail']['Item_comment2'] : NULL;
            $Item_comment3 = !empty($post['TbDrugsetDetail']['Item_comment3']) ? $post['TbDrugsetDetail']['Item_comment3'] : NULL;
            $Item_comment4 = !empty($post['TbDrugsetDetail']['Item_comment4']) ? $post['TbDrugsetDetail']['Item_comment4'] : NULL;
            $cpoe_route_id = !empty($post['TbDrugsetDetail']['cpoe_route_id']) ? $post['TbDrugsetDetail']['cpoe_route_id'] : NULL;
            $cpoe_sig_code = !empty($post['TbDrugsetDetail']['cpoe_sig_code']) ? $post['TbDrugsetDetail']['cpoe_sig_code'] : NULL;
            $cpoe_iv_driprate = !empty($post['TbDrugsetDetail']['cpoe_iv_driprate']) ? $post['TbDrugsetDetail']['cpoe_iv_driprate'] : NULL;
            $cpoe_doseqty = !empty($post['TbDrugsetDetail']['cpoe_doseqty']) ? $post['TbDrugsetDetail']['cpoe_doseqty'] : NULL;
            $cpoe_prn_with_stat = null;
            $cpoe_prn_reason = !empty($post['TbDrugsetDetail']['cpoe_prn_reason']) ? $post['TbDrugsetDetail']['cpoe_prn_reason'] : NULL;
            $cpoe_stat = !empty($post['TbDrugsetDetail']['cpoe_stat']) ? $post['TbDrugsetDetail']['cpoe_stat'] : NULL;
            $cpoe_period = null;
            $cpoe_period_value = !empty($post['TbDrugsetDetail']['cpoe_period_value']) ? $post['TbDrugsetDetail']['cpoe_period_value'] : NULL;
            $cpoe_period_unit = !empty($post['TbDrugsetDetail']['cpoe_period_unit']) ? $post['TbDrugsetDetail']['cpoe_period_unit'] : NULL;
            $cpoe_frequency = !empty($post['TbDrugsetDetail']['cpoe_frequency']) ? $post['TbDrugsetDetail']['cpoe_frequency'] : NULL;
            $cpoe_frequency_value = !empty($post['TbDrugsetDetail']['cpoe_frequency_value']) ? $post['TbDrugsetDetail']['cpoe_frequency_value'] : NULL;
            $cpoe_frequency_unit = !empty($post['TbDrugsetDetail']['cpoe_frequency_unit']) ? $post['TbDrugsetDetail']['cpoe_frequency_unit'] : NULL;
            $cpoe_dayrepeat = !empty($post['TbDrugsetDetail']['cpoe_dayrepeat']) ? $post['TbDrugsetDetail']['cpoe_dayrepeat'] : NULL;
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
            $cpoe_begindate = !empty($post['TbDrugsetDetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbDrugsetDetail']['cpoe_begindate']) : NULL;
            $cpeo_begintime = !empty($post['TbDrugsetDetail']['cpeo_begintime']) ? $post['TbDrugsetDetail']['cpeo_begintime'] : NULL;
            $cpoe_enddate = !empty($post['TbDrugsetDetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbDrugsetDetail']['cpoe_enddate']) : NULL;
            $cpoe_endtime = !empty($post['TbDrugsetDetail']['cpoe_endtime']) ? $post['TbDrugsetDetail']['cpoe_endtime'] : NULL;
            $cpoe_repeat = !empty($post['TbDrugsetDetail']['cpoe_repeat']) ? $post['TbDrugsetDetail']['cpoe_repeat'] : NULL;
            $cpoe_once = !empty($post['TbDrugsetDetail']['cpoe_once']) ? $post['TbDrugsetDetail']['cpoe_once'] : NULL;
            $cpoe_drugprandialadviceid = !empty($post['TbDrugsetDetail']['cpoe_drugprandialadviceid']) ? $post['TbDrugsetDetail']['cpoe_drugprandialadviceid'] : NULL;
            $cpoe_seq_mindelay = !empty($post['TbDrugsetDetail']['cpoe_seq_mindelay']) ? $post['TbDrugsetDetail']['cpoe_seq_mindelay'] : NULL;
            $chemo_regimen_ids = !empty($post['TbDrugsetDetail']['chemo_regimen_ids']) ? $post['TbDrugsetDetail']['chemo_regimen_ids'] : NULL;
            $cpoe_doseadvice_rate_min = !empty($post['TbDrugsetDetail']['cpoe_doseadvice_rate_min']) ? $post['TbDrugsetDetail']['cpoe_doseadvice_rate_min'] : NULL;
            $cpoe_doseadvice_rate_max = !empty($post['TbDrugsetDetail']['cpoe_doseadvice_rate_max']) ? $post['TbDrugsetDetail']['cpoe_doseadvice_rate_max'] : NULL;
            $cpoe_doseadvice_rate_unit_id = !empty($post['TbDrugsetDetail']['cpoe_doseadvice_rate_unit_id']) ? $post['TbDrugsetDetail']['cpoe_doseadvice_rate_unit_id'] : NULL;
            if ($cpoe_Itemtype == 21) {
                Yii::$app->db->createCommand('CALL cmd_orderset_itemsave('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
            } elseif ($cpoe_Itemtype == 22) {
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_premed('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
                Yii::$app->db->createCommand('CALL cmd_orderset_itemsave('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
            } elseif ($cpoe_Itemtype == 53) {
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_chemoinj('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
            } elseif ($cpoe_Itemtype == 54) {
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_chemopo('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
            } elseif ($cpoe_Itemtype == 51) {
                $Acpoe_seq = !empty($post['TbDrugsetDetail']['cpoe_seq']) ? $post['TbDrugsetDetail']['cpoe_seq'] : null;
                $Acpoe_ids = !empty($post['TbDrugsetDetail']['cpoe_parentid']) ? $post['TbDrugsetDetail']['cpoe_parentid'] : NULL;
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_basesolution('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
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
                                . ':Item_comment4,'
                                . ':chemo_regimen_ids);')
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
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
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 52) {
                $Acpoe_seq = !empty($post['TbDrugsetDetail']['cpoe_seq']) ? $post['TbDrugsetDetail']['cpoe_seq'] : null;
                $Acpoe_ids = !empty($post['TbDrugsetDetail']['cpoe_parentid']) ? $post['TbDrugsetDetail']['cpoe_parentid'] : NULL;
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_additive('
                                . ':drugset_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':drugset_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':cpoe_doseadvice_rate_min,'
                                . ':cpoe_doseadvice_rate_max,'
                                . ':cpoe_doseadvice_rate_unit_id,'
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
                                . ':chemo_regimen_ids);')
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':drugset_id', $drugset_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $Acpoe_seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':cpoe_doseadvice_rate_min', $cpoe_doseadvice_rate_min)
                        ->bindParam(':cpoe_doseadvice_rate_max', $cpoe_doseadvice_rate_max)
                        ->bindParam(':cpoe_doseadvice_rate_unit_id', $cpoe_doseadvice_rate_unit_id)
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
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 50 || $cpoe_Itemtype == 40) {
                Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_instruction('
                                . ':drugset_ids,'
                                . ':cpoe_rxordertype,'
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
                        ->bindParam(':drugset_ids', $drugset_ids)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->ItemQty = $ItemQty;
                $model->save();
                return true;
            }
        }
    }

    private function strNumber($number) {
        if (!empty($number)) {
            return str_replace(',', '', $number);
        } else {
            return NULL;
        }
    }

    public function actionGetDisunit() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $disunit = VwCpoeDrugDefault::findOne($request->post('id'));
            return Json::encode($disunit->DispUnit);
        } else {
            return Json::encode('');
        }
    }

    public function actionDeleteDrugsetdetail() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = TbDrugsetDetail::findOne($id)->delete();
    }

    public function actionSavedraftOrderset() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $chemo_regimen_ids = null;
            $chemo_cycle_seq = !empty($post['TbDrugset']['chemo_cycle_seq']) ? $post['TbDrugset']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['TbDrugset']['chemo_cycle_day']) ? $post['TbDrugset']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = null;
            $chemo_regimen_freq_value = !empty($post['TbDrugset']['chemo_regimen_freq_value']) ? $post['TbDrugset']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['TbDrugset']['chemo_regimen_freq_unit']) ? $post['TbDrugset']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['TbPtTrpChemo']['pt_trp_chemo_id']) ? $post['TbPtTrpChemo']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['TbPtTrpChemo']['pt_trp_regimen_name']) ? $post['TbPtTrpChemo']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['TbDrugset']['drugset_id']) ? $post['TbDrugset']['drugset_id'] : NULL;
            $drugset_ids = null;
            $pt_trp_comment = !empty($post['TbPtTrpChemo']['pt_trp_comment']) ? $post['TbPtTrpChemo']['pt_trp_comment'] : NULL;
            Yii::$app->db->createCommand('CALL cmd_cpoe_orderset_draft(:chemo_regimen_ids,:chemo_cycle_seq,:chemo_cycle_day,:chemo_regimen_cycleqty,:chemo_regimen_freq_value,:chemo_regimen_freq_unit,:pt_trp_chemo_id,:chemo_regimen_createby,:pt_trp_regimen_name,:drugset_id,:drugset_ids,:pt_trp_comment);')
                    ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':chemo_regimen_cycleqty', $chemo_regimen_cycleqty)
                    ->bindParam(':chemo_regimen_freq_value', $chemo_regimen_freq_value)
                    ->bindParam(':chemo_regimen_freq_unit', $chemo_regimen_freq_unit)
                    ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                    ->bindParam(':chemo_regimen_createby', $chemo_regimen_createby)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':drugset_id', $drugset_id)
                    ->bindParam(':drugset_ids', $drugset_ids)
                    ->bindParam(':pt_trp_comment', $pt_trp_comment)
                    ->execute();
            return true;
        }
    }

    public function actionGetDrugadvice() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DrugrouteID = $parents[0];
                $out = $this->getDrugadvice($DrugrouteID);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDrugadvice($id) {
        $datas = TbDrugprandialadvice::find()->where(['DrugRouteID' => $id])->all();
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
            $query = VwIvsolutionDrugsetDetail::find()
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
                $table .='<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                //$table .= '<td class="text-center">' . $result->cpoe_itemtype_decs . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-basesolution', 'id' => $result['drugset_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->drugset_ids . ');']) . '</td>';
                $table .='</tr>';
            }
            $table .='</tbody>';
            $table .='</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }

    public function actionGettbDrugadditive() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = VwIvsolutionDrugsetDetail::find()
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
                $table .='<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                //$table .= '<td class="text-center">' . $result->cpoe_itemtype_decs . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-additive', 'id' => $result['drugset_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->drugset_ids . ');']) . '</td>';
                $table .='</tr>';
            }
            $table .='</tbody>';
            $table .='</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }

    public function actionSaveOrderset() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $chemo_regimen_ids = null;
            $chemo_cycle_seq = !empty($post['TbDrugset']['chemo_cycle_seq']) ? $post['TbDrugset']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['TbDrugset']['chemo_cycle_day']) ? $post['TbDrugset']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = null;
            $chemo_regimen_freq_value = !empty($post['TbDrugset']['chemo_regimen_freq_value']) ? $post['TbDrugset']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['TbDrugset']['chemo_regimen_freq_unit']) ? $post['TbDrugset']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['TbPtTrpChemo']['pt_trp_chemo_id']) ? $post['TbPtTrpChemo']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['TbPtTrpChemo']['pt_trp_regimen_name']) ? $post['TbPtTrpChemo']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['TbDrugset']['drugset_id']) ? $post['TbDrugset']['drugset_id'] : NULL;
            $drugset_ids = null;
            $pt_trp_comment = !empty($post['TbPtTrpChemo']['pt_trp_comment']) ? $post['TbPtTrpChemo']['pt_trp_comment'] : NULL;
            Yii::$app->db->createCommand('CALL cmd_cpoe_orderset_save(:chemo_regimen_ids,:chemo_cycle_seq,:chemo_cycle_day,:chemo_regimen_cycleqty,:chemo_regimen_freq_value,:chemo_regimen_freq_unit,:pt_trp_chemo_id,:chemo_regimen_createby,:pt_trp_regimen_name,:drugset_id,:drugset_ids,:pt_trp_comment);')
                    ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':chemo_regimen_cycleqty', $chemo_regimen_cycleqty)
                    ->bindParam(':chemo_regimen_freq_value', $chemo_regimen_freq_value)
                    ->bindParam(':chemo_regimen_freq_unit', $chemo_regimen_freq_unit)
                    ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                    ->bindParam(':chemo_regimen_createby', $chemo_regimen_createby)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':drugset_id', $drugset_id)
                    ->bindParam(':drugset_ids', $drugset_ids)
                    ->bindParam(':pt_trp_comment', $pt_trp_comment)
                    ->execute();
            return true;
        }
    }

    public function actionDuplicate() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            //Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $pt_trp_chemo_id = $post['pt_trp_chemo_id'];
            $chemo_cycle_seq = $post['chemo_cycle_seq'];
            $chemo_cycle_qty = $post['chemo_cycle_qty'];
            $userid = Yii::$app->user->identity->id;
            Yii::$app->db->createCommand('CALL cmd_pt_trplan_chemo_cyclecopy(:pt_trp_chemo_id,:chemo_cycle_seq,:chemo_cycle_qty,:userid);')
                    ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_qty', $chemo_cycle_qty)
                    ->bindParam(':userid', $userid)
                    ->execute();
            return json_encode('true');
        }
    }

    public function actionCreateRxorder($drugset_id, $chemoid) {
        $modelChemo = $this->findModel($chemoid);
        $vn = $modelChemo['pt_visit_number'];
        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_pt_chemo_rxorder_create2(:drugset_id,:pt_vn_number,:userid);')
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':pt_vn_number', $vn)
                ->bindParam(':userid', $userid)
                ->execute();
        $cpoe_id = TbCpoe::find()->max('cpoe_id');

        $query = TbCpoeDetail::find()
                ->where(['cpoe_id' => $cpoe_id])
                ->andWhere(['not', ['cpoe_parentid' => null]])
                ->all();
        foreach ($query as $data) {
            $modelDrugset = TbDrugsetDetail::findOne(['drugset_ids' => $data['cpoe_parentid']]);
            $modelCpoe = TbCpoeDetail::findOne(['cpoe_detail_time' => $modelDrugset['cpoe_detail_time'], 'cpoe_id' => $cpoe_id, 'cpoe_Itemtype' => $modelDrugset['cpoe_Itemtype']]);
            $model = TbCpoeDetail::findOne($data['cpoe_ids']);
            $model->cpoe_parentid = $modelCpoe['cpoe_ids'];
            $model->save();
        }

        return $this->redirect(['/pharmacy/rxorderip/create', 'data' => $cpoe_id, 'vn' => $vn]);
    }

}
