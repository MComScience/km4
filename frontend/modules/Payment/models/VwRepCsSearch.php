<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwRepCs;

/**
 * VwRepCsSearch represents the model behind the search form about `app\modules\Payment\models\VwRepCs`.
 */
class VwRepCsSearch extends VwRepCs
{
    /**
     * @inheritdoc
     */
    public $q;
    public function rules()
    {
        return [
            [['cs_rep_id', 'import_by'], 'integer'],
            [['rep', 'claim_num', 'report_filename', 'user_name', 'Import_date', 'itemstatus', 'q'], 'safe'],
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
        $query = VwRepCs::find();

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
            'cs_rep_id' => $this->cs_rep_id,
            'import_by' => $this->import_by,
            'Import_date' => $this->Import_date,
        ]);

        $query->orFilterWhere(['like', 'rep', $this->q])
            ->orFilterWhere(['like', 'claim_num', $this->q])
            ->orFilterWhere(['like', 'report_filename', $this->q])
            ->orFilterWhere(['like', 'user_name', $this->q]);
        if(isset($this->itemstatus)){
            $query->andWhere(['itemstatus' => $this->itemstatus]);
        }   
        return $dataProvider;
    }
}
