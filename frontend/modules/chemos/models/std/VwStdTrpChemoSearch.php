<?php

namespace app\modules\chemo\models\std;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemos\models\VwStdTrpChemo;

/**
 * VwStdTrpChemoSearch represents the model behind the search form about `app\modules\chemo\models\std\VwStdTrpChemo`.
 */
class VwStdTrpChemoSearch extends VwStdTrpChemo {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['std_trp_chemo_id', 'credit_group_id', 'std_trp_regimen_createby', 'std_trp_regimen_status'], 'integer'],
            [['std_trp_regimen_name', 'medical_right_id', 'std_trp_regimen_id', 'std_trp_credit_id', 'std_trp_regimen_paycode', 'std_trp_comment', 'std_trp_chemo_name', 'dx_code', 'ca_stage_code', 'medical_right_desc', 'cpoe_status_decs', 'drugset_type','q'], 'safe'],
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
        $query = VwStdTrpChemo::find();

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
            'medical_right_id' => $this->medical_right_id,
            'dx_code' => $this->dx_code,
            'drugset_type' => $this->drugset_type,
            'credit_group_id' => $this->credit_group_id,
            'std_trp_regimen_createby' => $this->std_trp_regimen_createby,
            'std_trp_regimen_status' => $this->std_trp_regimen_status,
        ]);

        $query->orFilterWhere(['like', 'std_trp_regimen_name', $this->q])
                ->orFilterWhere(['like', 'std_trp_regimen_id', $this->q])
                ->orFilterWhere(['like', 'dx_code', $this->q])
                //->orFilterWhere(['like', 'drugset_type', $this->q])
                ->orFilterWhere(['like', 'std_trp_chemo_id', $this->q])
                ->orFilterWhere(['like', 'std_trp_credit_id', $this->q])
                ->orFilterWhere(['like', 'std_trp_regimen_paycode', $this->q])
                ->orFilterWhere(['like', 'std_trp_comment', $this->q])
                ->orFilterWhere(['like', 'std_trp_chemo_name', $this->q]);

        return $dataProvider;
    }

}
