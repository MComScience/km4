<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2Gr2DetailGroup;

/**
 * VwSt2Gr2DetailGroupSearch represents the model behind the search form about `app\modules\Inventory\models\VwSt2Gr2DetailGroup`.
 */
class VwSt2Gr2DetailGroupSearch extends VwSt2Gr2DetailGroup
{   
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'ids_gr', 'ItemID', 'GRItemPackID', 'STID', 'STItemPackID'], 'integer'],
            [['GRNum', 'ItemName', 'GRItemPackSKUQty', 'PackUnit', 'DispUnit', 'GRUnit', 'STNum', 'PackUnitST', 'DispUnitST', 'STUnit'], 'safe'],
            [['GRPackQty', 'GRPackUnitCost', 'GRItemQty', 'GRItemUnitCost', 'STSentQty', 'GRQty', 'STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost', 'STQty'], 'number'],
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
        $query = VwSt2Gr2DetailGroup::find();

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
            'GRID' => $this->GRID,
            'ids_gr' => $this->ids_gr,
            'ItemID' => $this->ItemID,
            'GRPackQty' => $this->GRPackQty,
            'GRPackUnitCost' => $this->GRPackUnitCost,
            'GRItemPackID' => $this->GRItemPackID,
            'GRItemQty' => $this->GRItemQty,
            'GRItemUnitCost' => $this->GRItemUnitCost,
            'STSentQty' => $this->STSentQty,
            'GRQty' => $this->GRQty,
            'STID' => $this->STID,
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemUnitCost' => $this->STItemUnitCost,
            'STQty' => $this->STQty,
        ]);

        $query->andFilterWhere(['like', 'GRNum', $this->q])
            ->andFilterWhere(['like', 'ItemName', $this->q])
            ->andFilterWhere(['like', 'GRItemPackSKUQty', $this->q])
            ->andFilterWhere(['like', 'PackUnit', $this->q])
            ->andFilterWhere(['like', 'DispUnit', $this->q])
            ->andFilterWhere(['like', 'GRUnit', $this->q])
            ->andFilterWhere(['like', 'STNum', $this->q])
            ->andFilterWhere(['like', 'PackUnitST', $this->q])
            ->andFilterWhere(['like', 'DispUnitST', $this->q])
            ->andFilterWhere(['like', 'STUnit', $this->q]);

        return $dataProvider;
    }
    
     public function SearchLond($params,$GRID,$STID)
    {
        $query = VwSt2Gr2DetailGroup::find()
                ->where(['GRID'=>$GRID,'STID'=>$STID]);

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
            'GRID' => $this->GRID,
            'ids_gr' => $this->ids_gr,
            'ItemID' => $this->ItemID,
            'GRPackQty' => $this->GRPackQty,
            'GRPackUnitCost' => $this->GRPackUnitCost,
            'GRItemPackID' => $this->GRItemPackID,
            'GRItemQty' => $this->GRItemQty,
            'GRItemUnitCost' => $this->GRItemUnitCost,
            'STSentQty' => $this->STSentQty,
            'GRQty' => $this->GRQty,
            'STID' => $this->STID,
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemUnitCost' => $this->STItemUnitCost,
            'STQty' => $this->STQty,
        ]);

        $query->andFilterWhere(['like', 'GRNum', $this->q])
            ->andFilterWhere(['like', 'ItemName', $this->q])
            ->andFilterWhere(['like', 'GRItemPackSKUQty', $this->q])
            ->andFilterWhere(['like', 'PackUnit', $this->q])
            ->andFilterWhere(['like', 'DispUnit', $this->q])
            ->andFilterWhere(['like', 'GRUnit', $this->q])
            ->andFilterWhere(['like', 'STNum', $this->q])
            ->andFilterWhere(['like', 'PackUnitST', $this->q])
            ->andFilterWhere(['like', 'DispUnitST', $this->q])
            ->andFilterWhere(['like', 'STUnit', $this->q]);

        return $dataProvider;
    }
}
