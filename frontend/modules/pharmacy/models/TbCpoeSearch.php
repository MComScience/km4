<?php

namespace app\modules\pharmacy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pharmacy\models\TbCpoe;

/**
 * TbCpoeSearch represents the model behind the search form about `app\modules\pharmacy\models\TbCpoe`.
 */
class TbCpoeSearch extends TbCpoe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id', 'cpoe_schedule_type', 'cpoe_type', 'pt_vn_number', 'cpoe_order_by', 'cpoe_order_section', 'cpoe_status', 'cpoe_createby', 'pt_trp_chemo_id', 'chemo_regimen_ids', 'chemo_cycle_seq', 'chemo_cycle_day', 'drugset_id'], 'integer'],
            [['cpoe_num', 'cpoe_date', 'cpoe_comment', 'pt_trp_regimen_paycode'], 'safe'],
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
        $query = TbCpoe::find();

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
            'cpoe_id' => $this->cpoe_id,
            'cpoe_schedule_type' => $this->cpoe_schedule_type,
            'cpoe_type' => $this->cpoe_type,
            'pt_vn_number' => $this->pt_vn_number,
            'cpoe_date' => $this->cpoe_date,
            'cpoe_order_by' => $this->cpoe_order_by,
            'cpoe_order_section' => $this->cpoe_order_section,
            'cpoe_status' => $this->cpoe_status,
            'cpoe_createby' => $this->cpoe_createby,
            'pt_trp_chemo_id' => $this->pt_trp_chemo_id,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'chemo_cycle_seq' => $this->chemo_cycle_seq,
            'chemo_cycle_day' => $this->chemo_cycle_day,
            'drugset_id' => $this->drugset_id,
        ]);

        $query->andFilterWhere(['like', 'cpoe_num', $this->cpoe_num])
            ->andFilterWhere(['like', 'cpoe_comment', $this->cpoe_comment])
            ->andFilterWhere(['like', 'pt_trp_regimen_paycode', $this->pt_trp_regimen_paycode]);

        return $dataProvider;
    }
}
