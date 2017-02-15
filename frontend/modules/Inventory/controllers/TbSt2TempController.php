<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbSt2Temp;
use app\modules\Inventory\models\SearchTbSt2Temp;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\Inventory\models\Tbsritemdetail2Search;
use app\modules\Inventory\models\Tbsritemdetail2;
use app\modules\Inventory\models\VwSt2DetailSub;
use app\modules\Inventory\models\VwSt2LotnumberAvalible;
use app\modules\Inventory\models\VwSt2SrBalance;
use app\modules\Inventory\models\TbStitemdetail2Temp;
use app\modules\Inventory\models\VwItempack;

/**
 * TbSt2TempController implements the CRUD actions for TbSt2Temp model.
 */
class TbSt2TempController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionPritpickinglist() {
        $rssr2list = \app\modules\Inventory\models\Vwsr2list::findOne(['SRID' => '22']);
        $sr2detail = \app\modules\Inventory\models\Vwsr2detail2::findAll(['SRID' => '22']);
        return $this->renderPartial('pickinglist', [
                    'sr2detail' => $sr2detail
        ]);
    }

    public function actionCheckSrForst() {
        $SRNum = Yii::$app->request->post('SRNum');
        $rs = TbSt2Temp::find()->where(['SRNum' => $SRNum])->one();
        if ($rs == null) {
            return "true";
        } else {
            return "false";
        }
    }

    public function actionExtPen2() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {
            $model = VwSt2DetailSub::findAll(['ids_sr' => $pos['expandRowKey']]);
            return $this->renderPartial('expenlot2', ['lotnumber' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionDeleteDetail2() {
        $ids_sr = Yii::$app->request->get('ids_sr');
        $ids = Yii::$app->request->get('id');
        $model = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids' => $ids]);
        $model->delete();
    }

    /**
     * Lists all TbSt2Temp models.
     * @return mixed
     */
    public function actionIndex() {
        $_SESSION['ss_sectionid'] = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new SearchTbSt2Temp();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        $this->DeleteTemp();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = \app\modules\Inventory\models\VwStListDraft::findOne(['STID' => $id]);
        //$model = //$this->findModel($id);
        $searchModel = new \app\modules\Inventory\models\VwSt2DetailGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->SRID);
        return $this->render('view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new TbSt2Temp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($STID, $SRID, $SRNum) {
        $model = TbSt2Temp::findOne(['STID' => $STID]);
        if (Yii::$app->request->post() != null) {
            $pos = Yii::$app->request->post('TbSt2Temp');
            $stid = Yii::$app->request->post('stid');
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['STDate']);

            $SRNum = $SRNum;
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = date('Y-m-d');
            $STIssue_StkID = $pos['STIssue_StkID'];
            $STRecieve_StkID = $pos['STRecieve_StkID'];
            $STStatus = $pos['STStatus'];
            $STNote = $pos['STNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_savedraft(:STID,:STDate,:SRNum,:STCreateBy,
                    :STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $stid)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();
            $model12 = TbSt2Temp::findOne(['STID' => $stid]);
            echo $model12->STNum;
        } else {
            $searchModel = new \app\modules\Inventory\models\VwSt2DetailGroupSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $SRID);
            $model->STStatus = 1;
            return $this->render('create', [
                        'STID' => $STID,
                        'SRID' => $SRID,
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function action_clear() {
        $x = Yii::$app->request->post('stid');
        Yii::$app->db->createCommand('
                    CALL cmd_st2_clear(:x);')
                ->bindParam(':x', $x)
                ->execute();
        echo '1';
    }

    public function actionUpdate($id) {
        $model = TbSt2Temp::findOne(['STID' => $id]);
        if (Yii::$app->request->post() != null) {
            $pos = Yii::$app->request->post('TbSt2Temp');
            $stid = Yii::$app->request->post('stid');
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate2($pos['STDate']);
            $model = TbSt2Temp::findOne(['STID' => $stid]);
            $SRNum = $model->SRNum;
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = date('Y-m-d');
            $STIssue_StkID = $pos['STIssue_StkID'];
            $STRecieve_StkID = $pos['STRecieve_StkID'];
            $STStatus = $pos['STStatus'];
            $STNote = $pos['STNote'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_savedraft(:STID,:STDate,:SRNum,:STCreateBy,
                    :STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $stid)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();
            $model12 = TbSt2Temp::findOne(['STID' => $stid]);
            echo $model12->STNum;
        } else {
            $model = TbSt2Temp::findOne(['STID' => $id]);
            $SRNum = $model->SRNum;
            $Tbsr = \app\modules\Inventory\models\Tbsr2::findOne(['SRNum' => $SRNum]);
            $searchModel = new \app\modules\Inventory\models\VwSt2DetailGroupSearch();
            $dataProvider = $searchModel->searchst(Yii::$app->request->queryParams, $Tbsr->SRID);
            return $this->render('update', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'STID' => $model->STID,
                        'SRID' => $Tbsr->SRID,
            ]);
        }
    }

    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteDetail() {
        $id = Yii::$app->request->post('id');
        \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids' => $id])->delete();
    }

    protected function findModel($id) {
        if (($model = TbSt2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSpicking() {
        $_SESSION['ss_sectionid'] = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new \app\modules\Inventory\models\Vwsr2list1Search();
        $dataProvider = $searchModel->searchhistoryspicking(Yii::$app->request->queryParams);
        $dataProvider->pagination->PageSize = $dataProvider->getTotalCount();
        $this->DeleteTemp();
        return $this->render('stissupicking', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function CheckAuto() {
        $MaxSTID_temp = \app\modules\Inventory\models\TbSt2Temp::find()->max('STID');
        $MaxSTID_Nottemp = \app\modules\Inventory\models\TbSt2::find()->max('STID');
        $MaxIdsST_temp = \app\modules\Inventory\models\TbStitemdetail2Temp::find()->max('ids');
        $MaxIdsST_Nottemp = \app\modules\Inventory\models\TbStitemdetail2::find()->max('ids');
        if (empty($MaxSTID_temp) && empty($MaxSTID_Nottemp)) {
            $setAuto_st2temp = "ALTER TABLE tb_st2_temp AUTO_INCREMENT = 1;";
        } elseif ($MaxSTID_Nottemp > $MaxSTID_temp) {
            $NextSTID = $MaxSTID_Nottemp + 1;
            $setAuto_st2temp = "ALTER TABLE tb_st2_temp AUTO_INCREMENT = $NextSTID;";
        } elseif ($MaxSTID_Nottemp < $MaxSTID_temp) {
            $NextSTID = $MaxSTID_temp + 1;
            $setAuto_st2temp = "ALTER TABLE tb_st2_temp AUTO_INCREMENT = $NextSTID;";
        }
        if (empty($MaxIdsST_temp) && empty($MaxIdsST_Nottemp)) {
            $setAuto_stitemdetail2temp = "ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = 1;";
        } elseif ($MaxIdsST_Nottemp > $MaxIdsST_temp) {
            $NextIds = $MaxIdsST_Nottemp + 1;
            $setAuto_stitemdetail2temp = "ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = $NextIds;";
        } elseif ($MaxIdsST_Nottemp < $MaxIdsST_temp) {
            $NextIds = $MaxIdsST_temp + 1;
            $setAuto_stitemdetail2temp = "ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }
        Yii::$app->db->createCommand($setAuto_st2temp)->query();
        Yii::$app->db->createCommand($setAuto_stitemdetail2temp)->query();
    }

    public function DeleteTemp() {
        $user_id = Yii::$app->user->identity->profile->user_id;
        $query_temp = TbSt2Temp::find()->select('STID')->where('STCreateDate <= (DATE_SUB(curdate(), INTERVAL 1 DAY))')->andWhere('STNum is null')->asArray()->all();
        if (!empty($query_temp)) {
            foreach ($query_temp as $key_temp) {
                TbSt2Temp::deleteAll('STID = :STID', [':STID' => $key_temp['STID']]);
                TbStitemdetail2Temp::deleteAll('STID = :STID', [':STID' => $key_temp['STID']]);
            }
        }
        $findSTID = TbSt2Temp::find()->select('STID')->where('STNum is null')->asArray()->all();
        foreach ($findSTID as $data) {
            TbSt2Temp::deleteAll('STID = :STID AND STCreateBy = :STCreateBy', [':STID' => $data['STID'], ':STCreateBy' => $user_id]);
            TbStitemdetail2Temp::deleteAll('STID = :STID AND STCreatedBy = :STCreatedBy', [':STID' => $data['STID'], ':STCreatedBy' => $user_id]);
        }
    }

    public function actionCreateheader($id) {
        $this->CheckAuto();
        $sr = \app\modules\Inventory\models\Tbsr2::findOne($id);
        $sr2 = $sr->SRNum;
        $userid = Yii::$app->user->identity->profile->user_id;
        $cmd = Yii::$app->db->createCommand('CALL cmd_st2_create_header(:SRID,:userid);')
                ->bindParam(':SRID', $id)
                ->bindParam(':userid', $userid)
                ->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'STID' => $max, 'SRID' => $id, 'SRNum' => $sr2]);
    }

    public function actionCmdSt2StkIssu() {
        $x = Yii::$app->request->post('stid');
//        $srid = Yii::$app->request->post('srid');
//        $data = \app\modules\Inventory\models\VwSt2DetailGroup::findAll(['SRID' => $srid]);
        $statusID = 20;
//        foreach ($data as $r) {
//            if ($r['SRQty'] == $r['STQty']) {
//                $statusID = 20;
//            } else {
//                $statusID = 21;
//            }
//        }
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('
                    CALL cmd_st2_stk_issue(:x,:userid,:statusID);')
                ->bindParam(':x', $x)
                ->bindParam(':userid', $userid)
                ->bindParam(':statusID', $statusID)
                ->execute();
        Yii::$app->finddata->setmessage("Stock Issu " . $x . " Success fully");
        echo '1';
    }

    public function actionAutolot() {
        $SRID = $_POST['SRID'];
        $STID = $_POST['STID'];
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('
                CALL cmd_st_pickinglist_autolot(:SRID,:STID,:userid);')
                ->bindParam(':SRID', $SRID)
                ->bindParam(':userid', $userid)
                ->bindParam(':STID', $STID)
                ->execute();
        return true;
    }

    public function actionSelectLot() {
        $ids_sr = Yii::$app->request->get('ids_sr');
        $x = Yii::$app->request->get('id');
        $stkid = Yii::$app->request->get('stkid');
        $srid = Yii::$app->request->get('srid');
        $stkall = \app\modules\Inventory\models\TbStk::findOne(['StkID' => $stkid]);
        $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $x]);
        $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
        $dataProvider = $searchModel->search($stkid, $x);
        return $this->renderAjax('form_detail', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'stkall' => $stkall,
                    'ids_sr' => $ids_sr,
        ]);
    }

    public function actionExtPen() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {
            $model = VwSt2DetailSub::findAll(['ids_sr' => $pos['expandRowKey']]);
            return $this->renderAjax('expenlot', ['lotnumber' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionDetail() {
        $id = Yii::$app->request->get('id');
        $model = \app\modules\Inventory\models\Tbsr2::findOne(['SRID' => $id]);
        // $searchModel = new Tbsritemdetail2Search();
        //   $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $searchModel = new \app\modules\Inventory\models\Sritemdetail2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('_view', [
                    'STID' => $id,
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionSelectNumBer() {
        if (Yii::$app->request->post() != NULL) {
            $datas = TbSt2Temp::findOne(['STID' => Yii::$app->request->get('stid')]);
            $post = Yii::$app->request->post('TbStitemdetail2Temp');
            $ids_sr = Yii::$app->request->post('ids_sr');
            $pos = Yii::$app->request->post('VwSt2DetailGroup');
            $poslot = Yii::$app->request->post('VwSt2LotnumberAvalible');
            $itempack = VwItempack::findOne(['ItemID' => $pos['ItemID'], 'ItemPackID' => !empty($pos['STItemPackID']) ? $pos['STItemPackID'] : '']);
            if ($itempack != null) {
                $packdata = Yii::$app->request->post('pack');
                if ($packdata == "1") {
                    $itemp = null;
                } else {
                    $itemp = $itempack->ItemPackID;
                }
            } else {
                $itemp = null;
            }
            $ids = null;
            $STNum = $datas->STNum;
            $STID = Yii::$app->request->get('stid');
            $ItemID = Yii::$app->request->get('itemid');
            $ItemInternalLotNum = Yii::$app->request->get('id');
            $STPackQty = str_replace(",", "", $post['STPackQty']);
            $STPackUnitCost = $poslot['PackItemUnitCost'];
            $STItemPackID = $itemp;
            $STItemQty = str_replace(",", "", $post['STItemQty']);
            $STCreatedBy = Yii::$app->user->identity->profile->user_id;
            $STItemUnitCost = $poslot['ItemUnitCost'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,
                    :STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->bindParam(':ids_sr', $ids_sr)
                    ->execute();
            return 'full';
        } else {
            $STID = Yii::$app->request->get('stid');
            $x = Yii::$app->request->get('id');
            $stkid = Yii::$app->request->get('stkid');
            $srid = Yii::$app->request->get('srid');
            $itemid = Yii::$app->request->get('itemid');
            $data = TbStitemdetail2Temp::findOne(['STID' => $STID, 'ItemInternalLotNum' => $x, 'ItemID' => $itemid]);
            if ($data != null) {
                return '1';
            } else {
                $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $itemid]);
                $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
                $stkmodel = \app\modules\Inventory\models\TbStk::findOne(['StkID' => $stkid]);
                $dataProvider = $searchModel->searchinternallot($stkid, $x);
                $balence = VwSt2SrBalance::findOne(['SRID' => $srid, 'ItemID' => $itemid]);
                $pack = VwItempack::findOne(['ItemPackID' => $model->SRItemPackIDApprove]);
                if (!empty($pack)) {
                    $packsize = $pack->ItemPackSKUQty;
                } else {
                    $packsize = '0.00';
                }
                $innernallot = VwSt2LotnumberAvalible::findOne(['StkID' => $stkid, 'ItemInternalLotNum' => $x]);
                $stdata = new TbStitemdetail2Temp();
                $ids_sr = Yii::$app->request->get('ids_sr');
                return $this->renderAjax('determine-the-number', [
                            'model' => $model,
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                            'stkmodel' => $stkmodel,
                            'balence' => $balence,
                            'stdata' => $stdata,
                            'packsize' => $packsize,
                            'innernallot' => $innernallot,
                            'ids_sr' => $ids_sr,
                ]);
            }
        }
    }

    public function actionEditDetail() {
        if (Yii::$app->request->post() != NULL) {
            $ids_sr = Yii::$app->request->get('ids_sr');
            $post = Yii::$app->request->post('TbStitemdetail2Temp');
            $postv = Yii::$app->request->post('VwSt2DetailGroup');
            $poslot = Yii::$app->request->post('VwSt2LotnumberAvalible');
            $datas = TbSt2Temp::findOne(['STID' => $post['STID']]);
            $itempack = VwItempack::findOne(['ItemID' => $postv['ItemID'], 'ItemPackID' => !empty($postv['STItemPackID']) ? $postv['STItemPackID'] : '']);
            if ($itempack != null) {
                $packdata = Yii::$app->request->post('pack');
                if ($packdata == "1") {
                    $itemp = null;
                } else {
                    if (!empty($postv['STItemPackID'])) {
                        $itemp = $itempack->ItemPackID;
                    } else {
                        $itemp = null;
                    }
                }
            } else {
                $itemp = null;
            }
            $ids = $post['ids'];
            $STNum = $datas->STNum;
            $STID = $post['STID'];
            $ItemID = $postv['ItemID'];
            $ItemInternalLotNum = $post['ItemInternalLotNum'];
            $STPackQty = str_replace(",", "", $post['STPackQty']);
            $STPackUnitCost = $poslot['PackItemUnitCost'];
            $STItemPackID = $itemp;
            $STItemQty = str_replace(",", "", $post['STItemQty']);
            $STCreatedBy = Yii::$app->user->identity->profile->user_id;
            $STItemUnitCost = $poslot['ItemUnitCost'];
            Yii::$app->db->createCommand('
                    CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,
                    :STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->bindParam(':ids_sr', $ids_sr)
                    ->execute();
            return 'full';
        } else {
            $id = Yii::$app->request->get('id');
            $ids_sr = Yii::$app->request->get('ids_sr');
            $stdata = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids' => $id]);
            $tbsrdetail = Tbsritemdetail2::findOne(['ids' => $ids_sr]);
            $srid = $tbsrdetail->SRID;
            $st2tem = TbSt2Temp::findOne(['STID' => $stdata->STID]);
            $stkid = $st2tem->STIssue_StkID; //Yii::$app->request->get('stkid');
            $stkmodel = \app\modules\Inventory\models\TbStk::findOne(['StkID' => $stkid]);
            $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
            $dataProvider = $searchModel->searchinternallot($stkid, $stdata->ItemInternalLotNum);
            $balence = VwSt2SrBalance::findOne(['SRID' => $srid, 'ItemID' => $stdata->ItemID]);
            $item = \app\modules\Inventory\models\Vwitemlist::findOne(['ItemID' => $stdata->ItemID]);
            $model = \app\modules\Inventory\models\VwSt2DetailGroup::findOne(['SRID' => $srid, 'ItemID' => $stdata->ItemID]);
            $pack = VwItempack::findOne(['ItemPackID' => $model->SRItemPackIDApprove]);
            $innernallot = VwSt2LotnumberAvalible::findOne(['StkID' => $stkid, 'ItemInternalLotNum' => $stdata->ItemInternalLotNum]);
            if (!empty($pack)) {
                $packsize = $pack->ItemPackSKUQty;
            } else {
                $packsize = '0.00';
            }

            return $this->renderAjax('edit_tranfer', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'StkID' => $stkid,
                        'balence' => $balence,
                        'stkmodel' => $stkmodel,
                        'stdata' => $stdata,
                        'item' => $item,
                        'packsize' => $packsize,
                        'innernallot' => $innernallot
            ]);
        }
    }

    public function actionSelectPack() {
        $id = Yii::$app->request->get('item_ids');
        $pack = VwItempack::findOne(['ItemPackID' => $id]);
        if (!empty($pack->ItemPackSKUQty)) {
            echo $pack->ItemPackSKUQty;
        } else {
            echo null;
        }
    }

}
