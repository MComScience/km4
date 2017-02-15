<?php

namespace app\modules\Payment\controllers;

use app\modules\Payment\models\VwInvForRepList;
use app\modules\Payment\models\VwInvForRepListSearch;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PaymentController implements the CRUD actions for VwInvForRepList model.
 */

class PaymentController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function actionClick()
    {
        return $this->renderAjax('notify');
    }
    /**
     * Lists all VwInvForRepList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        $find   = \app\modules\Payment\models\TbFiRep::find()->where(['rep_num' => null])->all();
        if ($find != null) {
            foreach ($find as $data) {
                $rep_id[] = $data['rep_id'];
            }
            foreach ($rep_id as $key) {
                $sql   = "DELETE FROM tb_fi_rep WHERE tb_fi_rep.rep_id = $key AND tb_fi_rep.createby = $userid;";
                $query = Yii::$app->db->createCommand($sql)->query();
            }
        }
        $searchModel  = new VwInvForRepListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionInPatient()
    {
        $SectionID = '2014';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index']);
    }
    public function actionOutPatient()
    {
        $SectionID = '2013';
        $_SESSION['section_view'] = $SectionID;
        return $this->redirect(['index']);
    }
    public function actionHistory()
    {
        $searchModel  = new \app\modules\Payment\models\VwFiRepHeaderSearch();
        $dataProvider = $searchModel->SearchHistory(Yii::$app->request->queryParams);
        return $this->render('_history_payment', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHistoryDetail($rep_id)
    {
        return $this->redirect(['create', 'rep_id' => $rep_id, 'view' => 'history']);
    }
    public function actionRepCreate()
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        $searchModel  = new \app\modules\Payment\models\VwFiRepHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('_rep_create', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single VwInvForRepList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VwInvForRepList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePayment($inv_id)
    {
        $userid  = Yii::$app->user->identity->profile->user_id;
        $findRep = \app\modules\Payment\models\TbFiRep::findOne(['inv_id' => $inv_id, 'rep_status' => '1']);
        if (!empty($findRep)) {
            return $findRep['rep_id'];
        } else {
            // //$inv_id_new = null;
            Yii::$app->db->createCommand('CALL cmd_rep_create_header_detail(:userid,:inv_id);')
                ->bindParam(':userid', $userid)
                ->bindParam(':inv_id', $inv_id)
                ->execute();
            $maxRep = \app\modules\Payment\models\TbFiRep::find()
                ->select('max(rep_id)')
                ->scalar();
            $rep_create_section = $_SESSION['section_view'];
            $sql = "update tb_fi_rep set rep_create_section= $rep_create_section WHERE tb_fi_rep.rep_id = $maxRep;";
            $query = Yii::$app->db->createCommand($sql)->execute();
            return $this->redirect(['create', 'rep_id' => $maxRep, 'view' => 'create']);

        }
    }
    public function actionRepToCreate($rep_id)
    {
        return $this->redirect(['create', 'rep_id' => $rep_id, 'view' => 'create']);
    }

    public function actionCreate($rep_id, $view)
    {
        $model = new VwInvForRepList();
        if (Yii::$app->request->post()) {
            $rep_id  = $_POST['VwItemPaid']['rep_id'];
            $repdate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwFiRepHeader']['repdate']);
			$rep_comment = $_POST['VwFiRepHeader']['rep_comment'];
            $rep_create_section = $_SESSION['section_view'];
            Yii::$app->db->createCommand('CALL cmd_rep_savedraft(:rep_id,:repdate,:rep_comment,:rep_create_section);')
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':repdate', $repdate)
                ->bindParam(':rep_comment', $rep_comment)
                ->bindParam(':rep_create_section', $rep_create_section)
                ->execute();
            $modelHD = \app\modules\Payment\models\VwFiRepHeader::findOne(['rep_id' => $rep_id]);
            echo $modelHD['rep_num'];
        } else {
            $modelHD = \app\modules\Payment\models\VwFiRepHeader::findOne(['rep_id' => $rep_id]);
            if(empty($modelHD)){

            }else{
            	$rep_id = $modelHD['rep_id'];
            $modelPaid = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            $pt_visit_number = $modelHD['pt_visit_number'];
            $find = \app\modules\Payment\models\VwPtAr::find()->where(['pt_visit_number' => $pt_visit_number])->all();
            if ($find != null) {
                foreach ($find as $data) {
                    $ar_name[] = $data['ar_name1'];
                }
            } else {
                $ar_name[] = '';
            }
			$searchModelFT  = new \app\modules\Payment\models\VwFiItemPaymentSearch();
            $dataProviderFT = $searchModelFT->search(Yii::$app->request->queryParams, $rep_id);
            $searchModelBD  = new \app\modules\Payment\models\VwFiRepDetailSearch();
            $dataProviderBD = $searchModelBD->search(Yii::$app->request->queryParams, $rep_id);
            return $this->render('_form', [
                'modelHD'        => $modelHD,
                'modelPaid'      => $modelPaid,
                'ar_name'        => $ar_name,
                'searchModelFT'  => $searchModelFT,
                'dataProviderFT' => $dataProviderFT,
                'searchModelBD'  => $searchModelBD,
                'dataProviderBD' => $dataProviderBD,
                'view'           => $view,
            ]);
            }
            
        }
    }

    public function actionViewDetailInv()
    {
        if (isset($_POST['expandRowKey'])) {
            $inv_id            = $_POST['expandRowKey'];
            $find_visit_number = \app\modules\Payment\models\VwInvForRepList::findOne(['inv_id' => $inv_id]);
            if (!empty($find_visit_number)) {
                $pt_visit_number                    = $find_visit_number['pt_visit_number'];
                $searchModel                        = new \app\modules\Payment\models\VwPtArSearch();
                $dataProvider                       = $searchModel->search(Yii::$app->request->queryParams, $pt_visit_number);
                $dataProvider->pagination->pageSize = 10;
                return $this->renderAjax('view_detail_inv', ['dataProvider' => $dataProvider]);
            } else {
                return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
            }
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionViewDetailRep()
    {
        if (isset($_POST['expandRowKey'])) {
            $rep_id                             = $_POST['expandRowKey'];
            $find_visit_number                  = \app\modules\Payment\models\VwFiRepHeader::findOne(['rep_id' => $rep_id]);
            $pt_visit_number                    = $find_visit_number['pt_visit_number'];
            $searchModel                        = new \app\modules\Payment\models\VwPtArSearch();
            $dataProvider                       = $searchModel->search(Yii::$app->request->queryParams, $pt_visit_number);
            $dataProvider->pagination->pageSize = 5;
            return $this->renderPartial('view_detail_rep', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionViewDetailItem()
    {
        if (isset($_POST['expandRowKey'])) {
            $ids_rep                            = $_POST['expandRowKey'];
            $findIds                            = \app\modules\Payment\models\VwFiRepDetail::findOne(['ids_rep' => $ids_rep]);
            $cpoe_ids                           = $findIds['cpoe_ids'];
            $searchModel                        = new \app\modules\Payment\models\VwInvDetailSearch();
            $dataProvider                       = $searchModel->search(Yii::$app->request->queryParams, $cpoe_ids);
            $dataProvider->pagination->pageSize = 5;
            return $this->renderPartial('view_detail_item', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-warning">ไม่พบข้อมูล</div>';
        }
    }
    public function actionEditPayment()
    {
        $payment_id  = $_GET['payment_id'];
        $findPayment = \app\modules\Payment\models\VwFiItemPayment::findOne(['payment_id' => $payment_id]);
        if ($findPayment['piad_typeid'] == '1') {
            return '1';
        } else if ($findPayment['piad_typeid'] == '2') {
            return '2';
        } else if ($findPayment['piad_typeid'] == '3') {
            return '3';
        } else if ($findPayment['piad_typeid'] == '4') {
            return '4';
        } else {
            return 'error!!';
        }
    }
    public function actionDeletePayment()
    {
        $payment_id = $_GET['payment_id'];
        $sql        = "DELETE FROM tb_fi_reppayment_detail WHERE tb_fi_reppayment_detail.payment_id = $payment_id;";
        $query      = Yii::$app->db->createCommand($sql)->execute();
    }
    public function actionDeleteDiscount()
    {
        $ids_rep = $_GET['ids_rep'];
        $sql     = "UPDATE tb_fi_rep_detail SET tb_fi_rep_detail.Item_Discount='0', tb_fi_rep_detail.Item_Amt_Net='0' WHERE tb_fi_rep_detail.ids_rep=$ids_rep;";
        $query   = Yii::$app->db->createCommand($sql)->execute();
    }
    /**
     * Updates an existing VwInvForRepList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->inv_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionCash($rep_id, $check_edit, $key)
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $payment_id      = $_POST['payment_id'];
            $check_paid_cash = str_replace(',', '', $_POST['TbFiReppaymentDetail']['paid_cash']);
            $findMax         = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            if ($findMax['rep_Amt_left'] === null) {
                $max = $findMax['rep_Amt_net'];
            } else {
                $max = $findMax['rep_Amt_left'];
            }
            if ($check_edit == 'create') {
                if ($check_paid_cash > $max || $check_paid_cash == $max) {
                    $paid_cash = $max;
                } else {
                    $paid_cash = $check_paid_cash;
                }
            } else {
                $findCash = \app\modules\Payment\models\VwFiItemPayment::findOne(['payment_id' => $key]);
                $Old_Cash = $findCash['paid_cash'];
                $Sum_Cash = $max + $Old_Cash;
                if ($check_paid_cash > $Sum_Cash || $check_paid_cash == $Sum_Cash) {
                    $paid_cash = $Sum_Cash;
                } else {
                    $paid_cash = $check_paid_cash;
                }
            }
            $paid_creditcard            = '';
            $creditcard_number          = '';
            $creditcard_type            = '';
            $creditcard_issueby         = '';
            $creditcard_expdate         = '';
            $creditcard_approvedcode    = '';
            $piad_banktransfer          = '';
            $paid_banktransfer_date     = '';
            $bankaccount_number         = '';
            $piad_Cheque                = '';
            $cheque_number              = '';
            $cheque_date                = '';
            $cheque_bankname            = '';
            $payment_comment            = '';
            $payment_status             = '';
            $piad_banktransfer_bankname = '';
            Yii::$app->db->createCommand('CALL cmd_item_payment_save (:payment_id,:rep_id,:paid_cash,:paid_creditcard,:creditcard_number,:creditcard_type,:creditcard_issueby,:creditcard_expdate,:creditcard_approvedcode,:piad_banktransfer,:paid_banktransfer_date,:bankaccount_number,:piad_Cheque,:cheque_number,:cheque_date,:cheque_bankname,:payment_comment,:payment_status,:userid,:piad_banktransfer_bankname);')
                ->bindParam(':payment_id', $payment_id)
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':paid_cash', $paid_cash)
                ->bindParam(':paid_creditcard', $paid_creditcard)
                ->bindParam(':creditcard_number', $creditcard_number)
                ->bindParam(':creditcard_type', $creditcard_type)
                ->bindParam(':creditcard_issueby', $creditcard_issueby)
                ->bindParam(':creditcard_expdate', $creditcard_expdate)
                ->bindParam(':creditcard_approvedcode', $creditcard_approvedcode)
                ->bindParam(':piad_banktransfer', $piad_banktransfer)
                ->bindParam(':paid_banktransfer_date', $paid_banktransfer_date)
                ->bindParam(':bankaccount_number', $bankaccount_number)
                ->bindParam(':piad_Cheque', $piad_Cheque)
                ->bindParam(':cheque_number', $cheque_number)
                ->bindParam(':cheque_date', $cheque_date)
                ->bindParam(':cheque_bankname', $cheque_bankname)
                ->bindParam(':payment_comment', $payment_comment)
                ->bindParam(':payment_status', $payment_status)
                ->bindParam(':userid', $userid)
                ->bindParam(':piad_banktransfer_bankname', $piad_banktransfer_bankname)
                ->execute();
            $max = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                ->select('max(payment_id)')
                ->scalar();
            return $max;
        } else {
            if ($check_edit == 'edit') {
//                $findPaymentID = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                //                        ->select('payment_id')
                //                        ->andWhere(['rep_id' => $rep_id])
                //                        ->andWhere(['<>', 'paid_cash', '0'])
                //                        ->scalar();
                $payment_id = $key;
                $modelPay   = \app\modules\Payment\models\TbFiReppaymentDetail::findOne(['payment_id' => $payment_id]);
            } else {
                $payment_id = $key;
                $modelPay   = new \app\modules\Payment\models\TbFiReppaymentDetail();
            }
            $modelPaid = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            return $this->renderAjax('payment_Cash', [
                'rep_id'     => $rep_id,
                'modelPaid'  => $modelPaid,
                'modelPay'   => $modelPay,
                'payment_id' => $payment_id,
                'check_edit' => $check_edit,
            ]);
        }
    }

    public function actionCreditcard($rep_id, $check_edit, $key)
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $payment_id        = $_POST['payment_id'];
            $paid_cash         = '';
            $paid_creditcard   = str_replace(',', '', $_POST['TbFiReppaymentDetail']['paid_creditcard']);
            $creditcard_number = $_POST['TbFiReppaymentDetail']['creditcard_number'];
            $creditcard_type   = $_POST['TbFiReppaymentDetail']['creditcard_type'];
            $checkother        = $_POST['other_bank'];
            if ($checkother == null) {
                $creditcard_issueby = $_POST['TbFiReppaymentDetail']['creditcard_issueby'];
            } else {
                $creditcard_issueby = $_POST['other_bank'];
            }
            $month                      = $_POST['month'];
            $year                       = $_POST['year'];
            $creditcard_expdate         = '0000/00/00'; //$year . '/' . $month . '/' . '00';
            $creditcard_approvedcode    = $_POST['TbFiReppaymentDetail']['creditcard_approvedcode'];
            $piad_banktransfer          = '';
            $paid_banktransfer_date     = '';
            $bankaccount_number         = '';
            $piad_Cheque                = '';
            $cheque_number              = '';
            $cheque_date                = '';
            $cheque_bankname            = '';
            $payment_comment            = '';
            $payment_status             = '';
            $piad_banktransfer_bankname = '';
            Yii::$app->db->createCommand('CALL cmd_item_payment_save (:payment_id,:rep_id,:paid_cash,:paid_creditcard,:creditcard_number,:creditcard_type,:creditcard_issueby,:creditcard_expdate,:creditcard_approvedcode,:piad_banktransfer,:paid_banktransfer_date,:bankaccount_number,:piad_Cheque,:cheque_number,:cheque_date,:cheque_bankname,:payment_comment,:payment_status,:userid,:piad_banktransfer_bankname);')
                ->bindParam(':payment_id', $payment_id)
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':paid_cash', $paid_cash)
                ->bindParam(':paid_creditcard', $paid_creditcard)
                ->bindParam(':creditcard_number', $creditcard_number)
                ->bindParam(':creditcard_type', $creditcard_type)
                ->bindParam(':creditcard_issueby', $creditcard_issueby)
                ->bindParam(':creditcard_expdate', $creditcard_expdate)
                ->bindParam(':creditcard_approvedcode', $creditcard_approvedcode)
                ->bindParam(':piad_banktransfer', $piad_banktransfer)
                ->bindParam(':paid_banktransfer_date', $paid_banktransfer_date)
                ->bindParam(':bankaccount_number', $bankaccount_number)
                ->bindParam(':piad_Cheque', $piad_Cheque)
                ->bindParam(':cheque_number', $cheque_number)
                ->bindParam(':cheque_date', $cheque_date)
                ->bindParam(':cheque_bankname', $cheque_bankname)
                ->bindParam(':payment_comment', $payment_comment)
                ->bindParam(':payment_status', $payment_status)
                ->bindParam(':userid', $userid)
                ->bindParam(':piad_banktransfer_bankname', $piad_banktransfer_bankname)
                ->execute();
            $max = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                ->select('max(payment_id)')
                ->scalar();
            return $max;
        } else {
            if ($check_edit == 'edit') {
//                $findPaymentID = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                //                        ->select('payment_id')
                //                        ->andWhere(['rep_id' => $rep_id])
                //                        ->andWhere(['<>', 'paid_creditcard', '0'])
                //                        ->scalar();
                $payment_id = $key;
                $modelPay   = \app\modules\Payment\models\TbFiReppaymentDetail::findOne(['payment_id' => $payment_id]);
            } else {
                $payment_id = $key;
                $modelPay   = new \app\modules\Payment\models\TbFiReppaymentDetail();
            }
            $modelPaid = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            return $this->renderAjax('payment_Creditcard', [
                'rep_id'     => $rep_id,
                'modelPaid'  => $modelPaid,
                'modelPay'   => $modelPay,
                'payment_id' => $payment_id,
                'check_edit' => $check_edit,
            ]);
        }
    }

    public function actionBanktrans($rep_id, $check_edit, $key)
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $payment_id                 = $_POST['payment_id'];
            $paid_cash                  = '';
            $paid_creditcard            = '';
            $creditcard_number          = '';
            $creditcard_type            = '';
            $creditcard_issueby         = '';
            $creditcard_expdate         = '';
            $creditcard_approvedcode    = '';
            $piad_banktransfer          = str_replace(',', '', $_POST['TbFiReppaymentDetail']['piad_banktransfer']);
            $paid_banktransfer_date     = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbFiReppaymentDetail']['paid_banktransfer_date']);
            $bankaccount_number         = $_POST['TbFiReppaymentDetail']['bankaccount_number'];
            $piad_Cheque                = '';
            $cheque_number              = '';
            $cheque_date                = '';
            $cheque_bankname            = '';
            $payment_comment            = '';
            $payment_status             = '';
            $piad_banktransfer_bankname = $_POST['TbFiReppaymentDetail']['piad_banktransfer_bankname'];
            Yii::$app->db->createCommand('CALL cmd_item_payment_save (:payment_id,:rep_id,:paid_cash,:paid_creditcard,:creditcard_number,:creditcard_type,:creditcard_issueby,:creditcard_expdate,:creditcard_approvedcode,:piad_banktransfer,:paid_banktransfer_date,:bankaccount_number,:piad_Cheque,:cheque_number,:cheque_date,:cheque_bankname,:payment_comment,:payment_status,:userid,:piad_banktransfer_bankname);')
                ->bindParam(':payment_id', $payment_id)
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':paid_cash', $paid_cash)
                ->bindParam(':paid_creditcard', $paid_creditcard)
                ->bindParam(':creditcard_number', $creditcard_number)
                ->bindParam(':creditcard_type', $creditcard_type)
                ->bindParam(':creditcard_issueby', $creditcard_issueby)
                ->bindParam(':creditcard_expdate', $creditcard_expdate)
                ->bindParam(':creditcard_approvedcode', $creditcard_approvedcode)
                ->bindParam(':piad_banktransfer', $piad_banktransfer)
                ->bindParam(':paid_banktransfer_date', $paid_banktransfer_date)
                ->bindParam(':bankaccount_number', $bankaccount_number)
                ->bindParam(':piad_Cheque', $piad_Cheque)
                ->bindParam(':cheque_number', $cheque_number)
                ->bindParam(':cheque_date', $cheque_date)
                ->bindParam(':cheque_bankname', $cheque_bankname)
                ->bindParam(':payment_comment', $payment_comment)
                ->bindParam(':payment_status', $payment_status)
                ->bindParam(':userid', $userid)
                ->bindParam(':piad_banktransfer_bankname', $piad_banktransfer_bankname)
                ->execute();
            $max = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                ->select('max(payment_id)')
                ->scalar();
            return $max;
        } else {
            if ($check_edit == 'edit') {
//                $findPaymentID = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                //                        ->select('payment_id')
                //                        ->andWhere(['rep_id' => $rep_id])
                //                        ->andWhere(['<>', 'piad_banktransfer', '0'])
                //                        ->scalar();
                $payment_id = $key;
                $modelPay   = \app\modules\Payment\models\TbFiReppaymentDetail::findOne(['payment_id' => $payment_id]);
            } else {
                $payment_id = $key;
                $modelPay   = new \app\modules\Payment\models\TbFiReppaymentDetail();
            }
            $modelPaid = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            return $this->renderAjax('payment_Banktrans', [
                'rep_id'     => $rep_id,
                'modelPaid'  => $modelPaid,
                'modelPay'   => $modelPay,
                'payment_id' => $payment_id,
                'check_edit' => $check_edit,
            ]);
        }
    }

    public function actionCheque($rep_id, $check_edit, $key)
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $payment_id                 = $_POST['payment_id'];
            $paid_cash                  = '';
            $paid_creditcard            = '';
            $creditcard_number          = '';
            $creditcard_type            = '';
            $creditcard_issueby         = '';
            $creditcard_expdate         = '';
            $creditcard_approvedcode    = '';
            $piad_banktransfer          = '';
            $paid_banktransfer_date     = '';
            $bankaccount_number         = '';
            $piad_Cheque                = str_replace(',', '', $_POST['TbFiReppaymentDetail']['piad_Cheque']);
            $cheque_number              = $_POST['TbFiReppaymentDetail']['cheque_number'];
            $cheque_date                = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbFiReppaymentDetail']['cheque_date']);
            $cheque_bankname            = $_POST['TbFiReppaymentDetail']['cheque_bankname'];
            $payment_comment            = '';
            $payment_status             = '';
            $piad_banktransfer_bankname = '';
            Yii::$app->db->createCommand('CALL cmd_item_payment_save (:payment_id,:rep_id,:paid_cash,:paid_creditcard,:creditcard_number,:creditcard_type,:creditcard_issueby,:creditcard_expdate,:creditcard_approvedcode,:piad_banktransfer,:paid_banktransfer_date,:bankaccount_number,:piad_Cheque,:cheque_number,:cheque_date,:cheque_bankname,:payment_comment,:payment_status,:userid,:piad_banktransfer_bankname);')
                ->bindParam(':payment_id', $payment_id)
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':paid_cash', $paid_cash)
                ->bindParam(':paid_creditcard', $paid_creditcard)
                ->bindParam(':creditcard_number', $creditcard_number)
                ->bindParam(':creditcard_type', $creditcard_type)
                ->bindParam(':creditcard_issueby', $creditcard_issueby)
                ->bindParam(':creditcard_expdate', $creditcard_expdate)
                ->bindParam(':creditcard_approvedcode', $creditcard_approvedcode)
                ->bindParam(':piad_banktransfer', $piad_banktransfer)
                ->bindParam(':paid_banktransfer_date', $paid_banktransfer_date)
                ->bindParam(':bankaccount_number', $bankaccount_number)
                ->bindParam(':piad_Cheque', $piad_Cheque)
                ->bindParam(':cheque_number', $cheque_number)
                ->bindParam(':cheque_date', $cheque_date)
                ->bindParam(':cheque_bankname', $cheque_bankname)
                ->bindParam(':payment_comment', $payment_comment)
                ->bindParam(':payment_status', $payment_status)
                ->bindParam(':userid', $userid)
                ->bindParam(':piad_banktransfer_bankname', $piad_banktransfer_bankname)
                ->execute();
            $max = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                ->select('max(payment_id)')
                ->scalar();
            return $max;
        } else {
            if ($check_edit == 'edit') {
//                $findPaymentID = \app\modules\Payment\models\TbFiReppaymentDetail::find()
                //                        ->select('payment_id')
                //                        ->andWhere(['rep_id' => $rep_id])
                //                        ->andWhere(['<>', 'piad_Cheque', '0'])
                //                        ->scalar();
                $payment_id = $key;
                $modelPay   = \app\modules\Payment\models\TbFiReppaymentDetail::findOne(['payment_id' => $payment_id]);
            } else {
                $payment_id = $key;
                $modelPay   = new \app\modules\Payment\models\TbFiReppaymentDetail();
            }
            $modelPaid = \app\modules\Payment\models\VwItemPaid::findOne(['rep_id' => $rep_id]);
            return $this->renderAjax('payment_Cheque', [
                'rep_id'     => $rep_id,
                'modelPaid'  => $modelPaid,
                'modelPay'   => $modelPay,
                'payment_id' => $payment_id,
                'check_edit' => $check_edit,
            ]);
        }
    }

    public function actionDiscount($ids_rep)
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        if (Yii::$app->request->post()) {
            $ids_rep       = $_POST['ids_rep'];
            $Item_Discount = str_replace(',', '', $_POST['VwFiRepDetail']['Item_Discount']);
            $Item_Amt_Net  = str_replace(',', '', $_POST['VwFiRepDetail']['Item_Amt_Net']);
            $valueOut      = Yii::$app->db->createCommand('SELECT func_rep_item_update(:ids_rep,:Item_Amt_Net,:Item_Discount);')
                ->bindParam(':ids_rep', $ids_rep)
                ->bindParam(':Item_Amt_Net', $Item_Amt_Net)
                ->bindParam(':Item_Discount', $Item_Discount)
                ->queryScalar();
            if ($valueOut == 'GO') {
                echo 'GO';
            } else {
                echo 'false';
            }
        } else {
            $modelDiscount = \app\modules\Payment\models\VwFiRepDetail::findOne(['ids_rep' => $ids_rep]);
            return $this->renderAjax('payment_Discount', [
                'modelDiscount' => $modelDiscount,
                'ids_rep'       => $ids_rep,
            ]);
        }
    }
    public function actionSave()
    {
        $rep_id      = $_POST['rep_id'];
        $repdate     = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['repdate']);
        $rep_comment = $_POST['rep_comment'];
        $valueOut    = Yii::$app->db->createCommand('SELECT cmd_vcheck_confirm_rep(:rep_id);')
            ->bindParam(':rep_id', $rep_id)
            ->queryScalar();
        if ($valueOut == 'OK') {
            $rep_create_section = $_SESSION['section_view'];
            Yii::$app->db->createCommand('CALL cmd_rep_save(:rep_id,:repdate,:rep_comment,:rep_create_section);')
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':repdate', $repdate)
                ->bindParam(':rep_comment', $rep_comment)
                ->bindParam(':rep_create_section', $rep_create_section)
                ->execute();
            // Yii::$app->getSession()->setFlash('alert1', [
            //     'type' => 'success',
            //     'duration' => 5000,
            //     'icon' => 'fa fa-check-square-o',
            //     'title' => Yii::t('app', \yii\helpers\Html::encode('Saved Complete!!')),
            //     'message' => Yii::t('app', \yii\helpers\Html::encode('เลขที่ใบเสร็จรับเงินที่ '.$rep_id.' บันทึกเรียบร้อย')),
            //     'positonY' => 'top',
            //     'positonX' => 'right'
            //  ]);
            //  return $this->redirect('index.php?r=Payment/payment/index');
            echo 'true';

        } else {
            $rep_create_section = $_SESSION['section_view'];
            Yii::$app->db->createCommand('CALL cmd_rep_save(:rep_id,:repdate,:rep_comment,:rep_create_section);')
                ->bindParam(':rep_id', $rep_id)
                ->bindParam(':repdate', $repdate)
                ->bindParam(':rep_comment', $rep_comment)
                ->bindParam(':rep_create_section', $rep_create_section)
                ->execute();
            // Yii::$app->getSession()->setFlash('alert1', [
            //     'type' => 'success',
            //     'duration' => 5000,
            //     'icon' => 'fa fa-check-square-o',
            //     'title' => Yii::t('app', \yii\helpers\Html::encode('Saved Complete!!')),
            //     'message' => Yii::t('app', \yii\helpers\Html::encode('เลขที่ใบเสร็จรับเงินที่ '.$rep_id.' บันทึกเรียบร้อย')),
            //     'positonY' => 'top',
            //     'positonX' => 'right'
            //  ]);
            // return $this->redirect('index.php?r=Payment/payment/index');
            echo 'false';
        }
    }
    public function actionPageIndex()
    {
        Yii::$app->getSession()->setFlash('alert1', [
            'type'     => 'success',
            'duration' => 5000,
            'icon'     => 'fa fa-check-square-o',
            'title'    => Yii::t('app', \yii\helpers\Html::encode('Saved Complete!!')),
            'message'  => Yii::t('app', \yii\helpers\Html::encode('บันทึกเรียบร้อย')),
            'positonY' => 'top',
            'positonX' => 'right',
        ]);
        return $this->redirect('index.php?r=Payment/payment/index');
    }
    // public function actionSave() {
    //     $rep_id= $_POST['rep_id'];
    //     $repdate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['repdate']);
    //     $rep_comment =$_POST['rep_comment'];
    //     // $userid = Yii::$app->user->identity->profile->user_id;
    //     $valueOut = Yii::$app->db->createCommand('SELECT cmd_vcheck_confirm_rep(:rep_id);')
    //                 ->bindParam(':rep_id', $rep_id)
    //                 ->queryScalar();
    //     if($valueOut =='OK'){
    //         Yii::$app->db->createCommand('CALL cmd_rep_save(:rep_id,:repdate,:rep_comment);')
    //                 ->bindParam(':rep_id', $rep_id)
    //                 ->bindParam(':repdate', $repdate)
    //                 ->bindParam(':rep_comment', $rep_comment)
    //                 ->execute();
    //         Yii::$app->getSession()->setFlash('alert1', [
    //             'type' => 'success',
    //             'duration' => 5000,
    //             'icon' => 'fa fa-check-square-o',
    //             'title' => Yii::t('app', \yii\helpers\Html::encode('Saved Complete!!')),
    //             'message' => Yii::t('app', \yii\helpers\Html::encode('เลขที่ใบเสร็จรับเงินที่ '.$rep_id.' บันทึกเรียบร้อย')),
    //             'positonY' => 'top',
    //             'positonX' => 'right'
    //          ]);
    //         return $this->redirect('index.php?r=Payment/payment/index');
    //     }else{
    //         echo 'false';
    //     }
    // }
    /**
     * Deletes an existing VwInvForRepList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VwInvForRepList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwInvForRepList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwInvForRepList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    #Report Function
    public function actionNewbill1($id)
    {

        $header  = \app\modules\Payment\models\VwFiRepHeader::findOne(['rep_id' => $id]);
        $content = \app\modules\Payment\models\VwFiRepDetail::find()->where(['rep_id' => $id])->all();
        $footer  = \app\modules\Payment\models\vwitempaid::findOne(['rep_id' => $id]);
        $payment = \app\modules\Payment\models\vwfireppaymentdetail::find()->where(['rep_id' => $id])->all();
        $ar_name = \app\modules\Payment\models\vwptar::find()->where(['pt_visit_number' => $header->pt_visit_number])->all();
        $ed      = $this->SumEd($id);
        $ned     = $this->SumNEd($id);
        $pdf     = new Pdf([
            'mode'         => Pdf::MODE_UTF8,
            'orientation'  => Pdf::ORIENT_PORTRAIT,
            'destination'  => Pdf::DEST_DOWNLOAD,
            'format'       => Pdf::FORMAT_A4,
            'content'      => $this->renderPartial('newbill1', [
                'content'    => $content,
                'paid'       => $footer,
                'payment'    => $payment,
                'header'     => $header,
                'ar_name'    => $ar_name,
                'setheader'  => false,
                'setcontent' => true,
                'setfooter'  => false,
            ]),
            'marginTop'    => '35',
            //'marginHeader' => '10',
            //'marginLeft' => '10',
            //'marginRight' => '8',
            //'marginFooter' => '10',
            'marginBottom' => '45',
            'filename'     => 'ใบเสร็จรับเงิน.pdf',
            'options'      => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title'             => 'report',

            ],
            'cssFile'      => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'cssInline'    => 'body{font-size:16px}',
            'methods'      => [
                'SetHeader' => $this->renderPartial('newbill1', [
                    'header'     => $header,
                    'ar_name'    => $ar_name,
                    'content'    => $content,
                    'paid'       => $footer,
                    'payment'    => $payment,
                    'setheader'  => true,
                    'setcontent' => false,
                    'setfooter'  => false,
                ]),
                'SetFooter' => $this->renderPartial('newbill1', [
                    'header'     => $header,
                    'content'    => $content,
                    'paid'       => $footer,
                    'payment'    => $payment,
                    'ar_name'    => $ar_name,
                    'setheader'  => false,
                    'setcontent' => false,
                    'setfooter'  => true,
                    'ed'         => $ed,
                    'ned'        => $ned,
                ]),
            ]]);

        return $pdf->render();
    }

    private function SumNEd($rep_id)
    {
        $command1 = Yii::$app->db->createCommand("SELECT
	sum(
		tb_fi_rep_detail.Item_Amt_Net
	) AS rep_item_Amt_ned
FROM
	tb_fi_rep_detail
LEFT JOIN vw_item_list_tpu ON vw_item_list_tpu.ItemID = tb_fi_rep_detail.ItemID
WHERE
	vw_item_list_tpu.ISED = 'NED'
AND tb_fi_rep_detail.rep_id = $rep_id
GROUP BY
	tb_fi_rep_detail.ItemID,
	tb_fi_rep_detail.ItemQTY,
	tb_fi_rep_detail.ItemPrice,
	tb_fi_rep_detail.Item_Amt,
	tb_fi_rep_detail.Item_Discount,
	vw_item_list_tpu.ISED");
        $sumned = $command1->queryOne();
        return number_format($sumned['rep_item_Amt_ned'], 2);
    }

    private function SumEd($rep_id)
    {
        $command1 = Yii::$app->db->createCommand("SELECT
	sum(
		tb_fi_rep_detail.Item_Amt_Net
	) AS rep_item_Amt_ned
FROM
	tb_fi_rep_detail
LEFT JOIN vw_item_list_tpu ON vw_item_list_tpu.ItemID = tb_fi_rep_detail.ItemID
WHERE
	vw_item_list_tpu.ISED = 'ED'
AND tb_fi_rep_detail.rep_id = $rep_id
GROUP BY
	tb_fi_rep_detail.ItemID,
	tb_fi_rep_detail.ItemQTY,
	tb_fi_rep_detail.ItemPrice,
	tb_fi_rep_detail.Item_Amt,
	tb_fi_rep_detail.Item_Discount,
	vw_item_list_tpu.ISED");
        $sumned = $command1->queryOne();
        return number_format($sumned['rep_item_Amt_ned'], 2);
    }

}