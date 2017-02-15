<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbPoitemdetail2;

/**
 * TbPoitemdetail2Search represents the model behind the search form about `app\modules\Inventory\models\TbPoitemdetail2`.
 */
class TbPoitemdetail2Search extends TbPoitemdetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'ItemPackID', 'POItemPackID', 'POItemNumStatusID', 'POCreatedBy', 'POItemType', 'POID'], 'integer'],
            [['PONum', 'PRNum', 'PCPlanNum', 'ItemName'], 'safe'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty'], 'number'],
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
        $query = TbPoitemdetail2::find();

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
            'PRApprovedUnitCost' => $this->PRApprovedUnitCost,
            'POPackQtyApprove' => $this->POPackQtyApprove,
            'POPackCostApprove' => $this->POPackCostApprove,
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
            ->andFilterWhere(['like', 'ItemName', $this->ItemName]);

        return $dataProvider;
    }
    
    public function SearchDetailVerify1($params,$id)
    {
        $query = TbPoitemdetail2::find()
                ->where(['POID' => $id,'POItemType' => 1]);

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
    
    public function SearchDetailVerify2($params,$id)
    {
        $query = TbPoitemdetail2::find()
                ->where(['POID' => $id,'POItemType' => 2]);

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
    
    public function SearchHistory($params,$id,$ItemID)
    {
        $query = TbPoitemdetail2::find()
                ->where(['POID' => $id,'ItemID' => $ItemID,'POItemType' => 1]);

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
