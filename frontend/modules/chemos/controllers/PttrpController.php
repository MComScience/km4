<?php

namespace app\modules\chemos\controllers;

use Yii;
use app\modules\chemo\models\TbpttrpChemo;
use app\modules\chemo\models\TbpttrpChemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
#models
use app\modules\chemo\models\Vwptservicelistop;
use app\modules\chemo\models\Vwptar;
use app\modules\chemo\models\VwPtTrpChemoSearch;
use app\modules\chemo\models\VwPtTrpChemoDetail;
use app\modules\chemo\models\VwPtTrpOrderset;
use app\modules\chemo\models\TbPtTrpChemoDetail;
use app\modules\chemo\models\VwDrugsetDetailSearch;
use app\modules\chemo\models\TbDrugsetDetail;
use app\modules\chemo\models\TbDrugset;
use app\modules\chemo\models\VwCpoeDruglistOp;
use app\modules\chemo\models\VwCpoeDrugDefault;
use app\modules\chemo\models\TbIsedReason;
use app\modules\chemo\models\VwCpoeDrugadmitDefault;
use app\modules\chemo\models\VwSigCode;
use app\modules\chemo\models\TbCpoeItemtype;
use app\modules\chemo\models\VwIvsolutionDrugsetDetail;
use app\modules\chemo\models\TbDrugprandialadvice;
use app\modules\chemo\models\TbCpoe;
use app\modules\chemo\models\VwPtTrpChemoDetailSearch;
use app\modules\chemo\models\VwPtTrpChemo;

/**
 * PttrpController implements the CRUD actions for TbpttrpChemo model.
 */
class PttrpController extends Controller {

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
     * Lists all TbpttrpChemo models.
     * @return mixed
     */
    public function actionIndex($id) {
        #id = vn
        $searchModel = new TbpttrpChemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $header = Vwptservicelistop::findOne($id);
        $ptar = Vwptar::find()->where(['pt_visit_number' => $id])->all();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'header' => $header,
                    'ptar' => $ptar,
        ]);
    }

    public function actionTreatmentindex($hn, $vn) {
        $searchModel = new VwPtTrpChemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $vn);

        $header = Vwptservicelistop::findOne($vn);
        $ptar = Vwptar::find()->where(['pt_visit_number' => $vn])->all();
        $checkplan = $this->checkPlan($vn);

        return $this->render('treatmentindex', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'header' => $header,
                    'ptar' => $ptar,
                    'checkplan' => $checkplan,
        ]);
    }

    public function checkPlan($vn) {
        $model = VwPtTrpChemo::find()
                //  ->where(['NOT IN', 'pt_trp_regimen_status', [1,3,4,5]])
                ->where(['pt_visit_number' => $vn, 'pt_trp_regimen_status' => 2])
                ->all();
        if (!empty($model)) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public function actionNewtreatmentPlan($vn) {
        $request = Yii::$app->request;
        $headermodel = $this->Createpttrp($vn);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                #setModal
                return [
                    'title' => 'Treatment Plan ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_form_headertreatment', [
                        'model' => $headermodel,
                    ]),
                ];
            }
        }
    }

    private function Createpttrp($vn) {
        //$check = TbpttrpChemo::findOne(['pt_visit_number' => $vn]);
        //if (empty($check)) {
        $id = time();
        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_pt_trp_create(:pt_trp_chemo_id,:pt_visit_number,:userid);')
                ->bindParam(':pt_trp_chemo_id', $id)
                ->bindParam(':pt_visit_number', $vn)
                ->bindParam(':userid', $userid)
                ->execute();
        $headermodel = $this->findModel($id);
        return $headermodel;
//        } else {
//            $headermodel = $this->findModel($check['pt_trp_chemo_id']);
//            return $headermodel;
//        }
    }

    public function actionUpdateTreatmentPlan($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $headermodel = $this->findModel($id);
            $headermodal = $this->getHeadermodal($headermodel->pt_visit_number);
            #setModal
            return [
                'title' => 'Treatment Plan ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_form_headertreatment', [
                    'model' => $headermodel,
                ]),
            ];
        }
    }

    public function actionSavetreatmentHeader() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $pt_trp_chemo_id = $post['TbpttrpChemo']['pt_trp_chemo_id'];
            $pt_trp_regimen_name = $post['TbpttrpChemo']['pt_trp_regimen_name'];
            $medical_right_id = $post['TbpttrpChemo']['medical_right_id'];
            $pt_trp_cpr_number = $post['TbpttrpChemo']['pt_trp_cpr_number'];
            $pt_trp_ocpa_number = $post['TbpttrpChemo']['pt_trp_ocpa_number'];
            $pt_trp_regimen_paycode = $post['TbpttrpChemo']['pt_trp_regimen_paycode'];
            $pt_trp_comment = $post['TbpttrpChemo']['pt_trp_comment'];
            $pt_trp_regimen_status = $post['TbpttrpChemo']['pt_trp_regimen_status'];
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

    public function actionCreateChemoadd($chemoid) {
        $userid = Yii::$app->user->identity->id;
        $chemo_regimen_ids = time();

        $max = TbDrugset::find()
                ->select('max(drugset_id)')
                ->scalar();

        if (!empty($max)) {
            $drugset_id = $max + 1;
        } else {
            $drugset_id = 1;
        }

        Yii::$app->db->createCommand('CALL cmd_pt_trplan_chemo_add(:userid,:pt_trp_chemo_id,:chemo_regimen_ids,:drugset_id);')
                ->bindParam(':userid', $userid)
                ->bindParam(':pt_trp_chemo_id', $chemoid)
                ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                ->bindParam(':drugset_id', $drugset_id)
                ->execute();
        return $this->redirect(['orderset', 'ids' => $chemo_regimen_ids, 'id' => $chemoid, 'drugsetid' => $drugset_id]);
    }

    public function actionOrderset($ids, $id, $drugsetid) {
        $detailmodel = VwPtTrpOrderset::findOne($ids);
        $headermodel = $this->findModel($id);
        $header = Vwptservicelistop::findOne($headermodel->pt_visit_number);
        $ptar = Vwptar::find()->where(['pt_visit_number' => $headermodel->pt_visit_number])->all();

        $searchModel = new VwDrugsetDetailSearch();
        $ivProvider = $searchModel->ivsearch(Yii::$app->request->queryParams, $ids);
        $keepProvider = $searchModel->search_keep(Yii::$app->request->queryParams, $ids); #เปิดเส้น
        $premedProvider = $searchModel->search_premed(Yii::$app->request->queryParams, $ids); #Premed
        $medicatProvider = $searchModel->search_medicat(Yii::$app->request->queryParams, $ids); #Medical
        $keepProvider->pagination->pageSize = 10;
        $premedProvider->pagination->pageSize = 10;
        $medicatProvider->pagination->pageSize = 10;
        $keepProvider->pagination->pageSize = 10;

        return $this->render('orderset', [
                    'detailmodel' => $detailmodel,
                    'header' => $header,
                    'ptar' => $ptar,
                    'headermodel' => $headermodel,
                    'keepProvider' => $keepProvider, #เปิดเส้น
                    'premedProvider' => $premedProvider, #Premed
                    'medicatProvider' => $medicatProvider, #Medical
                    'ivProvider' => $ivProvider,
                    'drugsetid' => $drugsetid,
                    'drugset_ids' => $ids,
        ]);
    }

    public function actionArdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = Vwptar::find()->where(['pt_visit_number' => $request->get('vn_number')])->all();
                $headerdetail = Vwptservicelistop::findOne(['pt_visit_number' => $request->get('vn_number')]);
                $headermodal = $this->getHeadermodal($request->get('vn_number'));
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

    public function actionCreateKeepVein($ids, $vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $ids,
                        'drugsetid' => $drugsetid,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditKeepVein($ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $drugsetmodel['chemo_regimen_ids'],
                        'drugsetid' => $drugsetmodel['drugset_id'],
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreatePremedication($ids, $vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $ids,
                        'drugsetid' => $drugsetid,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditPremedication($ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $drugsetmodel['chemo_regimen_ids'],
                        'drugsetid' => $drugsetmodel['drugset_id'],
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateMedication($ids, $vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $ids,
                        'drugsetid' => $drugsetid,
                        'cpoetype' => $cpoetype,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditMedication($ids) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $drugsetmodel['chemo_regimen_ids'],
                        'drugsetid' => $drugsetmodel['drugset_id'],
                        'cpoetype' => $cpoetype,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateInj($ids, $vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $ids,
                        'drugsetid' => $drugsetid,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditInj($ids) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $drugsetmodel['chemo_regimen_ids'],
                        'drugsetid' => $drugsetmodel['drugset_id'],
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateChemopo($ids, $vn, $drugsetid) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn);
                $creditgroups = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $ids,
                        'drugsetid' => $drugsetid,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditChemopo($ids) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($query_vn['pt_visit_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_visit_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedmodel = TbIsedReason::find()->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'isedmodel' => $isedmodel,
                        'regimen_ids' => $drugsetmodel['chemo_regimen_ids'],
                        'drugsetid' => $drugsetmodel['drugset_id'],
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset_ids = time();
                $drugset_id = $request->get('drugset_id');
                $vn = $request->get('vn');
                $regimen_ids = $request->get('regimen_ids');

                //$headermodel = TbDrugset::findOne($drugset_id);
                $this->CreateIvsolution($drugset_id, $drugset_ids, $regimen_ids);
                $invmodel = VwIvsolutionDrugsetDetail::find()->where(['cpoe_parentid' => $drugset_ids])->all();
                $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);

                $creditgroup = $this->getCreditGroup($vn);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup])->all();
                $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetmodel->cpoe_drugprandialadviceid), 'id', 'name');
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'drugset_ids' => $drugset_ids,
                            'drugset_id' => $drugset_id,
                            'drugsetmodel' => $drugsetmodel,
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
            $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);
            $queryvn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
            $invmodel = VwIvsolutionDrugsetDetail::find()->where(['cpoe_parentid' => $drugset_ids])->all();

            $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
            $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup])->all();
            $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetmodel->cpoe_drugprandialadviceid), 'id', 'name');
            $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
            return $this->renderAjax('_formiv', [
                        'invmodel' => $invmodel,
                        'drugset_ids' => $drugset_ids,
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'drugsetmodel' => $drugsetmodel,
                        'vn' => $queryvn['pt_visit_number'],
                        'druglistop' => $druglistop,
                        'route' => $queryroute,
                        'adviceid' => $adviceid,
            ]);
        }
    }

    private function CreateIvsolution($drugset_id, $drugset_ids, $regimen_ids) {
        Yii::$app->db->createCommand('CALL cmd_drugset_ivsolution_create(:drugset_id,:drugset_ids,:chemo_regimen_ids);')
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':drugset_ids', $drugset_ids)
                ->bindParam(':chemo_regimen_ids', $regimen_ids)
                ->execute();
        return $drugset_ids;
    }

    public function actionCreateBase($drugset_id, $vn_number, $drugset_ids) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn_number);
                $seq = TbDrugsetDetail::findOne($drugset_ids);
                $creditgroup = $this->getCreditGroup($vn_number);
                $isedmodel = TbIsedReason::find()->all();
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '157'])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'isedmodel' => $isedmodel,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugset_ids,
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                        'regimen_ids' => $seq['chemo_regimen_ids'],
                        'contentshow' => 'create'
                    ]),
                ];
            }
        }
    }

    public function actionEditBasesolution($id) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $queryvn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($queryvn['pt_visit_number']);
                $seq = TbDrugsetDetail::findOne($drugsetmodel['cpoe_parentid']);
                $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
                $isedmodel = TbIsedReason::find()->all();
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '157'])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'druglistop' => $druglistop,
                        'isedmodel' => $isedmodel,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugsetmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                        'regimen_ids' => $seq['chemo_regimen_ids'],
                        'contentshow' => 'create'
                    ]),
                ];
            }
        }
    }

    public function actionCreateAdditive($drugset_id, $vn_number, $drugset_ids) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn_number);
                $seq = TbDrugsetDetail::findOne($drugset_ids);
                $creditgroup = $this->getCreditGroup($vn_number);
                $isedmodel = TbIsedReason::find()->all();
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '101'])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'isedmodel' => $isedmodel,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugset_ids,
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                        'regimen_ids' => $seq['chemo_regimen_ids'],
                        'contentshow' => 'create'
                    ]),
                ];
            }
        }
    }

    public function actionEditAdditive($id) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $queryvn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
                $headermodal = $this->getHeadermodal($queryvn['pt_visit_number']);
                $seq = TbDrugsetDetail::findOne($drugsetmodel['cpoe_parentid']);
                $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
                $isedmodel = TbIsedReason::find()->all();
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup, 'Class_GP' => '101'])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'druglistop' => $druglistop,
                        'isedmodel' => $isedmodel,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugsetmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                        'regimen_ids' => $seq['chemo_regimen_ids'],
                        'contentshow' => 'create'
                    ]),
                ];
            }
        }
    }

    public function actionUpdateInstruction($drugset_id, $vn_number, $drugset_ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $queryvn = VwPtTrpChemoDetail::findOne($drugsetmodel['chemo_regimen_ids']);
            $headermodal = $this->getHeadermodal($queryvn['pt_visit_number']);
            $creditgroup = $this->getCreditGroup($queryvn['pt_visit_number']);
            $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroup])->all();
            $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetmodel->cpoe_drugprandialadviceid), 'id', 'name');
            $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
            return [
                'title' => '<i class="glyphicon glyphicon-list"></i> Drug Instruction ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_instruction_modal', [
                    'drugset_id' => $drugset_id,
                    'druglistop' => $druglistop,
                    'drugsetmodel' => $drugsetmodel,
                    'route' => $route,
                    'adviceid' => $adviceid,
                ]),
            ];
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

    public function actionSelectitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            #$request->get('id') = ItemID
            $checkned = $this->Checknedgp($request->get('id'));
            $query_drugdefault = VwCpoeDrugDefault::findOne($request->get('id'));
            $query_druglistop = VwCpoeDruglistOp::findOne($request->get('id'));
            $arr = array(
                'ned' => $checkned->NED_required,
                'gp' => $checkned->Jor2_required,
                'itemdetail' => $checkned->Itemdetail,
                'comment1' => $query_drugdefault->DrugAdminstration,
                'comment2' => $query_drugdefault->DrugPrecaution_lable,
                'comment3' => $query_drugdefault->DrugIndication_lable,
                'cpoe_doseqty' => $query_drugdefault->cpoe_doseqty,
                'RouteID' => $query_drugdefault->DrugRouteID,
                'AdviceID' => $query_drugdefault->DrugPrandialAdviceID,
                'RouteName' => $query_drugdefault->DrugRouteName,
                'AdviceName' => $query_drugdefault->DrugPrandialAdviceDesc,
                'TMTID_GPU' => $query_drugdefault->TMTID_GPU,
                'ItemPrice' => $query_druglistop->ItemPrice
            );
            return $arr;
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

    private function Checknedgp($itemid) {
        $data = VwCpoeDruglistOp::findOne($itemid);
        if (empty($data)) {
            return null;
        } else {
            return $data;
        }
    }

    private function getHeadermodal($vn) {
        $modelheader = Vwptservicelistop::findOne($vn);
        $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                ' <span class="success">VN</span> ' . $modelheader->pt_visit_number . ' | ' .
                ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
        return $headermodal;
    }

    private function getCreditGroup($vn) {
        if (!empty($vn)) {
            $querygroupid = Vwptar::find()->where(['pt_visit_number' => $vn])->all();
            foreach ($querygroupid as $data) {
                $groupid[] = $data['credit_group_id'];
            }
            return $groupid;
        } else {
            return NULL;
        }
    }

    public function actionChemoDetail() {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new VwPtTrpChemoDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $_POST['expandRowKey']);
            // $model = VwPtTrpChemoDetail::find()->where(['pt_trp_chemo_id' => $_POST['expandRowKey']])->all();
            return $this->renderAjax('_chemo-details', ['dataProvider' => $dataProvider, 'chemoid' => $_POST['expandRowKey'], 'searchModel' => $searchModel]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /**
     * Displays a single TbpttrpChemo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbpttrpChemo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbpttrpChemo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pt_trp_chemo_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbpttrpChemo model.
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
     * Deletes an existing TbpttrpChemo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }

    public function actionDeleteChemodetails() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPtTrpChemoDetail::findOne($request->post('id'));
            $model->delete();
        }
    }

    public function actionDeleteDrugsetdetail() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = TbDrugsetDetail::findOne($id)->delete();
    }

    /**
     * Finds the TbpttrpChemo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbpttrpChemo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbpttrpChemo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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

    public function actionCalculateQty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
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
            return json_encode(number_format($qty['Qty'], 2));
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

            $query = Yii::$app->db->createCommand('CALL cmd_cal_itemdrugprice_op (:ItemID, :ItemQty, :pt_visit_number,@Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt);'
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
            $drugset_ids = !empty($post['TbDrugsetDetail']['drugset_ids']) ? $post['TbDrugsetDetail']['drugset_ids'] : NULL;
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
            $cpoe_begindate = !empty($post['TbDrugsetDetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate($post['TbDrugsetDetail']['cpoe_begindate']) : NULL;
            $cpeo_begintime = !empty($post['TbDrugsetDetail']['cpeo_begintime']) ? $post['TbDrugsetDetail']['cpeo_begintime'] : NULL;
            $cpoe_enddate = !empty($post['TbDrugsetDetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate($post['TbDrugsetDetail']['cpoe_enddate']) : NULL;
            $cpoe_endtime = !empty($post['TbDrugsetDetail']['cpoe_endtime']) ? $post['TbDrugsetDetail']['cpoe_endtime'] : NULL;
            $cpoe_repeat = !empty($post['TbDrugsetDetail']['cpoe_repeat']) ? $post['TbDrugsetDetail']['cpoe_repeat'] : NULL;
            $cpoe_once = !empty($post['TbDrugsetDetail']['cpoe_once']) ? $post['TbDrugsetDetail']['cpoe_once'] : NULL;
            $cpoe_drugprandialadviceid = !empty($post['TbDrugsetDetail']['cpoe_drugprandialadviceid']) ? $post['TbDrugsetDetail']['cpoe_drugprandialadviceid'] : NULL;
            $cpoe_seq_mindelay = !empty($post['TbDrugsetDetail']['cpoe_seq_mindelay']) ? $post['TbDrugsetDetail']['cpoe_seq_mindelay'] : NULL;
            $chemo_regimen_ids = !empty($post['TbDrugsetDetail']['chemo_regimen_ids']) ? $post['TbDrugsetDetail']['chemo_regimen_ids'] : NULL;
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
            } elseif ($cpoe_Itemtype == 50) {
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

    public function actionSaveitemIvsolution() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $drugset_ids = $request->post('id');
            $itemqty = $this->strNumber($request->post('ItemQty'));
            Yii::$app->db->createCommand('CALL cmd_drugsetitemsave_ivsolution(:Adrugset_ids,:ItemQty);')
                    ->bindParam(':Adrugset_ids', $drugset_ids)
                    ->bindParam(':ItemQty', $itemqty)
                    ->execute();
            return true;
        }
    }

    public function actionSaveChemodetail() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $chemo_regimen_ids = !empty($post['VwPtTrpOrderset']['chemo_regimen_ids']) ? $post['VwPtTrpOrderset']['chemo_regimen_ids'] : NULL;
            $chemo_cycle_seq = !empty($post['VwPtTrpOrderset']['chemo_cycle_seq']) ? $post['VwPtTrpOrderset']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['VwPtTrpOrderset']['chemo_cycle_day']) ? $post['VwPtTrpOrderset']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = !empty($post['VwPtTrpOrderset']['chemo_regimen_cycleqty']) ? $post['VwPtTrpOrderset']['chemo_regimen_cycleqty'] : NULL;
            $chemo_regimen_freq_value = !empty($post['VwPtTrpOrderset']['chemo_regimen_freq_value']) ? $post['VwPtTrpOrderset']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['VwPtTrpOrderset']['chemo_regimen_freq_unit']) ? $post['VwPtTrpOrderset']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['VwPtTrpOrderset']['pt_trp_chemo_id']) ? $post['VwPtTrpOrderset']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['VwPtTrpOrderset']['pt_trp_regimen_name']) ? $post['VwPtTrpOrderset']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['VwPtTrpOrderset']['drugset_id']) ? $post['VwPtTrpOrderset']['drugset_id'] : NULL;
            $drugset_ids = !empty($post['VwPtTrpOrderset']['drugset_ids']) ? $post['VwPtTrpOrderset']['drugset_ids'] : NULL;
            $pt_trp_comment = !empty($post['VwPtTrpOrderset']['pt_trp_comment']) ? $post['VwPtTrpOrderset']['pt_trp_comment'] : NULL;
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

    public function actionSavechemoOrderset() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $chemo_regimen_ids = !empty($post['VwPtTrpOrderset']['chemo_regimen_ids']) ? $post['VwPtTrpOrderset']['chemo_regimen_ids'] : NULL;
            $chemo_cycle_seq = !empty($post['VwPtTrpOrderset']['chemo_cycle_seq']) ? $post['VwPtTrpOrderset']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['VwPtTrpOrderset']['chemo_cycle_day']) ? $post['VwPtTrpOrderset']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = !empty($post['VwPtTrpOrderset']['chemo_regimen_cycleqty']) ? $post['VwPtTrpOrderset']['chemo_regimen_cycleqty'] : NULL;
            $chemo_regimen_freq_value = !empty($post['VwPtTrpOrderset']['chemo_regimen_freq_value']) ? $post['VwPtTrpOrderset']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['VwPtTrpOrderset']['chemo_regimen_freq_unit']) ? $post['VwPtTrpOrderset']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['VwPtTrpOrderset']['pt_trp_chemo_id']) ? $post['VwPtTrpOrderset']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['VwPtTrpOrderset']['pt_trp_regimen_name']) ? $post['VwPtTrpOrderset']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['VwPtTrpOrderset']['drugset_id']) ? $post['VwPtTrpOrderset']['drugset_id'] : NULL;
            $drugset_ids = !empty($post['VwPtTrpOrderset']['drugset_ids']) ? $post['VwPtTrpOrderset']['drugset_ids'] : NULL;
            $pt_trp_comment = !empty($post['VwPtTrpOrderset']['pt_trp_comment']) ? $post['VwPtTrpOrderset']['pt_trp_comment'] : NULL;
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

    public function actionCreateRxorder($ids, $vn) {
        #ids = regimen_ids
        $max = TbCpoe::find()
                ->select('max(cpoe_id)')
                ->scalar();

        if (!empty($max)) {
            $cpoe_id = $max + 1;
        } else {
            $cpoe_id = 1;
        }
        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_pt_chemo_rxorder_create(:chemo_regimen_ids,:pt_vn_number,:userid,:cpoe_id);')
                ->bindParam(':chemo_regimen_ids', $ids)
                ->bindParam(':pt_vn_number', $vn)
                ->bindParam(':userid', $userid)
                ->bindParam(':cpoe_id', $cpoe_id)
                ->execute();
        return $this->redirect(['/chemos/rxorder/create', 'id' => $cpoe_id, 'vn' => $vn]);
    }

    private function strNumber($number) {
        if (!empty($number)) {
            return str_replace(',', '', $number);
        } else {
            return NULL;
        }
    }

    public function actionDuplicate() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $chemo_remgimen_id = $post['chemo_regimen_ids'];
            $chemo_cycle_seq = $post['chemo_cycle_seq'];
            $chemo_cycle_qty = $post['chemo_cycle_qty'];
            $userid = Yii::$app->user->identity->id;
            Yii::$app->db->createCommand('CALL cmd_pt_trplan_chemo_cyclecopy(:chemo_remgimen_id,:chemo_cycle_seq,:chemo_cycle_qty,:userid);')
                    ->bindParam(':chemo_remgimen_id', $chemo_remgimen_id)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_qty', $chemo_cycle_qty)
                    ->bindParam(':userid', $userid)
                    ->execute();
            return TRUE;
        }
    }

}
