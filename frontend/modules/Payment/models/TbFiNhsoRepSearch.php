<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\TbFiNhsoRep;

/**
 * TbFiNhsoRepSearch represents the model behind the search form about `app\modules\Payment\models\TbFiNhsoRep`.
 */
class TbFiNhsoRepSearch extends TbFiNhsoRep
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_rep_id'], 'integer'],
            [['invoice_eclaim_num', 'rep', 'report_filename', 'report_date', 'report_time', 'fund_section', 'fund_region', 'prov', 'hcode', 'import_by', 'Import_date'], 'safe'],
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
    public function search($params,$type)
    {
        $query = TbFiNhsoRep::find();

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
            'nhso_rep_id' => $this->nhso_rep_id,
        ]);
        $type_where = explode("-", $type);    
        $query->orFilterWhere(['like', 'invoice_eclaim_num', $this->invoice_eclaim_num])
            ->orFilterWhere(['like', 'rep', $this->rep])
            ->orFilterWhere(['like', 'report_filename', $this->report_filename])
            ->orFilterWhere(['like', 'report_date', $this->report_date])
            ->orFilterWhere(['like', 'report_time', $this->report_time])
            ->orFilterWhere(['like', 'fund_section', $this->fund_section])
            ->orFilterWhere(['like', 'fund_region', $this->fund_region])
            ->orFilterWhere(['like', 'prov', $this->prov])
            ->orFilterWhere(['like', 'hcode', $this->hcode])
            ->orFilterWhere(['like', 'import_by', $this->import_by])
            ->orFilterWhere(['like', 'Import_date', $this->Import_date])
            ->andWhere(['doc_type' => $type_where[0]])
            ->orWhere(['doc_type' => $type_where[1]]);
        return $dataProvider;
    }
}
