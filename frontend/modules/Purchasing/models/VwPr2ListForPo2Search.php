<?php

namespace app\modules\Purchasing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Purchasing\models\VwPr2ListForPo2;

/**
 * VwPr2ListForPo2Search represents the model behind the search form about `app\modules\Purchasing\models\VwPr2ListForPo2`.
 */
class VwPr2ListForPo2Search extends VwPr2ListForPo2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['PRID', 'POTypeID', 'PRTypeID', 'PRStatusID'], 'integer'],
                [['PRNum', 'PRDate', 'POType', 'PRType', 'q', 'PRExpectDate'], 'safe'],
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
        $query = VwPr2ListForPo2::find();

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
            'PRID' => $this->PRID,
            'PRDate' => $this->PRDate,
            'POTypeID' => $this->POTypeID,
            'PRTypeID' => $this->PRTypeID,
            'PRStatusID' => $this->PRStatusID,
            'PRExpectDate' => $this->PRExpectDate,
        ]);

        $query->orFilterWhere(['like', 'PRNum', $this->q]);
                //->orFilterWhere(['like', 'POType', $this->q])
                //->orFilterWhere(['like', 'PRDate', $this->q])
                //->orFilterWhere(['like', 'PRExpectDate', $this->q])
                //->orFilterWhere(['like', 'PRType', $this->q]);

        return $dataProvider;
    }

}
