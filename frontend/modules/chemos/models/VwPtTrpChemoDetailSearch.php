<?php

namespace app\modules\chemo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemo\models\VwPtTrpChemoDetail;

/**
 * VwPtTrpChemoDetailSearch represents the model behind the search form about `app\modules\chemo\models\VwPtTrpChemoDetail`.
 */
class VwPtTrpChemoDetailSearch extends VwPtTrpChemoDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chemo_regimen_ids', 'chemo_regimen_id', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_ids', 'pt_trp_chemo_id', 'drugset_id', 'pt_visit_number'], 'integer'],
            [['q', 'chemo_detail', 'trplan', 'progress'], 'safe'],
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
    public function search($params,$pt_trp_chemo_id)
    {
        $query = VwPtTrpChemoDetail::find()->where(['pt_trp_chemo_id' => $pt_trp_chemo_id]);

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
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'chemo_regimen_id' => $this->chemo_regimen_id,
            'chemo_cycle_seq' => $this->chemo_cycle_seq,
            'chemo_cycle_day' => $this->chemo_cycle_day,
            'drugset_ids' => $this->drugset_ids,
            'pt_trp_chemo_id' => $this->pt_trp_chemo_id,
            'drugset_id' => $this->drugset_id,
            'pt_visit_number' => $this->pt_visit_number,
        ]);

        $query->andFilterWhere(['like', 'q', $this->q])
            ->andFilterWhere(['like', 'chemo_detail', $this->chemo_detail])
            ->andFilterWhere(['like', 'trplan', $this->trplan])
            ->andFilterWhere(['like', 'progress', $this->progress]);

        return $dataProvider;
    }
}
