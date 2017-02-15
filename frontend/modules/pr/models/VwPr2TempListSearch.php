<?php

namespace app\modules\pr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pr\models\VwPr2TempList;

/**
 * VwPr2TempListSearch represents the model behind the search form about `app\modules\pr\models\VwPr2TempList`.
 */
class VwPr2TempListSearch extends VwPr2TempList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRTypeID', 'POTypeID', 'PRExpectDate', 'PRStatusID', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PRDate', 'PRType', 'POType', 'PRStatus'], 'safe'],
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
        $query = VwPr2TempList::find();

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
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'PRTypeID' => $this->PRTypeID,
            'POTypeID' => $this->POTypeID,
            'PRExpectDate' => $this->PRExpectDate,
            'PRStatusID' => $this->PRStatusID,
            'ids_PR_selected' => $this->ids_PR_selected,
        ]);

        $query->andFilterWhere(['like', 'PRNum', $this->PRNum])
            ->andFilterWhere(['like', 'PRType', $this->PRType])
            ->andFilterWhere(['like', 'POType', $this->POType])
            ->andFilterWhere(['like', 'PRStatus', $this->PRStatus]);

        return $dataProvider;
    }
}
