<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiRepList;

/**
 * VwFiRepListSearch represents the model behind the search form about `app\modules\Payment\models\VwFiRepList`.
 */
class VwFiRepListSearch extends VwFiRepList
{   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rep_id', 'inv_id', 'pt_hospital_number', 'pt_visit_number', 'pt_admission_number', 'createby', 'rep_status', 'rep_summary_id', 'rep_create_section'], 'integer'],
            [['rep_num', 'pt_name', 'repdate','q'], 'safe'],
            [['sum_cash', 'sum_creditcard', 'sum_cheque', 'sum_banktransfer', 'rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_left', 'rep_Amt_net'], 'number'],
        ];
    }
    public $q;
    public $rep_create_section;
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
    public function search($params,$rep_summary_id)
    {
        $query = VwFiRepList::find();

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
            'rep_id' => $this->rep_id,
            'inv_id' => $this->inv_id,
            'repdate' => $this->repdate,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_visit_number' => $this->pt_visit_number,
            'pt_admission_number' => $this->pt_admission_number,
            'createby' => $this->createby,
            'rep_status' => $this->rep_status,
            'sum_cash' => $this->sum_cash,
            'sum_creditcard' => $this->sum_creditcard,
            'sum_cheque' => $this->sum_cheque,
            'sum_banktransfer' => $this->sum_banktransfer,
            'rep_Amt_total' => $this->rep_Amt_total,
            'rep_Amt_discount' => $this->rep_Amt_discount,
            'rep_Amt_left' => $this->rep_Amt_left,
            'rep_Amt_net' => $this->rep_Amt_net,
            'rep_summary_id' => $this->rep_summary_id,
            'rep_create_section' => $this->rep_create_section,
        ]);

        $query->orFilterWhere(['like', 'rep_num', $this->q])
              ->orFilterWhere(['like', 'pt_hospital_number', $this->q])
              ->orFilterWhere(['like', 'pt_name', $this->q])
              //->andFilterWhere(['rep_status'=>'2']);
              ->andFilterWhere(['rep_summary_id'=>$rep_summary_id]);

        return $dataProvider;
    }
    public function SearchPatient($params)
    {
        $query = VwFiRepList::find();

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
            'rep_id' => $this->rep_id,
            'inv_id' => $this->inv_id,
            //'repdate' => $this->repdate,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_visit_number' => $this->pt_visit_number,
            'pt_admission_number' => $this->pt_admission_number,
            'createby' => $this->createby,
            'rep_status' => $this->rep_status,
            'sum_cash' => $this->sum_cash,
            'sum_creditcard' => $this->sum_creditcard,
            'sum_cheque' => $this->sum_cheque,
            'sum_banktransfer' => $this->sum_banktransfer,
            'rep_Amt_total' => $this->rep_Amt_total,
            'rep_Amt_discount' => $this->rep_Amt_discount,
            'rep_Amt_left' => $this->rep_Amt_left,
            'rep_Amt_net' => $this->rep_Amt_net,
            'rep_summary_id' => $this->rep_summary_id,
            'rep_create_section' => $this->rep_create_section,
        ]);

        $query->orFilterWhere(['like', 'rep_num', $this->q])
            ->andFilterWhere(['rep_status'=>'2'])
            ->andFilterWhere(['rep_summary_id'=> '0'])
            ->andFilterWhere(['rep_create_section'=>$_SESSION['section_view']]);

        return $dataProvider;
    }

}
