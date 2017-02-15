<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwPo2Detail2New;

/**
 * VwPo2Detail2NewSearch represents the model behind the search form about `app\modules\Inventory\models\VwPo2Detail2New`.
 */
class VwPo2Detail2NewSearch extends VwPo2Detail2New
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'POItemNum', 'ItemID', 'TMTID_GPU', 'TMTID_TPU', 'POID', 'POItemType', 'ItemPackID', 'POItemPackID'], 'integer'],
            [['PONum', 'PRNum', 'PCPlanNum', 'ItemDetail', 'PRPackunit', 'POPackUnit', 'DispUnit', 'PRUnit', 'POUnit'], 'safe'],
            [['PRPackQtyApprove', 'PRPackCostApprove', 'ItemPackSKUQty', 'PRApprovedOrderQty', 'PRApprovedUnitCost', 'POPackQtyApprove', 'POPackCostApprove', 'POApprovedUnitCost', 'POApprovedOrderQty', 'PRQty', 'PRUnitCost', 'PRExtenedCost', 'POQty', 'POUnitCost', 'POExtenedCost'], 'number'],
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
    public function search($params,$POID,$POItemType)
    {
        $query = VwPo2Detail2New::find();

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
            'POItemNum' => $this->POItemNum,
            'ItemID' => $this->ItemID,
            'TMTID_GPU' => $this->TMTID_GPU,
            'TMTID_TPU' => $this->TMTID_TPU,
            'POID' => $this->POID,
            'POItemType' => $this->POItemType,
            'PRPackQtyApprove' => $this->PRPackQtyApprove,
            'PRPackCostApprove' => $this->PRPackCostApprove,
            'ItemPackID' => $this->ItemPackID,
            'ItemPackSKUQty' => $this->ItemPackSKUQty,
            'PRApprovedOrderQty' => $this->PRApprovedOrderQty,
            'PRApprovedUnitCost' => $this->PRApprovedUnitCost,
            'POPackQtyApprove' => $this->POPackQtyApprove,
            'POPackCostApprove' => $this->POPackCostApprove,
            'POItemPackID' => $this->POItemPackID,
            'POApprovedUnitCost' => $this->POApprovedUnitCost,
            'POApprovedOrderQty' => $this->POApprovedOrderQty,
            'PRQty' => $this->PRQty,
            'PRUnitCost' => $this->PRUnitCost,
            'PRExtenedCost' => $this->PRExtenedCost,
            'POQty' => $this->POQty,
            'POUnitCost' => $this->POUnitCost,
            'POExtenedCost' => $this->POExtenedCost,
        ]);

        $query->orFilterWhere(['like', 'PONum', $this->PONum])
            ->orFilterWhere(['like', 'PRNum', $this->PRNum])
            ->orFilterWhere(['like', 'PCPlanNum', $this->PCPlanNum])
            ->orFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
            ->orFilterWhere(['like', 'PRPackunit', $this->PRPackunit])
            ->orFilterWhere(['like', 'POPackUnit', $this->POPackUnit])
            ->orFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->orFilterWhere(['like', 'PRUnit', $this->PRUnit])
            ->orFilterWhere(['like', 'POUnit', $this->POUnit])
            ->andWhere(['POID'=>$POID])
            ->andWhere(['POItemType'=>$POItemType]);

        return $dataProvider;
    }
}
