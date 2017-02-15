<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\AuthenticationandFinance\models\VwPtAr;

/**
 * VwPtArSearch represents the model behind the search form about `app\modules\AuthenticationandFinance\models\VwPtAr`.
 */
class VwPtArSearch extends VwPtAr
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_ar_id', 'pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'credit_group_id', 'refer_hsender_sent_typeid', 'refer_hsender_doc_qtylimited'], 'integer'],
            [['medical_right_group_id', 'medical_right_group', 'medical_right_desc', 'ar_name', 'refer_hsender_doc_id', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate', 'ar_maincode', 'medical_right_id', 'refer_hrecieve_doc_date', 'pt_refer_note'], 'safe'],
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
    public function search($params,$pt_visitnumber)
    {
        $query = VwPtAr::find();

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
            'pt_ar_id' => $this->pt_ar_id,
          //  'pt_visit_number' => $this->pt_visit_number,
            'pt_ar_seq' => $this->pt_ar_seq,
            'pt_ar_usage' => $this->pt_ar_usage,
            'refer_hsender_doc_start' => $this->refer_hsender_doc_start,
            'refer_hsender_doc_expdate' => $this->refer_hsender_doc_expdate,
            'credit_group_id' => $this->credit_group_id,
            'refer_hrecieve_doc_date' => $this->refer_hrecieve_doc_date,
            'refer_hsender_sent_typeid' => $this->refer_hsender_sent_typeid,
            'refer_hsender_doc_qtylimited' => $this->refer_hsender_doc_qtylimited,
        ]);

        $query->andFilterWhere(['like', 'medical_right_group_id', $this->medical_right_group_id])
            ->andFilterWhere(['like', 'medical_right_group', $this->medical_right_group])
            ->andFilterWhere(['like', 'medical_right_desc', $this->medical_right_desc])
            ->andFilterWhere(['like', 'ar_name', $this->ar_name])
            ->andFilterWhere(['like', 'refer_hsender_doc_id', $this->refer_hsender_doc_id])
            ->andFilterWhere(['like', 'ar_maincode', $this->ar_maincode])
            ->andFilterWhere(['like', 'medical_right_id', $this->medical_right_id])
            ->andFilterWhere(['like', 'pt_refer_note', $this->pt_refer_note])
  ->andWhere(['pt_visit_number'=> $pt_visitnumber]);
        return $dataProvider;
    }
}
