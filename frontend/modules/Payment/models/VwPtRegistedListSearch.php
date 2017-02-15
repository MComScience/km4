<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwPtRegistedList;

/**
 * VwPtRegistedListSearch represents the model behind the search form about `app\modules\Payment\models\VwPtRegistedList`.
 */
class VwPtRegistedListSearch extends VwPtRegistedList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date', 'pt_nation_id'], 'integer'],
            [['pt_name', 'pt_registry_date', 'pt_registry_time', 'pt_nation_decs'], 'safe'],
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
        $query = VwPtRegistedList::find();

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
            'pt_visit_number' => $this->pt_visit_number,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_status' => $this->pt_status,
            'pt_age_registry_date' => $this->pt_age_registry_date,
            'pt_registry_date' => $this->pt_registry_date,
            'pt_registry_time' => $this->pt_registry_time,
            'pt_nation_id' => $this->pt_nation_id,
        ]);

        $query->andFilterWhere(['like', 'pt_name', $this->pt_name])
            ->andFilterWhere(['like', 'pt_nation_decs', $this->pt_nation_decs]);

        return $dataProvider;
    }
}
