<?php

namespace app\modules\pharmacy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pharmacy\models\VwPtTrpChemoDetail2;

/**
 * VwPtTrpChemoDetail2Search represents the model behind the search form about `app\modules\pharmacy\models\VwPtTrpChemoDetail2`.
 */
class VwPtTrpChemoDetail2Search extends VwPtTrpChemoDetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id', 'chemo_regimen_paycode', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_status', 'drugset_createby', 'std_trp_chemo_id'], 'integer'],
            [['chemo_regimen_name', 'q', 'chemo_detail', 'trplan', 'progress', 'drugset_comment', 'drugset_tage'], 'safe'],
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
    public function search($params,$data)
    {
        $query = VwPtTrpChemoDetail2::find()->where(['std_trp_chemo_id' => $data]);

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
            'drugset_id' => $this->drugset_id,
            'chemo_regimen_paycode' => $this->chemo_regimen_paycode,
            'chemo_cycle_seq' => $this->chemo_cycle_seq,
            'chemo_cycle_day' => $this->chemo_cycle_day,
            'drugset_status' => $this->drugset_status,
            'drugset_createby' => $this->drugset_createby,
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
        ]);

        $query->andFilterWhere(['like', 'chemo_regimen_name', $this->chemo_regimen_name])
            ->andFilterWhere(['like', 'q', $this->q])
            ->andFilterWhere(['like', 'chemo_detail', $this->chemo_detail])
            ->andFilterWhere(['like', 'trplan', $this->trplan])
            ->andFilterWhere(['like', 'progress', $this->progress])
            ->andFilterWhere(['like', 'drugset_comment', $this->drugset_comment])
            ->andFilterWhere(['like', 'drugset_tage', $this->drugset_tage]);

        return $dataProvider;
    }
}
