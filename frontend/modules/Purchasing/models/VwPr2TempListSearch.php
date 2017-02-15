<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwPr2TempList;

/**
 * TbPr2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbPr2Temp`.
 */
class VwPr2TempListSearch extends VwPr2TempList {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['PRID','PRNum', 'PRDate','PRTypeID','q','PRType','POTypeID','POType','PRExpectDate','PRStatusID','PRStatus','ids_PR_selected'], 'safe'],
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
        $query = VwPr2TempList::find();
        //->where(['POTypeID' => 1]);

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
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'PRNum' => $this->PRNum,
            'PRTypeID' => $this->PRTypeID,
            'PRType' => $this->PRType,
            'POTypeID' => $this->POTypeID,
            'POType' => $this->POType,
            'PRExpectDate' => $this->PRExpectDate,
            'PRStatusID' => $this->PRStatusID,
            'PRStatus' => $this->PRStatus,
            'ids_PR_selected' => $this->ids_PR_selected,
        ]);

        $query->orFilterWhere(['like', 'PRID', $this->q])
                ->orFilterWhere(['like', 'PRDate', $this->q])
                ->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'PRTypeID', $this->q])
                ->orFilterWhere(['like', 'PRType', $this->q])
                ->orFilterWhere(['like', 'POTypeID', $this->q])
                ->orFilterWhere(['like', 'POType', $this->q])
                ->orFilterWhere(['like', 'PRExpectDate', $this->q])
                ->orFilterWhere(['like', 'PRStatusID', $this->q])
                ->orFilterWhere(['like', 'PRStatus', $this->q])
                ->orFilterWhere(['like', 'ids_PR_selected', $this->q]);

        return $dataProvider;
    }

}
