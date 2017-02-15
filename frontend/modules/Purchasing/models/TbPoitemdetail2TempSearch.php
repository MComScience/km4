<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbPoitemdetail2Temp;

/**
 * TbPoitemdetail2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbPoitemdetail2Temp`.
 */
class TbPoitemdetail2TempSearch extends TbPoitemdetail2Temp
{
    public  $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PONum', 'PRNum', 'PCPlanNum', 'ItemName', 'PRApprovedUnitCost', 'POPackCostApprove','ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'POItemPackID', 'POApprovedUnitCost', 'POApprovedOrderQty', 'POItemNumStatusID', 'POCreatedBy', 'POItemType', 'POID','q'], 'safe'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'POPackQtyApprove'], 'number'],
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
    public function SearchType1($params,$PRNum)
    {
        $query = TbPoitemdetail2Temp::find()
                ->where(['PRNum' => $PRNum,'POItemType' => 1]);

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
            'POItemNum' => $this->POItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'PRPackCostApprove' => $this->PRPackCostApprove,
            'ItemPackID' => $this->ItemPackID,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'POPackQtyApprove' => $this->POPackQtyApprove,
            'POItemPackID' => $this->POItemPackID,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'POItemNumStatusID' => $this->POItemNumStatusID,
            'POCreatedBy' => $this->POCreatedBy,
            'POItemType' => $this->POItemType,
            'POID' => $this->POID,
        ]);

        $query->andFilterWhere(['like', 'PONum', $this->q])
            ->andFilterWhere(['like', 'PRNum', $this->q])
            ->andFilterWhere(['like', 'PCPlanNum', $this->q])
            ->andFilterWhere(['like', 'ItemName', $this->q])
            ->andFilterWhere(['like', 'PRApprovedUnitCost', $this->q])
            ->andFilterWhere(['like', 'POPackCostApprove', $this->q]);

        return $dataProvider;
    }
    
    public function SearchType2($params,$PRNum)
    {
        $query = TbPoitemdetail2Temp::find()
                ->where(['PRNum' => $PRNum,'POItemType' => 2]);

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
            'POItemNum' => $this->POItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'PRPackCostApprove' => $this->PRPackCostApprove,
            'ItemPackID' => $this->ItemPackID,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'POPackQtyApprove' => $this->POPackQtyApprove,
            'POItemPackID' => $this->POItemPackID,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'POItemNumStatusID' => $this->POItemNumStatusID,
            'POCreatedBy' => $this->POCreatedBy,
            'POItemType' => $this->POItemType,
            'POID' => $this->POID,
        ]);

        $query->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'PRNum', $this->PRNum])
            ->andFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'PRApprovedUnitCost', $this->PRApprovedUnitCost])
            ->andFilterWhere(['like', 'POPackCostApprove', $this->POPackCostApprove]);

        return $dataProvider;
    }
    
    
}