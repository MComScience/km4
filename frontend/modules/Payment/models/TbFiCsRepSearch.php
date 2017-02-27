<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\TbFiCsRep;

/**
 * TbFiCsRepSearch represents the model behind the search form about `app\modules\Payment\models\TbFiCsRep`.
 */
class TbFiCsRepSearch extends TbFiCsRep
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cs_rep_id', 'import_by'], 'integer'],
            [['claim_num', 'rep', 'report_filename', 'report_date', 'report_time', 'Import_date', 'doc_type'], 'safe'],
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
        $query = TbFiCsRep::find();

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
            'cs_rep_id' => $this->cs_rep_id,
            'report_date' => $this->report_date,
            'report_time' => $this->report_time,
            'import_by' => $this->import_by,
            'Import_date' => $this->Import_date,
        ]);

        $query->andFilterWhere(['like', 'claim_num', $this->claim_num])
            ->andFilterWhere(['like', 'rep', $this->rep])
            ->andFilterWhere(['like', 'report_filename', $this->report_filename])
            ->andFilterWhere(['like', 'doc_type', $this->doc_type]);

        return $dataProvider;
    }
}
