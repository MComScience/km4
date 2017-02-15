<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwGr2LotAssignedDetail2;

/**
 * VwGr2LotAssignedDetail2Search represents the model behind the search form about `app\modules\Inventory\models\VwGr2LotAssignedDetail2`.
 */
class VwGr2LotAssignedDetail2Search extends VwGr2LotAssignedDetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'ItemPackUnit', 'ids_gr'], 'integer'],
            [['ItemExternalLotNum', 'ItemExpDate', 'PackUnit', 'DispUnit', 'LN_Detail', 'GRUnit'], 'safe'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost', 'ItemPackSKUQty', 'GRQty'], 'number'],
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
    public function search($params,$ids_gr)
    {
        $query = VwGr2LotAssignedDetail2::find();

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
            'ItemInternalLotNum' => $this->ItemInternalLotNum,
            'ItemID' => $this->ItemID,
            'ItemExpDate' => $this->ItemExpDate,
            'LNPackQty' => $this->LNPackQty,
            'LNPackUnitCost' => $this->LNPackUnitCost,
            'LNItemPackID' => $this->LNItemPackID,
            'LNItemQty' => $this->LNItemQty,
            'LNItemUnitCost' => $this->LNItemUnitCost,
            'ItemPackSKUQty' => $this->ItemPackSKUQty,
            'ItemPackUnit' => $this->ItemPackUnit,
            'ids_gr' => $this->ids_gr,
            'GRQty' => $this->GRQty,
        ]);

        $query->orFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->orFilterWhere(['like', 'PackUnit', $this->PackUnit])
            ->orFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->orFilterWhere(['like', 'LN_Detail', $this->LN_Detail])
            ->orFilterWhere(['like', 'GRUnit', $this->GRUnit])
            ->andWhere(['ids_gr'=>$ids_gr]);

        return $dataProvider;
    }
}
