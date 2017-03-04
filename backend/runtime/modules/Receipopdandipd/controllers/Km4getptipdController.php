<?php

namespace app\modules\Receipopdandipd\controllers;

use Yii;
use app\modules\Receipopdandipd\models\KM4GETPTIPD;
//use app\modules\Receipopdandipd\models\KM4GETPTIPDSearch;
use app\modules\Receipopdandipd\models\KM4GETPATENT;
use app\modules\Receipopdandipd\models\Vwptwaitingcheckinlist;
use app\modules\Receipopdandipd\models\Vwptmdassignedlist;
use app\modules\Receipopdandipd\models\KM4GETREFER;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * Km4getptipdController implements the CRUD actions for KM4GETPTIPD model.
 */
class Km4getptipdController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIpdregister() {
        $register = Vwptwaitingcheckinlist::find()->all();
        return $this->render('ipdregister', ['register' => $register]);
    }
    
    public function actionWaitregisterdoctor() {
        $wgd = Vwptmdassignedlist::find()->all();
        return $this->render('waitregisterdoctor', ['wgd' => $wgd]);
    }
    function actionSave_service_arrive($hn, $date) {

        $km4opd = KM4GETPTIPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();

        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = $km4opd->PT_ADMISSION_NUMBER;
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->execute();

        $this->redirect('index.php?r=Opdandipd/km4getptipd');
    }

    function converdate($dat) {
        $y = substr($dat, 0, 4);
        $m = substr($dat, 4, 2);
        $d = substr($dat, 6, 2);
        return $y . '-' . $m . '-' . $d;
    }

    function setmessage($data) {
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', Html::encode('Submission')),
            'message' => Yii::t('app', Html::encode($data)),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
    }

    function actionSave_service() {
        $post = Yii::$app->request->get();
        $hn = $post['hn'];
        $date = $this->converdate($post['dat']);
        $km4opd = KM4GETPTIPD::find()->where(['PT_HOSPITAL_NUMBER' => $hn, 'PT_REGISTRY_DATE' => $date])->one();
        $km4patent = KM4GETPATENT::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $km4refer = KM4GETREFER::find()->where(['PT_HOSPITAL_NUMBER' => $hn])->one();
        $pt_titlename_id = $km4opd->PT_TITLENAME_ID;
        $pt_fname_th = $km4opd->PT_FNAME_TH;
        $pt_lname_th = $km4opd->PT_LNAME_TH;
        $pt_dob = $km4opd->PT_DOB;
        $pt_sex_id = $km4opd->PT_SEX_ID;
        $pt_nation_id = $km4opd->PT_NATION_ID;
        $pt_cid = $km4opd->PT_CID;
        $user_id = Yii::$app->user->id;
        $pt_admission_number = $km4opd->PT_ADMISSION_NUMBER;
        $pt_service_comg_id = "";
        $pt_mascl_id = (!empty($km4patent) ? $km4patent->PT_MAININSCL_ID : ''); //$km4patent->PT_MAININSCL_ID;
        $pt_subscl_id = (!empty($km4patent) ? $km4patent->PT_SUBINSCL_ID : ''); //$km4patent->PT_SUBINSCL_ID;
        $pt_sclcard_id = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_ID : ''); //$km4patent->PT_INSCLCARD_ID;
        $pt_sclcard_startdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_STARTDATE : ''); //$km4patent->PT_INSCLCARD_STARTDATE;
        $pt_sclcard_exdate = (!empty($km4patent) ? $km4patent->PT_INSCLCARD_EXPDATE : ''); //$km4patent->PT_INSCLCARD_EXPDATE;
        $pt_purchaseprovince_id = (!empty($km4patent) ? $km4patent->PT_PURCHASEPROVINCE_ID : ''); //$km4patent->PT_PURCHASEPROVINCE_ID;

        $refer_hrecieve_doc_id = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_ID : ''); //$km4refer->REFER_HRECIEVE_DOC_ID;
        $refer_hrecieve_doc_date = (!empty($km4refer) ? $km4refer->REFER_HRECIEVE_DOC_DATE : ''); //$km4refer->REFER_HRECIEVE_DOC_DATE;
        $refer_hsender_doc_id = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_ID : ''); //$km4refer->REFER_HSENDER_DOC_ID;
        $refer_hsender_code = (!empty($km4refer) ? $km4refer->REFER_HSENDER_CODE : ''); //$km4refer->REFER_HSENDER_CODE;
        $refer_hsender_sent_typeid = (!empty($km4refer) ? $km4refer->REFER_HSENDER_SENT_TYPEID : ''); //$km4refer->REFER_HSENDER_SENT_TYPEID;
        $refer_hsender_doc_start = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_START : ''); //$km4refer->REFER_HSENDER_DOC_START;
        $refer_hsender_doc_expdate = (!empty($km4refer) ? $km4refer->REFER_HSENDER_DOC_EXPDATE : ''); //$km4refer->REFER_HSENDER_DOC_EXPDATE;

        Yii::$app->db->createCommand('CALL cmd_pt_service_arrive(:pt_hospital_number,:pt_titlename_id,:pt_fname_th,:pt_lname_th,:pt_dob,:pt_sex_id,:pt_nation_id,:pt_cid,:pt_update_by,:pt_admission_number,:pt_service_incoming_id,:pt_maininscl_id,:pt_subinscl_id,:pt_insclcard_id,:pt_insclcard_startdate,:pt_insclcard_exdate,:pt_purchaseprovince_id,:refer_hrecieve_doc_id,:refer_hrecieve_doc_date,:refer_hsender_doc_id,:refer_hsender_code,:refer_hsender_sent_typeid,:refer_hsender_doc_start,:refer_hsender_doc_expdate);')
                ->bindParam(':pt_hospital_number', $hn)
                ->bindParam(':pt_titlename_id', $pt_titlename_id)
                ->bindParam(':pt_fname_th', $pt_fname_th)
                ->bindParam(':pt_lname_th', $pt_lname_th)
                ->bindParam(':pt_dob', $pt_dob)
                ->bindParam(':pt_sex_id', $pt_sex_id)
                ->bindParam(':pt_nation_id', $pt_nation_id)
                ->bindParam(':pt_cid', $pt_cid)
                ->bindParam(':pt_update_by', $user_id)
                ->bindParam(':pt_admission_number', $pt_admission_number)
                ->bindParam(':pt_service_incoming_id', $pt_service_comg_id)
                ->bindParam(':pt_maininscl_id', $pt_mascl_id)
                ->bindParam(':pt_subinscl_id', $pt_subscl_id)
                ->bindParam(':pt_insclcard_id', $pt_sclcard_id)
                ->bindParam(':pt_insclcard_startdate', $pt_sclcard_startdate)
                ->bindParam(':pt_insclcard_exdate', $pt_sclcard_exdate)
                ->bindParam(':pt_purchaseprovince_id', $pt_purchaseprovince_id)
                ->bindParam(':refer_hrecieve_doc_id', $refer_hrecieve_doc_id)
                ->bindParam(':refer_hrecieve_doc_date', $refer_hrecieve_doc_date)
                ->bindParam(':refer_hsender_doc_id', $refer_hsender_doc_id)
                ->bindParam(':refer_hsender_code', $refer_hsender_code)
                ->bindParam(':refer_hsender_sent_typeid', $refer_hsender_sent_typeid)
                ->bindParam(':refer_hsender_doc_start', $refer_hsender_doc_start)
                ->bindParam(':refer_hsender_doc_expdate', $refer_hsender_doc_expdate)
                ->execute();

        $this->redirect('index.php?r=Opdandipd/km4getptipd');
    }

    /**
     * Lists all KM4GETPTIPD models.
     * @return mixed
     */
    public function actionIndex() {
        //$getipd = KM4GETPTIPD::find()->limit(20)->all();
        $getipd = KM4GETPTIPD::find()->with('d')->all();
//        $searchModel = new KM4GETPTIPDSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'getipd' => $getipd
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KM4GETPTIPD model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "KM4GETPTIPD #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new KM4GETPTIPD model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new KM4GETPTIPD();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new KM4GETPTIPD",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new KM4GETPTIPD",
                    'content' => '<span class="text-success">Create KM4GETPTIPD success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new KM4GETPTIPD",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->PT_HOSPITAL_NUMBER]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing KM4GETPTIPD model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update KM4GETPTIPD #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "KM4GETPTIPD #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update KM4GETPTIPD #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->PT_HOSPITAL_NUMBER]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing KM4GETPTIPD model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing KM4GETPTIPD model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the KM4GETPTIPD model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return KM4GETPTIPD the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = KM4GETPTIPD::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
