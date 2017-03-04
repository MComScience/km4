<?php

namespace app\modules\chemo\models\std;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemo\models\std\VwStdDrugsetDetail;

/**
 * VwStdDrugsetDetailSearch represents the model behind the search form about `app\modules\chemo\models\std\VwStdDrugsetDetail`.
 */
class VwStdDrugsetDetailSearch extends VwStdDrugsetDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_id', 'chemo_regimen_paycode', 'chemo_cycle_seq', 'chemo_cycle_day', 'chemo_regimen_cycleqty', 'chemo_regimen_freq_value', 'chemo_regimen_freq_unit', 'chemo_regimen_peroid_value', 'chemo_regimen_peroid_unit', 'drugset_status', 'drugset_createby', 'std_trp_chemo_id'], 'integer'],
            [['chemo_regimen_name', 'drugset_comment', 'drugset_tage', 'chemo_detail', 'chemo_sig'], 'safe'],
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
    public function search($params,$trp_chemo_id)
    {
        $query = VwStdDrugsetDetail::find()->where(['std_trp_chemo_id' => $trp_chemo_id]);

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
            'chemo_regimen_cycleqty' => $this->chemo_regimen_cycleqty,
            'chemo_regimen_freq_value' => $this->chemo_regimen_freq_value,
            'chemo_regimen_freq_unit' => $this->chemo_regimen_freq_unit,
            'chemo_regimen_peroid_value' => $this->chemo_regimen_peroid_value,
            'chemo_regimen_peroid_unit' => $this->chemo_regimen_peroid_unit,
            'drugset_status' => $this->drugset_status,
            'drugset_createby' => $this->drugset_createby,
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
        ]);

        $query->andFilterWhere(['like', 'chemo_regimen_name', $this->chemo_regimen_name])
            ->andFilterWhere(['like', 'drugset_comment', $this->drugset_comment])
            ->andFilterWhere(['like', 'drugset_tage', $this->drugset_tage])
            ->andFilterWhere(['like', 'chemo_detail', $this->chemo_detail])
            ->andFilterWhere(['like', 'chemo_sig', $this->chemo_sig]);

        return $dataProvider;
    }
}
