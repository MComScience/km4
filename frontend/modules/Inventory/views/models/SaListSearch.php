<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSaList;

/**
 * SaListSearch represents the model behind the search form about `app\modules\Inventory\models\VwSaList`.
 */
class SaListSearch extends VwSaList {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SAID', 'SATypeID', 'SA_stkID', 'SAStatus', 'SACreateBy'], 'integer'],
            [['SANum', 'SADate', 'SAType', 'StkName', 'SAStatusDesc', 'SANote', 'q'], 'safe'],
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
        $query = VwSaList::find()->where(['SAStatus'=>1]);

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
            'SAID' => $this->SAID,
            'SADate' => $this->SADate,
            'SATypeID' => $this->SATypeID,
            'SA_stkID' => $this->SA_stkID,
            'SAStatus' => $this->SAStatus,
            'SACreateBy' => $this->SACreateBy,
        ]);

        $query->orFilterWhere(['like', 'SANum', $this->q])
                ->orFilterWhere(['like', 'SAType', $this->q])
                ->orFilterWhere(['like', 'StkName', $this->q])
                ->orFilterWhere(['like', 'SAStatusDesc', $this->q])
                ->orFilterWhere(['like', 'SANote', $this->q])
                ->andFilterWhere(['like', 'SAStatus', $this->q]);

        return $dataProvider;
    }

    public function searchwaitapprove($params) {
        $query = VwSaList::find();//->where(['SAStatus'=>[2,6]]);

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
            'SAID' => $this->SAID,
            'SADate' => $this->SADate,
            'SATypeID' => $this->SATypeID,
            'SA_stkID' => $this->SA_stkID,
            'SAStatus' => $this->SAStatus,
            'SACreateBy' => $this->SACreateBy,
        ]);

        $query->orFilterWhere(['like', 'SANum', $this->q])
                ->orFilterWhere(['like', 'SAType', $this->q])
                ->orFilterWhere(['like', 'StkName', $this->q])
                ->orFilterWhere(['like', 'SAStatusDesc', $this->q])
                ->orFilterWhere(['like', 'SANote', $this->q])
              //  ->orFilterWhere(['like', 'SAStatus', 2])
                ->andWhere(['SAStatus'=>[2,6]]);
                

        return $dataProvider;
    }

    public function searchhistory($params) {
        $query = VwSaList::find();

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
            'SAID' => $this->SAID,
            'SADate' => $this->SADate,
            'SATypeID' => $this->SATypeID,
            'SA_stkID' => $this->SA_stkID,
            'SAStatus' => $this->SAStatus,
            'SACreateBy' => $this->SACreateBy,
        ]);

        $query->orFilterWhere(['like', 'SANum', $this->q])
                ->orFilterWhere(['like', 'SAType', $this->q])
                ->orFilterWhere(['like', 'StkName', $this->q])
                ->orFilterWhere(['like', 'SAStatusDesc', $this->q])
                ->orFilterWhere(['like', 'SANote', $this->q])
                ->andFilterWhere(['like', 'SAStatus', 4]);

        return $dataProvider;
    }

}
