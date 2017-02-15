<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiRepHeader;

/**
 * VwFiRepHeaderSearch represents the model behind the search form about `app\modules\Payment\models\VwFiRepHeader`.
 */
class VwFiRepHeaderSearch extends VwFiRepHeader
{
    /**
     * @inheritdoc
     */
    public $q;
    public function rules()
    {
        return [
            [['rep_id', 'inv_id', 'rep_type', 'pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_age_registry_date', 'pt_ar_id', 'createby', 'rep_status'], 'integer'],
            [['rep_num', 'repdate', 'pt_name', 'rep_comment', 'pt_titlename', 'User_fname', 'User_lname', 'rep_piad_cash', 'rep_piad_creditcard', 'rep_piad_banktransfer', 'rep_piad_cheque','q'], 'safe'],
            [['rep_Amt_total', 'rep_Amt_discount', 'rep_Amt_left', 'rep_Amt_net'], 'number'],
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
        $query = VwFiRepHeader::find();

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
            'rep_type' => $this->rep_type,
            'repdate' => $this->repdate,
            'pt_visit_number' => $this->pt_visit_number,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_age_registry_date' => $this->pt_age_registry_date,
            'pt_ar_id' => $this->pt_ar_id,
            'rep_Amt_total' => $this->rep_Amt_total,
            'createby' => $this->createby,
            'rep_status' => $this->rep_status,
            'rep_Amt_discount' => $this->rep_Amt_discount,
            'rep_Amt_left' => $this->rep_Amt_left,
            'rep_Amt_net' => $this->rep_Amt_net,
        ]);

        $query->orFilterWhere(['like', 'rep_num', $this->q])
            ->orFilterWhere(['like', 'pt_name', $this->q])
            ->orFilterWhere(['like', 'pt_hospital_number', $this->q])
            ->andFilterWhere(['rep_status'=>'1']);

        return $dataProvider;
    }
    public function SearchHistory($params)
    {
        $query = VwFiRepHeader::find();

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
            'rep_type' => $this->rep_type,
            'repdate' => $this->repdate,
            'pt_visit_number' => $this->pt_visit_number,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_age_registry_date' => $this->pt_age_registry_date,
            'pt_ar_id' => $this->pt_ar_id,
            'rep_Amt_total' => $this->rep_Amt_total,
            'createby' => $this->createby,
            'rep_status' => $this->rep_status,
            'rep_Amt_discount' => $this->rep_Amt_discount,
            'rep_Amt_left' => $this->rep_Amt_left,
            'rep_Amt_net' => $this->rep_Amt_net,
        ]);

        $query->orFilterWhere(['like', 'rep_num', $this->q])
            ->orFilterWhere(['like', 'pt_name', $this->q])
            ->orFilterWhere(['like', 'pt_hospital_number', $this->q])
            ->andFilterWhere(['rep_status'=>[2,3]]);

        return $dataProvider;
    }
}
