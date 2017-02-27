<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwNkCheckup02;

/**
 * VwNkCheckup02Search represents the model behind the search form about `app\modules\Payment\models\VwNkCheckup02`.
 */
class VwNkCheckup02Search extends VwNkCheckup02
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'itemstatus', 'nk_checkup_id'], 'integer'],
            [['PV', 'CBC', 'Urine', 'Stool', 'Glucose', 'BUN', 'Creatinine', 'Uric', 'Cholesterol', 'Triglyceride', 'LFT', 'Serology', 'CXR', 'PSA', 'EKG', 'Thin', 'HPV'], 'number'],
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
        $query = VwNkCheckup02::find();

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
            'CBC' => $this->CBC,
            'Urine' => $this->Urine,
            'Stool' => $this->Stool,
            'Glucose' => $this->Glucose,
            'BUN' => $this->BUN,
            'Creatinine' => $this->Creatinine,
            'Uric' => $this->Uric,
            'Cholesterol' => $this->Cholesterol,
            'Triglyceride' => $this->Triglyceride,
            'LFT' => $this->LFT,
            'Serology' => $this->Serology,
            'CXR' => $this->CXR,
            'PSA' => $this->PSA,
            'EKG' => $this->EKG,
            'Thin' => $this->Thin,
            'HPV' => $this->HPV,
            'itemstatus' => $this->itemstatus,
            //'nk_checkup_id' => $this->nk_checkup_id,
        ]);
        $query->andFilterWhere(['nk_checkup_id'=>$key]);
        return $dataProvider;
    }
}
