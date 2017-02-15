<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbPrSelectedDetail;

/**
 * TbPrSelectedDetailSearch represents the model behind the search form about `app\modules\Inventory\models\TbPrSelectedDetail`.
 */
class TbPrSelectedDetailSearch extends TbPrSelectedDetail {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'PRCreateBy','PRItemOnPCPlan','PCPlanTypeID'], 'integer'],
            [['PCPlanNum', 'q', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRPackQty', 'ItemPackID', 'PRCreateBy', 'PRQty'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = TbPrSelectedDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('plannum');
        //$query->joinWith('fsngpu');

        $query->andFilterWhere([
            'ids' => $this->ids,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRCreateBy' => $this->PRCreateBy,
            'PCPlanTypeID' => $this->PCPlanTypeID
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'TMTID_GPU', $this->q])
                ->orFilterWhere(['like', 'TMTID_TPU', $this->q])
                ->orFilterWhere(['like', 'PRPackQty', $this->q])
                ->orFilterWhere(['like', 'ItemPackID', $this->q])
                ->orFilterWhere(['like', 'PRQty', $this->q])
                ->orFilterWhere(['like', 'PRUnitCost', $this->q])
                ->orFilterWhere(['like', 'PCPlanNum', $this->q])
                //->orFilterWhere(['like', 'fsngpu.FSN_GPU', $this->q])
                ->andWhere(['PCPlanTypeID' => array(1, 2)]);
                //->andWhere(['tb_pcplan.PCPlanTypeID' => array(1, 2)]);

        return $dataProvider;
    }
    
    public function searchtpu($params) {
        $query = TbPrSelectedDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('plannum');
        $query->joinWith('datatpu');

        $query->andFilterWhere([
            'ids' => $this->ids,
            'ItemID' => $this->ItemID,
            //'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRCreateBy' => $this->PRCreateBy,
            'PCPlanTypeID' => $this->PCPlanTypeID
        ]);

        $query->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected.PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected.TMTID_TPU', $this->q])
                //->orFilterWhere(['like', 'TMTID_TPU', $this->q])
               // ->orFilterWhere(['like', 'PRPackQty', $this->q])
//                ->orFilterWhere(['like', 'ItemPackID', $this->q])
//                ->orFilterWhere(['like', 'PRQty', $this->q])
//                ->orFilterWhere(['like', 'PRUnitCost', $this->q])
//                ->orFilterWhere(['like', 'PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected.ItemName', $this->q])
                //->orFilterWhere(['like', 'fsngpu.FSN_GPU', $this->q])
                ->andWhere(['vw_tpuplan_detail_pr_selected.PCPlanTypeID' => array(7, 8)]);
                //->andWhere(['tb_pcplan.PCPlanTypeID' => array(1, 2)]);

        return $dataProvider;
    }
    
    public function searchnd($params) {
        $query = TbPrSelectedDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('plannum');
        $query->joinWith('datand');

        $query->andFilterWhere([
            'ids' => $this->ids,
            //'ItemID' => $this->ItemID,
            //'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRCreateBy' => $this->PRCreateBy,
            'PCPlanTypeID' => $this->PCPlanTypeID
        ]);

        $query->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected.PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected.ItemID', $this->q])
                ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected.PCPlanNDUnitCost', $this->q])
                ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected.PCPlanNDQty', $this->q])
//                ->orFilterWhere(['like', 'PRQty', $this->q])
//                ->orFilterWhere(['like', 'PRUnitCost', $this->q])
//                ->orFilterWhere(['like', 'PCPlanNum', $this->q])
                ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected.ItemName', $this->q])
                //->orFilterWhere(['like', 'fsngpu.FSN_GPU', $this->q])
                ->andWhere(['vw_ndplan_detail_pr_selected.PCPlanTypeID' => array(3, 4)]);
                //->andWhere(['tb_pcplan.PCPlanTypeID' => array(1, 2)]);

        return $dataProvider;
    }
    
    public function searchplantpu($params) {
        $query = TbPrSelectedDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('plannum');
        $query->joinWith('dataplantpu');

        $query->andFilterWhere([
            'ids' => $this->ids,
            //'ItemID' => $this->ItemID,
            //'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRCreateBy' => $this->PRCreateBy,
            'PCPlanTypeID' => $this->PCPlanTypeID
        ]);

        $query->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected_pocont.PCPlanNum', $this->q])
                 ->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected_pocont.TMTID_TPU', $this->q])
                ->orFilterWhere(['like', 'vw_tpuplan_detail_pr_selected_pocont.ItemName', $this->q])
                ->andWhere(['vw_tpuplan_detail_pr_selected_pocont.PCPlanTypeID' => array(5)]);

        return $dataProvider;
    }
    
    public function searchplannd($params) {
        $query = TbPrSelectedDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->joinWith('plannum');
        $query->joinWith('dataplannd');

        $query->andFilterWhere([
            'ids' => $this->ids,
            //'ItemID' => $this->ItemID,
            //'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRCreateBy' => $this->PRCreateBy,
            'PCPlanTypeID' => $this->PCPlanTypeID
        ]);

        $query->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected_pocont.PCPlanNum', $this->q])
                 ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected_pocont.TMTID_TPU', $this->q])
                ->orFilterWhere(['like', 'vw_ndplan_detail_pr_selected_pocont.ItemName', $this->q])
                ->andWhere(['vw_ndplan_detail_pr_selected_pocont.PCPlanTypeID' => array(6)]);

        return $dataProvider;
    }
    
    

}
