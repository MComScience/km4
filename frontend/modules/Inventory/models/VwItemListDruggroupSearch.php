<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwItemListDruggroup;

/**
 * VwItemListDruggroupSearch represents the model behind the search form about `app\modules\Inventory\models\VwItemListDruggroup`.
 */
class VwItemListDruggroupSearch extends VwItemListDruggroup {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['DrugClassID', 'DrugSubClassID', 'ItemID', 'Item_workingcode'], 'integer'],
            [['DrugClass', 'DrugSubClass', 'FNS_GP', 'ItemName', 'ISED', 'druggroup', 'ItemPrice'], 'safe'],
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
    public function search($params) {
        $query = VwItemListDruggroup::find();

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
            'DrugClassID' => $this->DrugClassID,
            'DrugSubClassID' => $this->DrugSubClassID,
            'ItemID' => $this->ItemID,
            'Item_workingcode' => $this->Item_workingcode,
        ]);

        $query->andFilterWhere(['like', 'DrugClass', $this->DrugClass])
                ->andFilterWhere(['like', 'DrugSubClass', $this->DrugSubClass])
                ->andFilterWhere(['like', 'FNS_GP', $this->FNS_GP])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'ISED', $this->ISED])
                ->andFilterWhere(['like', 'druggroup', $this->druggroup])
                ->andFilterWhere(['like', 'ItemPrice', $this->ItemPrice]);
        $query->orderBy('DrugClassID ASC');
        return $dataProvider;
    }

}
