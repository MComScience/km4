<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbStitemdetail2;

/**
 * TbStitemdetail2Search represents the model behind the search form about `app\modules\Inventory\models\TbStitemdetail2`.
 */
class TbStitemdetail2Search extends TbStitemdetail2 {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'STID', 'ItemID', 'ItemInternalLotNum', 'STItemPackID', 'STItemNumStatusID', 'STCreatedBy'], 'integer'],
            [['STNum'], 'safe'],
            [['STPackQty', 'STPackUnitCost', 'STItemQty', 'STItemUnitCost'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params, $id) {
        $query = TbStitemdetail2::find();

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

        $query->andFilterWhere(['like', 'STNum', $this->STNum])
                ->andFilterWhere(['like', 'STID', $id]);

        return $dataProvider;
    }

     public function SearchHistoryClaim($params, $STID) {
        $query = TbStitemdetail2::find()
                ->where(['STID'=>$STID]);

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

        $query->andFilterWhere(['like', 'STNum', $this->STNum])
                ->andFilterWhere(['like', 'STID', $this->STID]);

        return $dataProvider;
    }
    public function SearchHistoryLend($params, $STID) {
        $query = TbStitemdetail2::find()
                ->where(['STID'=>$STID]);

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

        $query->andFilterWhere(['like', 'STNum', $this->STNum])
                ->andFilterWhere(['like', 'STID', $this->STID]);

        return $dataProvider;
    }


    public function Detailsearch($params,$ids)
    {
        $query = TbStitemdetail2::find()
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

}
