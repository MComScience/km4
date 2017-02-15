<?php

namespace app\modules\drugorders\controllers;

use Yii;
use app\modules\drugorders\models\Tbcpoe;
use app\modules\drugorders\models\TbcpoeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\drugorders\models\VwcpoerxdetailSearch;
use app\modules\drugorders\models\Vwcpoerxheader;
use app\modules\drugorders\models\Vwptar;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use app\modules\drugorders\models\TbcpoeItemtype;
use app\modules\drugorders\models\Vwcpoedruglistop;
use app\modules\drugorders\models\Vwcpoedrugdefault;
use app\modules\drugorders\models\Tbcpoedetail;
use app\modules\drugorders\models\Vwcpoedrugadmitdefault;
use app\modules\drugorders\models\Tbisedreason;
use app\modules\drugorders\models\Vwinvdetail;
use app\modules\drugorders\models\Vwcpoerxdetail;
use app\modules\drugorders\models\VwSigCode;
use app\modules\drugorders\models\Vwivsolutiondetail;
use app\modules\drugorders\models\Tbdrugprandialadvice;

/**
 * DrugorderController implements the CRUD actions for Tbcpoe model.
 */
class DrugorderController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-details' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreateHeader() {
        if (Yii::$app->request->get()) {
            $maxpk = Tbcpoe::find()
                    ->select('max(cpoe_id)')
                    ->scalar();
            if (empty($maxpk)) {
                $maxpk = 1;
            } else {
                $maxpk = $maxpk + 1;
            }
            $pt_vn_number = Yii::$app->request->get('id');
            $userid = Yii::$app->user->id;
            Yii::$app->db->createCommand('CALL cmd_create_rx_header(:cpoe_id,:x,:pt_vn_number);')
                    ->bindParam(':cpoe_id', $maxpk)
                    ->bindParam(':x', $userid)
                    ->bindParam(':pt_vn_number', $pt_vn_number)
                    ->execute();
            return $this->redirect(['index', 'id' => $maxpk]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /**
     * Lists all Tbcpoe models.
     * @return mixed
     */
    public function actionIndex($id) {
        $modelcpoe = $this->findModel($id);
        $header = Vwcpoerxheader::findOne($id);
        $ptar = Vwptar::find()->where(['pt_visit_number' => $modelcpoe->pt_vn_number])->all();
        $searchModel = new VwcpoerxdetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelcpoe' => $modelcpoe,
                    'header' => $header,
                    'ptar' => $ptar,
        ]);
    }

    public function actionArdetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = Vwptar::find()->where(['pt_visit_number' => $request->get('vn_number')])->all();
                $headerdetail = Vwcpoerxheader::findOne(['pt_vn_number' => $request->get('vn_number')]);
                return [
                    'title' => "สิทธิการรักษา#" . " " . $headerdetail->pt_name . '<span class="pull-right">' . '<b>อายุ</b> ' . $headerdetail->pt_age_registry_date . ' <b>ปี</b>' . ' <b>HN</b> ' . $headerdetail->pt_hospital_number . ' <b>VN</b> ' . $headerdetail->pt_vn_number . '&nbsp;&nbsp;' . '</span>',
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

    public function actionRxdetails() {
        if (isset($_POST['expandRowKey'])) {
            $model = Vwinvdetail::find()->where(['cpoe_ids' => $_POST['expandRowKey']])->all();
            $rxdetail = Vwcpoerxdetail::findOne(['cpoe_ids' => $_POST['expandRowKey']]);
            return $this->renderPartial('_rxdetails', ['model' => $model, 'rxdetail' => $rxdetail]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionCreateDetails($cpoeid) {
        $request = Yii::$app->request;
        $cpoedetail = new Tbcpoedetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modelheader = Vwcpoerxheader::findOne($cpoeid);
                $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                        $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                        ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                        ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                        ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                $creditgroup = $this->queryVNNumber($request->get('vn_number'));
                $isedreason = Tbisedreason::find()->all();
                $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_formrxdetails', [
                        'cpoetype' => $cpoetype,
                        'druglist' => $druglistop,
                        'cpoedetail' => $cpoedetail,
                        'cpoeid' => $cpoeid,
                        'isedreason' => $isedreason,
                        'route' => $queryroute,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])/* .
                        //      Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"]) */
                ];
            }
        }
    }

    public function actionCreateKeepVein($cpoeid, $vn_number) {
        $request = Yii::$app->request;
        $cpoedetail = new Tbcpoedetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modelheader = Vwcpoerxheader::findOne($cpoeid);
                $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                        $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                        ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                        ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                        ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 21])->all();
                $creditgroup = $this->queryVNNumber($vn_number);
                $isedreason = Tbisedreason::find()->all();
                $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_form_keepvein', [
                        'cpoetype' => $cpoetype,
                        'druglist' => $druglistop,
                        'cpoedetail' => $cpoedetail,
                        'cpoeid' => $cpoeid,
                        'isedreason' => $isedreason,
                        'route' => $queryroute,
                    ]),
                ];
            }
        }
    }

    public function actionCreatePremedication($cpoeid, $vn_number) {
        $request = Yii::$app->request;
        $cpoedetail = new Tbcpoedetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modelheader = Vwcpoerxheader::findOne($cpoeid);
                $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                        $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                        ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                        ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                        ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 22])->all();
                $creditgroup = $this->queryVNNumber($vn_number);
                $isedreason = Tbisedreason::find()->all();
                $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_form_premedication', [
                        'cpoetype' => $cpoetype,
                        'druglist' => $druglistop,
                        'cpoedetail' => $cpoedetail,
                        'cpoeid' => $cpoeid,
                        'isedreason' => $isedreason,
                        'route' => $queryroute,
                    ]),
                ];
            }
        }
    }

    public function actionCreateBase($cpoeid, $vn_number, $cpoe_ids) {
        $request = Yii::$app->request;
        $detailmodel = new Tbcpoedetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modelheader = Vwcpoerxheader::findOne($cpoeid);
                $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                        $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                        ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                        ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                        ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 51])->all();
                $seq = Tbcpoedetail::findOne($cpoe_ids);
                $creditgroup = $this->queryVNNumber($vn_number);
                $isedreason = Tbisedreason::find()->all();
                $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'cpoetype' => $cpoetype,
                        'cpoeid' => $cpoeid,
                        'druglist' => $druglistop,
                        'isedreason' => $isedreason,
                        'detailmodel' => $detailmodel,
                        'parentid' => $cpoe_ids,
                        'isedreason' => $isedreason,
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                        'contentshow' => 'create'
                    ]),
                ];
            }
        }
    }

    public function actionCreateAdditive($cpoeid, $vn_number, $cpoe_ids) {
        $request = Yii::$app->request;
        $detailmodel = new Tbcpoedetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $modelheader = Vwcpoerxheader::findOne($cpoeid);
            $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                    $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                    ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                    ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                    ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
            $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 52])->all();
            $seq = Tbcpoedetail::findOne($cpoe_ids);
            $creditgroup = $this->queryVNNumber($vn_number);
            $isedreason = Tbisedreason::find()->all();
            $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
            $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
            return [
                'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_additive_modal', [
                    'cpoetype' => $cpoetype,
                    'cpoeid' => $cpoeid,
                    'druglist' => $druglistop,
                    'isedreason' => $isedreason,
                    'detailmodel' => $detailmodel,
                    'parentid' => $cpoe_ids,
                    'isedreason' => $isedreason,
                    'route' => $queryroute,
                    'seq' => $seq['cpoe_seq'],
                    'contentshow' => 'create',
                ]),
            ];
        }
    }

    public function actionUpdateInstruction($cpoeid, $vn_number, $cpoe_ids) {
        $request = Yii::$app->request;
        $detailmodel = Tbcpoedetail::findOne($cpoe_ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $modelheader = Vwcpoerxheader::findOne($cpoeid);
            $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                    $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                    ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                    ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                    ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
            $creditgroup = $this->queryVNNumber($vn_number);
            $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
            $adviceid = ArrayHelper::map($this->getDrugadvice($detailmodel->cpoe_drugprandialadviceid), 'id', 'name');
            $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
            return [
                'title' => '<i class="glyphicon glyphicon-list"></i> Drug Instruction ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_instruction_modal', [
                    'cpoeid' => $cpoeid,
                    'druglist' => $druglistop,
                    'detailmodel' => $detailmodel,
                    'route' => $queryroute,
                    'adviceid' => $adviceid,
                ]),
            ];
        }
    }

    public function actionIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $cpoe_ids = time();
                $cpoeid = $request->get('cpoeid');

                $headermodel = Vwcpoerxheader::findOne($cpoeid);
                $this->CreateIvsolution($cpoeid, $cpoe_ids);
                $invmodel = Vwivsolutiondetail::find()->where(['cpoe_parentid' => $cpoe_ids])->all();
                $cpoedetail = Tbcpoedetail::findOne($cpoe_ids);
                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'cpoe_ids' => $cpoe_ids,
                            'headermodel' => $headermodel,
                            'detailmodel' => $cpoedetail,
                ]);
            }
        }
    }

    public function actionEditIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = $request->post('id');
            $cpoedetail = Tbcpoedetail::findOne($id);
            $headermodel = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
            $invmodel = Vwivsolutiondetail::find()->where(['cpoe_parentid' => $id])->all();
            return $this->renderAjax('_formiv', [
                        'invmodel' => $invmodel,
                        'cpoe_ids' => $id,
                        'headermodel' => $headermodel,
                        'detailmodel' => $cpoedetail,
            ]);
        }
    }

    private function CreateIvsolution($cpoeid, $cpoe_ids) {
        Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_create(:cpoe_id,:cpoe_ids);')
                ->bindParam(':cpoe_id', $cpoeid)
                ->bindParam(':cpoe_ids', $cpoe_ids)
                ->execute();
        return $cpoe_ids;
    }

    public function actionEditDetails($id) {
        $request = Yii::$app->request;
        $cpoedetail = Tbcpoedetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                if ($cpoedetail['cpoe_Itemtype'] == '10' || $cpoedetail['cpoe_Itemtype'] == '20') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                    $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                    $isedreason = Tbisedreason::find()->all();
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> แก้ไขรายการ ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_formrxdetails', [
                            'cpoetype' => $cpoetype,
                            'druglist' => $druglistop,
                            'cpoedetail' => $cpoedetail,
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'isedreason' => $isedreason,
                            'route' => $queryroute,
                        ]),
                            //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) /* .
                            //     Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"]) */
                    ];
                } elseif ($cpoedetail['cpoe_Itemtype'] == '21') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                    $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 21])->all();
                    $isedreason = Tbisedreason::find()->all();
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> Edit Keep Vein Open ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_form_keepvein', [
                            'cpoetype' => $cpoetype,
                            'druglist' => $druglistop,
                            'cpoedetail' => $cpoedetail,
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'isedreason' => $isedreason,
                            'route' => $queryroute,
                        ]),
                            //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) /* .
                            //     Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"]) */
                    ];
                } elseif ($cpoedetail['cpoe_Itemtype'] == '51') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                    $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 51])->all();
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $isedreason = Tbisedreason::find()->all();
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_base_modal', [
                            'cpoetype' => $cpoetype,
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'druglist' => $druglistop,
                            'isedreason' => $isedreason,
                            'detailmodel' => $cpoedetail,
                            'parentid' => $cpoedetail['cpoe_parentid'],
                            'isedreason' => $isedreason,
                            'route' => $queryroute,
                            'seq' => $cpoedetail['cpoe_seq'],
                            'contentshow' => 'update'
                        ]),
                    ];
                } elseif ($cpoedetail['cpoe_Itemtype'] == '52') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                    $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 52])->all();
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $isedreason = Tbisedreason::find()->all();
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_additive_modal', [
                            'cpoetype' => $cpoetype,
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'druglist' => $druglistop,
                            'isedreason' => $isedreason,
                            'detailmodel' => $cpoedetail,
                            'parentid' => $cpoedetail['cpoe_parentid'],
                            'isedreason' => $isedreason,
                            'route' => $queryroute,
                            'seq' => $cpoedetail['cpoe_seq'],
                            'contentshow' => 'update'
                        ]),
                    ];
                } elseif ($cpoedetail['cpoe_Itemtype'] == '50') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $adviceid = ArrayHelper::map($this->getDrugadvice($cpoedetail->cpoe_drugprandialadviceid), 'id', 'name');
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> Drug Instruction ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_instruction_modal', [
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'druglist' => $druglistop,
                            'detailmodel' => $cpoedetail,
                            'route' => $queryroute,
                            'adviceid' => $adviceid,
                        ]),
                    ];
                } elseif ($cpoedetail['cpoe_Itemtype'] == '22') {
                    $modelheader = Vwcpoerxheader::findOne($cpoedetail['cpoe_id']);
                    $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                            $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                            ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                            ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                            ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';

                    $cpoetype = TbcpoeItemtype::find()->where(['cpoe_itemtype_id' => 22])->all();
                    $creditgroup = $this->queryVNNumber($modelheader->pt_vn_number);
                    $isedreason = Tbisedreason::find()->all();
                    $druglistop = Vwcpoedruglistop::find()->where(['credit_group_id' => $creditgroup])->all();
                    $queryroute = Vwcpoedrugadmitdefault::findOne(['DrugRouteID' => $cpoedetail['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoedetail['cpoe_drugprandialadviceid']]);
                    return [
                        'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                        'content' => $this->renderAjax('_form_premedication', [
                            'cpoetype' => $cpoetype,
                            'druglist' => $druglistop,
                            'cpoedetail' => $cpoedetail,
                            'cpoeid' => $cpoedetail['cpoe_id'],
                            'isedreason' => $isedreason,
                            'route' => $queryroute,
                        ]),
                    ];
                }
            }
        }
    }

    private function queryVNNumber($vn_number) {
        if (!empty($vn_number)) {
            $querygroupid = Vwptar::find()->where(['pt_visit_number' => $vn_number])->all();
            foreach ($querygroupid as $data) {
                $groupid[] = $data['credit_group_id'];
            }
            return $groupid;
        } else {
            return NULL;
        }
    }

    public function actionGettableOnselcetitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = Vwcpoedrugdefault::find()->where(['ItemID' => $request->get('id')])->all();
            $checkned = $this->Checknedgp($request->get('id'));
            $comment = Vwcpoedrugdefault::findOne($request->get('id'));
            $druglistop = Vwcpoedruglistop::findOne($request->get('id'));
            $ids = $request->get('ids');
            Yii::$app->response->format = Response::FORMAT_JSON;

            $table = '<table class="default kv-grid-table table table-hover table-condensed dataTable no-footer dtr-inline" id="tbdetailonselect"><tbody>';
            foreach ($query as $result) {
                /*
                  $table .='<tr>';
                  $table .= '<td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">' . '' . '</td>';
                  $table .= '<td class="fixed-column text-right" style="width:100%;vertical-align: middle;">' . '<a class="btn btn-xs btn-success">ChangeItem</a>' . '</td>';
                  $table .='</tr>';
                 * 
                 */

                $table .='<tr>';
                $table .= '<td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">' . '<b>ItemDetail</b> ' . '</td>';
                $table .= '<td class="fixed-column text-left" style="width:100%;vertical-align: middle;">' . $result->ItemDetail . '</td>';
                $table .='</tr>';

                $table .='<tr>';
                $table .= '<td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">' . '<b>วิธีใช้ยา</b> ' . '</td>';
                $table .= '<td class="fixed-column text-left" style="width:100%;vertical-align: middle;">' . '<a href="#" data-type="textarea" class="myeditable" id="item_comment1" data-pk="' . $ids . '">' . $result->DrugAdminstration . '</a>' . '</td>';
                $table .='</tr>';

                $table .='<tr>';
                $table .= '<td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">' . '<b>คำเตือน!</b> ' . '</td>';
                $table .= '<td class="fixed-column text-left" style="width:100%;vertical-align: middle;">' . '<a href="#" data-type="textarea" class="myeditable" id="item_comment2" data-pk="' . $ids . '">' . $result->DrugPrecaution_lable . '</a>' . '</td>';
                $table .='</tr>';

                $table .='<tr>';
                $table .= '<td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">' . '<b>สรรพคุณ</b> ' . '</td>';
                $table .= '<td class="fixed-column text-left" style="width:100%;vertical-align: middle;">' . '<a href="#" data-type="textarea" class="myeditable" id="item_comment3" data-pk="' . $ids . '">' . $result->DrugIndication_lable . '</a>' . '</td>';
                $table .='</tr>';
            }

            $table .='</tbody>';
            $table .='</table>';
            $arr = array(
                'table' => $table,
                'ned' => $checkned->NED_required,
                'gp' => $checkned->Jor2_required,
                'itemdetail' => $checkned->Itemdetail,
                'comment1' => $comment->DrugAdminstration,
                'comment2' => $comment->DrugPrecaution_lable,
                'comment3' => $comment->DrugIndication_lable,
                'cpoe_doseqty' => $comment->cpoe_doseqty,
                'RouteID' => $comment->DrugRouteID,
                'AdviceID' => $comment->DrugPrandialAdviceID,
                'RouteName' => $comment->DrugRouteName,
                'AdviceName' => $comment->DrugPrandialAdviceDesc,
                'TMTID_GPU' => $comment->TMTID_GPU,
                'ItemPrice' => $druglistop->ItemPrice
            );
            return $arr;
        }
    }

    public function actionSelectitemBase() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $checkned = $this->Checknedgp($request->post('itemid'));
            $druglistop = Vwcpoedruglistop::findOne($request->post('itemid'));
            $arr = array(
                'ned' => $checkned->NED_required,
                'gp' => $checkned->Jor2_required,
                'itemdetail' => $checkned->Itemdetail,
                'ItemPrice' => $druglistop->ItemPrice
            );
            return $arr;
        }
    }

    public function actionSaveDetailcpoe() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            if ($post['Tbcpoedetail']['cpoe_Itemtype'] == '10' || $post['Tbcpoedetail']['cpoe_Itemtype'] == '20') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_detail_date = new Expression('NOW()');
                $cpoe_detail_time = new Expression('NOW()');
                $cpoe_id = !empty($post['Tbcpoedetail']['cpoe_id']) ? $post['Tbcpoedetail']['cpoe_id'] : null;
                $cpoe_Itemtype = !empty($post['Tbcpoedetail']['cpoe_Itemtype']) ? $post['Tbcpoedetail']['cpoe_Itemtype'] : null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $ItemID = $post['Tbcpoedetail']['ItemID'];
                $ItemQty = !empty($post['Tbcpoedetail']['ItemQty']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemQty']) : null;
                $ItemPrice = !empty($post['Tbcpoedetail']['ItemPrice']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemPrice']) : null;
                $Item_Amt = $ItemQty * $ItemPrice;
                $ised = !empty($post['Tbcpoedetail']['ised_reason']) ? '1' : null;
                $ised_reason = !empty($post['Tbcpoedetail']['ised_reason']) ? $post['Tbcpoedetail']['ised_reason'] : null;
                $cpoe_narcotics_confirmed = !empty($post['Tbcpoedetail']['cpoe_narcotics_confirmed']) ? $post['Tbcpoedetail']['cpoe_narcotics_confirmed'] : null;
                $cpoe_ocpa = NULL;
                $cpoe_cpr = NULL;
                $Item_comment1 = !empty($post['Tbcpoedetail']['Item_comment1']) ? $post['Tbcpoedetail']['Item_comment1'] : null;
                $Item_comment2 = !empty($post['Tbcpoedetail']['Item_comment2']) ? $post['Tbcpoedetail']['Item_comment2'] : null;
                $Item_comment3 = !empty($post['Tbcpoedetail']['Item_comment3']) ? $post['Tbcpoedetail']['Item_comment3'] : null;
                $Item_comment4 = !empty($post['Tbcpoedetail']['Item_comment4']) ? $post['Tbcpoedetail']['Item_comment4'] : null;
                $cpoe_route_id = !empty($post['Tbcpoedetail']['cpoe_route_id']) ? $post['Tbcpoedetail']['cpoe_route_id'] : null;
                $cpoe_sig_code = !empty($post['Tbcpoedetail']['cpoe_sig_code']) ? $post['Tbcpoedetail']['cpoe_sig_code'] : null;
                $cpoe_iv_driprate = !empty($post['Tbcpoedetail']['cpoe_iv_driprate']) ? $post['Tbcpoedetail']['cpoe_iv_driprate'] : null;
                $cpoe_doseqty = !empty($post['Tbcpoedetail']['cpoe_doseqty']) ? $post['Tbcpoedetail']['cpoe_doseqty'] : null;
                $cpoe_prn_with_stat = null;
                $cpoe_prn_reason = !empty($post['Tbcpoedetail']['cpoe_prn_reason']) ? $post['Tbcpoedetail']['cpoe_prn_reason'] : null;
                $cpoe_stat = !empty($post['Tbcpoedetail']['cpoe_stat']) ? $post['Tbcpoedetail']['cpoe_stat'] : null;
                $cpoe_period = null;
                $cpoe_period_value = !empty($post['Tbcpoedetail']['cpoe_period_value']) ? $post['Tbcpoedetail']['cpoe_period_value'] : null;
                $cpoe_period_unit = !empty($post['Tbcpoedetail']['cpoe_period_unit']) ? $post['Tbcpoedetail']['cpoe_period_unit'] : null;
                $cpoe_frequency = !empty($post['Tbcpoedetail']['cpoe_frequency']) ? $post['Tbcpoedetail']['cpoe_frequency'] : null;
                $cpoe_frequency_value = !empty($post['Tbcpoedetail']['cpoe_frequency_value']) ? $post['Tbcpoedetail']['cpoe_frequency_value'] : null;
                $cpoe_frequency_unit = !empty($post['Tbcpoedetail']['cpoe_frequency_unit']) ? $post['Tbcpoedetail']['cpoe_frequency_unit'] : null;
                $cpoe_dayrepeat = !empty($post['Tbcpoedetail']['cpoe_dayrepeat']) ? $post['Tbcpoedetail']['cpoe_dayrepeat'] : null;
                $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
                $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
                $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
                $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
                $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
                $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
                $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
                $cpoe_begindate = !empty($post['Tbcpoedetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_begindate']) : null;
                $cpeo_begintime = !empty($post['Tbcpoedetail']['cpeo_begintime']) ? $post['Tbcpoedetail']['cpeo_begintime'] : null;
                $cpoe_enddate = !empty($post['Tbcpoedetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_enddate']) : null;
                $cpoe_endtime = !empty($post['Tbcpoedetail']['cpoe_endtime']) ? $post['Tbcpoedetail']['cpoe_endtime'] : null;
                $cpoe_repeat = !empty($post['Tbcpoedetail']['cpoe_repeat']) ? $post['Tbcpoedetail']['cpoe_repeat'] : null;
                $cpoe_once = !empty($post['Tbcpoedetail']['cpoe_once']) ? $post['Tbcpoedetail']['cpoe_once'] : null;
                $cpoe_drugprandialadviceid = !empty($post['Tbcpoedetail']['cpoe_drugprandialadviceid']) ? $post['Tbcpoedetail']['cpoe_drugprandialadviceid'] : null;
                $cpoe_seq_mindelay = !empty($post['Tbcpoedetail']['cpoe_seq_mindelay']) ? $post['Tbcpoedetail']['cpoe_seq_mindelay'] : null;
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
            } elseif ($post['Tbcpoedetail']['cpoe_Itemtype'] == '21') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_detail_date = new Expression('NOW()');
                $cpoe_detail_time = new Expression('NOW()');
                $cpoe_id = !empty($post['Tbcpoedetail']['cpoe_id']) ? $post['Tbcpoedetail']['cpoe_id'] : null;
                $cpoe_Itemtype = !empty($post['Tbcpoedetail']['cpoe_Itemtype']) ? $post['Tbcpoedetail']['cpoe_Itemtype'] : null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $ItemID = $post['Tbcpoedetail']['ItemID'];
                $ItemQty = !empty($post['Tbcpoedetail']['ItemQty']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemQty']) : null;
                $ItemPrice = !empty($post['Tbcpoedetail']['ItemPrice']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemPrice']) : null;
                $Item_Amt = $ItemQty * $ItemPrice;
                $ised = !empty($post['Tbcpoedetail']['ised_reason']) ? '1' : null;
                $ised_reason = !empty($post['Tbcpoedetail']['ised_reason']) ? $post['Tbcpoedetail']['ised_reason'] : null;
                $cpoe_narcotics_confirmed = !empty($post['Tbcpoedetail']['cpoe_narcotics_confirmed']) ? $post['Tbcpoedetail']['cpoe_narcotics_confirmed'] : null;
                $cpoe_ocpa = NULL;
                $cpoe_cpr = NULL;
                $Item_comment1 = !empty($post['Tbcpoedetail']['Item_comment1']) ? $post['Tbcpoedetail']['Item_comment1'] : null;
                $Item_comment2 = !empty($post['Tbcpoedetail']['Item_comment2']) ? $post['Tbcpoedetail']['Item_comment2'] : null;
                $Item_comment3 = !empty($post['Tbcpoedetail']['Item_comment3']) ? $post['Tbcpoedetail']['Item_comment3'] : null;
                $Item_comment4 = !empty($post['Tbcpoedetail']['Item_comment4']) ? $post['Tbcpoedetail']['Item_comment4'] : null;
                $cpoe_route_id = !empty($post['Tbcpoedetail']['cpoe_route_id']) ? $post['Tbcpoedetail']['cpoe_route_id'] : null;
                $cpoe_sig_code = !empty($post['Tbcpoedetail']['cpoe_sig_code']) ? $post['Tbcpoedetail']['cpoe_sig_code'] : null;
                $cpoe_iv_driprate = !empty($post['Tbcpoedetail']['cpoe_iv_driprate']) ? $post['Tbcpoedetail']['cpoe_iv_driprate'] : null;
                $cpoe_doseqty = !empty($post['Tbcpoedetail']['cpoe_doseqty']) ? $post['Tbcpoedetail']['cpoe_doseqty'] : null;
                $cpoe_prn_with_stat = null;
                $cpoe_prn_reason = !empty($post['Tbcpoedetail']['cpoe_prn_reason']) ? $post['Tbcpoedetail']['cpoe_prn_reason'] : null;
                $cpoe_stat = !empty($post['Tbcpoedetail']['cpoe_stat']) ? $post['Tbcpoedetail']['cpoe_stat'] : null;
                $cpoe_period = null;
                $cpoe_period_value = !empty($post['Tbcpoedetail']['cpoe_period_value']) ? $post['Tbcpoedetail']['cpoe_period_value'] : null;
                $cpoe_period_unit = !empty($post['Tbcpoedetail']['cpoe_period_unit']) ? $post['Tbcpoedetail']['cpoe_period_unit'] : null;
                $cpoe_frequency = !empty($post['Tbcpoedetail']['cpoe_frequency']) ? $post['Tbcpoedetail']['cpoe_frequency'] : null;
                $cpoe_frequency_value = !empty($post['Tbcpoedetail']['cpoe_frequency_value']) ? $post['Tbcpoedetail']['cpoe_frequency_value'] : null;
                $cpoe_frequency_unit = !empty($post['Tbcpoedetail']['cpoe_frequency_unit']) ? $post['Tbcpoedetail']['cpoe_frequency_unit'] : null;
                $cpoe_dayrepeat = !empty($post['Tbcpoedetail']['cpoe_dayrepeat']) ? $post['Tbcpoedetail']['cpoe_dayrepeat'] : null;
                $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
                $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
                $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
                $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
                $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
                $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
                $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
                $cpoe_begindate = !empty($post['Tbcpoedetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_begindate']) : null;
                $cpeo_begintime = !empty($post['Tbcpoedetail']['cpeo_begintime']) ? $post['Tbcpoedetail']['cpeo_begintime'] : null;
                $cpoe_enddate = !empty($post['Tbcpoedetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_enddate']) : null;
                $cpoe_endtime = !empty($post['Tbcpoedetail']['cpoe_endtime']) ? $post['Tbcpoedetail']['cpoe_endtime'] : null;
                $cpoe_repeat = !empty($post['Tbcpoedetail']['cpoe_repeat']) ? $post['Tbcpoedetail']['cpoe_repeat'] : null;
                $cpoe_once = !empty($post['Tbcpoedetail']['cpoe_once']) ? $post['Tbcpoedetail']['cpoe_once'] : null;
                $cpoe_drugprandialadviceid = !empty($post['Tbcpoedetail']['cpoe_drugprandialadviceid']) ? $post['Tbcpoedetail']['cpoe_drugprandialadviceid'] : null;
                $cpoe_seq_mindelay = !empty($post['Tbcpoedetail']['cpoe_seq_mindelay']) ? $post['Tbcpoedetail']['cpoe_seq_mindelay'] : null;
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
            } elseif ($post['Tbcpoedetail']['cpoe_Itemtype'] == '51') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_detail_date = new Expression('NOW()');
                $cpoe_detail_time = new Expression('NOW()');
                $cpoe_id = !empty($post['Tbcpoedetail']['cpoe_id']) ? $post['Tbcpoedetail']['cpoe_id'] : null;
                $Acpoe_ids = !empty($post['Tbcpoedetail']['cpoe_parentid']) ? $post['Tbcpoedetail']['cpoe_parentid'] : null;
                $Acpoe_seq = !empty($post['Tbcpoedetail']['cpoe_seq']) ? $post['Tbcpoedetail']['cpoe_seq'] : null;
                $cpoe_level = !empty($post['Tbcpoedetail']['cpoe_level']) ? $post['Tbcpoedetail']['cpoe_level'] : null;
                $cpoe_drugset_id = null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $ItemID = $post['Tbcpoedetail']['ItemID'];
                $ItemQty = !empty($post['Tbcpoedetail']['ItemQty']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemQty']) : null;
                $ItemPrice = !empty($post['Tbcpoedetail']['ItemPrice']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemPrice']) : null;
                $Item_Amt = $ItemQty * $ItemPrice;
                $ised = !empty($post['Tbcpoedetail']['ised_reason']) ? '1' : null;
                $ised_reason = !empty($post['Tbcpoedetail']['ised_reason']) ? $post['Tbcpoedetail']['ised_reason'] : null;
                $cpoe_narcotics_confirmed = !empty($post['Tbcpoedetail']['cpoe_narcotics_confirmed']) ? $post['Tbcpoedetail']['cpoe_narcotics_confirmed'] : null;
                $cpoe_ocpa = NULL;
                $cpoe_cpr = NULL;
                $Item_comment1 = !empty($post['Tbcpoedetail']['Item_comment1']) ? $post['Tbcpoedetail']['Item_comment1'] : null;
                $Item_comment2 = !empty($post['Tbcpoedetail']['Item_comment2']) ? $post['Tbcpoedetail']['Item_comment2'] : null;
                $Item_comment3 = !empty($post['Tbcpoedetail']['Item_comment3']) ? $post['Tbcpoedetail']['Item_comment3'] : null;
                $Item_comment4 = !empty($post['Tbcpoedetail']['Item_comment4']) ? $post['Tbcpoedetail']['Item_comment4'] : null;
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
            } elseif ($post['Tbcpoedetail']['cpoe_Itemtype'] == '52') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_detail_date = new Expression('NOW()');
                $cpoe_detail_time = new Expression('NOW()');
                $cpoe_id = !empty($post['Tbcpoedetail']['cpoe_id']) ? $post['Tbcpoedetail']['cpoe_id'] : null;
                $Acpoe_ids = !empty($post['Tbcpoedetail']['cpoe_parentid']) ? $post['Tbcpoedetail']['cpoe_parentid'] : null;
                $Acpoe_seq = !empty($post['Tbcpoedetail']['cpoe_seq']) ? $post['Tbcpoedetail']['cpoe_seq'] : null;
                $cpoe_level = !empty($post['Tbcpoedetail']['cpoe_level']) ? $post['Tbcpoedetail']['cpoe_level'] : null;
                $cpoe_drugset_id = null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $ItemID = $post['Tbcpoedetail']['ItemID'];
                $ItemQty = !empty($post['Tbcpoedetail']['ItemQty']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemQty']) : null;
                $ItemPrice = !empty($post['Tbcpoedetail']['ItemPrice']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemPrice']) : null;
                $Item_Amt = $ItemQty * $ItemPrice;
                $ised = !empty($post['Tbcpoedetail']['ised_reason']) ? '1' : null;
                $ised_reason = !empty($post['Tbcpoedetail']['ised_reason']) ? $post['Tbcpoedetail']['ised_reason'] : null;
                $cpoe_narcotics_confirmed = !empty($post['Tbcpoedetail']['cpoe_narcotics_confirmed']) ? $post['Tbcpoedetail']['cpoe_narcotics_confirmed'] : null;
                $cpoe_ocpa = NULL;
                $cpoe_cpr = NULL;
                $Item_comment1 = !empty($post['Tbcpoedetail']['Item_comment1']) ? $post['Tbcpoedetail']['Item_comment1'] : null;
                $Item_comment2 = !empty($post['Tbcpoedetail']['Item_comment2']) ? $post['Tbcpoedetail']['Item_comment2'] : null;
                $Item_comment3 = !empty($post['Tbcpoedetail']['Item_comment3']) ? $post['Tbcpoedetail']['Item_comment3'] : null;
                $Item_comment4 = !empty($post['Tbcpoedetail']['Item_comment4']) ? $post['Tbcpoedetail']['Item_comment4'] : null;
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
                return true;
            } elseif ($post['Tbcpoedetail']['cpoe_Itemtype'] == '50') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $cpoe_route_id = !empty($post['Tbcpoedetail']['cpoe_route_id']) ? $post['Tbcpoedetail']['cpoe_route_id'] : null;
                $cpoe_sig_code = !empty($post['Tbcpoedetail']['cpoe_sig_code']) ? $post['Tbcpoedetail']['cpoe_sig_code'] : null;
                $cpoe_iv_driprate = !empty($post['Tbcpoedetail']['cpoe_iv_driprate']) ? $post['Tbcpoedetail']['cpoe_iv_driprate'] : null;
                $cpoe_doseqty = !empty($post['Tbcpoedetail']['cpoe_doseqty']) ? $post['Tbcpoedetail']['cpoe_doseqty'] : null;
                $cpoe_prn_with_stat = null;
                $cpoe_prn_reason = !empty($post['Tbcpoedetail']['cpoe_prn_reason']) ? $post['Tbcpoedetail']['cpoe_prn_reason'] : null;
                $cpoe_stat = !empty($post['Tbcpoedetail']['cpoe_stat']) ? $post['Tbcpoedetail']['cpoe_stat'] : null;
                $cpoe_period = null;
                $cpoe_period_value = !empty($post['Tbcpoedetail']['cpoe_period_value']) ? $post['Tbcpoedetail']['cpoe_period_value'] : null;
                $cpoe_period_unit = !empty($post['Tbcpoedetail']['cpoe_period_unit']) ? $post['Tbcpoedetail']['cpoe_period_unit'] : null;
                $cpoe_frequency = !empty($post['Tbcpoedetail']['cpoe_frequency']) ? $post['Tbcpoedetail']['cpoe_frequency'] : null;
                $cpoe_frequency_value = !empty($post['Tbcpoedetail']['cpoe_frequency_value']) ? $post['Tbcpoedetail']['cpoe_frequency_value'] : null;
                $cpoe_frequency_unit = !empty($post['Tbcpoedetail']['cpoe_frequency_unit']) ? $post['Tbcpoedetail']['cpoe_frequency_unit'] : null;
                $cpoe_dayrepeat = !empty($post['Tbcpoedetail']['cpoe_dayrepeat']) ? $post['Tbcpoedetail']['cpoe_dayrepeat'] : null;
                $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
                $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
                $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
                $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
                $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
                $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
                $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
                $cpoe_begindate = !empty($post['Tbcpoedetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_begindate']) : null;
                $cpeo_begintime = !empty($post['Tbcpoedetail']['cpeo_begintime']) ? $post['Tbcpoedetail']['cpeo_begintime'] : null;
                $cpoe_enddate = !empty($post['Tbcpoedetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_enddate']) : null;
                $cpoe_endtime = !empty($post['Tbcpoedetail']['cpoe_endtime']) ? $post['Tbcpoedetail']['cpoe_endtime'] : null;
                $cpoe_repeat = !empty($post['Tbcpoedetail']['cpoe_repeat']) ? $post['Tbcpoedetail']['cpoe_repeat'] : null;
                $cpoe_once = !empty($post['Tbcpoedetail']['cpoe_once']) ? $post['Tbcpoedetail']['cpoe_once'] : null;
                $cpoe_drugprandialadviceid = !empty($post['Tbcpoedetail']['cpoe_drugprandialadviceid']) ? $post['Tbcpoedetail']['cpoe_drugprandialadviceid'] : null;
                $cpoe_seq_mindelay = !empty($post['Tbcpoedetail']['cpoe_seq_mindelay']) ? $post['Tbcpoedetail']['cpoe_seq_mindelay'] : null;
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_instruction('
                                . ':cpoe_ids,'
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
                        ->bindParam(':cpoe_ids', $cpoe_ids)
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
                return true;
            } elseif ($post['Tbcpoedetail']['cpoe_Itemtype'] == '22') {
                $cpoe_ids = !empty($post['Tbcpoedetail']['cpoe_ids']) ? $post['Tbcpoedetail']['cpoe_ids'] : null;
                $cpoe_detail_date = new Expression('NOW()');
                $cpoe_detail_time = new Expression('NOW()');
                $cpoe_id = !empty($post['Tbcpoedetail']['cpoe_id']) ? $post['Tbcpoedetail']['cpoe_id'] : null;
                $cpoe_Itemtype = !empty($post['Tbcpoedetail']['cpoe_Itemtype']) ? $post['Tbcpoedetail']['cpoe_Itemtype'] : null;
                $cpoe_rxordertype = !empty($post['Tbcpoedetail']['cpoe_rxordertype']) ? $post['Tbcpoedetail']['cpoe_rxordertype'] : null;
                $ItemID = $post['Tbcpoedetail']['ItemID'];
                $ItemQty = !empty($post['Tbcpoedetail']['ItemQty']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemQty']) : null;
                $ItemPrice = !empty($post['Tbcpoedetail']['ItemPrice']) ? str_replace(',', '', $post['Tbcpoedetail']['ItemPrice']) : null;
                $Item_Amt = $ItemQty * $ItemPrice;
                $ised = !empty($post['Tbcpoedetail']['ised_reason']) ? '1' : null;
                $ised_reason = !empty($post['Tbcpoedetail']['ised_reason']) ? $post['Tbcpoedetail']['ised_reason'] : null;
                $cpoe_narcotics_confirmed = !empty($post['Tbcpoedetail']['cpoe_narcotics_confirmed']) ? $post['Tbcpoedetail']['cpoe_narcotics_confirmed'] : null;
                $cpoe_ocpa = NULL;
                $cpoe_cpr = NULL;
                $Item_comment1 = !empty($post['Tbcpoedetail']['Item_comment1']) ? $post['Tbcpoedetail']['Item_comment1'] : null;
                $Item_comment2 = !empty($post['Tbcpoedetail']['Item_comment2']) ? $post['Tbcpoedetail']['Item_comment2'] : null;
                $Item_comment3 = !empty($post['Tbcpoedetail']['Item_comment3']) ? $post['Tbcpoedetail']['Item_comment3'] : null;
                $Item_comment4 = !empty($post['Tbcpoedetail']['Item_comment4']) ? $post['Tbcpoedetail']['Item_comment4'] : null;
                $cpoe_route_id = !empty($post['Tbcpoedetail']['cpoe_route_id']) ? $post['Tbcpoedetail']['cpoe_route_id'] : null;
                $cpoe_sig_code = !empty($post['Tbcpoedetail']['cpoe_sig_code']) ? $post['Tbcpoedetail']['cpoe_sig_code'] : null;
                $cpoe_iv_driprate = !empty($post['Tbcpoedetail']['cpoe_iv_driprate']) ? $post['Tbcpoedetail']['cpoe_iv_driprate'] : null;
                $cpoe_doseqty = !empty($post['Tbcpoedetail']['cpoe_doseqty']) ? $post['Tbcpoedetail']['cpoe_doseqty'] : null;
                $cpoe_prn_with_stat = null;
                $cpoe_prn_reason = !empty($post['Tbcpoedetail']['cpoe_prn_reason']) ? $post['Tbcpoedetail']['cpoe_prn_reason'] : null;
                $cpoe_stat = !empty($post['Tbcpoedetail']['cpoe_stat']) ? $post['Tbcpoedetail']['cpoe_stat'] : null;
                $cpoe_period = null;
                $cpoe_period_value = !empty($post['Tbcpoedetail']['cpoe_period_value']) ? $post['Tbcpoedetail']['cpoe_period_value'] : null;
                $cpoe_period_unit = !empty($post['Tbcpoedetail']['cpoe_period_unit']) ? $post['Tbcpoedetail']['cpoe_period_unit'] : null;
                $cpoe_frequency = !empty($post['Tbcpoedetail']['cpoe_frequency']) ? $post['Tbcpoedetail']['cpoe_frequency'] : null;
                $cpoe_frequency_value = !empty($post['Tbcpoedetail']['cpoe_frequency_value']) ? $post['Tbcpoedetail']['cpoe_frequency_value'] : null;
                $cpoe_frequency_unit = !empty($post['Tbcpoedetail']['cpoe_frequency_unit']) ? $post['Tbcpoedetail']['cpoe_frequency_unit'] : null;
                $cpoe_dayrepeat = !empty($post['Tbcpoedetail']['cpoe_dayrepeat']) ? $post['Tbcpoedetail']['cpoe_dayrepeat'] : null;
                $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
                $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
                $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
                $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
                $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
                $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
                $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
                $cpoe_begindate = !empty($post['Tbcpoedetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_begindate']) : null;
                $cpeo_begintime = !empty($post['Tbcpoedetail']['cpeo_begintime']) ? $post['Tbcpoedetail']['cpeo_begintime'] : null;
                $cpoe_enddate = !empty($post['Tbcpoedetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoedetail']['cpoe_enddate']) : null;
                $cpoe_endtime = !empty($post['Tbcpoedetail']['cpoe_endtime']) ? $post['Tbcpoedetail']['cpoe_endtime'] : null;
                $cpoe_repeat = !empty($post['Tbcpoedetail']['cpoe_repeat']) ? $post['Tbcpoedetail']['cpoe_repeat'] : null;
                $cpoe_once = !empty($post['Tbcpoedetail']['cpoe_once']) ? $post['Tbcpoedetail']['cpoe_once'] : null;
                $cpoe_drugprandialadviceid = !empty($post['Tbcpoedetail']['cpoe_drugprandialadviceid']) ? $post['Tbcpoedetail']['cpoe_drugprandialadviceid'] : null;
                $cpoe_seq_mindelay = !empty($post['Tbcpoedetail']['cpoe_seq_mindelay']) ? $post['Tbcpoedetail']['cpoe_seq_mindelay'] : null;
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
            }
        }
    }

    public function actionSaveCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $cpoe_id = $post['Tbcpoe']['cpoe_id'];
            $cpoe_schedule_type = !empty($post['Tbcpoe']['cpoe_schedule_type']) ? $post['Tbcpoe']['cpoe_schedule_type'] : null;
            $cpoe_date = Yii::$app->componentdate->convertThaiToMysqlDate2($post['Tbcpoe']['cpoe_date']);
            $cpoe_order_section = !empty($post['Tbcpoe']['cpoe_order_section']) ? $post['Tbcpoe']['cpoe_order_section'] : null;
            $cpoe_comment = !empty($post['Tbcpoe']['cpoe_comment']) ? $post['Tbcpoe']['cpoe_comment'] : null;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsavedrafe(:cpoe_id, :cpoe_schedule_type,:cpoe_date,:cpoe_order_section,:cpoe_comment);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':cpoe_schedule_type', $cpoe_schedule_type)
                    ->bindParam(':cpoe_date', $cpoe_date)
                    ->bindParam(':cpoe_order_section', $cpoe_order_section)
                    ->bindParam(':cpoe_comment', $cpoe_comment)
                    ->execute();
            $model = $this->findModel($cpoe_id);
            return $model['cpoe_num'];
        }
    }

    public function actionSaveitemIvsolution() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $cpoe_ids = $request->post('id');
            $itemqty = str_replace(',', '', $request->post('ItemQty'));
            Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_itemsave(:Acpoe_ids,:ItemQty);')
                    ->bindParam(':Acpoe_ids', $cpoe_ids)
                    ->bindParam(':ItemQty', $itemqty)
                    ->execute();
            return true;
        }
    }

    public function actionUpdateComment() {
        $request = Yii::$app->request;
        $name = $request->post('name');
        $value = $request->post('value');
        $pk = $request->post('pk');
        if ($name == 'item_comment1') {
            $sql = "
                 update tb_cpoe_detail
                    set 
                        Item_comment1 = '$value'
                 where cpoe_ids = $pk;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
        }
        if ($name == 'item_comment2') {
            $sql = "
                 update tb_cpoe_detail
                    set 
                        Item_comment2 = '$value'
                 where cpoe_ids = $pk;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
        }
        if ($name == 'item_comment3') {
            $sql = "
                 update tb_cpoe_detail
                    set 
                        Item_comment3 = '$value'
                 where cpoe_ids = $pk;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
        }

        return true;
    }

    private function Checknedgp($itemid) {
        $data = Vwcpoedruglistop::findOne($itemid);
        if (empty($data)) {
            return null;
        } else {
            return $data;
        }
    }

    public function actionRoute() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $routeid = $request->post('routeid');
            return $routeid;
        } else {
            return '';
        }
    }

    public function actionRouteAdvice() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $routeadviceid = $request->post('routeadviceid');
            return $routeadviceid;
        } else {
            return '';
        }
    }

    public function actionRouteList() {
        $request = Yii::$app->request;
        $gpu = $request->get('gpu');

        $query = new \yii\db\Query;

        $query->select('TMTID_GPU,DrugRouteName,DrugRouteID')
                ->from('vw_cpoe_drugadmit_default')
                ->where('TMTID_GPU LIKE "%' . $gpu . '%"')
                ->orderBy('TMTID_GPU');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $data) {
            $out[] = ['value' => $data['DrugRouteID'], 'text' => $data['DrugRouteName']];
        }
        return Json::encode($out);
    }

    public function actionRouteadviceList() {
        $request = Yii::$app->request;
        $gpu = $request->get('gpu');
        $routeid = $request->get('routeid');
        $query = new \yii\db\Query;

        $query->select('TMTID_GPU,DrugPrandialAdviceDesc,DrugRouteID,DrugPrandialAdviceID')
                ->from('vw_cpoe_drugadmit_default')
                //->where('TMTID_GPU LIKE "%' . $gpu . '%"')
                ->where('TMTID_GPU = "' . $gpu . '" AND DrugRouteID = "' . $routeid . '"')
                ->orderBy('TMTID_GPU');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $data) {
            $out[] = ['value' => $data['DrugPrandialAdviceID'], 'text' => $data['DrugPrandialAdviceDesc']];
        }
        return Json::encode($out);
    }

    public function actionGetDisunit() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $disunit = Vwcpoedrugdefault::findOne($request->post('id'));
            return Json::encode($disunit->DispUnit);
        } else {
            return Json::encode('');
        }
    }

    public function actionGetrouteSelect() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data1 = Vwcpoedrugadmitdefault::find()->where(['TMTID_GPU' => $request->get('gpu')])->all();
            $result = '<select id="cat-id" class="form-control">';
            $result .= '<option value="">Select Options</option>';
            foreach ($data1 as $datas) {
                $result .= '<option value="' . $datas['DrugRouteID'] . '">' . $datas['DrugRouteName'] . '</option>';
            }
            $result .= '</select>';

            $data2 = Vwcpoedrugadmitdefault::find()->where(['TMTID_GPU' => $request->get('gpu'), 'DrugRouteID' => $request->get('routeid')])->all();
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
            $cpoe_once = !empty($post['Tbcpoedetail']['cpoe_once']) ? $post['Tbcpoedetail']['cpoe_once'] : '';
            $cpoe_repeat = !empty($post['Tbcpoedetail']['cpoe_repeat']) ? $post['Tbcpoedetail']['cpoe_repeat'] : '';
            $cpoe_doseqty = !empty($post['Tbcpoedetail']['cpoe_doseqty']) ? $post['Tbcpoedetail']['cpoe_doseqty'] : '';
            $cpoe_sig_code = !empty($post['Tbcpoedetail']['cpoe_sig_code']) ? $post['Tbcpoedetail']['cpoe_sig_code'] : '';
            $cpoe_period_value = !empty($post['Tbcpoedetail']['cpoe_period_value']) ? $post['Tbcpoedetail']['cpoe_period_value'] : '';
            $cpoe_period_unit = !empty($post['Tbcpoedetail']['cpoe_period_unit']) ? $post['Tbcpoedetail']['cpoe_period_unit'] : '';
            $cpoe_frequency = !empty($post['Tbcpoedetail']['cpoe_frequency']) ? $post['Tbcpoedetail']['cpoe_frequency'] : '';
            $cpoe_frequency_value = !empty($post['Tbcpoedetail']['cpoe_frequency_value']) ? $post['Tbcpoedetail']['cpoe_frequency_value'] : '';
            $cpoe_frequency_unit = !empty($post['Tbcpoedetail']['cpoe_frequency_unit']) ? $post['Tbcpoedetail']['cpoe_frequency_unit'] : '';
            $cpoe_dayrepeat = !empty($post['Tbcpoedetail']['cpoe_dayrepeat']) ? $post['Tbcpoedetail']['cpoe_dayrepeat'] : '';
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? $post['cpoe_dayrepeat_mon'] : '';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? $post['cpoe_dayrepeat_tue'] : '';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? $post['cpoe_dayrepeat_wed'] : '';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? $post['cpoe_dayrepeat_thu'] : '';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? $post['cpoe_dayrepeat_fri'] : '';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? $post['cpoe_dayrepeat_sat'] : '';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? $post['cpoe_dayrepeat_sun'] : '';
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

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tbcpoe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Tbcpoe();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cpoe_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tbcpoe model.
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
     * Deletes an existing Tbcpoe model.
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
        $model = Tbcpoedetail::findOne($id);
        $model->delete();
        return true;
    }

    /**
     * Finds the Tbcpoe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tbcpoe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Tbcpoe::findOne($id)) !== null) {
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

    public function actionRxsave() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $cpoe_id = $request->post('id');
            $userid = Yii::$app->user->identity->id;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsave(:cpoe_id,:userid);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':userid', $userid)
                    ->execute();
            return $this->redirect(['/cpoes/default/order-status']);
        }
    }

    public function actionGettbivdetails() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = Vwivsolutiondetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent')])
                    ->orWhere('cpoe_ids = :cpoe_ids', [':cpoe_ids' => $request->post('parent')])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbivdetails">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    <th class="text-center">ประเภท</th>
                    <th class="text-center">รายการ</th>
                    <th class="text-center">ปริมาณ</th>
                    <th class="text-center">หน่วย</th>
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
                $table .= '<td class="text-center">' . $result->cpoe_Itemtype . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-center">' . $result->DispUnit . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-details', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
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

    public function actionGettbBasesolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = Vwivsolutiondetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 51])
                    // ->orWhere('cpoe_ids = :cpoe_ids', [':cpoe_ids' => $request->post('parent')])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbBasesolution">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    <th class="text-center">ประเภท</th>
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
                $table .= '<td class="text-center">' . $result->cpoe_Itemtype . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-details', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
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
            $query = Vwivsolutiondetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 52])
                    // ->orWhere('cpoe_ids = :cpoe_ids', [':cpoe_ids' => $request->post('parent')])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbDrugAdditive">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    <th class="text-center">ประเภท</th>
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
                $table .= '<td class="text-center">' . $result->cpoe_Itemtype . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-details', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
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

    public function actionGetDrugadvice() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DrugrouteID = $parents[0];
                $out = $this->getDrugadvice($DrugrouteID);
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDrugadvice($id) {
        $datas = Tbdrugprandialadvice::find()->where(['DrugRouteID' => $id])->all();
        return $this->MapData($datas, 'DrugPrandialAdviceID', 'DrugPrandialAdviceDesc');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

}