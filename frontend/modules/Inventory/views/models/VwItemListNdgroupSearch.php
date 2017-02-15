<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwItemListNdgroup;

/**
 * VwItemListNdgroupSearch represents the model behind the search form about `app\modules\Inventory\models\VwItemListNdgroup`.
 */
class VwItemListNdgroupSearch extends VwItemListNdgroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemNDMedSupplyCatID', 'ItemID'], 'integer'],
            [['ItemNDMedSupply', 'ItemName', 'ItemPrice'], 'safe'],
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
        $query = VwItemListNdgroup::find();

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
            'ItemID' => $this->ItemID,
        ]);

        $query->andFilterWhere(['like', 'ItemNDMedSupply', $this->ItemNDMedSupply])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'ItemPrice', $this->ItemPrice]);
 $query->orderBy('ItemNDMedSupplyCatID ASC');
        return $dataProvider;
    }
}
