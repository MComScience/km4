<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwPtArdetail;

/**
 * VwPtArdetailSearch represents the model behind the search form about `app\modules\Payment\models\VwPtArdetail`.
 */
class VwPtArdetailSearch extends VwPtArdetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_ar_id', 'pt_ar_seq', 'pt_ar_usage', 'ar_id', 'pt_ar_status', 'pt_visit_number', 'refer_hsender_sent_typeid', 'refer_hsender_doc_qtylimited', 'refer_hrecieve_doc_id'], 'integer'],
            [['ar_maincode', 'refer_hrecieve_doc_date', 'refer_hsender_doc_id', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate', 'ar_name', 'medical_right_desc', 'medical_right_group_code', 'medical_right_group', 'ar_card_id', 'pt_refer_note'], 'safe'],
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
    public function search($params, $pt_visit_number)
    {
        $query = VwPtArdetail::find();

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
            'pt_ar_seq' => $this->pt_ar_seq,
            'pt_ar_usage' => $this->pt_ar_usage,
            'ar_id' => $this->ar_id,
            'refer_hrecieve_doc_date' => $this->refer_hrecieve_doc_date,
            'refer_hsender_doc_start' => $this->refer_hsender_doc_start,
            'refer_hsender_doc_expdate' => $this->refer_hsender_doc_expdate,
            'pt_ar_status' => $this->pt_ar_status,
            'pt_visit_number' => $this->pt_visit_number,
            'refer_hsender_sent_typeid' => $this->refer_hsender_sent_typeid,
            'refer_hsender_doc_qtylimited' => $this->refer_hsender_doc_qtylimited,
            'refer_hrecieve_doc_id' => $this->refer_hrecieve_doc_id,
        ]);

        $query->andFilterWhere(['like', 'ar_maincode', $this->ar_maincode])
            ->andFilterWhere(['like', 'refer_hsender_doc_id', $this->refer_hsender_doc_id])
            ->andFilterWhere(['like', 'ar_name', $this->ar_name])
            ->andFilterWhere(['like', 'medical_right_desc', $this->medical_right_desc])
            ->andFilterWhere(['like', 'medical_right_group_code', $this->medical_right_group_code])
            ->andFilterWhere(['like', 'medical_right_group', $this->medical_right_group])
            ->andFilterWhere(['like', 'ar_card_id', $this->ar_card_id])
            ->andFilterWhere(['like', 'pt_refer_note', $this->pt_refer_note])
            ->andFilterWhere(['pt_visit_number'=>$pt_visit_number]);

        return $dataProvider;
    }
}
