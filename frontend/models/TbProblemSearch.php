<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TbProblem;

/**
 * TbProblemSearch represents the model behind the search form about `app\models\TbProblem`.
 */
class TbProblemSearch extends TbProblem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_by', 'update_by', 'status'], 'integer'],
            [['subject', 'details', 'ref', 'create_date'], 'safe'],
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
        $query = TbProblem::find();

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
            'id' => $this->id,
            'create_by' => $this->create_by,
            'update_by' => $this->update_by,
            'create_date' => $this->create_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'ref', $this->ref]);

        return $dataProvider;
    }
}
