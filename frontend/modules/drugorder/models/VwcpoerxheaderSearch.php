<?php

namespace app\modules\drugorder\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\drugorder\models\Vwcpoerxheader;

/**
 * VwcpoerxheaderSearch represents the model behind the search form about `app\modules\drugorder\models\Vwcpoerxheader`.
 */
class VwcpoerxheaderSearch extends Vwcpoerxheader
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_id', 'cpoe_type', 'pt_vn_number', 'cpoe_order_by', 'cpoe_order_section', 'pt_hospital_number', 'pt_admission_number', 'pt_status', 'pt_age_registry_date', 'cpoe_createby'], 'integer'],
            [['cpoe_num', 'HNVN', 'cpoe_date', 'md_name', 'pt_name', 'SectionDecs', 'cpoe_comment', 'User_name', 'pt_picture', 'pt_picture_path', 'cpoe_status', 'cpoe_schedule_type', 'cpoe_rep_status'], 'safe'],
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
        $query = Vwcpoerxheader::find();

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
            'cpoe_id' => $this->cpoe_id,
            'cpoe_type' => $this->cpoe_type,
            'pt_vn_number' => $this->pt_vn_number,
            'cpoe_date' => $this->cpoe_date,
            'cpoe_order_by' => $this->cpoe_order_by,
            'cpoe_order_section' => $this->cpoe_order_section,
            'pt_hospital_number' => $this->pt_hospital_number,
            'pt_admission_number' => $this->pt_admission_number,
            'pt_status' => $this->pt_status,
            'pt_age_registry_date' => $this->pt_age_registry_date,
            'cpoe_createby' => $this->cpoe_createby,
        ]);

        $query->andFilterWhere(['like', 'cpoe_num', $this->cpoe_num])
            ->andFilterWhere(['like', 'HNVN', $this->HNVN])
            ->andFilterWhere(['like', 'md_name', $this->md_name])
            ->andFilterWhere(['like', 'pt_name', $this->pt_name])
            ->andFilterWhere(['like', 'SectionDecs', $this->SectionDecs])
            ->andFilterWhere(['like', 'cpoe_comment', $this->cpoe_comment])
            ->andFilterWhere(['like', 'User_name', $this->User_name])
            ->andFilterWhere(['like', 'pt_picture', $this->pt_picture])
            ->andFilterWhere(['like', 'pt_picture_path', $this->pt_picture_path])
            ->andFilterWhere(['like', 'cpoe_status', $this->cpoe_status])
            ->andFilterWhere(['like', 'cpoe_schedule_type', $this->cpoe_schedule_type])
            ->andFilterWhere(['like', 'cpoe_rep_status', $this->cpoe_rep_status]);

        return $dataProvider;
    }
}
