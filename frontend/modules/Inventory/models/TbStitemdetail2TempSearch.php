<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbStitemdetail2Temp;

/**
 * TbStitemdetail2TempSearch represents the model behind the search form about `app\modules\Inventory\models\TbStitemdetail2Temp`.
 */
class TbStitemdetail2TempSearch extends TbStitemdetail2Temp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'STItemNumStatusID', 'STCreatedBy'], 'integer'],
            [['STNum'], 'safe'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost'], 'number'],
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
    public $q;
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TbStitemdetail2Temp::find();

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
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemNumStatusID' => $this->STItemNumStatusID,
            'STCreatedBy' => $this->STCreatedBy,
            'STItemUnitCost' => $this->STItemUnitCost,
        ]);

        $query->andFilterWhere(['like', 'STNum', $this->STNum]);

        return $dataProvider;
    }
    
     public function searchstid($params,$STID)
    {
        $query = TbStitemdetail2Temp::find();

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
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemNumStatusID' => $this->STItemNumStatusID,
            'STCreatedBy' => $this->STCreatedBy,
            'STItemUnitCost' => $this->STItemUnitCost,
        ]);

        $query->andFilterWhere(['like', 'STID', $STID]);

        return $dataProvider;
    }
    public function Detailsearch($params,$ids)
    {
        $query = TbStitemdetail2Temp::find()
        ->where(['ids' => $ids]);

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
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemNumStatusID' => $this->STItemNumStatusID,
            'STCreatedBy' => $this->STCreatedBy,
            'STItemUnitCost' => $this->STItemUnitCost,
        ]);

        $query->andFilterWhere(['like', 'STNum', $this->STNum]);

        return $dataProvider;
    }
    public function SearchType1($params,$STID) {
        $query = TbStitemdetail2Temp::find()
        ->where(['STID' => $STID]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STID' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 5,
            ],
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
            'STPackQty' => $this->STPackQty,
            'STPackUnitCost' => $this->STPackUnitCost,
            'STItemPackID' => $this->STItemPackID,
            'STItemQty' => $this->STItemQty,
            'STItemNumStatusID' => $this->STItemNumStatusID,
            'STCreatedBy' => $this->STCreatedBy,
            'STItemUnitCost' => $this->STItemUnitCost, 
        ]);

        $query->orFilterWhere(['like', 'ids', $this->q])
                ->orFilterWhere(['like', 'STID', $this->q])
                ->orFilterWhere(['like', 'ItemID', $this->q])
                ->orFilterWhere(['like', 'ItemInternalLotNum', $this->q])
                ->orFilterWhere(['like', 'STPackQty', $this->q])
                ->orFilterWhere(['like', 'STPackUnitCost', $this->q])
                ->orFilterWhere(['like', 'STItemPackID', $this->q])
                ->orFilterWhere(['like', 'STItemQty', $this->q])
                ->orFilterWhere(['like', 'STItemNumStatusID', $this->q])
                ->orFilterWhere(['like', 'STCreatedBy', $this->q])
                ->orFilterWhere(['like', 'STItemUnitCost', $this->q]);
        return $dataProvider;
    }
}
