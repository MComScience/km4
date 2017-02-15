<?php

namespace app\modules\chemo\controllers;

use Yii;
use app\modules\chemo\models\std\TbStdTrpChemo;
use app\modules\chemo\models\std\TbStdTrpChemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Json;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
#models
use app\modules\chemo\models\std\VwStdTrpChemoSearch;
use app\modules\chemo\models\Vwptservicelistop;
use app\modules\chemo\models\std\VwStdDrugsetDetailSearch;
use app\modules\chemo\models\std\VwStdTrpChemoDetailSearch;
use app\modules\chemo\models\std\TbStdTrpChemoDetail;
use app\modules\chemo\models\TbDrugset;
use app\modules\chemo\models\VwDrugsetDetailSearch;
use app\modules\chemo\models\TbDrugsetDetail;
use app\modules\chemo\models\VwCpoeDruglistOp;
use app\modules\chemo\models\Vwptar;
use app\modules\chemo\models\VwCpoeDrugDefault;
use app\modules\chemo\models\VwCpoeDrugadmitDefault;
use app\modules\chemo\models\VwSigCode;
use app\modules\chemo\models\std\TbScl;
use app\modules\chemo\models\VwIvsolutionDrugsetDetail;
use app\modules\chemo\models\TbDrugprandialadvice;
use app\modules\chemo\models\TbCpoeItemtype;
use app\modules\chemo\models\std\VwStdTrpChemoDetail;

/**
 * StdController implements the CRUD actions for TbStdTrpChemo model.
 */
class StdController extends Controller {

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
     * Lists all TbStdTrpChemo models.
     * @return mixed
     */
    public function actionIndex($vn, $ptid) {
        $searchModel = new VwStdTrpChemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        $data_vn = Vwptservicelistop::findOne($vn);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'data_vn' => $data_vn,
                    'ptid' => $ptid,
        ]);
    }

    public function actionStandardIndex($id) {
        $searchModel = new VwStdTrpChemoDetailSearch();
        $dataProvider = $searchModel->search_newstd(Yii::$app->request->post(), $id);

        $model = $this->findModel($id);

        return $this->render('std-index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionCreateStdRegimen($ids, $id, $drugset_id) {
        #ids คือ id ของ table details //tb_std_trp_chemo_detail
        #id คือ id ของ tb_std_trp_chemo
        #drugset_id คือ id ของ tb_drugset

        $model = $this->findModel($id);
        $detailmodel = VwStdTrpChemoDetail::findOne($ids);

        $searchModel = new VwDrugsetDetailSearch();
        $keepProvider = $searchModel->search_std_keep(Yii::$app->request->queryParams, $ids); #เปิดเส้น
        $premedProvider = $searchModel->search_std_premed(Yii::$app->request->queryParams, $ids); #Premed
        $ivProvider = $searchModel->search_std_iv(Yii::$app->request->queryParams, $ids);
        $medicatProvider = $searchModel->search_std_medicat(Yii::$app->request->queryParams, $ids);
        return $this->render('csr-index', [
                    'model' => $model,
                    'detailmodel' => $detailmodel,
                    'keepProvider' => $keepProvider,
                    'premedProvider' => $premedProvider,
                    'medicatProvider' => $medicatProvider,
                    'ivProvider' => $ivProvider,
                    'drugset_id' => $drugset_id,
        ]);
    }

    public function actionCreateStdDetail($id) {
        $std_trp_chemo_ids = TbStdTrpChemoDetail::find()->max('std_trp_chemo_ids'); //id ของ tb_std_trp_chemo_detail
        $ids_details = $std_trp_chemo_ids + 1; //Query Max ids and + 1

        $maxid = TbDrugset::find()->max('drugset_id');
        $drugset_id = $maxid + 1; // id ของ tb_drugset

        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_std_trplan_chemo_add(:userid,:std_trp_chemo_id,:drugset_id,:std_trp_chemo_ids);')
                ->bindParam(':userid', $userid)
                ->bindParam(':std_trp_chemo_id', $id)
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':std_trp_chemo_ids', $ids_details)
                ->execute();
        return $this->redirect(['create-std-regimen', 'ids' => $ids_details, 'id' => $id, 'drugset_id' => $drugset_id]);
    }

    public function actionStdDetails() {
        if (isset($_POST['expandRowKey'])) {
            //$model = VwStdDrugsetDetail::findOne($_POST['expandRowKey']);
            $searchModel = new VwStdDrugsetDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['expandRowKey']);
            return $this->renderAjax('_std-details', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel,]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionNewRegimen() {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $post = $request->post();
            $std_trp_chemo_id = $post['TbStdTrpChemo']['std_trp_chemo_id'];
            $dx_code = !empty($post['TbStdTrpChemo']['dx_code']) ? $post['TbStdTrpChemo']['dx_code'] : null;
            $std_trp_regimen_name = !empty($post['TbStdTrpChemo']['std_trp_regimen_name']) ? $post['TbStdTrpChemo']['std_trp_regimen_name'] : null;
            $ca_stage_code = !empty($post['TbStdTrpChemo']['ca_stage_code']) ? $post['TbStdTrpChemo']['ca_stage_code'] : null;
            $regimen_for_cr = $post['TbStdTrpChemo']['regimen_for_cr'] == 'Y' || $post['TbStdTrpChemo']['regimen_for_cr'] == '1' ? 'Y' : 'N';
            $medical_right_id = !empty($post['TbStdTrpChemo']['medical_right_id']) ? $post['TbStdTrpChemo']['medical_right_id'] : null;
            $std_trp_regimen_paycode = !empty($post['TbStdTrpChemo']['std_trp_regimen_paycode']) ? $post['TbStdTrpChemo']['std_trp_regimen_paycode'] : null;
            $std_trp_comment = !empty($post['TbStdTrpChemo']['std_trp_comment']) ? $post['TbStdTrpChemo']['std_trp_comment'] : null;
            $std_trp_for_op = $post['TbStdTrpChemo']['std_trp_for_op'] == 'Y' || $post['TbStdTrpChemo']['std_trp_for_op'] == '1' ? 'Y' : 'N';
            $std_trp_for_ip = $post['TbStdTrpChemo']['std_trp_for_ip'] == 'Y' || $post['TbStdTrpChemo']['std_trp_for_ip'] == '1' ? 'Y' : 'N';
            $credit_group_id = !empty($post['TbStdTrpChemo']['credit_group_id']) ? $post['TbStdTrpChemo']['credit_group_id'] : null;
            Yii::$app->db->createCommand('CALL cmd_std_trp_save(:std_trp_chemo_id,:dx_code,:std_trp_regimen_name,:ca_stage_code,:regimen_for_cr,:medical_right_id,:std_trp_regimen_paycode,:std_trp_comment,:std_trp_for_ip,:std_trp_for_op,:credit_group_id);')
                    ->bindParam(':std_trp_chemo_id', $std_trp_chemo_id)
                    ->bindParam(':dx_code', $dx_code)
                    ->bindParam(':std_trp_regimen_name', $std_trp_regimen_name)
                    ->bindParam(':ca_stage_code', $ca_stage_code)
                    ->bindParam(':regimen_for_cr', $regimen_for_cr)
                    ->bindParam(':medical_right_id', $medical_right_id)
                    ->bindParam(':std_trp_regimen_paycode', $std_trp_regimen_paycode)
                    ->bindParam(':std_trp_comment', $std_trp_comment)
                    ->bindParam(':std_trp_for_ip', $std_trp_for_ip)
                    ->bindParam(':std_trp_for_op', $std_trp_for_op)
                    ->bindParam(':credit_group_id', $credit_group_id)
                    ->execute();
            echo 1;
        } else {
            $model = $this->createStd();
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isAjax) {
                return [
                    'title' => '<span class="white">New Regimen</span>',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                ];
            }
        }
    }

    private function createStd() {
        $std_trp_chemo_id = time();
        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_std_trp_create(:std_trp_chemo_id,:userid);')
                ->bindParam(':std_trp_chemo_id', $std_trp_chemo_id)
                ->bindParam(':userid', $userid)
                ->execute();
        $model = $this->findModel($std_trp_chemo_id);
        return $model;
    }

    /**
     * Displays a single TbStdTrpChemo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbStdTrpChemo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbStdTrpChemo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->std_trp_chemo_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbStdTrpChemo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->std_trp_chemo_id]);
        } else {
            //Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return $this->renderAjax('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing TbStdTrpChemo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $this->findModel($id)->delete();
        return true;
        // return $this->redirect(['index']);
    }

    public function actionDeleteDetails() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        TbStdTrpChemoDetail::findOne($id)->delete();
        return true;
    }

    /**
     * Finds the TbStdTrpChemo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbStdTrpChemo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbStdTrpChemo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateKeepVein($chemo_ids, $drugset_id, $chemo_id) {
        #chemo_ids = id of  tb_pt_trp_chemo_detail
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $chemo_ids,
                        'drugset_id' => $drugset_id,
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
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
                $chemo_model = $this->findModel($drugsetmodel->drugset->std_trp_chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Keep Vein Open ',
                    'content' => $this->renderAjax('_keepvein_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreatePremedication($chemo_ids, $drugset_id, $chemo_id) {
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $chemo_ids,
                        'drugset_id' => $drugset_id,
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
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
                $chemo_model = $this->findModel($drugsetmodel->drugset->std_trp_chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Premedication ',
                    'content' => $this->renderAjax('_premedication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateBase($drugset_id, $chemo_ids, $chemo_id, $drugset_ids) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modeliv = TbDrugsetDetail::findOne($drugset_ids); //Query IV detail
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugset_ids,
                        'route' => $queryroute,
                        'seq' => $modeliv['cpoe_seq'],
                        'chemo_ids' => $chemo_ids,
                    ]),
                ];
            }
        }
    }

    public function actionEditBasesolution($id, $chemo_id) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modeliv = TbDrugsetDetail::findOne($drugsetmodel['cpoe_parentid']); //Query IV detail
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ',
                    'content' => $this->renderAjax('_base_modal', [
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugsetmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $modeliv['cpoe_seq'],
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                    ]),
                ];
            }
        }
    }

    public function actionCreateAdditive($drugset_id, $chemo_ids, $chemo_id, $drugset_ids) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modeliv = TbDrugsetDetail::findOne($drugset_ids); //Query IV detail
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugset_id,
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugset_ids,
                        'route' => $queryroute,
                        'seq' => $modeliv['cpoe_seq'],
                        'chemo_ids' => $chemo_ids,
                    ]),
                ];
            }
        }
    }

    public function actionEditAdditive($id, $chemo_id) {
        #drugset_ids = ids ของตัว IV Solution
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $modeliv = TbDrugsetDetail::findOne($drugsetmodel['cpoe_parentid']); //Query IV detail
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'parentid' => $drugsetmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $modeliv['cpoe_seq'],
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                    ]),
                ];
            }
        }
    }

    public function actionUpdateInstruction($drugset_ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $adviceid = ArrayHelper::map($this->getDrugadvice($drugsetmodel->cpoe_drugprandialadviceid), 'id', 'name');
            $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
            return [
                'title' => '<i class="glyphicon glyphicon-list"></i> Drug Instruction ',
                'content' => $this->renderAjax('_instruction_modal', [
                    'drugsetmodel' => $drugsetmodel,
                    'route' => $queryroute,
                    'adviceid' => $adviceid,
                ]),
            ];
        }
    }

    public function actionCreateInj($chemo_ids, $drugset_id, $chemo_id) {
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $chemo_ids,
                        'drugset_id' => $drugset_id,
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditInj($ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($drugsetmodel->drugset->std_trp_chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo Injection  ',
                    'content' => $this->renderAjax('_inj_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateMedication($chemo_ids, $drugset_id, $chemo_id) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $chemo_ids,
                        'drugset_id' => $drugset_id,
                        'route' => $queryroute,
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
                $chemo_model = $this->findModel($drugsetmodel->drugset->std_trp_chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                $cpoetype = TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all();
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> กำหนดรายการ  ',
                    'content' => $this->renderAjax('_medication_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'route' => $queryroute,
                        'cpoetype' => $cpoetype,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionCreateChemopo($chemo_ids, $drugset_id, $chemo_id) {
        # ids = regimen_ids,
        $request = Yii::$app->request;
        $drugsetmodel = new TbDrugsetDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $chemo_ids,
                        'drugset_id' => $drugset_id,
                        'route' => $queryroute,
                    ]),
                        //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionEditChemopo($ids) {
        $request = Yii::$app->request;
        $drugsetmodel = TbDrugsetDetail::findOne($ids);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $chemo_model = $this->findModel($drugsetmodel->drugset->std_trp_chemo_id);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $chemo_model['credit_group_id']])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $drugsetmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $drugsetmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Chemo P.O. ',
                    'content' => $this->renderAjax('_chemopo_modal', [
                        'druglistop' => $druglistop,
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_ids' => $drugsetmodel['std_trp_chemo_ids'],
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'route' => $queryroute,
                    ]),
                        // 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
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

    public function actionIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $drugset_ids = time();
                $drugset_id = $request->get('drugset_id');
                $chemo_ids = $request->get('chemo_ids');
                $chemo_id = $request->get('chemo_id');

                $this->CreateIvsolution($drugset_id, $drugset_ids, $chemo_ids);
                $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);
                return $this->renderAjax('_formiv', [
                            'drugset_ids' => $drugset_ids, #id ของตัว IV ที่จะนำไปเป็น parent
                            'drugset_id' => $drugset_id,
                            'drugsetmodel' => $drugsetmodel,
                            'chemo_id' => $chemo_id,
                            'chemo_ids' => $chemo_ids,
                ]);
            }
        }
    }

    public function actionEditIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = $request->get('id');
            $chemo_ids = $request->get('chemo_ids');
            $chemo_id = $request->get('chemo_id');
            $drugsetmodel = TbDrugsetDetail::findOne($id);
            return $this->renderAjax('_formiv', [
                        'drugset_ids' => $id,
                        'drugset_id' => $drugsetmodel['drugset_id'],
                        'drugsetmodel' => $drugsetmodel,
                        'chemo_id' => $chemo_id,
                        'chemo_ids' => $chemo_ids,
            ]);
        }
    }

    private function CreateIvsolution($drugset_id, $drugset_ids, $chemo_ids) {
        $regimen_ids = null;
        Yii::$app->db->createCommand('CALL cmd_drugset_ivsolution_create(:drugset_id,:drugset_ids,:chemo_regimen_ids);')
                ->bindParam(':drugset_id', $drugset_id)
                ->bindParam(':drugset_ids', $drugset_ids)
                ->bindParam(':chemo_regimen_ids', $regimen_ids)
                ->execute();
        $drugsetmodel = TbDrugsetDetail::findOne($drugset_ids);
        $drugsetmodel->std_trp_chemo_ids = $chemo_ids;
        $drugsetmodel->save();

        return $drugset_ids;
    }

    public function actionSelectitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query_drugdefault = VwCpoeDrugDefault::findOne($request->get('id'));
            $query_druglistop = VwCpoeDruglistOp::findOne($request->get('id'));
            $arr = array(
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
                'ItemPrice' => $query_druglistop->ItemPrice
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

    public function actionGettbBasesolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $chemo_id = $request->post('chemo_id');
            $query = VwIvsolutionDrugsetDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 51])
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
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-basesolution', 'id' => $result['drugset_ids'], 'chemo_id' => $chemo_id], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->drugset_ids . ');']) . '</td>';
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
            $chemo_id = $request->post('chemo_id');
            $query = VwIvsolutionDrugsetDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 52])
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
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-additive', 'id' => $result['drugset_ids'], 'chemo_id' => $chemo_id], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->drugset_ids . ');']) . '</td>';
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

    public function actionGetDisunit() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $disunit = VwCpoeDrugDefault::findOne($request->post('id'));
            return Json::encode($disunit->DispUnit);
        } else {
            return Json::encode('');
        }
    }

    public function actionGetCreditgroup() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = TbScl::findOne(['medical_right_id_defualt' => $request->post('id')]);
            return [
                'medical_right_id' => $query['credit_group_id'],
            ];
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
            $std_trp_chemo_ids = !empty($post['TbDrugsetDetail']['std_trp_chemo_ids']) ? $post['TbDrugsetDetail']['std_trp_chemo_ids'] : NULL;
            $Acpoe_seq = !empty($post['TbDrugsetDetail']['cpoe_seq']) ? $post['TbDrugsetDetail']['cpoe_seq'] : null;
            $Acpoe_ids = !empty($post['TbDrugsetDetail']['cpoe_parentid']) ? $post['TbDrugsetDetail']['cpoe_parentid'] : NULL;
            $cpoe_level = null;
            $cpoe_drugset_id = null;
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

                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
                return true;
            } elseif ($cpoe_Itemtype == 51) {

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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
                return true;
            } elseif ($cpoe_Itemtype == 52) {
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
                $model->save();
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
                $model = TbDrugsetDetail::findOne($drugset_ids);
                $model->std_trp_chemo_ids = $std_trp_chemo_ids;
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

    public function actionSelectStd() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $userid = Yii::$app->user->identity->id;
            $pt_visit_number = $request->post('vn');
            $std_trp_chemo_id = $request->post('stdid');
            $pt_trp_chemo_id = $request->post('ptid');
            Yii::$app->db->createCommand('CALL cmd_std_trp_select(:userid,:pt_visit_number,:std_trp_chemo_id,:pt_trp_chemo_id);')
                    ->bindParam(':userid', $userid)
                    ->bindParam(':pt_visit_number', $pt_visit_number)
                    ->bindParam(':std_trp_chemo_id', $std_trp_chemo_id)
                    ->bindParam(':pt_trp_chemo_id', $pt_trp_chemo_id)
                    ->execute();
            return true;
        }
    }

    private function strNumber($number) {
        if (!empty($number)) {
            return str_replace(',', '', $number);
        } else {
            return NULL;
        }
    }

    public function actionDeleteDrugsetdetail() {
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = TbDrugsetDetail::findOne($id)->delete();
    }

    public function actionSaveChemodetail() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $chemo_regimen_ids = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_ids']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_ids'] : NULL;
            $chemo_cycle_seq = !empty($post['VwStdTrpChemoDetail']['chemo_cycle_seq']) ? $post['VwStdTrpChemoDetail']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['VwStdTrpChemoDetail']['chemo_cycle_day']) ? $post['VwStdTrpChemoDetail']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_cycleqty']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_cycleqty'] : NULL;
            $chemo_regimen_freq_value = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_freq_value']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_freq_unit']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['VwStdTrpChemoDetail']['pt_trp_chemo_id']) ? $post['VwStdTrpChemoDetail']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['VwStdTrpChemoDetail']['pt_trp_regimen_name']) ? $post['VwStdTrpChemoDetail']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['VwStdTrpChemoDetail']['drugset_id']) ? $post['VwStdTrpChemoDetail']['drugset_id'] : NULL;
            $drugset_ids = !empty($post['VwStdTrpChemoDetail']['drugset_ids']) ? $post['VwStdTrpChemoDetail']['drugset_ids'] : NULL;
            $pt_trp_comment = !empty($post['VwStdTrpChemoDetail']['std_trp_comment']) ? $post['VwStdTrpChemoDetail']['std_trp_comment'] : NULL;
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
            $chemo_regimen_ids = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_ids']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_ids'] : NULL;
            $chemo_cycle_seq = !empty($post['VwStdTrpChemoDetail']['chemo_cycle_seq']) ? $post['VwStdTrpChemoDetail']['chemo_cycle_seq'] : NULL;
            $chemo_cycle_day = !empty($post['VwStdTrpChemoDetail']['chemo_cycle_day']) ? $post['VwStdTrpChemoDetail']['chemo_cycle_day'] : NULL;
            $chemo_regimen_cycleqty = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_cycleqty']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_cycleqty'] : NULL;
            $chemo_regimen_freq_value = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_freq_value']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_freq_value'] : NULL;
            $chemo_regimen_freq_unit = !empty($post['VwStdTrpChemoDetail']['chemo_regimen_freq_unit']) ? $post['VwStdTrpChemoDetail']['chemo_regimen_freq_unit'] : NULL;
            $pt_trp_chemo_id = !empty($post['VwStdTrpChemoDetail']['pt_trp_chemo_id']) ? $post['VwStdTrpChemoDetail']['pt_trp_chemo_id'] : NULL;
            $chemo_regimen_createby = Yii::$app->user->identity->id;
            $pt_trp_regimen_name = !empty($post['VwStdTrpChemoDetail']['pt_trp_regimen_name']) ? $post['VwStdTrpChemoDetail']['pt_trp_regimen_name'] : NULL;
            $drugset_id = !empty($post['VwStdTrpChemoDetail']['drugset_id']) ? $post['VwStdTrpChemoDetail']['drugset_id'] : NULL;
            $drugset_ids = !empty($post['VwStdTrpChemoDetail']['drugset_ids']) ? $post['VwStdTrpChemoDetail']['drugset_ids'] : NULL;
            $pt_trp_comment = !empty($post['VwStdTrpChemoDetail']['std_trp_comment']) ? $post['VwStdTrpChemoDetail']['std_trp_comment'] : NULL;
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

}
