<?php

namespace app\modules\dispense\controllers;

use Yii;
use app\modules\dispense\models\VwCpoeRxHeaderSearch;
use app\modules\dispense\models\VwCpoeRxHeader;
use app\modules\dispense\models\Vwptar;
use app\modules\dispense\models\Vwcpoerxdetail;
use app\modules\dispense\models\VwCpoeRxDetail2Search;
use yii\helpers\Html; 
use yii\helpers\Json;
use \yii\web\Response;
use app\modules\dispense\models\VwUserprofile;
class ChemoRxOrderController extends \yii\web\Controller
{
	public function actionListWaitDispense()
	{
		$searchModel = new VwCpoeRxHeaderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('list-wait-dispense',[
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			]);
	}
	public function actionListWaitPharmacy()
	{
		$searchModel = new VwCpoeRxHeaderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('list-wait-pharmacy',[
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			]);
	}
	function actionListCheckDrug(){
		$searchModel = new VwCpoeRxHeaderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('list-check-drug', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,

			]);
	}
	function actionDispenChemi($id){
		$modelheader = VwCpoeRxHeader::findOne(['cpoe_id'=>$id]);
		$ptar = Vwptar::find()->where(['pt_visit_number' => $modelheader->pt_vn_number])->all();
		$searchModel = new VwCpoeRxDetail2Search();
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
	public function actionCheckDrug($id,$user_id = null){
		if($user_id != null){
			$user = VwUserprofile::find()->where(['user_id' =>$user_id])->one();
			$_SESSION['user_id_chemorx'] = $user->user_id;
			$_SESSION['user_name_chemorx'] = $user->User_name;
		}
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
			'type'=>'3'
			]);
	}
	function actionCmdRxcheckItem(){
		$cpoe_ids = Yii::$app->request->post('cpoe_num');
		$cpoe_prepareby = $_SESSION['user_id_chemorx'];
		$user_id = Yii::$app->user->id;
		Yii::$app->db->createCommand('CALL cmd_cpoe_rx_itemcheck(:cpoe_ids,:user_id,:cpoe_prepareby);')
		->bindParam(':cpoe_ids', $cpoe_ids)
		->bindParam(':user_id', $user_id)
		->bindParam(':cpoe_prepareby', $cpoe_prepareby)
		->execute();
		echo '1';
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

}
