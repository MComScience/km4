<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwNkSeq;

/**
 * VwNkSeqSearch represents the model behind the search form about `app\modules\Payment\models\VwNkSeq`.
 */
class VwNkSeqSearch extends VwNkSeq
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nk_seq_id', 'pt_right', 'age'], 'integer'],
            [['seq', 'h_main', 'visit_time', 'hn_id_no', 'hn_no', 'fullname', 'sex', 'diag10', 'diag9', 'doc_code', 'import_by', 'import_date'], 'safe'],
            [['p_lab', 'p_xray', 'p_us', 'p_tm', 'p_ot', 'p_cl', 'p_sent', 'p_bb', 'p_chemo', 'p_rt', 'p_or', 'p_drug', 'notpay'], 'number'],
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
        $query = VwNkSeq::find();

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
            'nk_seq_id' => $this->nk_seq_id,
            'visit_time' => $this->visit_time,
            'pt_right' => $this->pt_right,
            'age' => $this->age,
            'p_lab' => $this->p_lab,
            'p_xray' => $this->p_xray,
            'p_us' => $this->p_us,
            'p_tm' => $this->p_tm,
            'p_ot' => $this->p_ot,
            'p_cl' => $this->p_cl,
            'p_sent' => $this->p_sent,
            'p_bb' => $this->p_bb,
            'p_chemo' => $this->p_chemo,
            'p_rt' => $this->p_rt,
            'p_or' => $this->p_or,
            'p_drug' => $this->p_drug,
            'notpay' => $this->notpay,
            'import_date' => $this->import_date,
        ]);

        $query->andFilterWhere(['like', 'seq', $this->seq])
            ->andFilterWhere(['like', 'h_main', $this->h_main])
            ->andFilterWhere(['like', 'hn_id_no', $this->hn_id_no])
            ->andFilterWhere(['like', 'hn_no', $this->hn_no])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'diag10', $this->diag10])
            ->andFilterWhere(['like', 'diag9', $this->diag9])
            ->andFilterWhere(['like', 'doc_code', $this->doc_code])
            ->andFilterWhere(['like', 'import_by', $this->import_by]);

        return $dataProvider;
    }
}
