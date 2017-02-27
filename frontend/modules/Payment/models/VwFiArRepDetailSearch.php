<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiArRepDetail;

/**
 * VwFiArRepDetailSearch represents the model behind the search form about `app\modules\Payment\models\VwFiArRepDetail`.
 */
class VwFiArRepDetailSearch extends VwFiArRepDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_rep_ids', 'ar_rep_id', 'nhso_inv_ids', 'nhso_inv_id', 'rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'pt_admission_number', 'ar_paid_amt', 'ItemStatus'], 'integer'],
            [['doc_type', 'pid', 'pt_name', 'pt_visit_type', 'pt_registry_datetime', 'pt_discharge_datetime', 'refer_hsender_doc_id', 'paid_by'], 'safe'],
            [['fpnhso_piad', 'affiliation_piad', 'ar_amt', 'ar_amt_left'], 'number'],
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
    public function search($params,$ar_rep_id)
    {
        $query = VwFiArRepDetail::find();

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
            'ar_rep_ids' => $this->ar_rep_ids,
            'ar_rep_id' => $this->ar_rep_id,
            'nhso_inv_ids' => $this->nhso_inv_ids,
            'nhso_inv_id' => $this->nhso_inv_id,
            'rep' => $this->rep,
            'rep_seq' => $this->rep_seq,
            'tran_id' => $this->tran_id,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_registry_datetime' => $this->pt_registry_datetime,
            'pt_discharge_datetime' => $this->pt_discharge_datetime,
            'fpnhso_piad' => $this->fpnhso_piad,
            'affiliation_piad' => $this->affiliation_piad,
            'ar_amt' => $this->ar_amt,
            'ar_paid_amt' => $this->ar_paid_amt,
            'ar_amt_left' => $this->ar_amt_left,
            'ItemStatus' => $this->ItemStatus,
        ]);

        $query->orFilterWhere(['like', 'doc_type', $this->doc_type])
            ->orFilterWhere(['like', 'pid', $this->pid])
            ->orFilterWhere(['like', 'pt_name', $this->pt_name])
            ->orFilterWhere(['like', 'pt_visit_type', $this->pt_visit_type])
            ->orFilterWhere(['like', 'refer_hsender_doc_id', $this->refer_hsender_doc_id])
            ->orFilterWhere(['like', 'paid_by', $this->paid_by])
            ->andWhere(['ar_rep_id'=>$ar_rep_id]);

        return $dataProvider;
    }
}
