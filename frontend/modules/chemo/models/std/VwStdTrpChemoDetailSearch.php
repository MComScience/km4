<?php

namespace app\modules\chemo\models\std;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemo\models\std\VwStdTrpChemoDetail;

/**
 * VwStdTrpChemoDetailSearch represents the model behind the search form about `app\modules\chemo\models\std\VwStdTrpChemoDetail`.
 */
class VwStdTrpChemoDetailSearch extends VwStdTrpChemoDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['std_trp_chemo_ids', 'std_trp_chemo_id', 'drugset_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'std_trp_chemo_createby', 'std_trp_chemo_status'], 'integer'],
            [['chemo_detail', 'chemo_sig'], 'safe'],
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
    public function search_newstd($params,$id)
    {
        $query = VwStdTrpChemoDetail::find()->where(['std_trp_chemo_id' => $id]);

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
            'std_trp_chemo_ids' => $this->std_trp_chemo_ids,
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
            'drugset_ids' => $this->drugset_ids,
            'chemo_cycle_seq' => $this->chemo_cycle_seq,
            'chemo_cycle_day' => $this->chemo_cycle_day,
            'chemo_regimen_freq_value' => $this->chemo_regimen_freq_value,
            'chemo_regimen_freq_unit' => $this->chemo_regimen_freq_unit,
            'std_trp_chemo_createby' => $this->std_trp_chemo_createby,
            'std_trp_chemo_status' => $this->std_trp_chemo_status,
        ]);

        $query->andFilterWhere(['like', 'chemo_detail', $this->chemo_detail])
            ->andFilterWhere(['like', 'chemo_sig', $this->chemo_sig]);

        return $dataProvider;
    }
}
