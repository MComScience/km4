<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbGr2Temp;
use app\modules\Inventory\models\TbGritemdetail2Temp;
use app\modules\Inventory\models\TbItemlotnum2Temp;
use app\modules\Inventory\models\TbGr2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockInitailController implements the CRUD actions for TbGr2Temp model.
 */
class StockInitailController extends Controller
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
     * Lists all TbGr2Temp models.
     * @return mixed
     */
    public function actionViewLotnumber() {
        if (isset($_POST['expandRowKey'])) {
            $ids_gr = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Inventory\models\VwGr2LotAssignedDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $ids_gr);
            return $this->renderAjax('view_lotnumber', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionClickEdit(){
        if (isset($_POST['ItemInternalLotNum'])){
           $model = \app\modules\Inventory\models\VwGr2LotAssignedDetail2::findOne(['ItemInternalLotNum'=>$_POST['ItemInternalLotNum']]);
           if(empty($model)){
            return '<div class="alert alert-danger">ไม่พบข้อมูลในระบบ</div>';
           }else{
            $findItemName = \app\modules\Inventory\models\TbGritemdetail2::findOne(['ids_gr'=>$model['ids_gr']]);
            $ItemName =$findItemName['ItemName']; 
            return $this->renderAjax('_modal_edit_lotnumber', [
                'model' => $model,
                'ItemName' => $ItemName,
            ]);
           }
        }else{
            return '<div class="alert alert-danger">ไม่พบข้อมูลในระบบ</div>';
        }
        
    }
    public function actionUpdateLotnumber(){
       $ItemInternalLotNum = $_POST['ItemInternalLotNum'];
       $ExpDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['ExpDate']);
       $External = $_POST['External'];
       $sql = "UPDATE tb_itemlotnum2 SET ItemExpDate='$ExpDate',ItemExternalLotNum='$External' WHERE tb_itemlotnum2.ItemInternalLotNum='$ItemInternalLotNum';";    
       $query = Yii::$app->db->createCommand($sql)->query();
       return true;
    }
    public function actionClickCancel(){
        if(isset($_POST['GRID'])){
            $GRID = $_POST['GRID'];
            $findGRNum = \app\modules\Inventory\models\TbGr2::findOne(['GRID'=>$GRID]);
            //-----START Check transaction----
            $sql ="SELECT ItemInternalLotNum,COUNT(tb_stk_trans.ItemInternalLotNum) AS chk_transaction
            FROM tb_stk_trans
            WHERE tb_stk_trans.ItemInternalLotNum IN (select tb_itemlotnum2.ItemInternalLotNum from tb_itemlotnum2 WHERE GRID = '$GRID')
            GROUP BY
            tb_stk_trans.ItemInternalLotNum
            HAVING 
            COUNT(tb_stk_trans.ItemInternalLotNum) > 1";
            $query = Yii::$app->db->createCommand($sql)->query();
            //-----END Check transaction----
            if(empty($query->rowCount)){
                Yii::$app->db->createCommand('CALL cmd_gr2_cancel(:x);')
                    ->bindParam(':x', $GRID)
                    ->execute();
                Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-check-square-o',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบรับสินค้า')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบรับสินค้าที่ '.$findGRNum['GRNum'].' เรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
                return "6213624557568926";
            }else{
                return "83625443654557";
            }
        }else{
            return false;
        }
        
    }
    public function DeleteTemp(){
        $user_id = Yii::$app->user->identity->profile->user_id;
        $query_temp = TbGr2Temp::find()->select('GRID')->where('GRCreatedDate <= (DATE_SUB(curdate(), INTERVAL 1 DAY))')->andWhere('GRNum is null')->asArray()->all();
        if(!empty($query_temp)){
          foreach ($query_temp as $key_temp) {
          TbGr2Temp::deleteAll('GRID = :GRID', [':GRID' => $key_temp['GRID']]);
          TbGritemdetail2Temp::deleteAll('GRID = :GRID', [':GRID' => $key_temp['GRID']]);
          TbItemlotnum2Temp::deleteAll('GRID = :GRID',[':GRID' => $key_temp['GRID']]);
          }
        }
        $findGRID = TbGr2Temp::find()->select('GRID')->where(['GRNum' => NULL])->asArray()->all();
        foreach ($findGRID as $data) {
          TbGr2Temp::deleteAll('GRID = :GRID AND GRCreatedBy = :GRCreatedBy', [':GRID' => $data['GRID'],':GRCreatedBy'=>$user_id]);
          TbGritemdetail2Temp::deleteAll('GRID = :GRID AND GRCreatedBy = :GRCreatedBy', [':GRID' => $data['GRID'],':GRCreatedBy'=>$user_id]);
          TbItemlotnum2Temp::deleteAll('GRID = :GRID AND LNCreatedBy = :LNCreatedBy',[':GRID' => $data['GRID'],':LNCreatedBy'=>$user_id]);
        }
    }
    public function actionIndex() {
        $_SESSION['ss_sectionid'] = Yii::$app->user->identity->profile->User_sectionid;
        $this->DeleteTemp();
        $searchModel = new \app\modules\Inventory\models\TbGr2TempSearch();
        $dataProvider = $searchModel->SearchStinitail(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHistoryStockinitail() {
        $searchModel = new \app\modules\Inventory\models\TbGr2Search();
        $dataProvider = $searchModel->SearchHistoryStk(Yii::$app->request->queryParams);
        return $this->render('history-stk', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function CheckAuto() {
        $MaxGRID_temp = \app\modules\Inventory\models\TbGr2Temp::find()->max('GRID');
        $MaxGRID_Nottemp = \app\modules\Inventory\models\TbGr2::find()->max('GRID');
        $MaxIdsGR_temp = \app\modules\Inventory\models\TbGritemdetail2Temp::find()->max('ids_gr');
        $MaxIdsGR_Nottemp = \app\modules\Inventory\models\TbGritemdetail2::find()->max('ids_gr');
        if(empty($MaxGRID_temp)&&empty($MaxGRID_Nottemp)){
                $setAuto_gr2temp ="ALTER TABLE tb_gr2_temp AUTO_INCREMENT = 1;";
        }elseif ($MaxGRID_Nottemp>$MaxGRID_temp) {
                $NextGRID = $MaxGRID_Nottemp+1;
                $setAuto_gr2temp ="ALTER TABLE tb_gr2_temp AUTO_INCREMENT = $NextGRID;";
        }elseif ($MaxGRID_Nottemp<$MaxGRID_temp){
                $NextGRID = $MaxGRID_temp+1;
                $setAuto_gr2temp ="ALTER TABLE tb_gr2_temp AUTO_INCREMENT = $NextGRID;";
        }
        if(empty($MaxIdsGR_temp)&&empty($MaxIdsGR_Nottemp)){
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = 1;";
        }elseif ($MaxIdsGR_Nottemp>$MaxIdsGR_temp) {
                $NextIds = $MaxIdsGR_Nottemp+1;
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }elseif ($MaxIdsGR_Nottemp<$MaxIdsGR_temp){
                $NextIds = $MaxIdsGR_temp+1;
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }
        Yii::$app->db->createCommand($setAuto_gr2temp)->query();
        Yii::$app->db->createCommand($setAuto_gritemdetail2temp)->query(); 
    }
    public function actionCreateStk() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $this->CheckAuto();
        Yii::$app->db->createCommand('CALL cmd_gr2_stkinitial_create_header(:x);')
                ->bindParam(':x', $userid)
                ->execute();
        $maxTemp = \app\modules\Inventory\models\TbGr2Temp::find()
                 ->select('max(GRID)')
                 ->scalar();
        return $this->redirect(['create','GRID' => $maxTemp, 'view' => '']);
    }
    public function actionCreate($GRID,$view)
    {   
        $model = new \app\modules\Inventory\models\VwGr2Header();
        $modelGR = $this->findModel($GRID);
        $searchModel = new \app\modules\Inventory\models\TbGritemdetail2TempSearch();
        $dataProvider = $searchModel->SearchDetail(Yii::$app->request->queryParams, $GRID);
        $dataProvider->pagination->pageSize = 9999;
        if($modelGR['StkID']== NULL ||$modelGR['StkID']==''){
            $stkname = '';
        }else {
            $getname = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$modelGR['StkID']]);
             $stkname = $getname['StkName'];
        }
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbGr2Temp']['GRDate']);
            $StkID = $_POST['TbGr2Temp']['StkID'];
            $GRNote= $_POST['TbGr2Temp']['GRNote'];
            Yii::$app->logger->savelog('บันทึกตั้งต้นสินค้าคงคลัง',$GRID,'GR');
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft_stkinitial(:GRID,:GRDate,:StkID,:GRNote);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':StkID', $StkID)
                    ->bindParam(':GRNote', $GRNote)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];

        }else {
            return $this->render('create', [
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
                'stkname'=>$stkname,
            ]);
        }
    }
    public function actionCreateHistory($GRID,$view)
    {   
        $model = new \app\modules\Inventory\models\VwGr2Header();
        $modelGR = \app\modules\Inventory\models\TbGr2::findOne(['GRID'=>$GRID]);
        $searchModel = new \app\modules\Inventory\models\TbGritemdetail2Search();
        $dataProvider = $searchModel->SearchDetail(Yii::$app->request->queryParams, $GRID);
        $dataProvider->pagination->pageSize = 9999;
        if($modelGR['StkID']== NULL ||$modelGR['StkID']==''){
            $stkname = '';
        }else {
            $getname = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$modelGR['StkID']]);
             $stkname = $getname['StkName'];
        }
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbGr2Temp']['GRDate']);
            $StkID = $_POST['TbGr2Temp']['StkID'];
            $GRNote= $_POST['TbGr2Temp']['GRNote'];
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft_stkinitial(:GRID,:GRDate,:StkID,:GRNote);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':StkID', $StkID)
                    ->bindParam(':GRNote', $GRNote)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];
        }else {
            return $this->render('create', [
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
                'stkname'=>$stkname,
            ]);
        }
    }
    
    function actionGetdataTpu() {
        $GRID = $_GET['GRID'];
        if(!empty($_GET['StkID'])){
           $StkID = $_GET['StkID'];
           $sql = "update tb_gr2_temp set StkID='$StkID' WHERE tb_gr2_temp.GRID = $GRID;";
           $query = Yii::$app->db->createCommand($sql)->query(); 
        }
        if(!empty($_GET['GRDate'])){
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_GET['GRDate']);
            $sql = "update tb_gr2_temp set GRDate='$GRDate' WHERE tb_gr2_temp.GRID = $GRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive " cellspacing="0" width="100%" id="detailgrdonatetpu">
    <thead class="bordered-success">
        <tr>
            <th style="text-align: center">ลำดับ</th>
            <th style="text-align: center">รหัสสินค้า</th>
            <th style="text-align: center">ชื่อสินค้า</th>
            <th style="text-align: center">รหัสยาการค้า</th>
         <th style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = \app\modules\Inventory\models\VwItemList::find()->where(['ItemCatID' => 1])->all();
        $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['TMTID_TPU'] . '</td>';
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
        $GRID = $_GET['GRID'];
        if(!empty($_GET['StkID'])){
           $StkID = $_GET['StkID'];
           $sql = "update tb_gr2_temp set StkID='$StkID' WHERE tb_gr2_temp.GRID = $GRID;";
           $query = Yii::$app->db->createCommand($sql)->query(); 
        }
        if(!empty($_GET['GRDate'])){
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_GET['GRDate']);
            $sql = "update tb_gr2_temp set GRDate='$GRDate' WHERE tb_gr2_temp.GRID = $GRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive" cellspacing="0" width="100%" id="detailgrdonatend">
    <thead class="bordered-success">
        <tr>
            <th width="5%" style="text-align: center">ลำดับ</th>
            <th style="text-align: center">รหัสสินค้า</th>
            <th width="" style="text-align: center">ชื่อสินค้า</th>
            <th width="" style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';    

       $data = \app\modules\Inventory\models\VwItemList::find()->where(['ItemCatID' => '2'])->all();
       $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            //$htl .= '<td style="text-align: center">' . $result['ItemNDMedSupply'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemName'] . '</td>';
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
    public function actionAddNewItemdetail($ItemID, $GRID, $ItemType, $GRNum) {
        $check = \app\modules\Inventory\models\VwGr2Detail::findOne(['ItemID' => $ItemID, 'GRID' => $GRID]);
        if ($check != null) {
            return 'false';
        }
        if ($ItemType == 'TPU') {
            return $this->redirect(['formlotnumber',
                'ItemID'=>$ItemID,
                'GRID'=>$GRID,
                'GRNum'=>$GRNum,
                
            ]);
        } elseif ($ItemType == 'ND') {
            return $this->redirect(['formlotnumber', 
                'ItemID'=>$ItemID,
                'GRID'=>$GRID,
                'GRNum'=>$GRNum,
            ]);
        }
    }
    public function actionFormlotnumber($ItemID, $GRID, $GRNum){
        $searchModel = new \app\modules\Inventory\models\TbItemlotnum2TempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ItemID,$GRID);
        $dataProvider->pagination->pageSize = 5;
        $modelGR = new \app\modules\Inventory\models\VwGr2Detail();
        $modelLN = new \app\modules\Inventory\models\TbGritemdetail2Temp();
        $balance = new \app\modules\Inventory\models\VwGr2LotAssignedBalance();
        $detail = new \app\modules\Inventory\models\VwGr2LotAssignedDetail();
        $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
        $checkpack = \app\models\TbItempack::findAll(['ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                    $GRItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $GRItemPackSKUQty = '';
                }
         if ($modelGR->load(Yii::$app->request->post())) {
            $sql = "
                 DELETE FROM tb_gritemdetail2_temp WHERE tb_gritemdetail2_temp.GRID=$GRID AND tb_gritemdetail2_temp.ItemID=$ItemID;
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.GRID=$GRID AND tb_itemlotnum2_temp.ItemID=$ItemID;
               ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwItemList']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2Detail']['GRItemPackID']]);
            if ($findpackid != NULL) {
               
            }else{
                $findpackid['ItemPackID']='0';
            }
            $GRID = $_POST['GRID'];
            $GRNum = $_POST['GRNum'];
            $ItemID = $_POST['VwItemList']['ItemID'];
            $ItemName = $_POST['VwItemList']['ItemName'];
            $GRPackQty = str_replace(',', '', $_POST['VwGr2Detail']['GRPackQty']);
            $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRPackUnitCost']);
            $GRItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = str_replace(',', '', $_POST['VwGr2Detail']['GRItemQty']);
            $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRItemUnitCost']);
            $GRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $data = Yii::$app->db->createCommand('CALL cmd_gr2_itemsave_receive(:GRID,:GRNum,:ItemID,:ItemName,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRCreatedBy);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRNum', $GRNum)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $GRItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRCreatedBy', $GRCreatedBy)
                    ->execute();
             $max = \app\modules\Inventory\models\TbGritemdetail2Temp::find()
                ->select('max(ids_gr)')
                ->scalar();
            return $max;
        } elseif ($modelLN->load(Yii::$app->request->post())) {
                $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemIDlot'], 'ItemPackUnit' => $_POST['TbGritemdetail2Temp']['GRItemPackID']]);
                $ItemInternalLotNum = $_POST['Internal'];
                $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemExternalLotNum'];
                $ItemID = $_POST['ItemIDlot'];
                $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwGr2LotAssignedDetail']['ItemExpDate']);
                $GRPackQty = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRPackQty']);
                $GRPackUnitCost = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRPackUnitCost']);
                $GRItemPackID = $findpackid['ItemPackID'];
                $GRItemUnitCost = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRItemUnitCost']);
                $GRItemQty = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRItemQty']);
                $userid = Yii::$app->user->identity->profile->user_id;
                $ids_gr = $_POST['ids_grlot'];
                $GRNum = $_POST['GRNum_lot'];
                Yii::$app->db->createCommand('CALL cmd_gr2_lotnumber_itemsave(:ItemInternalLotNum,:ItemExternalLotNum,:ItemID,:ItemExpDate,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:userid,:ids_gr,:GRNum);')
                        ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                        ->bindParam(':ItemExternalLotNum', $ItemExternalLotNum)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemExpDate', $ItemExpDate)
                        ->bindParam(':GRPackQty', $GRPackQty)
                        ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                        ->bindParam(':GRItemPackID', $GRItemPackID)
                        ->bindParam(':GRItemQty', $GRItemQty)
                        ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                        ->bindParam(':userid', $userid)
                        ->bindParam(':ids_gr', $ids_gr)
                        ->bindParam(':GRNum', $GRNum)
                        ->execute();
                return 'success';
        }else{
            return $this->render('_form_lotnumber', [
            'modelGR' => $modelGR,
            'modelLN'=>$modelLN,
            'balance'=>$balance,
            'detail'=>$detail,
            'dataProvider'=>$dataProvider,
            'Item' => $Item,
            'pack' => $pack,
            'GRPackQty' => '0.00',
            'GRPackUnitCost' => '0.00',
            'GRItemQty' => '0.00',
            'GRItemUnitCost' => '0.00',
            'PackUnit' => '',
            'GRItemPackSKUQty' => '0.00',
            'GRExtenedCost'=> '0.00',
            'DispUnit' => $Item['DispUnit'],
            'ItemDetail' => $Item['ItemName'],
            'GRID'=>$GRID,
            'GRNum'=>$GRNum,
            'packid'=>'',   
            ]); 
        }
        
    }
    function actionGetBalance() {
        $balance = \app\modules\Inventory\models\VwGr2LotAssignedBalance::findOne(['ids_gr' => $_POST['id']]);
        $arr = array(
            'LNAssignedQty' => $balance['LNAssignedQty'],
            'LNAssignedLeftQty' => $balance['LNAssignedLeftQty'],
            'GRUnit' => $balance['GRUnit'],
            'LNItemPackID' => $balance['LNItemPackID'],
        );
        return json_encode($arr);
    }
    public function actionDeletelot() {
        $id = $_POST['id'];
        $sql = "
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ItemInternalLotNum=$id;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }
    public function actionSaveLotNumber() {
        $ids_gr = $_POST['ids_gr'];
        $sql = "
                UPDATE tb_itemlotnum2_temp
                SET
                    LNItemStatusID='2'
                WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
                 ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }
    public function actionEdititemLotassign() {
        $find = \app\modules\Inventory\models\VwGr2LotAssignedDetail::findOne(['ItemInternalLotNum' => $_POST['id']]);
//        $savedata = \app\modules\Purchasing\models\TbItemlotnum2Temp::findOne($_POST['id']);
//        $sql = "
//                UPDATE tb_itemlotnum2_temp
//
//		SET	tb_itemlotnum2_temp.LNItemStatusID = 1
//
//                WHERE tb_itemlotnum2_temp.ids_gr = $savedata->ids_gr;
//                 ";
//        $query = Yii::$app->db->createCommand($sql)->execute();
//
//        $savedata->LNItemStatusID = '3';
//        $savedata->save();
        $arr = array(
            'ItemInternalLotNum' => $find['ItemInternalLotNum'],
            'ItemExternalLotNum' => $find['ItemExternalLotNum'],
            'ItemExpDate' => Yii::$app->componentdate->convertMysqlToThaiDate2($find['ItemExpDate']),
            'LNPackQty' => number_format($find['LNPackQty'], 2),
            'LNPackUnitCost' => number_format($find['LNPackUnitCost'], 2),
            'LNItemPackID' => $find['LNItemPackID'],
            'LNItemQty' => number_format($find['LNItemQty'], 2),
            'LNItemUnitCost' => number_format($find['LNItemUnitCost'], 2),
            'DispUnit' => $find['DispUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'ItemPackUnit' => $find['ItemPackUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'ids_gr' => $find['ids_gr'],
            'ItemID'=>    $find['ItemID'],
        );
        return json_encode($arr);
    }
    
    public function actionEditDetail() {
        $ids_gr = $_POST['id'];
        $modelEdit = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        // $sql = "
        //          DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
        //          ";
        // $query = Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect(['formlotnumberedit',
                'ids_gr'=>$ids_gr,
                'GRID' =>$modelEdit['GRID'],
                'GRNum' =>$modelEdit['GRNum'],
                'ItemID' => $modelEdit['ItemID'],
            ]);
    }
    public function actionFormlotnumberedit($ItemID, $GRID, $GRNum, $ids_gr){
        $searchModel = new \app\modules\Inventory\models\TbItemlotnum2TempSearch();
        $dataProvider = $searchModel->SearchEditdetail(Yii::$app->request->queryParams,$ids_gr);
        $dataProvider->pagination->pageSize = 5;
        $modelGR = new \app\modules\Inventory\models\VwGr2Detail();
        $modelLN = new \app\modules\Inventory\models\TbGritemdetail2Temp();
        $balance = new \app\modules\Inventory\models\VwGr2LotAssignedBalance();
        $detail = new \app\modules\Inventory\models\VwGr2LotAssignedDetail();
        $modeledit = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
        $checkpack = \app\models\TbItempack::findAll(['ItemID' => $ItemID]);
                if ($checkpack != null) {
                    foreach ($checkpack as $data) {
                        $pack[] = $data['ItemPackUnit'];
                    }
                   $GRItemPackSKUQty = '';
                } else {
                    $pack = '';
                    $GRItemPackSKUQty = '';
                }
        $checkpackgr = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['GRItemPackID']]);
                if ($checkpackgr != null) {
                    $packid = $checkpackgr['ItemPackUnit'];
                    $GRItemSKUQty = $checkpackgr['ItemPackSKUQty'];
                } else {
                    $packid='';
                    $GRItemSKUQty = '0.00';
                }        
         if ($modelGR->load(Yii::$app->request->post())) {
            $sql = "
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
                 ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwItemList']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2Detail']['GRItemPackID']]);
            $ids_gr = $ids_gr;
            $GRID = $_POST['GRID'];
            $GRNum = $_POST['GRNum'];
            $ItemID = $_POST['VwItemList']['ItemID'];
            $ItemName = $_POST['VwItemList']['ItemName'];
            $GRPackQty = str_replace(',', '', $_POST['VwGr2Detail']['GRPackQty']);
            $GRPackUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRPackUnitCost']);
            $GRItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = str_replace(',', '', $_POST['VwGr2Detail']['GRItemQty']);
            $GRItemUnitCost = str_replace(',', '', $_POST['VwGr2Detail']['GRItemUnitCost']);
            $GRCreatedBy = Yii::$app->user->identity->profile->user_id;
            $data = Yii::$app->db->createCommand('CALL cmd_gr2_itemsave_update(:ids_gr,:GRID,:GRNum,:ItemID,:ItemName,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRCreatedBy);')
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRNum', $GRNum)
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemName', $ItemName)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $GRItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRCreatedBy', $GRCreatedBy)
                    ->execute();
            return $ids_gr;
        } elseif ($modelLN->load(Yii::$app->request->post())) {
                $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemIDlot'], 'ItemPackUnit' => $_POST['TbGritemdetail2Temp']['GRItemPackID']]);
                $ItemInternalLotNum = $_POST['Internal'];
                $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemExternalLotNum'];
                $ItemID = $_POST['ItemIDlot'];
                $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwGr2LotAssignedDetail']['ItemExpDate']);
                $GRPackQty = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRPackQty']);
                $GRPackUnitCost = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRPackUnitCost']);
                $GRItemPackID = $findpackid['ItemPackID'];
                $GRItemUnitCost = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRItemUnitCost']);
                $GRItemQty = str_replace(',', '', $_POST['TbGritemdetail2Temp']['GRItemQty']);
                $userid = Yii::$app->user->identity->profile->user_id;
                $ids_gr = $_POST['ids_grlot'];
                $GRNum = $_POST['GRNum_lot'];
                Yii::$app->db->createCommand('CALL cmd_gr2_lotnumber_itemsave(:ItemInternalLotNum,:ItemExternalLotNum,:ItemID,:ItemExpDate,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:userid,:ids_gr,:GRNum);')
                        ->bindParam(':ItemInternalLotNum', $ItemInternalLotNum)
                        ->bindParam(':ItemExternalLotNum', $ItemExternalLotNum)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemExpDate', $ItemExpDate)
                        ->bindParam(':GRPackQty', $GRPackQty)
                        ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                        ->bindParam(':GRItemPackID', $GRItemPackID)
                        ->bindParam(':GRItemQty', $GRItemQty)
                        ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                        ->bindParam(':userid', $userid)
                        ->bindParam(':ids_gr', $ids_gr)
                        ->bindParam(':GRNum', $GRNum)
                        ->execute();
                return 'success';
        }else{
            $itemqty = $modeledit['GRItemQty'];
            $itemunitcost = $modeledit['GRItemUnitCost'];
            $sum = $itemqty*$itemunitcost;
            return $this->render('_form_lotnumber', [
            'modelGR' => $modelGR,
            'modelLN'=>$modelLN,
            'balance'=>$balance,
            'detail'=>$detail,
            'dataProvider'=>$dataProvider,
            'Item' => $Item,
            'pack' => $pack,
            'GRPackQty' => $modeledit['GRPackQty'],
            'GRPackUnitCost' => $modeledit['GRPackUnitCost'],
            'GRItemQty' => $modeledit['GRItemQty'],
            'GRItemUnitCost' => $modeledit['GRItemUnitCost'],
            'PackUnit' => '',
            'GRItemPackSKUQty' => $GRItemSKUQty,
            'GRExtenedCost'=> $sum,
            'DispUnit' => $Item['DispUnit'],
            'ItemDetail' => $Item['ItemName'],
            'GRID'=>$GRID,
            'GRNum'=>$GRNum,
            'packid'=>$packid,
            ]); 
        }
        
    }
    

    public function actionGetQty() {
        $qty = \app\modules\Inventory\models\VwItempack::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
            'PackNote' => $qty['PackNote'],
        );
        return json_encode($arr);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->GRID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionClearGrtemp() {
        $GRID= $_POST['id'];
        Yii::$app->db->createCommand('CALL cmd_gr2_clear(:x);')
                ->bindParam(':x', $GRID)
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
        return $this->redirect('index');
    }
    public function actionClear() {
        $ids_gr = $_POST['ids_gr'];
        $sql = "
                UPDATE tb_gritemdetail2_temp
                SET
                GRPackQty='',
                GRPackUnitCost='',
                GRItemPackID='',
                GRItemQty='',
                GRItemUnitCost=''
                where  tb_gritemdetail2_temp.ids_gr = $ids_gr;
                ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }
    public function actionReceiveToStock() {
        $GRID= $_POST['id'];
        $StkID = $_POST['StkID'];
        $userid = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_vcheck_GRandLN (:GRID,@Ans);SELECT @Ans;')
                ->bindParam(':GRID', $GRID)
                ->execute();
        $valueOut = Yii::$app->db->createCommand("select @Ans as result;")->queryScalar();
        if($valueOut =='GO'){
            Yii::$app->logger->savelog('ตั้งต้นสินค้าคงคลัง',$GRID,'GR');
            Yii::$app->db->createCommand('CALL cmd_gr2_stkinitial(:x,:StkID,:userid);')
                    ->bindParam(':x', $GRID)
                     ->bindParam(':StkID', $StkID)
                    ->bindParam(':userid', $userid)
                    ->execute();
            Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'duration' => 5000,
                'icon' => 'fa fa-check-square-o',
                'title' => Yii::t('app', \yii\helpers\Html::encode('ตั้งต้นสินค้าคงคลัง')),
                'message' => Yii::t('app', \yii\helpers\Html::encode('รับสินค้าเข้าคลังเรียบร้อยแล้ว!')),
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
            return $this->redirect('index');
        }else{
            echo 'false'; 
        }
    }
    /**
     * Displays a single TbGr2Temp model.
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
     * Creates a new TbGr2Temp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    /**
     * Updates an existing TbGr2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {	
    	Yii::$app->logger->savelog('ลบบันทึกตั้งต้นสินค้าคงคลัง',$id,'GR');
        //$this->findModel($id)->delete();
        $sql = "DELETE FROM tb_gr2_temp WHERE GRID = $id;
                DELETE FROM tb_gritemdetail2_temp WHERE GRID = $id;
                DELETE FROM tb_itemlotnum2_temp WHERE GRID = $id;";
        $query = Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect(['index']);
    }
    public function actionDeleteDetail()
    {
        $ids_gr = $_POST['id'];
        $sql = "DELETE FROM tb_gritemdetail2_temp WHERE ids_gr = $ids_gr;
               DELETE FROM tb_itemlotnum2_temp WHERE ids_gr = $ids_gr;";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }
    /**
     * Deletes an existing TbGr2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /**
     * Finds the TbGr2Temp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbGr2Temp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TbGr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
