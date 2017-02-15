<?php

namespace app\modules\drugorders\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\drugorders\models\Vwptservicelistop;

/**
 * VwptservicelistopSearch represents the model behind the search form about `app\modules\drugorders\models\Vwptservicelistop`.
 */
class VwptservicelistopSearch extends Vwptservicelistop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_number', 'pt_hospital_number', 'pt_registry_by', 'pt_age_registry_date', 'pt_discharge_by', 'pt_visit_status', 'pt_ar_id', 'pt_ar_seq', 'pt_ar_usage', 'ar_id', 'pt_status'], 'integer'],
            [['pt_visit_type', 'HNVN', 'pt_registry_date', 'pt_registry_time', 'pt_discharge_date', 'pt_discharge_time', 'pt_picture', 'pt_picture_path', 'ar_maincode', 'medical_right_id', 'medical_right_desc', 'pt_medical_right_desc', 'medical_right_group_id', 'medical_right_group', 'pt_name', 'pt_right'], 'safe'],
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
        $query = Vwptservicelistop::find();

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
            'pt_visit_number' => $this->pt_visit_number,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_registry_date' => $this->pt_registry_date,
            'pt_registry_time' => $this->pt_registry_time,
            'pt_registry_by' => $this->pt_registry_by,
            'pt_age_registry_date' => $this->pt_age_registry_date,
            'pt_discharge_date' => $this->pt_discharge_date,
            'pt_discharge_time' => $this->pt_discharge_time,
            'pt_discharge_by' => $this->pt_discharge_by,
            'pt_visit_status' => $this->pt_visit_status,
            'pt_ar_id' => $this->pt_ar_id,
            'pt_ar_seq' => $this->pt_ar_seq,
            'pt_ar_usage' => $this->pt_ar_usage,
            'ar_id' => $this->ar_id,
            'pt_status' => $this->pt_status,
        ]);

        $query->andFilterWhere(['like', 'pt_visit_type', $this->pt_visit_type])
            ->andFilterWhere(['like', 'HNVN', $this->HNVN])
            ->andFilterWhere(['like', 'pt_picture', $this->pt_picture])
            ->andFilterWhere(['like', 'pt_picture_path', $this->pt_picture_path])
            ->andFilterWhere(['like', 'ar_maincode', $this->ar_maincode])
            ->andFilterWhere(['like', 'medical_right_id', $this->medical_right_id])
            ->andFilterWhere(['like', 'medical_right_desc', $this->medical_right_desc])
            ->andFilterWhere(['like', 'pt_medical_right_desc', $this->pt_medical_right_desc])
            ->andFilterWhere(['like', 'medical_right_group_id', $this->medical_right_group_id])
            ->andFilterWhere(['like', 'medical_right_group', $this->medical_right_group])
            ->andFilterWhere(['like', 'pt_name', $this->pt_name])
            ->andFilterWhere(['like', 'pt_right', $this->pt_right]);

        return $dataProvider;
    }
}
