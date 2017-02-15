<?php

namespace app\modules\pharmacy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pharmacy\models\VwPtTrpChemo;

/**
 * VwPtTrpChemoSearch represents the model behind the search form about `app\modules\pharmacy\models\VwPtTrpChemo`.
 */
class VwPtTrpChemoSearch extends VwPtTrpChemo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_trp_chemo_id', 'pt_hospital_number', 'medical_right_id', 'credit_group_id', 'pt_trp_regimen_createby', 'pt_visit_number', 'pt_trp_regimen_status'], 'integer'],
            [['pt_trp_regimen_name', 'medical_right_desc', 'pt_trp_regimen_id', 'pt_trp_credit_id', 'pt_trp_regimen_paycode', 'pt_trp_cpr_number', 'pt_trp_ocpa_number', 'pt_trp_comment', 'pt_trp_chemo_name', 'cpoe_status_decs'], 'safe'],
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
        $query = VwPtTrpChemo::find()->where(['pt_visit_number' => $data]);

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
            'pt_trp_chemo_id' => $this->pt_trp_chemo_id,
            'pt_hospital_number' => $this->pt_hospital_number,
            'medical_right_id' => $this->medical_right_id,
            'credit_group_id' => $this->credit_group_id,
            'pt_trp_regimen_createby' => $this->pt_trp_regimen_createby,
            'pt_visit_number' => $this->pt_visit_number,
            'pt_trp_regimen_status' => $this->pt_trp_regimen_status,
        ]);

        $query->andFilterWhere(['like', 'pt_trp_regimen_name', $this->pt_trp_regimen_name])
            ->andFilterWhere(['like', 'medical_right_desc', $this->medical_right_desc])
            ->andFilterWhere(['like', 'pt_trp_regimen_id', $this->pt_trp_regimen_id])
            ->andFilterWhere(['like', 'pt_trp_credit_id', $this->pt_trp_credit_id])
            ->andFilterWhere(['like', 'pt_trp_regimen_paycode', $this->pt_trp_regimen_paycode])
            ->andFilterWhere(['like', 'pt_trp_cpr_number', $this->pt_trp_cpr_number])
            ->andFilterWhere(['like', 'pt_trp_ocpa_number', $this->pt_trp_ocpa_number])
            ->andFilterWhere(['like', 'pt_trp_comment', $this->pt_trp_comment])
            ->andFilterWhere(['like', 'pt_trp_chemo_name', $this->pt_trp_chemo_name])
            ->andFilterWhere(['like', 'cpoe_status_decs', $this->cpoe_status_decs]);

        return $dataProvider;
    }
}
