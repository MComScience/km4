<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwNkCheckup21;

/**
 * VwNkCheckup21Search represents the model behind the search form about `app\modules\Payment\models\VwNkCheckup21`.
 */
class VwNkCheckup21Search extends VwNkCheckup21
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'itemstatus', 'nk_checkup_id'], 'integer'],
            [['PV', 'PAP', 'CBC', 'UA', 'Stool', 'Sugar', 'BUN', 'Creatinine', 'Uric', 'Cholesterol', 'Triglyceride', 'SGOT', 'SGPT', 'ALK', 'CXR'], 'number'],
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
        $query = VwNkCheckup21::find();

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
            'ids' => $this->ids,
            'PV' => $this->PV,
            'PAP' => $this->PAP,
            'CBC' => $this->CBC,
            'UA' => $this->UA,
            'Stool' => $this->Stool,
            'Sugar' => $this->Sugar,
            'BUN' => $this->BUN,
            'Creatinine' => $this->Creatinine,
            'Uric' => $this->Uric,
            'Cholesterol' => $this->Cholesterol,
            'Triglyceride' => $this->Triglyceride,
            'SGOT' => $this->SGOT,
            'SGPT' => $this->SGPT,
            'ALK' => $this->ALK,
            'CXR' => $this->CXR,
            'itemstatus' => $this->itemstatus,
            //'nk_checkup_id' => $this->nk_checkup_id,
        ]);
        $query->andFilterWhere(['nk_checkup_id'=>$key]);
        return $dataProvider;
    }
}
