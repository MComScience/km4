<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbSt2;
use app\modules\Inventory\models\TbStitemdetail2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClaimProductController implements the CRUD actions for TbSt2Temp model.
 */
class LondProductStController extends Controller
{
    public function behaviors()
    {
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
     * Lists all TbSt2Temp models.
     * @return mixed
     */
    public function actionClickCancel(){
        if(isset($_POST['STID'])){
            $STID = $_POST['STID'];
            $findSTNum = \app\modules\Inventory\models\TbSt2::findOne(['STID'=>$STID]);
            Yii::$app->db->createCommand('CALL cmd_st_stk_cancel_todraft(:x);')
                    ->bindParam(':x', $STID)
                    ->execute();
            Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-check-square-o',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบส่งคืนสินค้า')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบส่งคืนสินค้า'.$findSTNum['STID'].' เรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
            return '99';
        }else{
            return false;
        }
    }
    public function actionIndex()
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        $searchModel = new \app\modules\Inventory\models\VwGr2ListForSt2LoanSearch();
        $dataProvider = $searchModel->SearchLondSt(Yii::$app->request->queryParams);
        $find = \app\modules\Inventory\models\TbSt2Temp::find()->where(['STNum' => NULL])->all();
        if ($find != null) {
            foreach ($find as $data) {
                $STID[] = $data['STID'];
            }
            foreach ($STID as $key) {
                $sql = "DELETE FROM tb_st2_temp WHERE STID = $key AND STCreateBy = $userid;
                       DELETE FROM tb_stitemdetail2_temp WHERE STID = $key AND STCreatedBy = $userid;";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionLondSt()
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        $searchModel = new \app\modules\Inventory\models\TbSt2TempSearch();
        $dataProvider = $searchModel->SearchLondST(Yii::$app->request->queryParams);
        $find = \app\modules\Inventory\models\TbSt2Temp::find()->where(['STNum' => NULL])->all();
        if ($find != null) {
            foreach ($find as $data) {
                $GRID[] = $data['STID'];
            }
            foreach ($GRID as $key) {
               $sql = "DELETE FROM tb_st2_temp WHERE STID = $key AND STCreateBy = $userid;
                       DELETE FROM tb_stitemdetail2_temp WHERE STID = $key AND STCreatedBy = $userid;";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
        }
        return $this->render('lond-st', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHistory()
    {
        $userid = Yii::$app->user->identity->profile->user_id;
        $searchModel = new \app\modules\Inventory\models\TbSt2Search();
        $dataProvider = $searchModel->SearchLondST(Yii::$app->request->queryParams);
        // $find = \app\modules\Inventory\models\TbSt2::find()->where(['STNum' => NULL])->all();
        // if ($find != null) {
        //     foreach ($find as $data) {
        //         $GRID[] = $data['STID'];
        //     }
        //     foreach ($GRID as $key) {
        //        $sql = "DELETE FROM tb_st2 WHERE STID = $key AND STCreateBy = $userid;
        //                DELETE FROM tb_stitemdetail2 WHERE STID = $key AND STCreatedBy = $userid;";
        //         $query = Yii::$app->db->createCommand($sql)->execute();
        //     }
        // }
        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function CheckAuto() {
        $MaxSTID_temp = \app\modules\Inventory\models\TbSt2Temp::find()->max('STID');
        $MaxSTID_Nottemp = \app\modules\Inventory\models\TbSt2::find()->max('STID');
        $MaxIdsST_temp = \app\modules\Inventory\models\TbStitemdetail2Temp::find()->max('ids');
        $MaxIdsST_Nottemp = \app\modules\Inventory\models\TbStitemdetail2::find()->max('ids');
        if(empty($MaxSTID_temp)&&empty($MaxSTID_Nottemp)){
                $setAuto_st2temp ="ALTER TABLE tb_st2_temp AUTO_INCREMENT = 1;";
        }elseif ($MaxSTID_Nottemp>$MaxSTID_temp) {
                $NextSTID = $MaxSTID_Nottemp+1;
                $setAuto_st2temp ="ALTER TABLE tb_st2_temp AUTO_INCREMENT = $NextSTID;";
        }elseif ($MaxSTID_Nottemp<$MaxSTID_temp){
                $NextSTID = $MaxSTID_temp+1;
                $setAuto_st2temp ="ALTER TABLE tb_st2_temp AUTO_INCREMENT = $NextSTID;";
        }
        if(empty($MaxIdsST_temp)&&empty($MaxIdsST_Nottemp)){
                $setAuto_stitemdetail2temp ="ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = 1;";
        }elseif ($MaxIdsST_Nottemp>$MaxIdsST_temp) {
                $NextIds = $MaxIdsST_Nottemp+1;
                $setAuto_stitemdetail2temp ="ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }elseif ($MaxIdsST_Nottemp<$MaxIdsST_temp){
                $NextIds = $MaxIdsST_temp+1;
                $setAuto_stitemdetail2temp ="ALTER TABLE tb_stitemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }
        Yii::$app->db->createCommand($setAuto_st2temp)->query();
        Yii::$app->db->createCommand($setAuto_stitemdetail2temp)->query(); 
    }    
    public function actionCreateLond($GRID) {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findGr2 = \app\modules\Inventory\models\TbGr2::findOne(['GRID'=>$GRID]);
        $findSt2 = \app\modules\Inventory\models\TbSt2Temp::findOne(['DocRefID'=>$GRID]);
        $GRDueDate = $findGr2['PODueDate'];
        $VenderID = $findGr2['VenderID'];
        if($findSt2!=null){
           return 'false';
        }else{
            $this->CheckAuto();
            Yii::$app->db->createCommand('CALL Cmd_st2_loanproduct_create_header(:x,:GRID,:GRDueDate,:VenderID);')
                ->bindParam(':x', $userid)
                ->bindParam(':GRID', $GRID)
                ->bindParam(':GRDueDate', $GRDueDate)
                ->bindParam(':VenderID', $VenderID)
                ->execute();
            $maxTemp = \app\modules\Inventory\models\TbSt2Temp::find()
                     ->select('max(STID)')
                     ->scalar();
            return $this->redirect(['create','STID' => $maxTemp,'GRID'=>$GRID,'view' => '']);
        }
    }
    public function actionCreate($GRID,$STID,$view)
    {   
        $model = new \app\modules\Inventory\models\VwSt2Header();
        $modelST = $this->findModel($STID);
        $searchModel = new \app\modules\Inventory\models\VwSt2Gr2DetailGroupSearch();
        $dataProvider = $searchModel->SearchLond(Yii::$app->request->queryParams, $GRID, $STID);
        $dataProvider->pagination->pageSize = 5;
        if($modelST['STPerson']== NULL ||$modelST['STPerson']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelST['STPerson']]);
             $vendername = $getname['VenderName'];
        }
        if (Yii::$app->request->post()) {
            $STID = $_POST['TbSt2Temp']['STID'];
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbSt2Temp']['STDate']);
            $STNum = $_POST['TbSt2Temp']['STNum'];
            $SRNum = '';
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = $modelST['STCreateDate']; 
            $STIssue_StkID = $_POST['TbSt2Temp']['STIssue_StkID'];
            $STRecieve_StkID ='';
            $STStatus = '';
            $STNote = $_POST['TbSt2Temp']['STNote'];
            Yii::$app->logger->savelog("บันทึกใบส่งคืนสินค้าขอยืม",$STID,'ST');
            $data = Yii::$app->db->createCommand('CALL cmd_st2_savedraft_loan(:STID,:STDate,:SRNum,:STCreateBy,:STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $STID)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();
            $modelST = $this->findModel($STID);
            echo $modelST['STNum'];
        } else {
            return $this->render('create', [
                'modelST' => $modelST,
                'vendername'=>$vendername,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
            ]);
        }
    }
    public function actionCreateLondSt($STID,$view)
    {   
        $findGr2 = \app\modules\Inventory\models\TbSt2Temp::findOne(['STID'=>$STID]);
        $GRID = $findGr2['DocRefID'];
        $model = new \app\modules\Inventory\models\VwSt2Header();
        $modelST = $this->findModel($STID);
        $searchModel = new \app\modules\Inventory\models\VwSt2Gr2DetailGroupSearch();
        $dataProvider = $searchModel->SearchLond(Yii::$app->request->queryParams, $GRID, $STID);
        $dataProvider->pagination->pageSize = 5;
        if($modelST['STPerson']== NULL ||$modelST['STPerson']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelST['STPerson']]);
             $vendername = $getname['VenderName'];
        }
        if (Yii::$app->request->post()) {
            $STID = $_POST['TbSt2Temp']['STID'];
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbSt2Temp']['STDate']);
            $STNum = $_POST['TbSt2Temp']['STNum'];
            $SRNum = '';
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = $modelST['STCreateDate']; 
            $STIssue_StkID = $_POST['TbSt2Temp']['STIssue_StkID'];
            $STRecieve_StkID ='';
            $STStatus = '';
            $STNote = $_POST['TbSt2Temp']['STNote'];
            Yii::$app->logger->savelog("บันทึกใบส่งคืนสินค้าขอยืม",$STID,'ST');
            $data = Yii::$app->db->createCommand('CALL cmd_st2_savedraft_loan(:STID,:STDate,:SRNum,:STCreateBy,:STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $STID)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();
            $modelST = $this->findModel($STID);
            echo $modelST['STNum'];
        } else {
            return $this->render('create', [
                'modelST' => $modelST,
                'vendername'=>$vendername,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
            ]);
        }
    }
    public function actionCreateHistory($STID,$view)
    {   
        $findGr2 = \app\modules\Inventory\models\TbSt2::findOne(['STID'=>$STID]);
        $GRID = $findGr2['DocRefID'];
        $model = new \app\modules\Inventory\models\VwSt2Header2();
        $modelST = \app\modules\Inventory\models\TbSt2::findOne(['STID'=>$STID]);
        $searchModel = new \app\modules\Inventory\models\VwSt2Gr2DetailGroup2Search();
        $dataProvider = $searchModel->SearchLond(Yii::$app->request->queryParams, $GRID, $STID);
        $dataProvider->pagination->pageSize = 5;
        if($modelST['STPerson']== NULL ||$modelST['STPerson']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelST['STPerson']]);
             $vendername = $getname['VenderName'];
        }
        if (Yii::$app->request->post()) {
            $STID = $_POST['TbSt2Temp']['STID'];
            $STDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbSt2Temp']['STDate']);
            $STNum = $_POST['TbSt2Temp']['STNum'];
            $SRNum = '';
            $STCreateBy = Yii::$app->user->identity->profile->user_id;
            $STCreateDate = $modelST['STCreateDate']; 
            $STIssue_StkID = $_POST['TbSt2Temp']['STIssue_StkID'];
            $STRecieve_StkID ='';
            $STStatus = '';
            $STNote = $_POST['TbSt2Temp']['STNote'];
            $data = Yii::$app->db->createCommand('CALL cmd_st2_savedraft_loan(:STID,:STDate,:SRNum,:STCreateBy,:STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
                    ->bindParam(':STID', $STID)
                    ->bindParam(':STDate', $STDate)
                    ->bindParam(':SRNum', $SRNum)
                    ->bindParam(':STCreateBy', $STCreateBy)
                    ->bindParam(':STCreateDate', $STCreateDate)
                    ->bindParam(':STIssue_StkID', $STIssue_StkID)
                    ->bindParam(':STRecieve_StkID', $STRecieve_StkID)
                    ->bindParam(':STStatus', $STStatus)
                    ->bindParam(':STNote', $STNote)
                    ->execute();
            $modelST = $this->findModel($STID);
            echo $modelST['STNum'];
        } else {
            return $this->render('create', [
                'modelST' => $modelST,
                'vendername'=>$vendername,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
            ]);
        }
    }
    function actionGetdataVendor() {
        $model = \app\modules\Inventory\models\VwVendorList::find()
                ->all();
        $htl = '<table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" id="getdatavendortable">
                            <thead class="bordered-success">
                                <tr>
                                    <th width="10%" style="text-align: center">ลำดับ</th>
                                    <th width="100%" style="text-align: center">รหัสผู้จำหน่าย</th>
                                    <th style="text-align: center">ชื่อผู้จำหน่าย</th>
                                    <th width="100%" style="text-align: center">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
        $no = 1;
        foreach ($model as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center;">' . $no . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['VenderName'] . '</td>';
            $htl .='<td style="text-align: center;"><a class="btn btn-success btn-sm" onclick="GetnameVendor(' . $result->user_id . ');" > Select</a></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
                </div>
            ';
        return json_encode($htl);
    }
    public function actionGetnameVendor() {
        $data = \app\modules\Inventory\models\VwVendorList::find()->where(['user_id' => $_POST['id']])->one();
        $arr = array(
            'VendorID' => $data['VendorID'],
            'VenderName' => $data['VenderName'],
        );
        return json_encode($arr);
    }
    function actionGetdataTpu() {
    	$StkID = $_GET['stk'];
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive " cellspacing="0" width="100%" id="detailgrdonatetpu">
    <thead class="bordered-success">
        <tr>
            <th style="text-align: center">ลำดับ</th>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th style="text-align: center">คงเหลือ</th>
            <th style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = \app\modules\Inventory\models\VwStkBalanceItemid::find()->where(['ItemCatID' => 1,'StkID'=>$StkID])->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemQtyBalance'] . '</td>';
            $htl .='<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailtpu(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
            </div>
            ';
        return json_encode($htl);
    }
    function actionGetdataNd() {
    	$StkID = $_GET['stk'];
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="detailgrdonatend">
    <thead class="bordered-success">
        <tr>
            <th width="5%" style="text-align: center">ลำดับ</th>
            <th style="text-align: center">รหัสสินค้า</th>
            <th width="" style="text-align: center">ชื่อสินค้า</th>
            <th width="" style="text-align: center">คงเหลือ</th>
            <th width="" style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
       $data = \app\modules\Inventory\models\VwStkBalanceItemid::find()->where(['ItemCatID' => 2,'StkID'=>$StkID])->all();
       $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemQtyBalance'] . '</td>';
            $htl .='<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailND(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>
            </div>
            ';
        return json_encode($htl);
    }
    public function actionSelectItem($ids_gr, $STID, $StkID, $STNum) {
        $findGr = \app\modules\Inventory\models\TbGritemdetail2::findOne(['ids_gr'=>$ids_gr]);
        $ItemID = $findGr['ItemID'];
        $modelstk = new \app\modules\Inventory\models\VwSt2Header();
        $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$StkID]);
        if($StkID != '0' || $StkID != null){
            $sql = "update tb_st2_temp set STIssue_StkID = $StkID WHERE tb_st2_temp.STID = $STID;";
            $query = Yii::$app->db->createCommand($sql)->execute();
        }
        $check = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['STID'=>$STID,'ItemID' => $ItemID]);
        if ($check != null) {
            return 'false';
        }
                $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
                $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
                $dataProvider = $searchModel->SearchType1(Yii::$app->request->queryParams,$ItemID,$StkID);
                return $this->renderAjax('_form_detail', [
                            'ids_gr'=>$ids_gr,
                            'STID'=> $STID,
                            'STNum' => $STNum,
                            'modeledit' => $modeledit,
                            'dataProvider'=>$dataProvider,
                            'modelstk'=> $modelstk,
                            'stkid'=>$StkName['StkName'],
                            'Item' => $Item,
                            'ItemDetail' => $Item['ItemName'],
                ]);
        }
    public function actionSelectLotnumber($ids_gr, $ItemID, $stkid, $Internal, $STID, $STNum) {
        if (Yii::$app->request->post()){
            if ($_POST['VwSt2DetailSub']['STPackUnit'] != NULL || $_POST['VwSt2DetailSub']['STPackUnit'] =='' ) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwSt2DetailGroup']['ItemID'],
                            'ItemPackUnit' => $_POST['VwSt2DetailSub']['STPackUnit']
                ]);
                $STItemPackID = $find['ItemPackID'];
            } else {
               $STItemPackID = '';
            } 
                $ids = '';
                $ids_gr = $_POST['ids_gr'];
                $STLeftQty = $_POST['STLeftQty2'];
                $STPackQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackQty']);
                $STPackUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackUnitCost']);
                $STItemQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemQty']);
                $STCreatedBy = Yii::$app->user->identity->profile->user_id; 
                $STItemUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemUnitCost']);
                Yii::$app->db->createCommand('CALL cmd_st2_item_save_loan(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,:STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr,:STLeftQty);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $Internal)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->bindParam(':ids_sr', $ids_gr)
                    ->bindParam(':STLeftQty', $STLeftQty)
                    ->execute();
            echo '1';
        }else{
                $modelstk = new \app\modules\Inventory\models\VwSt2Header();
                $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
                $modelST = new \app\modules\Inventory\models\VwSt2DetailSub();
                $modelGR =  \app\modules\Inventory\models\VwSt2Gr2DetailGroup::findOne(['ids_gr'=>$ids_gr]);
                $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
                $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $cost = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['StkID'=>$stkid,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$Internal]);
                $checklot = $cost['ItemQty'];
                $GRItemPackID = $modelGR['GRItemPackID'];
                if($GRItemPackID !=null){
                        $findpackGR = \app\models\TbItempack::findOne(['ItemPackID'=> $GRItemPackID]);
                        $GRItemPackSKUQty =  $findpackGR['ItemPackSKUQty'];
                }else{
                        $GRItemPackSKUQty = '0';
                }   
                $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
                $dataProvider = $searchModel->SearchType2(Yii::$app->request->queryParams,$ItemID,$stkid,$Internal);
                $dataProvider->pagination->pageSize = 5;
                $findpack = \app\models\TbItempack::findOne(['ItemPackID'=> '']);
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }
                return $this->renderAjax('_form_update_adjust', [
                            'ids_gr'=>$ids_gr,
                            'modeledit' => $modeledit,
                            'modelST' => $modelST,
                            'modelGR' =>$modelGR,
                            'modelstk'=> $modelstk,
                            'dataProvider'=>$dataProvider,
                            'stkid'=> $StkName['StkName'],
                            'Item' => $Item,
                            'pack' => $pack,
                            'ItemPackSKUQty' => '0.00',
                            'STPackQty' => '0.00',
                            'STPackUnitCost' => $cost['PackItemUnitCost'],
                            'STItemQty' => '0.00',
                            'STItemUnitCost' => $cost['ItemUnitCost'],
                            'STExtenedCost'=>'0.00',
                            'PackUnit' => '',
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                            'findpack'=>$findpack,
                            'checklot'=>$checklot,
                            'checkpacklot' => 'no',
                            'GRPackQty'=>$modelGR['GRPackQty'],
                            'GRPackUnitCost'=>$modelGR['GRPackUnitCost'],
                            'GRItemQty'=>$modelGR['GRItemQty'],
                            'GRItemUnitCost'=>$modelGR['GRItemUnitCost'],
                            'STSentQty'=>$modelGR['STSentQty'],
                            'GRUnit'=>$modelGR['GRUnit'],
                            'GRItemPackSKUQty' => $GRItemPackSKUQty,
        ]);
            
        }
    }
    public function actionEditLotnumber($ids_gr, $stkid) {
        $findST = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids_sr'=>$ids_gr]);
        $ids = $findST['ids'];
        $edit = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids'=>$ids]);
        if (Yii::$app->request->post()){
            if ($_POST['VwSt2DetailSub']['STPackUnit'] != NULL || $_POST['VwSt2DetailSub']['STPackUnit'] =='' ) {
                $find = \app\models\TbItempack::findOne([
                            'ItemID' => $_POST['VwSt2DetailGroup']['ItemID'],
                            'ItemPackUnit' => $_POST['VwSt2DetailSub']['STPackUnit']
                ]);
                $STItemPackID = $find['ItemPackID'];
            } else {
               $STItemPackID = '';
            } 
                $ids = $ids;
                $ids_gr = $_POST['ids_gr'];
                $STLeftQty = $_POST['STLeftQty2'];
                $STNum = $edit['STNum'];
                $STID = $edit['STID'];
                $ItemID = $edit['ItemID'];
                $Internal = $edit['ItemInternalLotNum'];
                $STPackQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackQty']);
                $STPackUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackUnitCost']);
                $STItemQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemQty']);
                $STCreatedBy = Yii::$app->user->identity->profile->user_id; 
                $STItemUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemUnitCost']);
                Yii::$app->db->createCommand('CALL cmd_st2_item_save_loan(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,:STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr,:STLeftQty);')
                    ->bindParam(':ids', $ids)
                    ->bindParam(':STNum', $STNum)
                    ->bindParam(':STID', $STID)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemInternalLotNum', $Internal)
                    ->bindParam(':STPackQty', $STPackQty)
                    ->bindParam(':STPackUnitCost', $STPackUnitCost)
                    ->bindParam(':STItemPackID', $STItemPackID)
                    ->bindParam(':STItemQty', $STItemQty)
                    ->bindParam(':STCreatedBy', $STCreatedBy)
                    ->bindParam(':STItemUnitCost', $STItemUnitCost)
                    ->bindParam(':ids_sr', $ids_gr)
                    ->bindParam(':STLeftQty', $STLeftQty)
                    ->execute();
            echo '1';
        }else{  
                $ItemID =  $edit['ItemID'];
                $Internal = $edit['ItemInternalLotNum'];
                $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
                $modelST = new \app\modules\Inventory\models\VwSt2DetailSub();
                $modelGR =  \app\modules\Inventory\models\VwSt2Gr2DetailGroup::findOne(['ids_gr'=>$ids_gr]);
                $modelstk = new \app\modules\Inventory\models\VwSt2Header();
                $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
                $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $Ext = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids'=>$ids]);
                $findpack = \app\models\TbItempack::findOne(['ItemPackID'=> $edit['STItemPackID']]);
                $cost = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['StkID'=>$stkid,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$Internal]);
                $checklot = $cost['ItemQty'];
                $GRItemPackID = $modelGR['GRItemPackID'];
                if($GRItemPackID !=null){
                        $findpackGR = \app\models\TbItempack::findOne(['ItemPackID'=> $GRItemPackID]);
                        $GRItemPackSKUQty =  $findpackGR['ItemPackSKUQty'];
                }else{
                        $GRItemPackSKUQty = '0';
                }   
                $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
                $dataProvider = $searchModel->SearchType2(Yii::$app->request->queryParams,$ItemID,$stkid,$Internal);
                $dataProvider->pagination->pageSize = 5;
                $checkpack = \app\models\TbItempack::findAll(['ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $ItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $ItemPackSKUQty = '';
                }
                return $this->renderAjax('_form_update_adjust', [
                            'ids_gr'=>$ids_gr,
                            'modeledit' => $modeledit,
                            'modelST' => $modelST,
                            'modelGR' =>$modelGR,
                            'modelstk'=> $modelstk,
                            'dataProvider'=>$dataProvider,
                            'stkid'=> $StkName['StkName'],
                            'Item' => $Item,
                            'pack' => $pack,
                            'findpack'=>$findpack,
                            'ItemPackSKUQty' => $findpack['ItemPackSKUQty'],
                            'STPackQty' => $edit['STPackQty'],
                            'STPackUnitCost' => $edit['STPackUnitCost'],
                            'STItemQty' => $edit['STItemQty'],
                            'STItemUnitCost' => $edit['STItemUnitCost'],
                            'STExtenedCost'=>$Ext['STExtenedCost'],
                            'PackUnit' => '',
                            'DispUnit' => $Item['DispUnit'],
                            'ItemDetail' => $Item['ItemName'],
                            'checklot'=>$checklot,
                            'checkpacklot' => 'edit',
                            'GRPackQty'=>$modelGR['GRPackQty'],
                            'GRPackUnitCost'=>$modelGR['GRPackUnitCost'],
                            'GRItemQty'=>$modelGR['GRItemQty'],
                            'GRItemUnitCost'=>$modelGR['GRItemUnitCost'],
                            'STSentQty'=>$modelGR['STSentQty'],
                            'GRUnit'=>$modelGR['GRUnit'],
                            'GRItemPackSKUQty' => $GRItemPackSKUQty,
        ]);
            
        }
    }
    public function actionStockIssue(){
        $STID = $_POST['STID'];
        $statusID = 20;
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->logger->savelog("ส่งคืนสินค้าขอยืม",$STID,'ST'); 
        Yii::$app->db->createCommand('CALL cmd_st2_stk_issue_loan(:x,:userid);')
                ->bindParam(':x', $STID)
                ->bindParam(':userid', $userid)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Stock Issue Complete!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Inventory/lond-product-st/index');
    }
    public function actionDeleteDetail() {
        $key = $_POST['ids'];
        $sql = "DELETE FROM tb_stitemdetail2_temp WHERE ids = $key";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionGetQty() {
        $qty = \app\models\TbItempack::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
        );
        return json_encode($arr);
    }
    public function actionViewDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $ids_gr = $_POST['expandRowKey'];
            $findST = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids_sr'=>$ids_gr ]);
            $ids = $findST['ids'];
            $searchModel = new \app\modules\Inventory\models\TbStitemdetail2TempSearch();
            $dataProvider = $searchModel->Detailsearch(Yii::$app->request->queryParams, $ids);
            $dataProvider->pagination->pageSize = 5;
            return $this->renderPartial('viewdetail', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionViewDetailHistory() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $ids_gr = $_POST['expandRowKey'];
            $findST = \app\modules\Inventory\models\TbStitemdetail2::findOne(['ids_sr'=>$ids_gr ]);
            $ids = $findST['ids'];
            $checkST = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids'=>$ids]);
            if($checkST != null){
                $searchModel = new \app\modules\Inventory\models\TbStitemdetail2TempSearch();
                $dataProvider = $searchModel->Detailsearch(Yii::$app->request->queryParams, $ids);
                $dataProvider->pagination->pageSize = 5;
            }else{
                $searchModel = new \app\modules\Inventory\models\TbStitemdetail2Search();
                $dataProvider = $searchModel->Detailsearch(Yii::$app->request->queryParams, $ids);
                $dataProvider->pagination->pageSize = 5;
            }
            return $this->renderPartial('viewdetail', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Updates an existing TbSt2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->STID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbSt2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $STID = $id;
        Yii::$app->logger->savelog("ลบบันทึกใบส่งคืนสินค้าขอยืม",$id,'ST');
        $sql = "DELETE FROM tb_st2_temp WHERE STID = $STID;
               DELETE FROM tb_stitemdetail2_temp WHERE STID = $STID;";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect(['index']);
    }
    public function actionClear(){
        $STID = $_POST['STID'];
        Yii::$app->db->createCommand('CALL cmd_st2_clear(:x);')
                ->bindParam(':x', $STID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 5000,
            'icon' => 'fa fa-users',
            'title' => Yii::t('app', \yii\helpers\Html::encode('Submission')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('Clear Successfully!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Inventory/claim-product/index');
    }

    /**
     * Finds the TbSt2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbSt2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \app\modules\Inventory\models\TbSt2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
