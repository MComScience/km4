<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwFiInvCrList;

/**
 * VwFiInvCrListSearch represents the model behind the search form about `app\modules\Payment\models\VwFiInvCrList`.
 */
class VwFiInvCrListSearch extends VwFiInvCrList {

    /**
     * @inheritdoc
     */
    public $q;
    //public $pt_visit_type;
    //public $value_chk;

    public function rules() {
        return [
            [['inv_id', 'pt_hospital_number', 'pt_ar_id', 'cpoe_status', 'pt_visit_status', 'createby', 'inv_status', 'cr_summary_id'], 'integer'],
            [['inv_num', 'invdate', 'VN_AN', 'pt_name', 'medical_right_group', 'medical_right_desc', 'ar_name', 'pt_visit_type', 'medical_right_id', 'q'], 'safe'],
            [['inv_Amt_total'], 'number'],
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
        $query = VwFiInvCrList::find();

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
            'inv_id' => $this->inv_id,
            'invdate' => $this->invdate,
            'pt_hospital_number' => $this->pt_hospital_number,
            'inv_Amt_total' => $this->inv_Amt_total,
            'pt_ar_id' => $this->pt_ar_id,
            'cpoe_status' => $this->cpoe_status,
            'pt_visit_status' => $this->pt_visit_status,
            'createby' => $this->createby,
            'inv_status' => $this->inv_status,
            //'cr_summary_id' => $this->cr_summary_id,
        ]);

        $query->orFilterWhere(['like', 'inv_num', $this->q])
                ->orFilterWhere(['like', 'VN_AN', $this->q])
                ->orFilterWhere(['like', 'pt_name', $this->q])
                ->orFilterWhere(['like', 'medical_right_group', $this->q])
                ->orFilterWhere(['like', 'medical_right_desc', $this->q])
                ->orFilterWhere(['like', 'ar_name', $this->q])
                ->orFilterWhere(['like', 'medical_right_id', $this->q])
                ->orFilterWhere(['cr_summary_id'=> '0'])
                ->andFilterWhere(['pt_visit_type' => $this->pt_visit_type])
                ->andFilterWhere(['pt_visit_status' => $this->pt_visit_status]);
                

        return $dataProvider;
    }
    public function SearchHistory($params,$cr_summary_id) {
        $query = VwFiInvCrList::find();

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
            'inv_id' => $this->inv_id,
            'invdate' => $this->invdate,
            'pt_hospital_number' => $this->pt_hospital_number,
            'inv_Amt_total' => $this->inv_Amt_total,
            'pt_ar_id' => $this->pt_ar_id,
            'cpoe_status' => $this->cpoe_status,
            'pt_visit_status' => $this->pt_visit_status,
            'createby' => $this->createby,
            'inv_status' => $this->inv_status,
            //'cr_summary_id' => $this->cr_summary_id,
        ]);

        $query->orFilterWhere(['like', 'inv_num', $this->q])
                ->orFilterWhere(['like', 'VN_AN', $this->q])
                ->orFilterWhere(['like', 'pt_name', $this->q])
                ->orFilterWhere(['like', 'medical_right_group', $this->q])
                ->orFilterWhere(['like', 'medical_right_desc', $this->q])
                ->orFilterWhere(['like', 'ar_name', $this->q])
                ->orFilterWhere(['like', 'medical_right_id', $this->q])
                ->andFilterWhere(['cr_summary_id' =>$cr_summary_id])
                ->andFilterWhere(['pt_visit_status' => '3']);

        return $dataProvider;
    }
}
