<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\TpuplanDetailAvalibleSearch;
use kartik\widgets\Growl;

class StocksBalanceController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new \app\models\TbItemSearch();
        $dataProvider = $searchModel->SearchStocksbalance(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 30;
//        $searchModel = new \app\modules\Inventory\models\VwItemBalanceSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 30;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListNd() {
        $searchModel = new \app\models\TbItemSearch();
        $dataProvider = $searchModel->SearchStocksbalanceND(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 30;
//        $searchModel = new \app\modules\Inventory\models\VwItemBalanceSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 30;

        return $this->render('list-nd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGendata() {
//        $connection = Yii::$app->getDb();
//$command = $connection->createCommand("SELECT
//	`tb_prgpudetail`.`TMTID_GPU` AS `TMTID_GPU`,
//	`tb_pr`.`PRStatusID` AS `PRStatusID`,
//	`tb_prgpudetail`.`PRApprovedOrderQty` AS `PRApprovedOrderQty`,
//	`tb_prgpudetail`.`PRItemNumStatusID` AS `PRItemNumStatusID`,
//	`tb_gpustdcost`.`GPUStdCost` AS `GPUStdCost`
//FROM
//	(
//		(
//			`tb_pr`
//			JOIN `tb_prgpudetail` ON (
//				(
//					(
//						`tb_pr`.`PRNum` = `tb_prgpudetail`.`PRNum`
//					)
//					AND ('' = '')
//				)
//			)
//		)
//		LEFT JOIN `tb_gpustdcost` ON (
//			(
//				`tb_prgpudetail`.`TMTID_GPU` = `tb_gpustdcost`.`TMTID_GPU`
//			)
//		)
//	)
//WHERE
//	(
//		(
//			`tb_prgpudetail`.`PRItemNumStatusID` = 2
//		)
//		AND (`tb_pr`.`PRStatusID` = 11)
//	)
//GROUP BY
//	`tb_prgpudetail`.`TMTID_GPU`
//ORDER BY
//	`tb_prgpudetail`.`TMTID_GPU` ");
//$result = $command->queryAll();
//print_r($result);
        $pr = Yii::$app->request->post();
        $id = $pr['keylist'];
        $prtype = $pr['prtype'];
        //$i = 0;
        foreach ($id as $data) {
            $id1 = $data;
            Yii::$app->db->createCommand('CALL cmd_pr_selectitemto_tb_pr_selected(:x,:y);')
                    ->bindParam(':x', $id1)
                    ->bindParam(':y', $prtype)->execute();
            //$i++;
        }
        $arr = array(
            'id' => $id,
        );
        return json_encode($arr);
    }

    public function actionDetailgpu() {
        $searchModel = new \app\modules\Inventory\models\TbPrSelectedDetailSearch();
        $modelPR = new \app\models\TbPr();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('detailgpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelPR' => $modelPR
        ]);
    }

    public function actionDetailtpu() {
        $searchModel = new \app\modules\Inventory\models\TbPrSelectedDetailSearch();
        $modelPR = new \app\models\TbPr();
        $dataProvider = $searchModel->searchtpu(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('detailtpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelPR' => $modelPR
        ]);
    }

    public function actionDetailnd() {
        $searchModel = new \app\modules\Inventory\models\TbPrSelectedDetailSearch();
        $modelPR = new \app\models\TbPr();
        $dataProvider = $searchModel->searchnd(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('detailnd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelPR' => $modelPR
        ]);
    }

    public function actionDetailplantpu() {
        $searchModel = new \app\modules\Inventory\models\TbPrSelectedDetailSearch();
        $modelPR = new \app\models\TbPr();
        $dataProvider = $searchModel->searchplantpu(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('detailplantpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelPR' => $modelPR
        ]);
    }

    public function actionDetailplannd() {
        $searchModel = new \app\modules\Inventory\models\TbPrSelectedDetailSearch();
        $modelPR = new \app\models\TbPr();
        $dataProvider = $searchModel->searchplannd(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('detailplannd', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'modelPR' => $modelPR
        ]);
    }

    public function actionUpdategpu($id) {
        $model = \app\modules\Inventory\models\TbPrSelectedDetail::findOne(['ids' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['TMTID_GPU' => $_POST['TbPrSelectedDetail']['TMTID_GPU'], 'ItemPackUnit' => $_POST['TbPrSelectedDetail']['ItemPackID']]);
            $model->PRPackQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRPackQty']);
            $model->PRQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRQty']);
            $model->PRUnitCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRUnitCost']);
            $model->ItemPackCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['ItemPackCost']);
            $model->ItemPackID = $findpackid['ItemPackID'];
            $model->PRCreateBy = Yii::$app->user->identity->profile->user_id;
            if ($_POST['VwGpuplanDetailPrSelected']['PRGPUAvalible'] > 0) {
                $model->PRItemOnPCPlan = 1;
            } else {
                $model->PRItemOnPCPlan = 0;
            }
            //$model->branch_created_date = date('Y-m-d h:m:s');
            if ($model->save()) {
                echo 1;
//                Yii::$app->getSession()->setFlash('alert1', [
//                ]);
                //return $this->redirect(['detailgpu']);
            }
        } else {
            $vwmodel = \app\modules\Inventory\models\VwGpuplanDetailPrSelected::findOne(['ids' => $id]);
            $itempack = \app\modules\Inventory\models\VwItempackGpu::findAll(['TMTID_GPU' => $model['TMTID_GPU']]);
            $ItemPackUnit = array();
            foreach ($itempack as $data) {
                $ItemPackUnit[] = $data['ItemPackUnit'];
            }
            $qty = \app\modules\Inventory\models\VwItempackGpu::findOne([
                        //'TMTID_GPU' => $model['TMTID_GPU'],
                        'ItemPackID' => $model['ItemPackID']
            ]);
            return $this->renderAjax('_formgpu', [
                        'model' => $model,
                        'vwmodel' => $vwmodel,
                        'ItemPackUnit' => $ItemPackUnit,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PackUnit' => $qty['ItemPackUnit'],
            ]);
        }
    }

    public function actionUpdatetpu($id) {
        $model = \app\modules\Inventory\models\TbPrSelectedDetail::findOne($id);
        $vwmodel = \app\modules\Inventory\models\VwTpuplanDetailPrSelected::findOne(['ids' => $id]);
        $itempack = \app\modules\Inventory\models\VwItempackGpu::findAll(['TMTID_GPU' => $vwmodel['TMTID_GPU']]);
        $ItemPackUnit = array();
        foreach ($itempack as $data) {
            $ItemPackUnit[] = $data['ItemPackUnit'];
        }
        $qty = \app\models\TbItempack::findOne([
                    'ItemPackID' => $model['ItemPackID']
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['TMTID_GPU' => $vwmodel['TMTID_GPU'], 'ItemPackUnit' => $_POST['TbPrSelectedDetail']['ItemPackID']]);
            $model->PRPackQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRPackQty']);
            $model->PRQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRQty']);
            $model->PRUnitCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRUnitCost']);
            $model->ItemPackCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['ItemPackCost']);
            $model->ItemPackID = $findpackid['ItemPackID'];
            $model->PRCreateBy = Yii::$app->user->identity->profile->user_id;
            if ($_POST['VwTpuplanDetailPrSelected']['PRTPUAvalible'] > 0) {
                $model->PRItemOnPCPlan = 1;
            } else {
                $model->PRItemOnPCPlan = 0;
            }
            //$model->branch_created_date = date('Y-m-d h:m:s');
            if ($model->save()) {
                echo 1;

                //return $this->redirect(['detailtpu']);
            }
        } else {
            return $this->renderAjax('_formtpu', [
                        'model' => $model,
                        'vwmodel' => $vwmodel,
                        'ItemPackUnit' => $ItemPackUnit,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PackUnit' => $qty['ItemPackUnit'],
            ]);
        }
    }

    public function actionUpdatend($id) {
        $model = \app\modules\Inventory\models\TbPrSelectedDetail::findOne($id);
        $vwmodel = \app\modules\Inventory\models\VwNdplanDetailPrSelected::findOne(['ids' => $id]);
        $itempack = \app\modules\Inventory\models\VwItempackNd::findAll(['ItemID' => $vwmodel['ItemID']]);
        $ItemPackUnit = array();
        foreach ($itempack as $data) {
            $ItemPackUnit[] = $data['ItemPackUnit'];
        }
        $qty = \app\modules\Inventory\models\VwItempackNd::findOne([
                    'ItemPackID' => $model['ItemPackID']
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['TbPrSelectedDetail']['ItemID'], 'ItemPackUnit' => $_POST['TbPrSelectedDetail']['ItemPackID']]);
            $model->PRPackQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRPackQty']);
            $model->PRQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRQty']);
            $model->PRUnitCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRUnitCost']);
            $model->ItemPackCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['ItemPackCost']);
            $model->PRCreateBy = Yii::$app->user->identity->profile->user_id;
            $model->ItemPackID = $findpackid['ItemPackID'];
            //$model->branch_created_date = date('Y-m-d h:m:s');
            if ($_POST['VwNdplanDetailPrSelected']['PRNDAvalible'] > 0) {
                $model->PRItemOnPCPlan = 1;
            } else {
                $model->PRItemOnPCPlan = 0;
            }
            if ($model->save()) {
                echo 1;
            }
        } else {
            return $this->renderAjax('_formnd', [
                        'model' => $model,
                        'vwmodel' => $vwmodel,
                        'ItemPackUnit' => $ItemPackUnit,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PackUnit' => $qty['ItemPackUnit']
            ]);
        }
    }

    public function actionUpdateplantpu($id) {
        $model = \app\modules\Inventory\models\TbPrSelectedDetail::findOne($id);
        $vwmodel = \app\modules\Inventory\models\VwTpuplanDetailPrSelectedPocont::findOne(['ids' => $id]);
        $itempack = \app\modules\Inventory\models\VwItempack::findAll(['ItemID' => $vwmodel['ItemID']]);
        $ItemPackUnit = array();
        foreach ($itempack as $data) {
            $ItemPackUnit[] = $data['ItemPackUnit'];
        }
        $qty = \app\modules\Inventory\models\VwItempack::findOne([
                    'ItemPackID' => $model['ItemPackID']
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['TMTID_GPU' => $vwmodel['TMTID_GPU'], 'ItemPackUnit' => $_POST['TbPrSelectedDetail']['ItemPackID']]);
            $model->PRPackQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRPackQty']);
            $model->PRQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRQty']);
            $model->PRUnitCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRUnitCost']);
            $model->PRCreateBy = Yii::$app->user->identity->profile->user_id;
            $model->ItemPackCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['ItemPackCost']);
            $model->ItemPackID = $findpackid['ItemPackID'];
            if ($_POST['VwTpuplanDetailPrSelectedPocont']['PRGPUAvalible'] > 0) {
                $model->PRItemOnPCPlan = 1;
            } else {
                $model->PRItemOnPCPlan = 0;
            }
            if ($model->save()) {
                echo 1;
            }
        } else {
            return $this->renderAjax('_formplantpu', [
                        'model' => $model,
                        'vwmodel' => $vwmodel,
                        'ItemPackUnit' => $ItemPackUnit,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PackUnit' => $qty['ItemPackUnit']
            ]);
        }
    }

    public function actionUpdateplannd($id) {
        $model = \app\modules\Inventory\models\TbPrSelectedDetail::findOne($id);
        $vwmodel = \app\modules\Inventory\models\VwNdplanDetailPrSelectedPocont::findOne(['ids' => $id]);
        $itempack = \app\modules\Inventory\models\VwItempackNd::findAll(['ItemID' => $vwmodel['ItemID']]);
        $ItemPackUnit = array();
        foreach ($itempack as $data) {
            $ItemPackUnit[] = $data['ItemPackUnit'];
        }
        $qty = \app\modules\Inventory\models\VwItempackNd::findOne([
                    'ItemPackID' => $model['ItemPackID']
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $findpackid = \app\models\TbItempack::findOne(['ItemID' => $_POST['TbPrSelectedDetail']['ItemID'], 'ItemPackUnit' => $_POST['TbPrSelectedDetail']['ItemPackID']]);
            $model->PRPackQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRPackQty']);
            $model->PRQty = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRQty']);
            $model->PRUnitCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['PRUnitCost']);
            $model->ItemPackCost = str_replace(',', '', $_POST['TbPrSelectedDetail']['ItemPackCost']);
            $model->PRCreateBy = Yii::$app->user->identity->profile->user_id;
            $model->ItemPackID = $findpackid['ItemPackID'];
            if ($_POST['VwNdplanDetailPrSelectedPocont']['PRNDAvalible'] > 0) {
                $model->PRItemOnPCPlan = 1;
            } else {
                $model->PRItemOnPCPlan = 0;
            }
            if ($model->save()) {
                echo 1;
            }
        } else {
            return $this->renderAjax('_formplannd', [
                        'model' => $model,
                        'vwmodel' => $vwmodel,
                        'ItemPackUnit' => $ItemPackUnit,
                        'ItemPackSKUQty' => $qty['ItemPackSKUQty'],
                        'PackUnit' => $qty['ItemPackUnit'],
            ]);
        }
    }

    public function actionGetQtygpu() {
        $qty = \app\modules\Inventory\models\VwItempackGpu::findOne([
                    'TMTID_GPU' => $_POST['TMTID_GPU'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
            'qty' => $_POST['qty'],
        );
        return json_encode($arr);
    }

    public function actionGetQtynd() {
        $qty = \app\modules\Inventory\models\VwItempackNd::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
            'qty' => $_POST['qty'],
        );
        return json_encode($arr);
    }

    public function actionGetQtyplantpu() {
        $qty = \app\modules\Inventory\models\VwItempack::findOne([
                    'ItemID' => $_POST['ItemID'],
                    'ItemPackUnit' => $_POST['ItemPackUnit']
        ]);
        $arr = array(
            'ItemPackSKUQty' => number_format($qty['ItemPackSKUQty'], 2),
            'qty' => $_POST['qty'],
        );
        return json_encode($arr);
    }

    public function actionDeletegpu() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_pr_selected_detail WHERE ids = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionCreateDataprtemp() {
        $max = \app\modules\Purchasing\models\TbPr2::find()
                ->select('max(PRID)')
                ->scalar();
        $maxTemp = \app\modules\Purchasing\models\TbPr2Temp::find()
                ->select('max(PRID)')
                ->scalar();
        if ($max > $maxTemp) {
            $PRIDMAX = $max + 1;
        } elseif ($max < $maxTemp) {
            $PRIDMAX = $maxTemp + 1;
        }

        if ($_POST['Plan'] == 'TPU') {
            $keys[] = $_POST['keylist'];
            $date = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['PRExpectDate']);
            $plantpu = \app\modules\Inventory\models\VwTpuplanDetailPrSelected::findOne(['ids' => $keys[0]]);
            $PCPlanNum = $plantpu['PCPlanNum'];

            Yii::$app->db->createCommand('CALL cmd_pr2_create_header(:ids_PR_selected,:PRTypeID,:POTypeID,:PRExpectDate,:PCPlanNum);')
                    ->bindParam(':ids_PR_selected', $PRIDMAX)
                    ->bindParam(':PRTypeID', $_POST['PRTypeID'])
                    ->bindParam(':POTypeID', $_POST['POTypeID'])
                    ->bindParam(':PRExpectDate', $date)
                    ->bindParam(':PCPlanNum', $PCPlanNum)
                    ->execute();
            foreach ($_POST['keylist'] as $data) {
                Yii::$app->db->createCommand('CALL cmd_pr2_create_detail(:x);')
                        ->bindParam(':x', $data)
                        ->execute();
            }
            Yii::$app->db->createCommand('CALL cmd_pr2_create_itemtemp(:x);')
                    ->bindParam(':x', $PRIDMAX)
                    ->execute();
            $sql = "
                DELETE FROM tb_pr_selected_header WHERE tb_pr_selected_header.ids_PR_selected=$PRIDMAX;
                DELETE FROM tb_pr_selected_detail WHERE tb_pr_selected_detail.ids_PR_selected=$PRIDMAX;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $find = \app\modules\Purchasing\models\TbPr2Temp::findOne($PRIDMAX);
            return $this->redirect(['/Purchasing/addpr-tpu/create', 'ids_PR_selected' => $PRIDMAX, 'PRID' => $find->PRID, 'view' => '']);
        } elseif ($_POST['Plan'] == 'GPU') {
            $keys[] = $_POST['keylist'];
            $date = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['PRExpectDate']);
            $plangpu = \app\modules\Inventory\models\VwGpuplanDetailPrSelected::findOne(['ids' => $keys[0]]);
            $PCPlanNum = $plangpu['PCPlanNum'];

            Yii::$app->db->createCommand('CALL cmd_pr2_create_header(:ids_PR_selected,:PRTypeID,:POTypeID,:PRExpectDate,:PCPlanNum);')
                    ->bindParam(':ids_PR_selected', $PRIDMAX)
                    ->bindParam(':PRTypeID', $_POST['PRTypeID'])
                    ->bindParam(':POTypeID', $_POST['POTypeID'])
                    ->bindParam(':PRExpectDate', $date)
                    ->bindParam(':PCPlanNum', $PCPlanNum)
                    ->execute();

            foreach ($_POST['keylist'] as $data) {
                Yii::$app->db->createCommand('CALL cmd_pr2_create_detail(:x);')
                        ->bindParam(':x', $data)
                        ->execute();
            }
            Yii::$app->db->createCommand('CALL cmd_pr2_create_itemtemp(:x);')
                    ->bindParam(':x', $PRIDMAX)
                    ->execute();
            $sql = "
                DELETE FROM tb_pr_selected_header WHERE tb_pr_selected_header.ids_PR_selected=$PRIDMAX;
                DELETE FROM tb_pr_selected_detail WHERE tb_pr_selected_detail.ids_PR_selected=$PRIDMAX;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $find = \app\modules\Purchasing\models\TbPr2Temp::findOne($PRIDMAX);
            return $this->redirect(['/Purchasing/addpr-gpu/create', 'ids_PR_selected' => $PRIDMAX, 'PRID' => $find->PRID, 'view' => '']);
        } elseif ($_POST['Plan'] == 'ND') {
            $keys[] = $_POST['keylist'];
            $date = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['PRExpectDate']);
            $plantpu = \app\modules\Inventory\models\VwNdplanDetailPrSelected::findOne(['ids' => $keys[0]]);
            $PCPlanNum = $plantpu['PCPlanNum'];
            Yii::$app->db->createCommand('CALL cmd_pr2_create_header(:ids_PR_selected,:PRTypeID,:POTypeID,:PRExpectDate,:PCPlanNum);')
                    ->bindParam(':ids_PR_selected', $PRIDMAX)
                    ->bindParam(':PRTypeID', $_POST['PRTypeID'])
                    ->bindParam(':POTypeID', $_POST['POTypeID'])
                    ->bindParam(':PRExpectDate', $date)
                    ->bindParam(':PCPlanNum', $PCPlanNum)
                    ->execute();

            foreach ($_POST['keylist'] as $data) {
                Yii::$app->db->createCommand('CALL cmd_pr2_create_detail(:x);')
                        ->bindParam(':x', $data)
                        ->execute();
            }
            Yii::$app->db->createCommand('CALL cmd_pr2_create_itemtemp(:x);')
                    ->bindParam(':x', $PRIDMAX)
                    ->execute();
            $sql = "
                DELETE FROM tb_pr_selected_header WHERE tb_pr_selected_header.ids_PR_selected=$PRIDMAX;
                DELETE FROM tb_pr_selected_detail WHERE tb_pr_selected_detail.ids_PR_selected=$PRIDMAX;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $find = \app\modules\Purchasing\models\TbPr2Temp::findOne($PRIDMAX);

            return $this->redirect(['/Purchasing/addpr-nd/create', 'ids_PR_selected' => $PRIDMAX, 'PRID' => $find->PRID, 'view' => '']);
        } elseif ($_POST['Plan'] == 'Plan_TPU') {
            $keys[] = $_POST['keylist'];
            $date = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['PRExpectDate']);
            $plantpu = \app\modules\Inventory\models\VwTpuplanDetailPrSelectedPocont::findOne(['ids' => $keys[0]]);
            $PCPlanNum = $plantpu['PCPlanNum'];

            Yii::$app->db->createCommand('CALL cmd_pr2_create_header(:ids_PR_selected,:PRTypeID,:POTypeID,:PRExpectDate,:PCPlanNum);')
                    ->bindParam(':ids_PR_selected', $PRIDMAX)
                    ->bindParam(':PRTypeID', $_POST['PRTypeID'])
                    ->bindParam(':POTypeID', $_POST['POTypeID'])
                    ->bindParam(':PRExpectDate', $date)
                    ->bindParam(':PCPlanNum', $PCPlanNum)
                    ->execute();

            foreach ($_POST['keylist'] as $data) {
                Yii::$app->db->createCommand('CALL cmd_pr2_create_detail(:x);')
                        ->bindParam(':x', $data)
                        ->execute();
            }
            Yii::$app->db->createCommand('CALL cmd_pr2_create_itemtemp(:x);')
                    ->bindParam(':x', $PRIDMAX)
                    ->execute();
            $sql = "
                DELETE FROM tb_pr_selected_header WHERE tb_pr_selected_header.ids_PR_selected=$PRIDMAX;
                DELETE FROM tb_pr_selected_detail WHERE tb_pr_selected_detail.ids_PR_selected=$PRIDMAX;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $find = \app\modules\Purchasing\models\TbPr2Temp::findOne($PRIDMAX);
            return $this->redirect(['/Purchasing/addpr-tpu-cont/create', 'ids_PR_selected' => $PRIDMAX, 'PRID' => $find->PRID, 'view' => '']);
        } elseif ($_POST['Plan'] == 'ND_Cont') {
            $keys[] = $_POST['keylist'];
            $date = Yii::$app->componentdate->convertThaiToMysqlDate($_POST['PRExpectDate']);
            $plantpu = \app\modules\Inventory\models\VwTpuplanDetailPrSelectedPocont::findOne(['ids' => $keys[0]]);
            $PCPlanNum = $plantpu['PCPlanNum'];
            Yii::$app->db->createCommand('CALL cmd_pr2_create_header(:ids_PR_selected,:PRTypeID,:POTypeID,:PRExpectDate,:PCPlanNum);')
                    ->bindParam(':ids_PR_selected', $PRIDMAX)
                    ->bindParam(':PRTypeID', $_POST['PRTypeID'])
                    ->bindParam(':POTypeID', $_POST['POTypeID'])
                    ->bindParam(':PRExpectDate', $date)
                    ->bindParam(':PCPlanNum', $PCPlanNum)
                    ->execute();

            foreach ($_POST['keylist'] as $data) {
                Yii::$app->db->createCommand('CALL cmd_pr2_create_detail(:x);')
                        ->bindParam(':x', $data)
                        ->execute();
            }
            Yii::$app->db->createCommand('CALL cmd_pr2_create_itemtemp(:x);')
                    ->bindParam(':x', $PRIDMAX)
                    ->execute();
            $sql = "
                DELETE FROM tb_pr_selected_header WHERE tb_pr_selected_header.ids_PR_selected=$PRIDMAX;
                DELETE FROM tb_pr_selected_detail WHERE tb_pr_selected_detail.ids_PR_selected=$PRIDMAX;
                    ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $find = \app\modules\Purchasing\models\TbPr2Temp::findOne($PRIDMAX);
            return $this->redirect(['/Purchasing/addpr-nd-cont/create', 'ids_PR_selected' => $PRIDMAX, 'PRID' => $find->PRID, 'view' => '']);
        }
    }

    public function actionGpuPlanDetail() {
        $model = \app\models\TbItem::findOne($_POST['expandRowKey']);
        //GPU
        $searchModel = new \app\modules\Inventory\models\TbPcplangpudetailSearch();
        $searchModel->TMTID_GPU = $model->TMTID_GPU;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $checkgpu = \app\modules\Inventory\models\VwGpuplanDetailAvalible::findAll(['TMTID_GPU' => $model->TMTID_GPU]);
        $checktpu = \app\modules\Inventory\models\VwTpuplanDetailAvalible::findOne(['TMTID_TPU' => $model->TMTID_TPU, 'ItemID' => $_POST['expandRowKey']]);
        $checknd = \app\modules\Inventory\models\VwNdplanDetailAvalible::findAll(['ItemID' => $_POST['expandRowKey']]);
//        $countgpu = \app\modules\Inventory\models\VwGpuplanDetailAvalible::find()
//                ->count();
        if ($checknd != null) {
            foreach ($checknd as $data) {
                $PCPlanTypeID[] = $data['PCPlanTypeID'];
            }
            if (in_array("6", $PCPlanTypeID)) {
                $PlanTypeID6 = '6';
            } else {
                $PlanTypeID6 = 'false';
            }
            if (in_array("3", $PCPlanTypeID)) {
                $PlanTypeID3 = '3';
            } else {
                $PlanTypeID3 = 'false';
            }
            if (in_array("4", $PCPlanTypeID)) {
                $PlanTypeID4 = '4';
            } else {
                $PlanTypeID4 = 'false';
            }
        } else {
            $PlanTypeID6 = 'false';
            $PlanTypeID3 = 'false';
            $PlanTypeID4 = 'false';
        }


        return $this->renderAjax('_gpuplandetail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'checkgpu' => $checkgpu,
                    'checktpu' => $checktpu,
                    'checknd' => $checknd,
                    'TypeIDTPU' => $checktpu['PCPlanTypeID'],
                    'PlanTypeID6' => $PlanTypeID6,
                    'PlanTypeID3' => $PlanTypeID3,
                    'PlanTypeID4' => $PlanTypeID4,
        ]);
    }

}
