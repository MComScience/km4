<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbStkTrans;

/**
 * TbStkSearch represents the model behind the search form about `app\modules\Inventory\models\TbStkTrans`.
 */
class TbStkSearch extends TbStkTrans
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkTransID', 'StkTransTypeID', 'StkID', 'ItemInternalLotNum', 'ItemID', 'ItemPackID', 'StkTransStatus', 'StkTransCreateBy'], 'integer'],
            [['StkTransDateTime', 'StkDocNum', 'ItemExpdate', 'ItemExternalLotNum'], 'safe'],
            [['ItemQtyOut', 'ItemQtyIn', 'ItemUnitCost', 'PackQtyOut', 'PackQtyIn', 'PackItemUnitCost'], 'number'],
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
        $query = TbStkTrans::find();

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
            'StkTransID' => $this->StkTransID,
            'StkTransTypeID' => $this->StkTransTypeID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            'ItemExpdate' => $this->ItemExpdate,
            'ItemInternalLotNum' => $this->ItemInternalLotNum,
            'ItemID' => $this->ItemID,
            'ItemQtyOut' => $this->ItemQtyOut,
            'ItemQtyIn' => $this->ItemQtyIn,
            'ItemUnitCost' => $this->ItemUnitCost,
            'PackQtyOut' => $this->PackQtyOut,
            'PackQtyIn' => $this->PackQtyIn,
            'ItemPackID' => $this->ItemPackID,
            'PackItemUnitCost' => $this->PackItemUnitCost,
            'StkTransStatus' => $this->StkTransStatus,
            'StkTransCreateBy' => $this->StkTransCreateBy,
        ]);

        $query->andFilterWhere(['like', 'StkDocNum', $this->StkDocNum])
            ->andFilterWhere(['like', 'ItemExternalLotNum', $this->ItemExternalLotNum]);

        return $dataProvider;
    }
}
