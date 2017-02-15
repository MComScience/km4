<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwSt2ListForGr2;

/**
 * VwSt2ListForGr2Search represents the model behind the search form about `app\modules\Inventory\models\VwSt2ListForGr2`.
 */
class VwSt2ListForGr2Search extends VwSt2ListForGr2
{
    /**
     * @inheritdoc
     */
    public $q;
    
    public function rules()
    {
        return [
            [['STID', 'StkID', 'GRStatusID', 'STTypeID'], 'integer'],
            [['STNum', 'STDate', 'StkName', 'VenderName', 'STDueDate', 'STStatusDesc','q'], 'safe'],
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
        $query = VwSt2ListForGr2::find();

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
            'STID' => $this->STID,
            'STDate' => $this->STDate,
            'StkID' => $this->StkID,
            'STDueDate' => $this->STDueDate,
            'GRStatusID' => $this->GRStatusID,
            'STTypeID' => $this->STTypeID,
        ]);

        $query->andFilterWhere(['like', 'STNum', $this->STNum])
            ->andFilterWhere(['like', 'StkName', $this->StkName])
            ->andFilterWhere(['like', 'VenderName', $this->VenderName])
            ->andFilterWhere(['like', 'STStatusDesc', $this->STStatusDesc]);

        return $dataProvider;
    }
    
    public function SearchIndexClaim($params)
    {
        $query = VwSt2ListForGr2::find();
                //->where(['STTypeID'=>2]);

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
            'STID' => $this->STID,
            'STDate' => $this->STDate,
            'StkID' => $this->StkID,
            'STDueDate' => $this->STDueDate,
            'GRStatusID' => $this->GRStatusID,
            'STTypeID' => $this->STTypeID,
        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'StkName', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->andFilterWhere(['STTypeID' =>2]);

        return $dataProvider;
    }
    public function SearchIndexLend($params)
    {
        $query = VwSt2ListForGr2::find();
                //->where(['STTypeID'=>4]);

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
            'STID' => $this->STID,
            'STDate' => $this->STDate,
            'StkID' => $this->StkID,
            'STDueDate' => $this->STDueDate,
            'GRStatusID' => $this->GRStatusID,
            'STTypeID' => $this->STTypeID,
        ]);

       $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'StkName', $this->q])
            ->orFilterWhere(['like', 'VenderName', $this->q])
            ->andFilterWhere(['STTypeID' =>4]);

        return $dataProvider;
    }
}