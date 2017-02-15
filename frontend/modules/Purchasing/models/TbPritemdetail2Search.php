<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbPritemdetail2;

/**
 * TbPritemdetail2Search represents the model behind the search form about `app\modules\Purchasing\models\TbPritemdetail2`.
 */
class TbPritemdetail2Search extends TbPritemdetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PRItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'PRItemOrderQty', 'PRApprovedOrderQtySum', 'PRItemAvalible', 'PROrderQty', 'PRApprovedUnitCost', 'PRApprovedOrderQty', 'PRItemNumStatusID', 'ItemPackID', 'PRItemOnPCPlan', 'PRCreatedBy', 'ids_PR_selected', 'PRID', 'ItemPackIDVerify'], 'integer'],
            [['PRNum', 'PCPlanNum', 'ItemName', 'PRUnitCost', 'PRExtendedCost'], 'safe'],
            [['PRItemStdCost', 'PRItemUnitCost', 'PRVerifyUnitCost', 'PRVerifyQty', 'PRPackQty', 'ItemPackCost', 'PRPackQtyVerify', 'ItemPackCostVerify', 'PRPackQtyApprove', 'ItemPackCostApprove'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = TbPritemdetail2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
            'PRPackQtyVerify' => $this->PRPackQtyVerify,
            'ItemPackCostVerify' => $this->ItemPackCostVerify,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'ItemPackCostApprove' => $this->ItemPackCostApprove,
            'PRID' => $this->PRID,
            'ItemPackIDVerify' => $this->ItemPackIDVerify,
        ]);

        $query->andFilterWhere(['like', 'PRNum', $this->PRNum])
            ->andFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'PRUnitCost', $this->PRUnitCost])
            ->andFilterWhere(['like', 'PRExtendedCost', $this->PRExtendedCost]);

        return $dataProvider;
    }
    public function SearchDetailVerify($params,$id)
    {
        $query = TbPritemdetail2::find()->where(['PRID' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
            'PRPackQtyVerify' => $this->PRPackQtyVerify,
            'ItemPackCostVerify' => $this->ItemPackCostVerify,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'ItemPackCostApprove' => $this->ItemPackCostApprove,
            'PRID' => $this->PRID,
            'ItemPackIDVerify' => $this->ItemPackIDVerify,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->PRNum])
            ->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->orFilterWhere(['like', 'ItemName', $this->ItemName])
            ->orFilterWhere(['like', 'PRUnitCost', $this->PRUnitCost])
            ->orFilterWhere(['like', 'PRExtendedCost', $this->PRExtendedCost]);

        return $dataProvider;
    }
    
    public function SearchViewDetailVerify($params)
    {
        $query = TbPritemdetail2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

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
            'PRPackQtyVerify' => $this->PRPackQtyVerify,
            'ItemPackCostVerify' => $this->ItemPackCostVerify,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'ItemPackCostApprove' => $this->ItemPackCostApprove,
            'PRID' => $this->PRID,
            'ItemPackIDVerify' => $this->ItemPackIDVerify,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->PRNum])
            ->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->orFilterWhere(['like', 'ItemName', $this->ItemName])
            ->orFilterWhere(['like', 'PRUnitCost', $this->PRUnitCost])
            ->orFilterWhere(['like', 'PRExtendedCost', $this->PRExtendedCost]);

        return $dataProvider;
    }
}
