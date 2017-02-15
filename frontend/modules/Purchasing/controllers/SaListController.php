<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\VwSaList;
use app\modules\Inventory\models\SaListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\Inventory\models\TbSa2;
use app\modules\Inventory\models\Vwitemlist;
use app\models\Vwitemlisttpu;
use app\modules\Inventory\models\VwSaLotnumberAvalibleSearch;
use app\modules\Inventory\models\TbSaitemdetail2;
use app\modules\Inventory\models\VwSaItemdetailSearch;

class SaListController extends Controller {

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

    /**
     * Lists all VwSaList models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SaListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteDetail() {
        $id = Yii::$app->request->post('id');
        TbSaitemdetail2::findOne(['SAID' => $id['SAID'], 'ItemID' => $id['ItemID']])->delete();
        echo '1';
    }
     public function actionDeleteDetail2() {
        $id = Yii::$app->request->post('id');
        TbSaitemdetail2::findOne(['ids' => $id])->delete();
        echo '1';
    }

    public function actionSaReject() {
        $SaReason = Yii::$app->request->post('SaReason');
        $tbsa2said = Yii::$app->request->post('tbsa2said');
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_sa_rejectsave(:SAID,:userid,:sanote);')
                ->bindParam(':SAID', $tbsa2said)
                ->bindParam(':userid', $userid)
                ->bindParam(':sanote', $SaReason)
                ->execute();
        echo '1';
    }

    public function actionCreateTemp() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $cmd = Yii::$app->db->createCommand('CALL cmd_sa_create_header(:userid);')->bindParam(':userid', $userid)->queryOne();
        $max = $cmd['lastid'];
        return $this->redirect(['create', 'SAID' => $max]);
    }

    public function actionView($id, $appvo) {
        $searchModel = new \app\modules\Inventory\models\VwSaItemdetailGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'appvo' => $appvo
        ]);
    }

    /**
     * Creates a new VwSaList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($SAID,$appvo=1) {
        $model = TbSa2::findOne($SAID);
        if ($model->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('TbSa2');
            $SAID = $pos['SAID'];
            $SA_stkID = $pos['SA_stkID'];
            $SANote = $pos['SANote'];
            $SAStatus = Yii::$app->request->post('status');
            Yii::$app->db->createCommand('
                    CALL cmd_sa_savedraft(:SAID,:SA_stkID,:SANote,:SAStatus);')
                    ->bindParam(':SAID', $SAID)
                    ->bindParam(':SA_stkID', $SA_stkID)
                    ->bindParam(':SANote', $SANote)
                    ->bindParam(':SAStatus', $SAStatus)                   
                    ->execute();
            $model = TbSa2::findOne($SAID);
            return $model->SANum;
        } else {
            $searchModel = new \app\modules\Inventory\models\VwSaItemdetailGroupSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $SAID);
            $model->SAStatus = 1;
            return $this->render('create', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'appvo' => $appvo
            ]);
        }
    }

    public function actionSa2SendToApprove() {
        $id = Yii::$app->request->get('id');
        Yii::$app->db->createCommand('CALL cmd_sa_send_to_approve(:SAID);')->bindParam(':SAID', $id)->execute();
        echo 'full';
    }

    public function actionExtPen() {
        $pos = Yii::$app->request->post();
        if (isset($pos['expandRowKey'])) {
            $searchModel = new VwSaItemdetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pos['expandRowKey']['SAID'], $pos['expandRowKey']['ItemID']);

            return $this->renderAjax('expenlot', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSa2Clear() {
        $id = Yii::$app->request->get('id');
        Yii::$app->db->createCommand('CALL cmd_sa_clear(:SAID);')->bindParam(':SAID', $id)->execute();
        echo 'full';
    }

    public function actionUpdate($id, $appvo) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $pos = Yii::$app->request->post('TbSa2');
            $SAID = $pos['SAID'];
            $SA_stkID = $pos['SA_stkID'];
            $SANote = $pos['SANote'];
            $SAStatus = Yii::$app->request->post('status');
            Yii::$app->db->createCommand('
                    CALL cmd_sa_savedraft(:SAID,:SA_stkID,:SANote,:SAStatus);')
                    ->bindParam(':SAID', $SAID)
                    ->bindParam(':SA_stkID', $SA_stkID)
                    ->bindParam(':SANote', $SANote)
                    ->bindParam(':SAStatus', $SAStatus)
                    ->execute();
            $model = TbSa2::findOne($SAID);
            return $model->SANum;
        } else {
            $searchModel = new \app\modules\Inventory\models\VwSaItemdetailGroupSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            return $this->render('update', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'appvo' => $appvo
            ]);
        }
    }

    public function actionSa2Approve() {
        $id = Yii::$app->request->get('id');

        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_sa_approve(:SAID,:USERID);')
                ->bindParam(':SAID', $id)
                ->bindParam(':USERID', $userid)
                ->execute();
        echo '1';
    }

    /**
     * Deletes an existing VwSaList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
      //  return $this->redirect(['index']);
    }

    public function actionWaitApprove() {
        $searchModel = new SaListSearch();
        $dataProvider = $searchModel->searchwaitapprove(Yii::$app->request->queryParams);

        return $this->render('wailt_approve', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistory() {
        $searchModel = new SaListSearch();
        $dataProvider = $searchModel->searchhistory(Yii::$app->request->queryParams);

        return $this->render('history', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id) {
        if (($model = TbSa2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGettpu() {
        $Productmodel = Vwitemlisttpu::find()->all();
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="50%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดยาการค้า</th>
                                   <th width="50%" style="text-align: center;">รหัสยาการค้า</th>
                                    <th width="20%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['FSN_TMT'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->ItemID . ',1);" > Select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return $htl;
    }

    public function actionGetnd() {
        $Productmodel = Vwitemlist::find()->where(['ItemCatID' => '2', 'ItemCatID' => '2'])->all();
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="data_tpu">
                            <thead class="bordered-success">
                                <tr>
                                   <th width="5%" style="text-align: center;">ลำดับ</th>
                                    <th width="30%" style="text-align: center;">รหัสสินค้า</th>
                                    <th width="100%" style="text-align: center;"> รายละเอียดสินค้า</th>
                                    <th width="20%" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($Productmodel as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->ItemID . ',2);" > Select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return $htl;
    }

    public function actionDetailSelect() {
        $modeledit = new TbSaitemdetail2();
        $pos = Yii::$app->request->post();
        $check = TbSaitemdetail2::findOne(['ItemID' => $pos['id'], 'SAID' => $pos['SAID']]);
        if ($check != null) {
            return 'false';
        } else {
            $Item = Vwitemlist::findOne(['ItemID' => $pos['id']]);
            $modeledit['ItemID'] = $Item['ItemID'];
            $Item['ItemName'] = $Item['ItemName'];

            $stk = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $pos['tbsa2sastkid']]);
            if ($stk->StkName) {
                $stk = $stk;
            } else {
                $stk = null;
            }
            $searchModel = new VwSaLotnumberAvalibleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pos['tbsa2sastkid'], $pos['id']);
            return $this->renderAjax('_form_detail', [
                        'modeledit' => $modeledit,
                        'SAID' => $pos['SAID'],
                        'Item' => $Item,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'stk' => $stk
            ]);
        }
    }

    public function actionAdjitemSelect() {
        $model = new TbSaitemdetail2();
        if (Yii::$app->request->post() != NULL) {
            $SAID = Yii::$app->request->post('SAID');
            $data = TbSa2::findOne(['SAID' => $SAID]);
            $posview = Yii::$app->request->post('VwSaLotnumberAvalible');
            $postbalance = Yii::$app->request->post('VwStkBalanceLotnumber');
            $postb = Yii::$app->request->post('TbSaitemdetail2');
            $stkid = Yii::$app->request->post('stkid');
            $ItemInternalLotNum = $posview['ItemInternalLotNum'];
            $ids = null;
            $ItemID = $posview['ItemID'];
            $SANum = $data->SANum;
            $OnhandLotItemQty = str_replace(',', '', $postbalance['ItemQtyBalance']);
            $ActualLotItemQty = str_replace(',', '', $postb['ActualLotItemQty']);
            $AdjLotItemQty = str_replace(',', '', $postb['ActualLotItemQty']);
            $BalanceAdjLotItemQty = str_replace(',', '', $postb['BalanceAdjLotItemQty']);
            $SAItemNumStatus = str_replace(',', '', $postb['SAItemNumStatus']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sa_adjitem_save(:ids,:SANum,:SAID,:ItemID,:ItemInternalLotNum,
                    :OnhandLotItemQty,:ActualLotItemQty,:AdjLotItemQty,:BalanceAdjLotItemQty,:SAItemNumStatus,:SACreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SANum', $SANum)
                    ->bindParam(':SAID', $SAID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':OnhandLotItemQty', $OnhandLotItemQty)
                    ->bindParam(':ActualLotItemQty', $ActualLotItemQty)
                    ->bindParam(':AdjLotItemQty', $AdjLotItemQty)
                    ->bindParam(':BalanceAdjLotItemQty', $BalanceAdjLotItemQty)
                    ->bindParam(':SAItemNumStatus', $SAItemNumStatus)
                    ->bindParam(':SACreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $tbsa2said = Yii::$app->request->get('tbsa2said');
            $internallotid = Yii::$app->request->get('id');
            $stkid = Yii::$app->request->get('stkid');
            $itemid = Yii::$app->request->get('itemid');
            $modeledit = \app\modules\Inventory\models\VwSaLotnumberAvalible::findOne(['ItemID' => $itemid, 'StkID' => $stkid, 'ItemInternalLotNum' => $internallotid]);
            $stk = $stk = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $stkid]);
            if ($stk->StkName) {
                $stk = $stk;
            } else {
                $stk = null;
            }
            $onhandata = \app\modules\Inventory\models\VwStkBalanceLotnumber::findOne(['ItemID' => $itemid, 'StkID' => $stkid, 'ItemInternalLotNum' => $internallotid]);
            $searchModel = new VwSaLotnumberAvalibleSearch();
            $dataProvider = $searchModel->searchinternallot(Yii::$app->request->queryParams, $stkid, $itemid,$internallotid);
            return $this->renderAjax('form_adjitem', [
                        'modeledit' => $modeledit,
                        'stk' => $stk,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'SAID' => $tbsa2said,
                        'onhandata' => $onhandata
            ]);
        }
    }

    public function actionEditSelect() {
        if (Yii::$app->request->post() != NULL) {
            $SAID = Yii::$app->request->post('SAID');
            $data = TbSa2::findOne(['SAID' => $SAID]);
            $posview = Yii::$app->request->post('VwSaLotnumberAvalible');
            $postbalance = Yii::$app->request->post('VwStkBalanceLotnumber');
            $postb = Yii::$app->request->post('TbSaitemdetail2');
            $stkid = Yii::$app->request->post('stkid');
            $ItemInternalLotNum = $posview['ItemInternalLotNum'];
            $ids = $postb['ids'];
            $ItemID = $posview['ItemID'];
            $SANum = $data->SANum;
            $OnhandLotItemQty = str_replace(',', '', $postbalance['ItemQtyBalance']);
            $ActualLotItemQty = str_replace(',', '', $postb['ActualLotItemQty']);
            $AdjLotItemQty = str_replace(',', '', $postb['ActualLotItemQty']);
            $BalanceAdjLotItemQty = str_replace(',', '', $postb['BalanceAdjLotItemQty']);
            $SAItemNumStatus = str_replace(',', '', $postb['SAItemNumStatus']);
            $SRCreatedBy = Yii::$app->user->identity->profile->user_id;
            Yii::$app->db->createCommand('
                    CALL cmd_sa_adjitem_save(:ids,:SANum,:SAID,:ItemID,:ItemInternalLotNum,
                    :OnhandLotItemQty,:ActualLotItemQty,:AdjLotItemQty,:BalanceAdjLotItemQty,:SAItemNumStatus,:SACreatedBy);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':SANum', $SANum)
                    ->bindParam(':SAID', $SAID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                    ->bindParam(':OnhandLotItemQty', $OnhandLotItemQty)
                    ->bindParam(':ActualLotItemQty', $ActualLotItemQty)
                    ->bindParam(':AdjLotItemQty', $AdjLotItemQty)
                    ->bindParam(':BalanceAdjLotItemQty', $BalanceAdjLotItemQty)
                    ->bindParam(':SAItemNumStatus', $SAItemNumStatus)
                    ->bindParam(':SACreatedBy', $SRCreatedBy)
                    ->execute();
            echo '1';
        } else {
            $ids = Yii::$app->request->get('id');
            $stkid = Yii::$app->request->get('stkid');
            $model = TbSaitemdetail2::findOne(['ids' => $ids]);
            $internallotid = $model->ItemInternalLotNum;
            $itemid = $model->ItemID;
            $modeledit = \app\modules\Inventory\models\VwSaLotnumberAvalible::findOne(['ItemID' => $itemid, 'StkID' => $stkid, 'ItemInternalLotNum' => $internallotid]);
            $stk = $stk = \app\modules\Inventory\models\Tbstk::findOne(['StkID' => $stkid]);
            if ($stk->StkName) {
                $stk = $stk;
            } else {
                $stk = null;
            }
            $onhandata = \app\modules\Inventory\models\VwStkBalanceLotnumber::findOne(['ItemID' => $itemid, 'StkID' => $stkid, 'ItemInternalLotNum' => $internallotid]);
            $searchModel = new VwSaLotnumberAvalibleSearch();
            $dataProvider = $searchModel->searchinternallot(Yii::$app->request->queryParams, $stkid, $itemid,$internallotid);
            return $this->renderAjax('form_adjitem', [
                        'modeledit' => $modeledit,
                        'stk' => $stk,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'SAID' => $model->SAID,
                        'onhandata' => $onhandata
            ]);
        }
    }

}
