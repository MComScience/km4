<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwPtAr;

/**
 * VwPtArSearch represents the model behind the search form about `app\modules\Payment\models\VwPtAr`.
 */
class VwPtArSearch extends VwPtAr
{
    /**
     * @inheritdoc
     */
    public $q;
    public function rules()
    {
        return [
            [['pt_ar_id', 'pt_visit_number', 'pt_ar_seq', 'pt_ar_usage', 'credit_group_id'], 'integer'],
            [['medical_right_group_id', 'medical_right_group', 'medical_right_desc', 'ar_name', 'refer_hsender_doc_id', 'refer_hsender_doc_start', 'refer_hsender_doc_expdate', 'ar_maincode', 'medical_right_id','q'], 'safe'],
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
            'pt_visit_number' => $this->pt_visit_number,
            'pt_ar_seq' => $this->pt_ar_seq,
            'pt_ar_usage' => $this->pt_ar_usage,
            'refer_hsender_doc_start' => $this->refer_hsender_doc_start,
            'refer_hsender_doc_expdate' => $this->refer_hsender_doc_expdate,
            'credit_group_id' => $this->credit_group_id,
        ]);

        $query->orFilterWhere(['like', 'medical_right_group_id', $this->q])
            ->orFilterWhere(['like', 'medical_right_group', $this->q])
            ->orFilterWhere(['like', 'medical_right_desc', $this->q])
            ->orFilterWhere(['like', 'ar_name', $this->q])
            ->orFilterWhere(['like', 'refer_hsender_doc_id', $this->q])
            ->orFilterWhere(['like', 'ar_maincode', $this->q])
            ->orFilterWhere(['like', 'medical_right_id', $this->q])
            ->andFilterWhere(['pt_visit_number'=>$pt_visit_number]);

        return $dataProvider;
    }
}
