<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\TbFiNhsoStm;

/**
 * TbFiNhsoStmSearch represents the model behind the search form about `app\modules\Payment\models\TbFiNhsoStm`.
 */
class TbFiNhsoStmSearch extends TbFiNhsoStm
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nhso_stm_id', 'prov', 'hcode', 'import_by'], 'integer'],
            [['stm_eclaim_num', 'report_date', 'report_time', 'Import_date'], 'safe'],
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
        $query = TbFiNhsoStm::find();

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
            'nhso_stm_id' => $this->nhso_stm_id,
            'prov' => $this->prov,
            'hcode' => $this->hcode,
            'report_date' => $this->report_date,
            'report_time' => $this->report_time,
            'import_by' => $this->import_by,
            'Import_date' => $this->Import_date,
        ]);

        $query->andFilterWhere(['like', 'stm_eclaim_num', $this->stm_eclaim_num]);

        return $dataProvider;
    }
}
