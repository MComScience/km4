<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2Gr2DetailGroup2;

/**
 * VwSt2Gr2DetailGroupSearch represents the model behind the search form about `app\modules\Inventory\models\VwSt2Gr2DetailGroup2`.
 */
class VwSt2Gr2DetailGroup2Search extends VwSt2Gr2DetailGroup2
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
        $query = VwSt2Gr2DetailGroup2::find();

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

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->orFilterWhere(['like', 'GRItemPackSKUQty', $this->q])
            ->orFilterWhere(['like', 'PackUnit', $this->q])
            ->orFilterWhere(['like', 'DispUnit', $this->q])
            ->orFilterWhere(['like', 'GRUnit', $this->q])
            ->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'PackUnitST', $this->q])
            ->orFilterWhere(['like', 'DispUnitST', $this->q])
            ->orFilterWhere(['like', 'STUnit', $this->q]);

        return $dataProvider;
    }
    
     public function SearchLond($params,$GRID,$STID)
    {
        $query = VwSt2Gr2DetailGroup2::find()
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

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'ItemName', $this->q])
            ->orFilterWhere(['like', 'GRItemPackSKUQty', $this->q])
            ->orFilterWhere(['like', 'PackUnit', $this->q])
            ->orFilterWhere(['like', 'DispUnit', $this->q])
            ->orFilterWhere(['like', 'GRUnit', $this->q])
            ->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'PackUnitST', $this->q])
            ->orFilterWhere(['like', 'DispUnitST', $this->q])
            ->orFilterWhere(['like', 'STUnit', $this->q]);

        return $dataProvider;
    }
}
