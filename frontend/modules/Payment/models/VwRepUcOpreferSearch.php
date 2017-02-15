<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwRepUcOprefer;

/**
 * VwRepUcOpreferSearch represents the model behind the search form about `app\modules\Payment\models\VwRepUcOprefer`.
 */
class VwRepUcOpreferSearch extends VwRepUcOprefer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_eclaim_num', 'import_by', 'Import_date', 'doc_type', 'pid', 'pt_name', 'pt_registry_datetime', 'refer_hsender_doc_id', 'hmain2'], 'safe'],
            [['rep', 'rep_seq', 'tran_id', 'pt_hospital_number', 'nhso_rep_id'], 'integer'],
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
        $query = VwRepUcOprefer::find();

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
            'Import_date' => $this->Import_date,
            'rep' => $this->rep,
            'rep_seq' => $this->rep_seq,
            'tran_id' => $this->tran_id,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_registry_datetime' => $this->pt_registry_datetime,
            'nhso_rep_id' => $this->nhso_rep_id,
        ]);

        $query->orFilterWhere(['like', 'invoice_eclaim_num', $this->invoice_eclaim_num])
            ->orFilterWhere(['like', 'import_by', $this->import_by])
            ->orFilterWhere(['like', 'doc_type', $this->doc_type])
            ->orFilterWhere(['like', 'pid', $this->pid])
            ->orFilterWhere(['like', 'pt_name', $this->pt_name])
            ->orFilterWhere(['like', 'refer_hsender_doc_id', $this->refer_hsender_doc_id])
            ->orFilterWhere(['like', 'hmain2', $this->hmain2])
            ->andFilterWhere(['nhso_rep_id'=>$key]);;

        return $dataProvider;
    }
}
