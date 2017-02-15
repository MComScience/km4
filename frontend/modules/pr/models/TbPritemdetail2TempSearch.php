<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\TbPritemdetail2Temp;

/**
 * TbPritemdetail2TempSearch represents the model behind the search form about `app\modules\pr\models\TbPritemdetail2Temp`.
 */
class TbPritemdetail2TempSearch extends TbPritemdetail2Temp {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['ids', 'PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID', 'ItemPackIDVerify'], 'integer'],
                [['PRNum', 'PCPlanNum', 'ItemName', 'PRUnitCost'], 'safe'],
                [['PRItemStdCost', 'PRItemUnitCost', 'PRExtendedCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQty', 'ItemPackCost', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove', 'ItemPackIDApprove', 'PRLastUnitCost'], 'number'],
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
    public function search($params, $id) {
        $query = TbPritemdetail2Temp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ids' => $this->ids,
            'PRItemNum' => $this->PRItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRItemStdCost' => $this->PRItemStdCost,
            'PRItemUnitCost' => $this->PRItemUnitCost,
            'PRItemOrderQty' => $this->PRItemOrderQty,
            'PRApprovedOrderQtySum' => $this->PRApprovedOrderQtySum,
            'PRItemAvalible' => $this->PRItemAvalible,
            'PROrderQty' => $this->PROrderQty,
            'PRExtendedCost' => $this->PRExtendedCost,
            'PRVerifyUnitCost' => $this->PRVerifyUnitCost,
            'PRVerifyQty' => $this->PRVerifyQty,
            'PRApprovedUnitCost' => $this->PRApprovedUnitCost,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'PRItemNumStatusID' => $this->PRItemNumStatusID,
            'PRPackQty' => $this->PRPackQty,
            'ItemPackID' => $this->ItemPackID,
            'PRItemOnPCPlan' => $this->PRItemOnPCPlan,
            'PRCreatedBy' => $this->PRCreatedBy,
            'ItemPackCost' => $this->ItemPackCost,
            'ids_PR_selected' => $this->ids_PR_selected,
            'PRID' => $this->PRID,
            'ItemPackIDVerify' => $this->ItemPackIDVerify,
            'PRPackQtyVerify' => $this->PRPackQtyVerify,
            'ItemPackCostVerify' => $this->ItemPackCostVerify,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'ItemPackCostApprove' => $this->ItemPackCostApprove,
            'ItemPackIDApprove' => $this->ItemPackIDApprove,
            'PRLastUnitCost' => $this->PRLastUnitCost,
        ]);

        $query->andFilterWhere(['like', 'PRNum', $this->PRNum])
                ->andFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'PRUnitCost', $this->PRUnitCost])
                ->andWhere(['PRID' => $id]);

        return $dataProvider;
    }

}
