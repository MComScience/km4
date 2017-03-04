<?php

namespace app\modules\chemos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemos\models\VwStdTrpChemoDetail2;

/**
 * VwStdTrpChemoDetail2Search represents the model behind the search form about `app\modules\chemos\models\VwStdTrpChemoDetail2`.
 */
class VwStdTrpChemoDetail2Search extends VwStdTrpChemoDetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id', 'std_trp_chemo_id', 'chemo_cycle_seq1', 'chemo_cycle_day'], 'integer'],
            [['chemo_cycle_seq', 'q', 'chemo_detail'], 'safe'],
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
        $query = VwStdTrpChemoDetail2::find()->where(['std_trp_chemo_id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['chemo_cycle_seq1'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'drugset_id' => $this->drugset_id,
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
            'chemo_cycle_seq1' => $this->chemo_cycle_seq1,
            'chemo_cycle_day' => $this->chemo_cycle_day,
        ]);

        $query->andFilterWhere(['like', 'chemo_cycle_seq', $this->chemo_cycle_seq])
            ->andFilterWhere(['like', 'q', $this->q])
            ->andFilterWhere(['like', 'chemo_detail', $this->chemo_detail]);

        return $dataProvider;
    }
}
