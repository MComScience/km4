<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2DetailSub2;

/**
 * VwSt2DetailSub2Search represents the model behind the search form about `app\modules\Inventory\models\VwSt2DetailSub2`.
 */
class VwSt2DetailSub2Search extends VwSt2DetailSub2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'ItemPackUnit'], 'integer'],
            [['STNum', 'ItemExternalLotNum', 'ItemExpDate', 'STPackUnit', 'DispUnit', 'SRNum'], 'safe'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost', 'ItemPackSKUQty', 'STExtenedCost'], 'number'],
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
    public function search($params,$ids)
    {
        $query = VwSt2DetailSub2::find();

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
            'STID' => $this->STID,
            'ItemID' => $this->ItemID,
            'ItemInternalLotNum' => $this->ItemInternalLotNum,
            'ItemExpDate' => $this->ItemExpDate,
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemUnitCost' => $this->STItemUnitCost,
            'ItemPackSKUQty' => $this->ItemPackSKUQty,
            'ItemPackUnit' => $this->ItemPackUnit,
            'STExtenedCost' => $this->STExtenedCost,
        ]);

        $query->andFilterWhere(['like', 'STNum', $this->STNum])
            ->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->andFilterWhere(['like', 'STPackUnit', $this->STPackUnit])
            ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
            ->andFilterWhere(['like', 'SRNum', $this->SRNum])->andFilterWhere(['like', 'ids', $ids]);

        return $dataProvider;
    }
}