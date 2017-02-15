<?php

namespace app\modules\plan\controllers;

use Yii;
use yii\web\Controller;
use app\modules\plan\models\TbPcplan;

/**
 * Default controller for the `plan` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $query = TbPcplan::find()
                ->where(['PCPlanStatusID' => [1, 2, 4, 5]])
                ->andWhere(['IN', 'PCPlanTypeID', [1, 2, 3, 4, 7, 8]])
                ->all();
        TbPcplan::deleteAll(['PCPlanTypeID' => null, 'PCPlanCreatedBy' => Yii::$app->user->getId()]);
        /* $provider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
          'pageSize' => 10,
          ],
          'sort' => [
          'defaultOrder' => [
          'PCPlanNum' => SORT_DESC,
          ]
          ],
          ]); */


        return $this->render('index', [
                    'query' => $query,
        ]);
    }

    public function actionPlansale() {
        $rows = (new \yii\db\Query())
                ->select(['tb_pcplan.*','tb_pcplantpudetail.TMTID_TPU','tb_pcplantpudetail.TPUUnitCost','tb_pcplantpudetail.TPUOrderQty','vw_item_list_tpu.FSN_TMT','vw_item_list_tpu.DispUnit','tb_pcplanstatus.PCPlanStatus'])
                ->from('tb_pcplan')
                ->leftJoin('tb_pcplantpudetail', '`tb_pcplantpudetail`.`PCPlanNum` = `tb_pcplan`.`PCPlanNum`')
                ->leftJoin('tb_pcplanstatus', '`tb_pcplanstatus`.`PCPlanStatusID` = `tb_pcplan`.`PCPlanStatusID`')
                ->innerJoin('vw_item_list_tpu', '`vw_item_list_tpu`.`TMTID_TPU` = `tb_pcplantpudetail`.`TMTID_TPU`')
                ->where(['tb_pcplan.PCPlanStatusID' => [1, 2, 4, 5]])
                ->andWhere(['IN', 'tb_pcplan.PCPlanTypeID', [5, 6]])
                ->groupBy('tb_pcplantpudetail.ids')
                ->all();
//        $query = TbPcplan::find()
//                ->select(['`tb_pcplan.PCPlanNum`','`tb_pcplantpudetail`.`TMTID_TPU`'])
//                ->from('`tb_pcplan`')
//                ->leftJoin('tb_pcplantpudetail', '`tb_pcplantpudetail`.`PCPlanNum` = `tb_pcplan`.`PCPlanNum`')
//                ->innerJoin('vw_item_list_tpu', '`vw_item_list_tpu`.`TMTID_TPU` = `tb_pcplantpudetail`.`TMTID_TPU`')
//                ->where(['PCPlanStatusID' => [1, 2, 4, 5]])
//                ->andWhere(['IN', 'PCPlanTypeID', [5, 6]])
//                ->all();
        TbPcplan::deleteAll(['PCPlanTypeID' => null, 'PCPlanCreatedBy' => Yii::$app->user->getId()]);

        return $this->render('plansale', [
                    'query' => $rows,
        ]);
    }

    public function actionWaitingVerify() {
        $query = TbPcplan::find()->where(['PCPlanStatusID' => 4])->all();
        return $this->render('waiting-verify', [
                    'query' => $query,
        ]);
    }

    public function actionDelete($id) {
        $model = TbPcplan::findOne($id);
        $model->PCPlanStatusID = 3;
        $model->save();
        Yii::$app->getSession()->setFlash('alert1', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Deleted ' . $id,
        ]);
        return $this->redirect(['index']);
    }

}
