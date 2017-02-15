<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwRepUcOpipList;

/**
 * VwRepUcOpipListSearch represents the model behind the search form about `app\modules\Payment\models\VwRepUcOpipList`.
 */
class VwRepUcOpipListSearch extends VwRepUcOpipList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number', 'nhso_rep_id'], 'integer'],
            [['pt_name', 'pt_visit_type', 'pt_registry_datetime', 'pt_discharge_datetime', 'hmain', 'invoice_eclaim_num', 'import_by', 'Import_date', 'doc_type'], 'safe'],
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
    public function search($params,$key)
    {
        $query = VwRepUcOpipList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'rep' => $this->rep,
            'rep_seq' => $this->rep_seq,
            'tran_id' => $this->tran_id,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_registry_datetime' => $this->pt_registry_datetime,
            'pt_discharge_datetime' => $this->pt_discharge_datetime,
            'Import_date' => $this->Import_date,
            'nhso_rep_id' => $this->nhso_rep_id,
        ]);

        $query->orFilterWhere(['like', 'pt_name', $this->pt_name])
            ->orFilterWhere(['like', 'pt_visit_type', $this->pt_visit_type])
            ->orFilterWhere(['like', 'hmain', $this->hmain])
            ->orFilterWhere(['like', 'invoice_eclaim_num', $this->invoice_eclaim_num])
            ->orFilterWhere(['like', 'import_by', $this->import_by])
            ->orFilterWhere(['like', 'doc_type', $this->doc_type])
            ->andFilterWhere(['nhso_rep_id'=>$key]);

        return $dataProvider;
    }
}
