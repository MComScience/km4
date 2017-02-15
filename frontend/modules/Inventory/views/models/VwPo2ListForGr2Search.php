<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwPo2ListForGr2;

/**
 * TbPo2Search represents the model behind the search form about `app\modules\Inventory\models\TbPo2`.
 */
class VwPo2ListForGr2Search extends VwPo2ListForGr2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['POID', 'PONum', 'PODate', 'POContID', 'PRNum', 'VendorID', 'POTypeID', 'POType', 'PODueDate', 'VenderName', 'q'], 'safe'],
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
        $query = VwPo2ListForGr2::find();

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
            'POID' => $this->POID,
            'PONum' => $this->PONum,
            'PODate' => $this->PODate,
            'POContID' => $this->POContID,
            'PRNum' => $this->PRNum,
            'VendorID' => $this->VendorID,
            'POTypeID' => $this->POTypeID,
            'POType' => $this->POType,
            'PODueDate' => $this->PODueDate,
            'VenderName' => $this->VenderName,
            'PRTypeID' => $this->PRTypeID,
        ]);

        $query->orFilterWhere(['like', 'POID', $this->q])
                ->orFilterWhere(['like', 'PONum', $this->q])
                ->orFilterWhere(['like', 'PODate', $this->q])
                ->orFilterWhere(['like', 'POContID', $this->q])
                ->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'VendorID', $this->q])
                ->orFilterWhere(['like', 'POTypeID', $this->q])
                ->orFilterWhere(['like', 'POType', $this->q])
                ->orFilterWhere(['like', 'PODueDate', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q]);

        return $dataProvider;
    }

    public function SearchIndexPO($params) {
        $query = VwPo2ListForGr2::find();

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
            'POID' => $this->POID,
            'PONum' => $this->PONum,
            'PODate' => $this->PODate,
            'POContID' => $this->POContID,
            'PRNum' => $this->PRNum,
            'VendorID' => $this->VendorID,
            'POTypeID' => $this->POTypeID,
            'POType' => $this->POType,
            'PODueDate' => $this->PODueDate,
            'VenderName' => $this->VenderName,
            'PRTypeID' => $this->PRTypeID,
        ]);

          $query->orFilterWhere(['like', 'PONum', $this->q])
                ->orFilterWhere(['like', 'POContID', $this->q])
                ->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'VendorID', $this->q])
                ->orFilterWhere(['like', 'POType', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
               ->andFilterWhere(['POStatus' =>11]);

        return $dataProvider;
    }

}
