<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwInvForRepList;

/**
 * VwInvForRepListSearch represents the model behind the search form about `app\modules\Payment\models\VwInvForRepList`.
 */
class VwInvForRepListSearch extends VwInvForRepList {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['inv_id', 'inv_type', 'pt_hospital_number', 'pt_visit_number', 'cpoe_status', 'rep_status'], 'integer'],
            [['inv_num', 'VNAN', 'pt_fullname', 'q'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = VwInvForRepList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'inv_id' => $this->inv_id,
            'inv_type' => $this->inv_type,
            'pt_hospital_number' => $this->pt_hospital_number,
            'cpoe_status' => $this->cpoe_status,
            //'rep_status' => $this->rep_status,
            'pt_visit_number' => $this->pt_visit_number,
        ]);

        $query  ->orFilterWhere(['like', 'inv_num', $this->q])
                ->orFilterWhere(['like', 'pt_hospital_number', $this->q])
                ->orFilterWhere(['like', 'cpoe_status', $this->q])
                //->orFilterWhere(['like', 'rep_status', $this->q])
                ->orFilterWhere(['like', 'VNAN', $this->q])
                ->orFilterWhere(['like', 'pt_fullname', $this->q])
                ->orFilterWhere(['like', 'pt_visit_number', $this->q])
                ->andFilterWhere(['inv_status'=>'2']);
        return $dataProvider;
    }

}
