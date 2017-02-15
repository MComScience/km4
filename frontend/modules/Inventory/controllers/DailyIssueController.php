<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TbSt2Temp;
use app\modules\Inventory\models\TbStitemdetail2Temp;
use app\modules\Inventory\models\TbStitemdetail2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DailyIssueController implements the CRUD actions for TbSt2Temp model.
 */
class DailyIssueController extends Controller
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
                    'title' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบจ่ายสินค้ารายวัน')),
                    'message' => Yii::t('app', \yii\helpers\Html::encode('ยกเลิกใบจ่ายสินค้ารายวัน'.$findSTNum['STID'].' เรียบร้อยแล้ว')),
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
            return '99';
        }else{
            return false;
        }
        
    }
    public function DeleteTemp(){
        $user_id = Yii::$app->user->identity->profile->user_id;
        $query_temp = TbSt2Temp::find()->select('STID')->where('STCreateDate <= (DATE_SUB(curdate(), INTERVAL 1 DAY))')->andWhere('STNum is null')->asArray()->all();
        if(!empty($query_temp)){
          foreach ($query_temp as $key_temp) {
          TbSt2Temp::deleteAll('STID = :STID', [':STID' => $key_temp['STID']]);
          TbStitemdetail2Temp::deleteAll('STID = :STID', [':STID' => $key_temp['STID']]);
          }
        }
        $findSTID = TbSt2Temp::find()->select('STID')->where(['STNum' => NULL])->asArray()->all();
        foreach ($findSTID as $data) {
          TbSt2Temp::deleteAll('STID = :STID AND STCreateBy = :STCreateBy', [':STID' => $data['STID'],':STCreateBy'=>$user_id]);
          TbStitemdetail2Temp::deleteAll('STID = :STID AND STCreatedBy = :STCreatedBy', [':STID' => $data['STID'],':STCreatedBy'=>$user_id]);
        }
    }
    public function actionIndex()
    {
        $_SESSION['ss_sectionid'] = Yii::$app->user->identity->profile->User_sectionid;
        $this->DeleteTemp();
        $searchModel = new \app\modules\Inventory\models\VwStListDraftSearch();
        $dataProvider = $searchModel->DailySearch(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionHistoryDaily()
    {
        $_SESSION['ss_sectionid'] = Yii::$app->user->identity->profile->User_sectionid;
        $searchModel = new \app\modules\Inventory\models\TbSt2Search();
        $dataProvider = $searchModel->SearchHistoryDaily(Yii::$app->request->queryParams);
        return $this->render('history-daily', [
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
    public function actionCreateDaily() {
        $userid = Yii::$app->user->identity->profile->user_id;
        $this->CheckAuto();
        // $max = \app\modules\Inventory\models\TbSt2::find()
        //         ->select('max(STID)')
        //         ->scalar();
        // $maxTemp = TbSt2Temp::find()
        //         ->select('max(STID)')
        //         ->scalar();
        // if($max == NULL || $max == ''){
        //     $max = $maxTemp + 1;
        // }else{
        //     if ($max > $maxTemp) {
        //     $max = $max + 1;
        //     } elseif ($max < $maxTemp) {
        //         $max = $maxTemp + 1;
        //     }
        // }
        Yii::$app->db->createCommand('CALL cmd_st2_create_header_dailyissue(:userid);')
                ->bindParam(':userid', $userid)
                ->execute();
        $maxTemp = \app\modules\Inventory\models\TbSt2Temp::find()
                 ->select('max(STID)')
                 ->scalar();
        return $this->redirect(['create','STID' => $maxTemp, 'view' => '']);
    }
    public function actionCreate($STID,$view)
    {   
        $model = new \app\modules\Inventory\models\VwSt2Header();
        $modelST = $this->findModel($STID);
        $searchModel = new \app\modules\Inventory\models\TbStitemdetail2TempSearch();
        $dataProvider = $searchModel->SearchType1(Yii::$app->request->queryParams, $STID);
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
            $STStatus = $_POST['TbSt2Temp']['STStatus'];
            $STNote = $_POST['TbSt2Temp']['STNote'];
            Yii::$app->logger->savelog("บันทึกจ่ายสินค้ารายวัน",$STID,'ST');
            $data = Yii::$app->db->createCommand('CALL cmd_st2_savedraft(:STID,:STDate,:SRNum,:STCreateBy,:STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
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
        $model = new \app\modules\Inventory\models\VwSt2Header();
        $modelST = \app\modules\Inventory\models\TbSt2::findOne(['STID'=>$STID]);
        $searchModel = new \app\modules\Inventory\models\TbStitemdetail2Search();
        $dataProvider = $searchModel->SearchHistoryClaim(Yii::$app->request->queryParams, $STID);
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
            $STStatus = $_POST['TbSt2Temp']['STStatus'];
            $STNote = $_POST['TbSt2Temp']['STNote'];
            $data = Yii::$app->db->createCommand('CALL cmd_st2_savedraft(:STID,:STDate,:SRNum,:STCreateBy,:STCreateDate,:STIssue_StkID,:STRecieve_StkID,:STStatus,:STNote);')
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
                                    <th width="100%" style="text-align: center">ชื่อผู้จำหน่าย</th>
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
    public function CmdItemStkBalance($StkID,$Type){
        $sql = "SELECT
         `tb_stk_card_byItemID`.`ids` AS `ids`,
         `tb_stk_card_byItemID`.`StkTransID` AS `StkTransID`,
         `tb_stk_card_byItemID`.`StkTransDateTime` AS `StkTransDateTime`,
         `tb_stk_card_byItemID`.`StkID` AS `StkID`,
         `tb_stk`.`StkName` AS `StkName`,
         `tb_stk_card_byItemID`.`ItemID` AS `ItemID`,
         `vw_item_list`.`ItemCatID` AS `ItemCatID`,
         `vw_item_list`.`ItemName` AS `ItemName`,
         `tb_stk_card_byItemID`.`ItemQtyBalance` AS `ItemQtyBalance`,
         `vw_item_list`.`DispUnit` AS `DispUnit`,
         sum(
          ifnull(
           `tb_stk_levelinfo`.`ItemReorderLevel`,
           0
          )
         ) AS `Reorderpoint`,
         sum(
          ifnull(
           `tb_stk_levelinfo`.`ItemTargetLevel`,
           0
          )
         ) AS `ItemTargetLevel`,
         ifnull(

          IF (
           (
            (
             `tb_stk_card_byItemID`.`ItemQtyBalance` - `tb_stk_levelinfo`.`ItemTargetLevel`
            ) > 0
           ),
           0,
           (
            `tb_stk_card_byItemID`.`ItemQtyBalance` - `tb_stk_levelinfo`.`ItemTargetLevel`
           )
          ),
          0
         ) AS `ItemROPDiff`,
         ifnull(

          IF (
           (
            (
             `tb_stk_card_byItemID`.`ItemQtyBalance` - `tb_stk_levelinfo`.`ItemTargetLevel`
            ) < 0
           ),
           '1',
           '0'
          ),
          0
         ) AS `ROPStatus`,
         `tb_stk`.`SectionID` AS `SectionID`
        FROM
         (
          (
           (
            `tb_stk_card_byItemID`
            JOIN `vw_item_list` ON (
             (
              `tb_stk_card_byItemID`.`ItemID` = `vw_item_list`.`ItemID`
             )
            )
           )
           JOIN `tb_stk` ON (
            (
             `tb_stk`.`StkID` = `tb_stk_card_byItemID`.`StkID`
            )
           )
          )
          LEFT JOIN `tb_stk_levelinfo` ON (
           (
            (
             `tb_stk_levelinfo`.`ItemID` = `tb_stk_card_byItemID`.`ItemID`
            )
            AND (
             `tb_stk_levelinfo`.`StkID` = `tb_stk_card_byItemID`.`StkID`
            )
           )
          )
         )
        WHERE
        tb_stk_card_byItemID.StkID = $StkID AND
        tb_stk_card_byItemID.ids IN ((
          SELECT
           max(
            `tb_stk_card_byItemID`.`ids`
           )
          FROM
           `tb_stk_card_byItemID`
          GROUP BY
           `tb_stk_card_byItemID`.`ItemID`,
           `tb_stk_card_byItemID`.`StkID`
         )) AND
        vw_item_list.ItemCatID = $Type AND
        tb_stk_card_byItemID.ItemQtyBalance > 0
        GROUP BY
         `tb_stk_card_byItemID`.`ids`,
         `tb_stk_card_byItemID`.`StkTransID`,
         `tb_stk_card_byItemID`.`StkTransDateTime`,
         `tb_stk_card_byItemID`.`StkID`,
         `tb_stk`.`StkName`,
         `tb_stk_card_byItemID`.`ItemID`,
         `vw_item_list`.`ItemCatID`,
         `vw_item_list`.`ItemName`,
         `tb_stk_card_byItemID`.`ItemQtyBalance`,
         `vw_item_list`.`DispUnit`
        ORDER BY
        ItemName ASC";
        $data = Yii::$app->db->createCommand ($sql)->QueryAll();
        return $data;
    }
    function actionGetdataTpu() {
    	$STID = $_GET['STID'];
        $StkID = $_GET['stk'];
        $sql = "update tb_st2_temp set STIssue_StkID = $StkID WHERE tb_st2_temp.STID = $STID;";
        $query = Yii::$app->db->createCommand($sql)->execute();
        $htl = '<table class="table table-bordered table-condensed flip-content dt-responsive " cellspacing="0" width="100%" id="detailgrdonatetpu">
    <thead class="bordered-success">
        <tr>
            <th style="text-align: center">ลำดับ</th>
            <th style="text-align: center">รหัสสินค้า</th>
            <th style="text-align: center">ชื่อสินค้า</th>
            <th style="text-align: center">คงเหลือ</th>
            <th style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
    
  ';
        $data = $this->CmdItemStkBalance($StkID,'1');
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
        $STID = $_GET['STID'];
    	$StkID = $_GET['stk'];
        $sql = "update tb_st2_temp set STIssue_StkID = $StkID WHERE tb_st2_temp.STID = $STID;";
        $query = Yii::$app->db->createCommand($sql)->execute();
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
        $data = $this->CmdItemStkBalance($StkID,'2');
        $no = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align: center">' . $no . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td style="text-align: center">' . $result['ItemQtyBalance'] . '</td>';
            $htl .='<td style="text-align: center"><button  class="btn btn-success btn-sm" type="buttons" onclick="AddNewItemdetailND(' . $result['ItemID'] . ');" >Select</button></td>';
            $htl .='</tr>';
            $no++;
        }
        $htl .='</tr></tbody>
                </table>.
            </div>
            ';
        return json_encode($htl);
    }
    public function actionCheckBarcode() {
        $request = Yii::$app->request;
        if ($request->isPost) {
           if(($model = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['STID'=>$request->post('STID'),'ItemID' =>$request->post('barcode')])) !== null){
               return true;
               //return $this->redirect(['check', 'id' => $model->cpoe_id]);
           } else {
               return false;
           }
        }
    }
    public function actionCheckLot() {
        $request = Yii::$app->request;
        if ($request->isPost) {
           if(($model = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['STID'=>$request->post('STID'),'ItemInternalLotNum' =>$request->post('barcode')])) !== null){
               
               return true;
               //return $this->redirect(['check', 'id' => $model->cpoe_id]);
           } else {
              //print_r('STID');
               return false;
           }
        }
    }
    public function actionAddNewItemdetailtpu($ItemID, $STID, $ItemType, $stkid, $STNum) {
        $modelstk = new \app\modules\Inventory\models\VwSt2Header();
        $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
        $check = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['STID'=>$STID,'ItemID' => $ItemID]);
        if ($check != null) {
            return 'false';
        }

        // checklotnumber
        $searchModel = new \app\modules\Inventory\models\VwSt2LotnumberAvalibleSearch();
        $dataProvider = $searchModel->SearchType1(Yii::$app->request->queryParams,$ItemID,$stkid);
        $countlot = $dataProvider->getTotalCount();
        $dataProvider->pagination->pageSize = $countlot;
        if ($countlot == '1') { //Lotnumber is = 1
          foreach ($dataProvider->getModels() as $SelectLot) {
            $Internal = $SelectLot['ItemInternalLotNum'];
          }
          if (Yii::$app->request->post()){
            if ($_POST['VwSt2DetailSub']['STPackUnit'] != NULL || $_POST['VwSt2DetailSub']['STPackUnit'] =='' ) {
                $find = \app\models\TbItempack::findOne([
                    'ItemID' => $_POST['VwSt2DetailGroup']['ItemID'],
                    'ItemPackUnit' => $_POST['VwSt2DetailSub']['STPackUnit']
                ]);
                $STItemPackID = $find['ItemPackID'];
            }else{
              $STItemPackID = '';
            } 
            $ids = '';
            $ids_sr = '';
            $STPackQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackQty']);
            $STPackUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackUnitCost']);
            $STItemQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemQty']);
            $STCreatedBy = Yii::$app->user->identity->profile->user_id; 
            $STItemUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemUnitCost']);
            Yii::$app->db->createCommand('CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,:STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr);')
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
                ->bindParam(':ids_sr', $ids_sr)
                ->execute();
              echo '1';
          }else{
            $modelstk = new \app\modules\Inventory\models\VwSt2Header();
            $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
            $modelST = new \app\modules\Inventory\models\VwSt2DetailSub();
            $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
            $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
            $cost = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['StkID'=>$stkid,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$Internal]);
            $checklot = $cost['ItemQty'];
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
                      'modeledit' => $modeledit,
                      'modelST' => $modelST,
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
            ]);
          }
        }else if($countlot > '1'){ //Lotnumber is > 1
          $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
          $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
            return $this->renderAjax('_form_detail', [
              'STID'=> $STID,
              'STNum' => $STNum,
              'modeledit' => $modeledit,
              'dataProvider'=>$dataProvider,
              'modelstk'=> $modelstk,
              'stkid'=>$StkName['StkName'],
              'Item' => $Item,
              'ItemDetail' => $Item['ItemName'],
          ]);
      }else{
        return false;
      }
    }
    public function actionSelectLotnumber($ItemID, $stkid, $Internal, $STID, $STNum) {
        if(empty($ItemID)){
          $findItemID = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['ItemInternalLotNum' => $Internal,'StkID' => $stkid]);
          if(empty($findItemID)) {
            return false;
          }else{
            $ItemID = $findItemID['ItemID'];
          }
        }
        
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
                $ids_sr = '';
                //$ItemID = $_POST['VwSt2DetailGroup']['ItemID'];
                //$ItemInternalLotNum ='';
                $STPackQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackQty']);
                $STPackUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackUnitCost']);
                $STItemQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemQty']);
                $STCreatedBy = Yii::$app->user->identity->profile->user_id; 
                $STItemUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemUnitCost']);
                Yii::$app->db->createCommand('CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,:STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr);')
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
                    ->bindParam(':ids_sr', $ids_sr)
                    ->execute();
                  echo "1";
        }else{
                $modelstk = new \app\modules\Inventory\models\VwSt2Header();
                $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
                $modelST = new \app\modules\Inventory\models\VwSt2DetailSub();
                $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
                $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $cost = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['StkID'=>$stkid,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$Internal]);
                $checklot = $cost['ItemQty'];
                // if($cost['ItemPackID'] == '' || $cost['ItemPackID'] == '0'){
                //     $checklot = $cost['ItemQty'];
                //     $checkpacklot = 'no';
                // }else{
                //     $checklot = $cost['ItemQty'];
                //     $checkpacklot = 'no';
                // }
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
                            'modeledit' => $modeledit,
                            'modelST' => $modelST,
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
        ]);
            
        }
    }
    public function actionEditLotnumber($ids, $stkid) {
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
                $ids_sr = '';
                $STNum = $edit['STNum'];
                $STID = $edit['STID'];
                $ItemID = $edit['ItemID'];
                $Internal = $edit['ItemInternalLotNum'];
                $STPackQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackQty']);
                $STPackUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STPackUnitCost']);
                $STItemQty = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemQty']);
                $STCreatedBy = Yii::$app->user->identity->profile->user_id; 
                $STItemUnitCost = str_replace(',', '', $_POST['VwSt2DetailSub']['STItemUnitCost']);
                Yii::$app->db->createCommand('CALL cmd_st2_item_save(:ids,:STNum,:STID,:ItemID,:ItemInternalLotNum,:STPackQty,:STPackUnitCost,:STItemPackID,:STItemQty,:STCreatedBy,:STItemUnitCost,:ids_sr);')
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
                    ->bindParam(':ids_sr', $ids_sr)
                    ->execute();
            echo '1';
        }else{  
                $ItemID =  $edit['ItemID'];
                $Internal = $edit['ItemInternalLotNum'];
                $modeledit = new \app\modules\Inventory\models\VwSt2DetailGroup();
                $modelST = new \app\modules\Inventory\models\VwSt2DetailSub();
                $modelstk = new \app\modules\Inventory\models\VwSt2Header();
                $StkName = \app\modules\Inventory\models\TbStk::findOne(['StkID'=>$stkid]);
                $Item = \app\modules\Inventory\models\VwItemList::findOne(['ItemID' => $ItemID]);
                $Ext = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids'=>$ids]);
                $findpack = \app\models\TbItempack::findOne(['ItemPackID'=> $edit['STItemPackID']]);
                $cost = \app\modules\Inventory\models\VwSt2LotnumberAvalible::findOne(['StkID'=>$stkid,'ItemID'=>$ItemID,'ItemInternalLotNum'=>$Internal]);
                $checklot = $cost['ItemQty'];
                // if($cost['ItemPackID'] == '' || $cost['ItemPackID'] == '0'){
                //     $checklot = $cost['ItemQty'];
                //     //$checkpacklot = 'no';
                // }else{
                //     $checklot = $cost['PackQTY'];
                //     //$checkpacklot = 'yes';
                // }
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
                            'modeledit' => $modeledit,
                            'modelST' => $modelST,
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
        ]);
            
        }
    }
    public function actionStockIssue(){
        $STID = $_POST['STID'];
        $statusID = 20;
        $userid = Yii::$app->user->identity->profile->user_id; 
        Yii::$app->logger->savelog("จ่ายสินค้ารายวัน",$STID,'ST');
        Yii::$app->db->createCommand('CALL cmd_st2_stk_issue(:x,:userid,:statusID);')
                ->bindParam(':x', $STID)
                ->bindParam(':userid', $userid)
                ->bindParam(':statusID', $statusID)
                ->execute();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'duration' => 12000,
            'icon' => 'fa fa-check-square-o',
            'title' => Yii::t('app', \yii\helpers\Html::encode('จ่ายสินค้ารายวัน')),
            'message' => Yii::t('app', \yii\helpers\Html::encode('ตัดยอดจากคลังเรียบร้อยแล้ว!')),
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
        return $this->redirect('index.php?r=Inventory/daily-issue/index');
    }
    public function actionDeleteDetail() {
        $key = $_POST['ids'];
        $sql = "DELETE FROM tb_stitemdetail2_temp WHERE ids = $key";
        $query = Yii::$app->db->createCommand($sql)->execute();
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
    public function actionViewDetail() {
        if (isset($_POST['expandRowKey'])) {
            //$model = \app\modules\Inventory\models\VwSt2DetailSub::findOne(['ids' => $_POST['expandRowKey']]);
            $ids = $_POST['expandRowKey'];
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
            $ids = $_POST['expandRowKey'];
            $findST = \app\modules\Inventory\models\TbStitemdetail2Temp::findOne(['ids'=>$ids]);
            if($findST != null){
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
        Yii::$app->logger->savelog("ลบบันทึกจ่ายสินค้ารายวัน",$STID,'ST');
        $sql = "DELETE FROM tb_st2_temp WHERE STID = $STID;
               DELETE FROM tb_stitemdetail2_temp WHERE STID = $STID;";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->redirect(['index']);
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
        if (($model = TbSt2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
