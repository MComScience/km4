<?php

namespace app\modules\pharmacy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pharmacy\models\TbStdTrpChemo;

/**
 * TbStdTrpChemoSearch represents the model behind the search form about `app\modules\pharmacy\models\TbStdTrpChemo`.
 */
class TbStdTrpChemoSearch extends TbStdTrpChemo {

    public $q;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['std_trp_chemo_id', 'credit_group_id', 'std_trp_regimen_createby', 'std_trp_regimen_status'], 'integer'],
                [['std_trp_regimen_name', 'medical_right_id', 'std_trp_regimen_id', 'std_trp_credit_id', 'std_trp_regimen_paycode', 'std_trp_comment', 'std_trp_regimen_date', 'dx_code', 'ca_stage_code', 'regimen_for_cr', 'std_trp_for_op', 'std_trp_for_ip', 'drugset_type','q'], 'safe'],
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
        $query = TbStdTrpChemo::find();

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
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
            'credit_group_id' => $this->credit_group_id,
            'std_trp_regimen_createby' => $this->std_trp_regimen_createby,
            'std_trp_regimen_date' => $this->std_trp_regimen_date,
            'std_trp_regimen_status' => $this->std_trp_regimen_status,
        ]);

        $query->andFilterWhere(['like', 'std_trp_regimen_name', $this->std_trp_regimen_name])
                ->andFilterWhere(['like', 'medical_right_id', $this->medical_right_id])
                ->andFilterWhere(['like', 'std_trp_regimen_id', $this->std_trp_regimen_id])
                ->andFilterWhere(['like', 'std_trp_credit_id', $this->std_trp_credit_id])
                ->andFilterWhere(['like', 'std_trp_regimen_paycode', $this->std_trp_regimen_paycode])
                ->andFilterWhere(['like', 'std_trp_comment', $this->std_trp_comment])
                ->andFilterWhere(['like', 'dx_code', $this->dx_code])
                ->andFilterWhere(['like', 'ca_stage_code', $this->ca_stage_code])
                ->andFilterWhere(['like', 'regimen_for_cr', $this->regimen_for_cr])
                ->andFilterWhere(['like', 'std_trp_for_op', $this->std_trp_for_op])
                ->andFilterWhere(['like', 'std_trp_for_ip', $this->std_trp_for_ip])
                ->andFilterWhere(['like', 'drugset_type', $this->drugset_type]);

        return $dataProvider;
    }

    public function search_chemo($params) {
        $query = TbStdTrpChemo::find();

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
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
            'credit_group_id' => $this->credit_group_id,
            'std_trp_regimen_createby' => $this->std_trp_regimen_createby,
            'std_trp_regimen_date' => $this->std_trp_regimen_date,
            'std_trp_regimen_status' => $this->std_trp_regimen_status,
        ]);

        $query->andFilterWhere(['like', 'std_trp_regimen_name', $this->std_trp_regimen_name])
                ->andFilterWhere(['like', 'medical_right_id', $this->medical_right_id])
                ->andFilterWhere(['like', 'std_trp_regimen_id', $this->std_trp_regimen_id])
                ->andFilterWhere(['like', 'std_trp_credit_id', $this->std_trp_credit_id])
                ->andFilterWhere(['like', 'std_trp_regimen_paycode', $this->std_trp_regimen_paycode])
                ->andFilterWhere(['like', 'std_trp_comment', $this->std_trp_comment])
                ->andFilterWhere(['like', 'dx_code', $this->dx_code])
                ->andFilterWhere(['like', 'ca_stage_code', $this->ca_stage_code])
                ->andFilterWhere(['like', 'regimen_for_cr', $this->regimen_for_cr])
                ->andFilterWhere(['like', 'std_trp_for_op', $this->std_trp_for_op])
                ->andFilterWhere(['like', 'std_trp_for_ip', $this->std_trp_for_ip])
                ->andFilterWhere(['like', 'drugset_type', $this->drugset_type])
                ->andWhere(['drugset_type' => 'CHEMO']);

        return $dataProvider;
    }
    
    public function search_homemed($params) {
        $query = TbStdTrpChemo::find();

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
            'std_trp_chemo_id' => $this->std_trp_chemo_id,
            'credit_group_id' => $this->credit_group_id,
            'std_trp_regimen_createby' => $this->std_trp_regimen_createby,
            'std_trp_regimen_date' => $this->std_trp_regimen_date,
            'std_trp_regimen_status' => $this->std_trp_regimen_status,
        ]);

        $query->andFilterWhere(['like', 'std_trp_regimen_name', $this->std_trp_regimen_name])
                ->andFilterWhere(['like', 'medical_right_id', $this->medical_right_id])
                ->andFilterWhere(['like', 'std_trp_regimen_id', $this->std_trp_regimen_id])
                ->andFilterWhere(['like', 'std_trp_credit_id', $this->std_trp_credit_id])
                ->andFilterWhere(['like', 'std_trp_regimen_paycode', $this->std_trp_regimen_paycode])
                ->andFilterWhere(['like', 'std_trp_comment', $this->std_trp_comment])
                ->andFilterWhere(['like', 'dx_code', $this->dx_code])
                ->andFilterWhere(['like', 'ca_stage_code', $this->ca_stage_code])
                ->andFilterWhere(['like', 'regimen_for_cr', $this->regimen_for_cr])
                ->andFilterWhere(['like', 'std_trp_for_op', $this->std_trp_for_op])
                ->andFilterWhere(['like', 'std_trp_for_ip', $this->std_trp_for_ip])
                ->andFilterWhere(['like', 'drugset_type', $this->drugset_type])
                ->andWhere(['drugset_type' => 'HOME MED']);

        return $dataProvider;
    }

}
