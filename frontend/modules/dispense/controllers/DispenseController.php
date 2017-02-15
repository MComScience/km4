<?php

namespace app\modules\dispense\controllers;
use Yii;
use app\modules\dispense\models\VwCpoeRxHeaderSearch;
use app\modules\dispense\models\VwCpoeRxHeader;
use app\modules\dispense\models\Vwptar;
use app\modules\dispense\models\Vwcpoerxdetail;
use app\modules\dispense\models\VwcpoerxdetailSearch;
use app\modules\dispense\models\Vwinvdetail;
use yii\helpers\Html; 
use yii\helpers\Json;
use \yii\web\Response;
use app\modules\dispense\models\vwcpoerxdetail2Search;

class DispenseController extends \yii\web\Controller
{
	public function actionListWaitDispense()
	{
		$searchModel = new VwCpoeRxHeaderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('list-wait-dispense', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,

			]);
	}
    function actionListWaitPharmacy(){
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list-wait-pharmacy', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            ]);
    }

function actionCheckBarcode(){
   $cpoe_num = Yii::$app->request->post('cpoe_num');
   $modelheader = VwCpoeRxHeader::find()->select('cpoe_num,cpoe_id')->where(['cpoe_num'=>$cpoe_num])->one();
   if($modelheader != null){
         return $modelheader->cpoe_id;
   }else{
         return 'false';
   }
}
    function actionListCheckDrug(){
       $searchModel = new VwCpoeRxHeaderSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('list-check-drug', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,

        ]);
   }
   public function actionCheckDrug($id){
       $modelheader = VwCpoeRxHeader::findOne(['cpoe_id'=>$id]);
       $ptar = Vwptar::find()->where(['pt_visit_number' => $modelheader->pt_vn_number])->all();
       $searchModel = new vwcpoerxdetail2Search();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);     
       return $this->render('form_detail_cpoe',
           [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'modelheader'=>$modelheader
           ,'ptar'=>$ptar,
           'type'=>'3'
           ]);
   }
   public function actionIssue($id){
      $modelheader = VwCpoeRxHeader::findOne(['cpoe_id'=>$id]);
      $ptar = Vwptar::find()->where(['pt_visit_number' => $modelheader->pt_vn_number])->all();
      $searchModel = new Vwcpoerxdetail2Search();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);     
      return $this->render('form_detail_cpoe',
       [
       'searchModel' => $searchModel,
       'dataProvider' => $dataProvider,
       'modelheader'=>$modelheader
       ,'ptar'=>$ptar,
       'type'=>'1'
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
public function actionIntolerance() {
    $request = Yii::$app->request;
    if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            $ardetails = Vwptar::find()->where(['pt_visit_number' => $request->get('vn_number')])->all();
            $headerdetail = Vwcpoerxheader::findOne(['pt_vn_number' => $request->get('vn_number')]);
            return [
            'title' => "บันทึกแพ้ยา#" . " " . $headerdetail->pt_name . '<span class="pull-right">' . '<b>อายุ</b> ' . $headerdetail->pt_age_registry_date . ' <b>ปี</b>' . ' <b>HN</b> ' . $headerdetail->pt_hospital_number . ' <b>VN</b> ' . $headerdetail->pt_vn_number . '&nbsp;&nbsp;' . '</span>',
            'content' => $this->renderAjax('intolerance', [
                'ardetails' => $ardetails,
                'profile' => $headerdetail,
                ]),
            'footer' => Html::button('Close', ['class' => 'btn btn-default ', 'data-dismiss' => "modal"]).' '.Html::button('Save', ['class' => 'btn btn-success']),
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
        return $this->renderPartial('_rxdetails',['model' => $model,'rxdetail' => $rxdetail]);
    } else {
        return '<div class="alert alert-danger">No data found</div>';
    }
}
public function actionVerifyPharmacy($id){
    $modelheader = VwCpoeRxHeader::findOne(['cpoe_id'=>$id]);
    $ptar = Vwptar::find()->where(['pt_visit_number' => $modelheader->pt_vn_number])->all();
    $searchModel = new vwcpoerxdetail2Search();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);     
    return $this->render('form_detail_cpoe',
        [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'modelheader'=>$modelheader
        ,'ptar'=>$ptar,
        'type'=>'2'
        ]);
}

}
