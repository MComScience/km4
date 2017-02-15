<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbItemlotnum2Temp;

/**
 * TbItemlotnum2TempSearch represents the model behind the search form about `app\modules\Inventory\models\TbItemlotnum2Temp`.
 */
class TbItemlotnum2TempSearch extends TbItemlotnum2Temp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'LNCreatedBy', 'LNItemStatusID', 'ids_gr'], 'integer'],
            [['ItemExternalLotNum', 'ItemExpDate', 'GRNum'], 'safe'],
            [['LNPackQty', 'LNPackUnitCost', 'LNItemQty', 'LNItemUnitCost'], 'number'],
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
    public function search($params,$ItemID,$GRID)
    {
        $query = TbItemlotnum2Temp::find()
                ->where(['ItemID'=>$ItemID,'GRID'=>$GRID]);

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
            'LNCreatedBy' => $this->LNCreatedBy,
            'LNItemStatusID' => $this->LNItemStatusID,
            'ids_gr' => $this->ids_gr,
            'GRNum' => $this->GRNum,
            'GRID' => $this->GRID,
        ]);

        $query->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->andFilterWhere(['like', 'GRNum', $this->GRNum]);

        return $dataProvider;
    }
    public function SearchEditdetail($params, $ids_gr)
    {
        $query = TbItemlotnum2Temp::find()
                ->where(['ids_gr'=>$ids_gr]);

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
            'LNCreatedBy' => $this->LNCreatedBy,
            'LNItemStatusID' => $this->LNItemStatusID,
            'ids_gr' => $this->ids_gr,
            'GRNum' => $this->GRNum,
            'GRID' => $this->GRID,
        ]);

        $query->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->andFilterWhere(['like', 'GRNum', $this->GRNum]);

        return $dataProvider;
    }
    public function searcheidt($params,$ItemID,$GRID)
    {
        $query = TbItemlotnum2Temp::find()
                ->where(['ItemID'=>$ItemID,'GRID'=>$GRID,'LNItemStasusID'=>2]);

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
            'LNCreatedBy' => $this->LNCreatedBy,
            'LNItemStatusID' => $this->LNItemStatusID,
            'ids_gr' => $this->ids_gr,
            'GRNum' => $this->GRNum,
            'GRID' => $this->GRID,
        ]);

        $query->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->andFilterWhere(['like', 'GRNum', $this->GRNum]);

        return $dataProvider;
    }
}