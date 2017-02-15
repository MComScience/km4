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
use yii\helpers\Json;

/**
 * GrPoController implements the CRUD actions for TbGr2Temp model.
 */
class GrPoController extends Controller
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
    public function actionViewDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $POID = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Inventory\models\VwPo2Detail2NewSearch();
            $dataProviderCat1 = $searchModel->search(Yii::$app->request->queryParams, $POID, $POItemType=1);
            $dataProviderCat2 = $searchModel->search(Yii::$app->request->queryParams, $POID, $POItemType=2);
            $dataProviderCat1->pagination->pageSize = false;
            $dataProviderCat2->pagination->pageSize = false;
            return $this->renderPartial('_expand_detail', ['dataProviderCat1' => $dataProviderCat1,'dataProviderCat2' => $dataProviderCat2]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionViewLotnumber() {
        if (isset($_POST['expandRowKey'])) {
            $ids_gr = $_POST['expandRowKey'];
            $searchModel = new \app\modules\Inventory\models\VwGr2LotAssignedDetail2Search();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $ids_gr);
            return $this->renderAjax('_expand_lotnumber', ['dataProvider' => $dataProvider]);
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
                $this->set_execution();
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
    public function actionIndex()
    {
       $this->DeleteTemp();
        $searchModel = new \app\modules\Inventory\models\VwPo2ListForGr2Search();
        $dataProvider = $searchModel->SearchIndexPO(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionGrTemp()
    {   
        $this->DeleteTemp();
        $searchModel = new \app\modules\Inventory\models\TbGr2TempSearch();
        $dataProvider = $searchModel->SearchPO(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('temp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHistory() {
        $searchModel = new \app\modules\Inventory\models\TbGr2Search();
        $dataProvider = $searchModel->SearchHistoryPO(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = FALSE;
        return $this->render('history', [
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
        }else{
            $NextEq = $MaxGRID_temp+1; 
            $setAuto_gr2temp ="ALTER TABLE tb_gr2_temp AUTO_INCREMENT = $NextEq;";
        }
        if(empty($MaxIdsGR_temp)&&empty($MaxIdsGR_Nottemp)){
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = 1;";
        }elseif ($MaxIdsGR_Nottemp>$MaxIdsGR_temp) {
                $NextIds = $MaxIdsGR_Nottemp+1;
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }elseif ($MaxIdsGR_Nottemp<$MaxIdsGR_temp){
                $NextIds = $MaxIdsGR_temp+1;
                $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = $NextIds;";
        }else{
            $NextEq_detail = $MaxIdsGR_temp+1;
            $setAuto_gritemdetail2temp ="ALTER TABLE tb_gritemdetail2_temp AUTO_INCREMENT = $NextEq_detail;";
        }
        Yii::$app->db->createCommand($setAuto_gr2temp)->query();
        Yii::$app->db->createCommand($setAuto_gritemdetail2temp)->query(); 
    }
    public function actionCreateGrtemp($POID) {
        $userid = Yii::$app->user->identity->profile->user_id;
        $findPo2 = \app\modules\Inventory\models\TbPo2::findOne(['POID'=>$POID]);
        $PONum = $findPo2['PONum'];
        $findGr2 = \app\modules\Inventory\models\TbGr2Temp::findOne(['PONum'=>$PONum]);
        if($findGr2!=null){
            return $this->redirect(['create-gr','GRID' => $findGr2['GRID']]);
            // return $findGr2['GRID'];
       }else{
            $this->CheckAuto();
            Yii::$app->db->createCommand('CALL cmd_gr2_create_header_detail(:x,:userid);')
                    ->bindParam(':x', $POID)
                    ->bindParam(':userid', $userid)
                    ->execute();
            $max = \app\modules\Inventory\models\TbGr2Temp::find()->max('GRID');
            $model = $this->findModel($max);
            return $this->redirect(['create','GRID' => $model->GRID,'POID'=>$POID]);
       }
    }
    public function actionEditCost(){
        if (Yii::$app->request->post('hasEditable')) {
             $key = Yii::$app->request->post('editableKey');
             $posted = current($_POST['TbGritemdetail2Temp']);
             if(isset($posted['GRItemUnitCost'])){
                 if(!empty($posted['GRItemUnitCost'])&&$posted['GRItemUnitCost']!=0){
                    $unitcost = $this->format_number($posted['GRItemUnitCost']);
                    $Qty = $_POST['VwGr2DetailNew']['GRQty'];
                    $sum = $unitcost*$Qty;
                    $checkpack_update = TbGritemdetail2Temp::findOne(['ids_gr'=>$key]);
                    if($checkpack_update['GRItemPackID']==null||$checkpack_update['GRItemPackID']==0){
                        $update_unitcost = "UPDATE tb_gritemdetail2_temp SET GRItemUnitCost=$unitcost,GRExtenedCost=$sum WHERE ids_gr = $key";
                        Yii::$app->db->createCommand($update_unitcost)->query();
                    }else{
                        $unit = $checkpack_update['GRItemQty'];
                        $cost_unit = $sum/$unit;
                        $update_packcost = "UPDATE tb_gritemdetail2_temp SET GRPackUnitCost=$unitcost,GRItemUnitCost=$cost_unit,GRExtenedCost=$sum WHERE ids_gr = $key";
                        Yii::$app->db->createCommand($update_packcost)->query();
                    }
                    return Json::encode(['output' => '', 'message' =>'']);
                 }else{
                    return Json::encode(['output' => false, 'message' =>'*กรุณากรอก! ราคาต่อหน่วย']);
                 }
             }
             if(isset($posted['GRExtenedCost'])){
                 if(!empty($posted['GRExtenedCost'])&&$posted['GRExtenedCost']!=0){
                    $extendcost = $this->format_number($posted['GRExtenedCost']);
                    $update_extendcost = "UPDATE tb_gritemdetail2_temp SET GRExtenedCost=$extendcost WHERE ids_gr = $key";
                    Yii::$app->db->createCommand($update_extendcost)->query();
                    return Json::encode(['output' => '', 'message' =>'']);
                 }else{
                    return Json::encode(['output' => false, 'message' =>'*กรุณากรอก! ราคารวม']);
                 }
             }   
             //else{
             //    return Json::encode(['output'=>false, 'message'=>'gg']);
             // }
        }
    }
    public function actionCreate($GRID,$POID)
    {   
        
        $model = new \app\modules\Inventory\models\VwGr2Header();
        $modelGR = $this->findModel($GRID);
        $modelST = \app\modules\Inventory\models\TbPo2::findOne(['POID'=>$POID]);
        $searchModel = new \app\modules\Inventory\models\TbGritemdetail2TempSearch();
        $dataProvider = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=1);
        $dataProviderCat2 = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=2);
        $dataProvider->pagination->pageSize = false;
        $dataProviderCat2->pagination->pageSize = false;
        if($modelGR['VenderID']== NULL ||$modelGR['VenderID']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelGR['VenderID']]);
             $vendername = $getname['VenderName'];
        }
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbGr2Temp']['GRDate']);
            $VenderInvoiceNum = $_POST['TbGr2Temp']['VenderInvoiceNum'];
            $StkID = $_POST['TbGr2Temp']['StkID'];
            Yii::$app->logger->savelog("บันทึกใบรับสินค้าจากการสั่งซื้อ",$GRID,'GR');
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft (:GRID,:GRDate,:VenderInvoiceNum,:StkID);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':VenderInvoiceNum', $VenderInvoiceNum)
                    ->bindParam(':StkID', $StkID)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];
        }else {
            return $this->render('create', [
                'POID'=>$POID,
                'modelST'=>$modelST,
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProviderCat2'=>$dataProviderCat2,
                'vendername'=>$vendername,
            ]);
        }
    }
    public function actionCreateGr($GRID)
    {   
        $model = new \app\modules\Inventory\models\VwGr2Header();
        $modelGR = $this->findModel($GRID);
        $findTbPo2 = \app\modules\Inventory\models\TbPo2::findOne(['PONum'=>$modelGR['PONum']]);
        $POID = $findTbPo2['POID'];
        $modelST = \app\modules\Inventory\models\TbPo2::findOne(['POID'=>$POID]);
        $searchModel = new \app\modules\Inventory\models\TbGritemdetail2TempSearch();
        $dataProvider = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=1);
        $dataProviderCat2 = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=2);
        $dataProvider->pagination->pageSize = false;
        $dataProviderCat2->pagination->pageSize = false;
        if($modelGR['VenderID']== NULL ||$modelGR['VenderID']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelGR['VenderID']]);
             $vendername = $getname['VenderName'];
        }
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbGr2Temp']['GRDate']);
            $VenderInvoiceNum = $_POST['TbGr2Temp']['VenderInvoiceNum'];
            $StkID = $_POST['TbGr2Temp']['StkID'];
            Yii::$app->logger->savelog("บันทึกใบรับสินค้าจากการสั่งซื้อ",$GRID,'GR');
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft (:GRID,:GRDate,:VenderInvoiceNum,:StkID);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':VenderInvoiceNum', $VenderInvoiceNum)
                    ->bindParam(':StkID', $StkID)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];
        }else {
            return $this->render('create', [
                'POID'=>$POID,
                'modelST'=>$modelST,
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProviderCat2'=>$dataProviderCat2,
                'vendername'=>$vendername,
            ]);
        }
    }
    public function actionCreateHistory($GRID)
    {   
        $model = new \app\modules\Inventory\models\VwGr2Header();
        $modelGR = \app\modules\Inventory\models\TbGr2::findOne(['GRID'=>$GRID]);
        $findTbPo2 = \app\modules\Inventory\models\TbPo2::findOne(['PONum'=>$modelGR['PONum']]);
        $POID = $findTbPo2['POID'];
        $modelST = \app\modules\Inventory\models\TbPo2::findOne(['POID'=>$POID]);
        $searchModel = new \app\modules\Inventory\models\TbGritemdetail2Search();
        $dataProvider = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=1);
        $dataProviderCat2 = $searchModel->search_detail_po(Yii::$app->request->queryParams, $GRID, $POItemType=2);
        $dataProvider->pagination->pageSize = false;
        $dataProviderCat2->pagination->pageSize = false;
        if($modelGR['VenderID']== NULL ||$modelGR['VenderID']==''){
            $vendername = '';
        }else {
            $getname = \app\modules\Inventory\models\VwVendorList::findOne(['VendorID'=>$modelGR['VenderID']]);
             $vendername = $getname['VenderName'];
        }
        if ($modelGR->load(Yii::$app->request->post())) {
            $GRID = $_POST['TbGr2Temp']['GRID'];
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['TbGr2Temp']['GRDate']);
            $VenderInvoiceNum = $_POST['TbGr2Temp']['VenderInvoiceNum'];
            $StkID = $_POST['TbGr2Temp']['StkID'];
            Yii::$app->db->createCommand('CALL cmd_gr2_savedraft (:GRID,:GRDate,:VenderInvoiceNum,:StkID);')
                    ->bindParam(':GRID', $GRID)
                    ->bindParam(':GRDate', $GRDate)
                    ->bindParam(':VenderInvoiceNum', $VenderInvoiceNum)
                    ->bindParam(':StkID', $StkID)
                    ->execute();
            $model = $this->findModel($_POST['TbGr2Temp']['GRID']);
            return $model['GRNum'];
        }else {
            return $this->render('create', [
                'POID'=>$POID,
                'modelST'=>$modelST,
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dataProviderCat2'=>$dataProviderCat2,
                'vendername'=>$vendername,
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
                </div>';
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
    public function actionSelectDetail() {
        $ids_gr = $_POST['id'];
        $POID = $_POST['POID'];
        $modelSelect = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        $GRID = $modelSelect['GRID'];
        if(!empty($_POST['GRDate'])){
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['GRDate']);
            $sql = "update tb_gr2_temp set GRDate='$GRDate' WHERE tb_gr2_temp.GRID = $GRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
        if(!empty($_POST['venderinvoicenum'])){
           $VenderInvoiceNum = $_POST['venderinvoicenum'];
           $sql = "update tb_gr2_temp set VenderInvoiceNum='$VenderInvoiceNum' WHERE tb_gr2_temp.GRID = $GRID;";
           $query = Yii::$app->db->createCommand($sql)->query(); 
        }
        if(!empty($_POST['StkID'])){
           $StkID = $_POST['StkID'];
           $sql = "update tb_gr2_temp set StkID='$StkID' WHERE tb_gr2_temp.GRID = $GRID;";
           $query = Yii::$app->db->createCommand($sql)->query(); 
        }
        $checkGRNum = $modelSelect['GRNum'];
        if ($checkGRNum == '' || $checkGRNum == NULL){
           $GRNum = '';
        }else{
           $GRNum = $modelSelect['GRNum']; 
        }
        return $this->redirect(['formlotnumberselect',
                'ids_gr'=>$ids_gr,
                'GRID' => $GRID,
                'GRNum' => $GRNum,
                'ItemID' => $modelSelect['ItemID'],
                'POID'=>$POID,
            ]);
    }
    public function actionFormlotnumberselect($ItemID, $GRID, $GRNum, $ids_gr,$POID){
        $searchModel = new \app\modules\Inventory\models\TbItemlotnum2TempSearch();
        $dataProvider = $searchModel->SearchEditdetail(Yii::$app->request->queryParams,$ids_gr);
        $dataProvider->pagination->pageSize = false;
        $modelGR = new \app\modules\Inventory\models\VwGr2Detail();
        $modelLN = new \app\modules\Inventory\models\TbGritemdetail2Temp();
        $balance = new \app\modules\Inventory\models\VwGr2LotAssignedBalance();
        $detail = new \app\modules\Inventory\models\VwGr2LotAssignedDetail();
        $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
        $modeledit = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        $modelST = \app\modules\Inventory\models\VwGr2DetailNew::findOne(['ids_gr'=>$ids_gr]);
        if ($modelST['GRReceivedQty'] == NULL || $modelST['GRReceivedQty'] == '0'){
            if($modelST['POItemPackID'] == NULL || $modelST['POItemPackID']=='0'){
                $packqtyz = '0';
            }else{
                $packqtyz = $modelST['POQty'];
            }
                $calGRReceivedQty = $modelST['GRReceivedQty'];
                $calPOQty = $modelST['POQty'];
                $GRLeftItemQty = $calPOQty-$calGRReceivedQty;
                
         }else{
            $calGRReceivedQty = $modelST['GRReceivedQty'];
            $calPOQty = $modelST['POQty'];
            $GRLeftItemQty = $calPOQty-$calGRReceivedQty;
            if($modelST['POItemPackID'] == NULL || $modelST['POItemPackID'] =='0'){
                $packqtyz = '0';
            }else{
                $packqtyz = $calPOQty-$calGRReceivedQty;
            }
        }
        $checkpackst = \app\models\TbItempack::findOne(['ItemPackID' => $modelST['POItemPackID']]);
                if ($checkpackst != null) {
                    $packst=$checkpackst['ItemPackUnit'];
                    $STItemSKUQty = $checkpackst['ItemPackSKUQty'];
                } else {
                    $packst='';
                    $STItemSKUQty = '0.00';
                }
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
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
                 ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwItemList']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2Detail']['GRItemPackID']]);
            $ids_gr = $_POST['idst'];
            $GRPackQty = $this->format_number( $_POST['VwGr2Detail']['GRPackQty']);
            $GRPackUnitCost = $this->format_number( $_POST['VwGr2Detail']['GRPackUnitCost']);
            $GRItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = $this->format_number($_POST['VwGr2Detail']['GRItemQty']);
            $GRItemUnitCost = $this->format_number($_POST['VwGr2Detail']['GRItemUnitCost']);
            $GRExtenedCost = $this->format_number($_POST['VwGr2Detail']['GRExtenedCost']);
            $GRLeftQty= $this->format_number( $_POST['has']);
            $data = Yii::$app->db->createCommand('CALL cmd_gr2_item_save(:ids_gr,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRLeftQty,:GRExtenedCost);')
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $GRItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRLeftQty', $GRLeftQty)
                    ->bindParam(':GRExtenedCost', $GRExtenedCost)
                    ->execute();
            return $ids_gr;
        } elseif ($modelLN->load(Yii::$app->request->post())) {
                $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemIDlot'], 'ItemPackUnit' => $_POST['TbGritemdetail2Temp']['GRItemPackID']]);
                $ItemInternalLotNum = $_POST['Internal'];
                $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemExternalLotNum'];
                $ItemID = $_POST['ItemIDlot'];
                $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwGr2LotAssignedDetail']['ItemExpDate']);
                $GRPackQty = $this->format_number( $_POST['TbGritemdetail2Temp']['GRPackQty']);
                $GRPackUnitCost = $this->format_number( $_POST['TbGritemdetail2Temp']['GRPackUnitCost']);
                $GRItemPackID = $findpackid['ItemPackID'];
                $GRItemUnitCost = $this->format_number( $_POST['TbGritemdetail2Temp']['GRItemUnitCost']);
                $GRItemQty = $this->format_number( $_POST['TbGritemdetail2Temp']['GRItemQty']);
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
            'modelST'=>$modelST,    
            'modelGR' => $modelGR,
            'modelLN'=>$modelLN,
            'balance'=>$balance,
            'detail'=>$detail,
            'dataProvider'=>$dataProvider,
            'Item' => $Item,
            'pack' => $pack,
            'GRPackQty' => $packqtyz,
            'GRPackUnitCost' => $modelST['POPackCostApprove'],
            'GRItemQty' => $GRLeftItemQty,
            'GRItemUnitCost' => $modelST['POApprovedUnitCost'],
            'GRLeftItemQty'=> $GRLeftItemQty,
            'PackUnit' => '',
            'GRItemPackSKUQty' => $STItemSKUQty,
            'GRExtenedCost'=> '0.0000',
            'DispUnit' => $Item['DispUnit'],
            'ItemDetail' => $Item['ItemName'],
            'GRID'=>$GRID,
            'GRNum'=>$GRNum,
            'idst'=>$ids_gr,
            'packst' => $packst,
            'packgr' => $packst,    
            'STPackQty'=>$modelST['POPackQtyApprove'],
            'STItemSKUQty'=>$STItemSKUQty,
            'STPackUnitCost'=>$modelST['POPackCostApprove'],
            'STItemQty'=>$modelST['POApprovedOrderQty'],
            'STItemPackID'=>$modelST['POItemPackID'],
            'STItemUnitCost'=>$modelST['POApprovedUnitCost'],
            'GRReceivedQty' => $modelST['GRReceivedQty'],
            'STUnit'=>'',
            'STExtenedCost'=>'0.0000',
            'POID' => $POID,
                
            ]); 
        }
        
    }
    public function actionEditDetail() {
        $ids_gr = $_POST['id'];
        $POID = $_POST['POID'];
        $modelSelect = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        $GRID = $modelSelect['GRID'];
        if(!empty($_POST['StkID'])){
            $StkID = $_POST['StkID'];
            $sql = "update tb_gr2_temp set StkID='$StkID' WHERE tb_gr2_temp.GRID = $GRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
        if(!empty($_POST['GRDate'])){
            $GRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['GRDate']);
            $sql = "update tb_gr2_temp set GRDate='$GRDate' WHERE tb_gr2_temp.GRID = $GRID;";
            $query = Yii::$app->db->createCommand($sql)->query();
        }
        if(!empty($_POST['venderinvoicenum'])){
           $VenderInvoiceNum = $_POST['venderinvoicenum'];
           $sql = "update tb_gr2_temp set VenderInvoiceNum='$VenderInvoiceNum' WHERE tb_gr2_temp.GRID = $GRID;";
           $query = Yii::$app->db->createCommand($sql)->query(); 
        }
        $checkGRNum = $modelSelect['GRNum'];
        if ($checkGRNum == '' || $checkGRNum == NULL){
           $GRNum = '';
        }else{
           $GRNum = $modelSelect['GRNum']; 
        }
        // $sql = "
        //          DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
        //          ";
        // $query = Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect(['formlotnumberedit',
                'ids_gr'=>$ids_gr,
                'GRID' =>$modelSelect['GRID'],
                'GRNum' => $GRNum,
                'ItemID' => $modelSelect['ItemID'],
                'POID'=>$POID,
            ]);
    }
    public function actionFormlotnumberedit($ItemID, $GRID, $GRNum, $ids_gr,$POID){
        $searchModel = new \app\modules\Inventory\models\TbItemlotnum2TempSearch();
        $dataProvider = $searchModel->SearchEditdetail(Yii::$app->request->queryParams,$ids_gr);
        $dataProvider->pagination->pageSize = false;
        $modelGR = new \app\modules\Inventory\models\VwGr2Detail();
        $modelLN = new \app\modules\Inventory\models\TbGritemdetail2Temp();
        $balance = new \app\modules\Inventory\models\VwGr2LotAssignedBalance();
        $detail = new \app\modules\Inventory\models\VwGr2LotAssignedDetail();
        $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
        $modeledit = \app\modules\Inventory\models\TbGritemdetail2Temp::findOne(['ids_gr'=>$ids_gr]);
        $modelST = \app\modules\Inventory\models\VwGr2DetailNew::findOne(['ids_gr'=>$ids_gr]);
//               if ($modeledit['GRItemPackID'] != null) {
//                    $GRLeftQty=$modeledit['GRLeftPackQty'];
//                } else {
//                    $GRLeftQty=$modeledit['GRLeftItemQty'];
//                }
        $checkpackst = \app\models\TbItempack::findOne(['ItemPackID' => $modelST['POItemPackID']]);
                if ($checkpackst != null) {
                    $packst=$checkpackst['ItemPackUnit'];
                    $STItemSKUQty = $checkpackst['ItemPackSKUQty'];
                } else {
                    $packst='';
                    $STItemSKUQty = '0.00';
                }
        $checkpackgr = \app\models\TbItempack::findOne(['ItemPackID' => $modeledit['GRItemPackID']]);
                if ($checkpackgr != null) {
                    $packgr = $checkpackgr['ItemPackUnit'];
                    $GRItemSKUQty = $checkpackgr['ItemPackSKUQty'];
                } else {
                    $packgr='';
                    $GRItemSKUQty = '0.00';
                }
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
                 DELETE FROM tb_itemlotnum2_temp WHERE tb_itemlotnum2_temp.ids_gr=$ids_gr;
                 ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['VwItemList']['ItemID'], 'ItemPackUnit' => $_POST['VwGr2Detail']['GRItemPackID']]);
            $ids_gr = $_POST['idst'];
            $GRPackQty = $this->format_number( $_POST['VwGr2Detail']['GRPackQty']);
            $GRPackUnitCost = $this->format_number( $_POST['VwGr2Detail']['GRPackUnitCost']);
            $GRItemPackID = $findpackid['ItemPackID'];
            $GRItemQty = $this->format_number( $_POST['VwGr2Detail']['GRItemQty']);
            $GRItemUnitCost = $this->format_number( $_POST['VwGr2Detail']['GRItemUnitCost']);
            $GRExtenedCost = $this->format_number($_POST['VwGr2Detail']['GRExtenedCost']);
            $GRLeftQty= $this->format_number( $_POST['has']);
            $data = Yii::$app->db->createCommand('CALL cmd_gr2_item_save(:ids_gr,:GRPackQty,:GRPackUnitCost,:GRItemPackID,:GRItemQty,:GRItemUnitCost,:GRLeftQty,:GRExtenedCost);')
                    ->bindParam(':ids_gr', $ids_gr)
                    ->bindParam(':GRPackQty', $GRPackQty)
                    ->bindParam(':GRPackUnitCost', $GRPackUnitCost)
                    ->bindParam(':GRItemPackID', $GRItemPackID)
                    ->bindParam(':GRItemQty', $GRItemQty)
                    ->bindParam(':GRItemUnitCost', $GRItemUnitCost)
                    ->bindParam(':GRLeftQty', $GRLeftQty)
                    ->bindParam(':GRExtenedCost', $GRExtenedCost)
                    ->execute();
            return $ids_gr;
        } elseif ($modelLN->load(Yii::$app->request->post())) {
                $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['ItemIDlot'], 'ItemPackUnit' => $_POST['TbGritemdetail2Temp']['GRItemPackID']]);
                $ItemInternalLotNum = $_POST['Internal'];
                $ItemExternalLotNum = $_POST['VwGr2LotAssignedDetail']['ItemExternalLotNum'];
                $ItemID = $_POST['ItemIDlot'];
                $ItemExpDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['VwGr2LotAssignedDetail']['ItemExpDate']);
                $GRPackQty = $this->format_number( $_POST['TbGritemdetail2Temp']['GRPackQty']);
                $GRPackUnitCost = $this->format_number( $_POST['TbGritemdetail2Temp']['GRPackUnitCost']);
                $GRItemPackID = $findpackid['ItemPackID'];
                $GRItemUnitCost = $this->format_number( $_POST['TbGritemdetail2Temp']['GRItemUnitCost']);
                $GRItemQty = $this->format_number( $_POST['TbGritemdetail2Temp']['GRItemQty']);
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
            'modelST'=>$modelST,    
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
            'GRLeftItemQty' => $modelST['POQty']-$modelST['GRReceivedQty'],
            'PackUnit' => '',
            'GRItemPackSKUQty' => $STItemSKUQty,
            'GRExtenedCost'=> '0.0000',
            'DispUnit' => $Item['DispUnit'],
            'ItemDetail' => $Item['ItemName'],
            'GRID'=>$GRID,
            'GRNum'=>$GRNum,
            'idst'=>$ids_gr,
            'packst' => $packst, 
            'packgr' => $packgr,
            'STPackQty'=>$modelST['POPackQtyApprove'],
            'STItemSKUQty'=>$STItemSKUQty,
            'STPackUnitCost'=>$modelST['POPackCostApprove'],
            'STItemQty'=>$modelST['POApprovedOrderQty'],
            'STItemPackID'=>$modelST['POItemPackID'],
            'STItemUnitCost'=>$modelST['POApprovedUnitCost'],
            'GRReceivedQty' => $modelST['GRReceivedQty'],
            'STUnit'=>'',
            'STExtenedCost'=>'0.0000',
            'POID' => $POID,
                
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
    public function actionClear() {
        $ids_gr = $_POST['ids_gr'];
        $sql = "UPDATE tb_gritemdetail2_temp
                SET
                GRPackQty='',
                GRItemPackID='',
                GRItemQty=''
                where  tb_gritemdetail2_temp.ids_gr = $ids_gr;";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }
    public function actionEdititemLotassign() {
        $find = \app\modules\Inventory\models\VwGr2LotAssignedDetail::findOne(['ItemInternalLotNum' => $_POST['id']]);
        $arr = array(
            'ItemInternalLotNum' => $find['ItemInternalLotNum'],
            'ItemExternalLotNum' => $find['ItemExternalLotNum'],
            'ItemExpDate' => Yii::$app->componentdate->convertMysqlToThaiDate2($find['ItemExpDate']),
            'LNPackQty' => number_format($find['LNPackQty'], 2),
            'LNPackUnitCost' => number_format($find['LNPackUnitCost'], 4),
            'LNItemPackID' => $find['LNItemPackID'],
            'LNItemQty' => number_format($find['LNItemQty'], 2),
            'LNItemUnitCost' => number_format($find['LNItemUnitCost'], 4),
            'DispUnit' => $find['DispUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'ItemPackUnit' => $find['ItemPackUnit'],
            'ItemPackSKUQty' => number_format($find['ItemPackSKUQty'], 2),
            'ids_gr' => $find['ids_gr'],
            'ItemID'=>    $find['ItemID'],
        );
        return json_encode($arr);
    }
    /**
     * Updates an existing TbGr2Temp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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
    public function actionReceiveToStock() {
        $this->set_execution();
        $GRID= $_POST['id'];
        $modelGR = $this->findModel($GRID);
        $userid = Yii::$app->user->identity->profile->user_id;
        $StkID = $_POST['StkID'];
        Yii::$app->db->createCommand('CALL cmd_vcheck_GRandLN (:GRID,@Ans);SELECT @Ans;')
                ->bindParam(':GRID', $GRID)
                ->execute();
        $valueOut = Yii::$app->db->createCommand("select @Ans as result;")->queryScalar();
        if($valueOut =='GO'){
        Yii::$app->logger->savelog("รับสินค้าจากการสั่งซื้อ",$GRID,'GR');
        Yii::$app->db->createCommand('CALL cmd_gr2_send_to_stk(:x,:userid,:StkID);')
                ->bindParam(':x', $GRID)
                ->bindParam(':userid', $userid)
                ->bindParam(':StkID', $StkID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
                    'type' => 'success',
                    'duration' => 5000,
                    'icon' => 'fa fa-check-square-o',
                    'title' => Yii::t('app', \yii\helpers\Html::encode('บันทึกรับสินค้า')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('รับสินค้าหมายเลข '.$modelGR['GRNum'].' เข้าคลังเรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
        ]);        
        // Yii::$app->getSession()->setFlash('alert1', [
        //     'type' => 'success',
        //     'title' => 'Success!',
        //     'message' => 'รับสินค้าเข้าคลังเรียบร้อยแล้ว'.$modelGR['GRNum'],
        // ]);
        return $this->redirect('index');
        }else{
             echo "false";
        }
    }

    /**
     * Deletes an existing TbGr2Temp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteGr($id)
    {
        Yii::$app->logger->savelog("ลบบันทึกใบรับสินค้าจากการสั่งซื้อ",$id,'GR');
        $sql = "DELETE FROM tb_gr2_temp WHERE GRID = $id;
                DELETE FROM tb_gritemdetail2_temp WHERE GRID = $id;
                DELETE FROM tb_itemlotnum2_temp WHERE GRID=$id;";    
        $query = Yii::$app->db->createCommand($sql)->execute();
        return $this->redirect(['index']);
    }
    private function set_execution(){
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        ini_set('memory_limit', '256M');
    }
    private function format_number($val){
        $format_number = str_replace(',', '',$val);
        return $format_number;
    }
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
