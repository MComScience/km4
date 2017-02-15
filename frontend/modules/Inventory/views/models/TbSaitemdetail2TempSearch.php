<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbSaitemdetail2Temp;

/**
 * TbSaitemdetail2TempSearch represents the model behind the search form about `app\modules\Inventory\models\TbSaitemdetail2Temp`.
 */
class TbSaitemdetail2TempSearch extends TbSaitemdetail2Temp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'SAID', 'ItemID', 'SAItemInternalLotNum', 'SAItemPackID__add', 'SAItemPackID_deduct', 'SAItemNumStatusID', 'SRCreatedBy'], 'integer'],
            [['SANum'], 'safe'],
            [['SAPackQty_add', 'SAPackUnitCost__add', 'SAItemQty__add', 'SAItemUnitCost__add', 'SAPackQty_deduct', 'SAPackUnitCost_deduct', 'SAItemQty_deduct', 'SAItemUnitCost_deduct'], 'number'],
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
        $query = TbSaitemdetail2Temp::find();

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
            'SAID' => $this->SAID,
            'ItemID' => $this->ItemID,
            'SAItemInternalLotNum' => $this->SAItemInternalLotNum,
            'SAPackQty_add' => $this->SAPackQty_add,
            'SAItemPackID__add' => $this->SAItemPackID__add,
            'SAPackUnitCost__add' => $this->SAPackUnitCost__add,
            'SAItemQty__add' => $this->SAItemQty__add,
            'SAItemUnitCost__add' => $this->SAItemUnitCost__add,
            'SAPackQty_deduct' => $this->SAPackQty_deduct,
            'SAItemPackID_deduct' => $this->SAItemPackID_deduct,
            'SAPackUnitCost_deduct' => $this->SAPackUnitCost_deduct,
            'SAItemQty_deduct' => $this->SAItemQty_deduct,
            'SAItemUnitCost_deduct' => $this->SAItemUnitCost_deduct,
            'SAItemNumStatusID' => $this->SAItemNumStatusID,
            'SRCreatedBy' => $this->SRCreatedBy,
        ]);

        $query->andFilterWhere(['like', 'SANum', $this->SANum]);

        return $dataProvider;
    }
}
