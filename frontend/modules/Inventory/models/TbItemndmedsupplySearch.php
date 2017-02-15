<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbItemndmedsupply;

/**
 * TbItemndmedsupplySearch represents the model behind the search form about `app\modules\Inventory\models\TbItemndmedsupply`.
 */
class TbItemndmedsupplySearch extends TbItemndmedsupply
{
public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemNDMedSupplyCatID', 'ItemNDMedSupplyCatID_sub'], 'integer'],
            [['ItemNDMedSupply', 'ItemNDMedSupplyDesc','q'], 'safe'],
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
        $query = TbItemndmedsupply::find();

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
            'ItemNDMedSupplyCatID' => $this->ItemNDMedSupplyCatID,
            'ItemNDMedSupplyCatID_sub' => $this->ItemNDMedSupplyCatID_sub,
        ]);

        $query->andFilterWhere(['like', 'ItemNDMedSupply', $this->q])
            ->andFilterWhere(['like', 'ItemNDMedSupplyDesc', $this->q]);

        return $dataProvider;
    }
}
