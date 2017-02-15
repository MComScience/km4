<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbDrugclass;

/**
 * TbDrugclassSearch represents the model behind the search form about `app\modules\Inventory\models\TbDrugclass`.
 */
class TbDrugclassSearch extends TbDrugclass
{
 public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugClassID'], 'integer'],
            [['DrugClass', 'DrugClassDesc'], 'safe'],
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
        $query = TbDrugclass::find();

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
        ]);

        $query->andFilterWhere(['like', 'DrugClass', $this->DrugClass])
            ->andFilterWhere(['like', 'DrugClassDesc', $this->DrugClassDesc]);

        return $dataProvider;
    }
}
