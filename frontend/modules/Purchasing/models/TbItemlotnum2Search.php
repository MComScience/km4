<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\TbItemlotnum2;

/**
 * TbItemlotnum2Search represents the model behind the search form about `app\modules\Purchasing\models\TbItemlotnum2`.
 */
class TbItemlotnum2Search extends TbItemlotnum2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemInternalLotNum', 'ItemID', 'LNItemPackID', 'LNCreatedBy', 'LNItemStatusID', 'ids_gr', 'GRID'], 'integer'],
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
    public function search($params,$id)
    {
        $query = TbItemlotnum2::find()->where(['ids_gr' => $id]);

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
            'GRID' => $this->GRID,
        ]);

        $query->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum])
            ->andFilterWhere(['like', 'GRNum', $this->GRNum]);

        return $dataProvider;
    }
}
