<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\AuthenticationandFinance\models\VwPtRegistedList;

/**
 * VwPtRegistedListSearch represents the model behind the search form about `app\modules\AuthenticationandFinance\models\VwPtRegistedList`.
 */
class VwPtRegistedListSearch extends VwPtRegistedList
{
    public  $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date'], 'integer'],
            [['pt_name', 'pt_registry_date'], 'safe'],
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
            'sort'=> ['defaultOrder' => ['pt_registry_date'=>SORT_DESC]]
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
        ]);

        $query->andFilterWhere(['like', 'pt_name', $this->pt_name]);

        return $dataProvider;
    }
}
