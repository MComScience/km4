<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbGr2;

/**
 * TbGr2Search represents the model behind the search form about `app\modules\Inventory\models\TbGr2`.
 */
class TbGr2Search extends TbGr2
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRTypeID', 'StkID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRNum', 'GRDate', 'PONum', 'PODate', 'POType', 'PRNum', 'PODueDate', 'GRSubtotal', 'GRVat', 'GRTotal', 'GRCreatedDate', 'GRCreatedTime', 'VenderInvoiceNum', 'GRNote','q'], 'safe'],
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
        $query = TbGr2::find();

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

        $query->andFilterWhere(['like', 'GRNum', $this->GRNum])
            ->andFilterWhere(['like', 'PONum', $this->PONum])
            ->andFilterWhere(['like', 'POType', $this->POType])
            ->andFilterWhere(['like', 'PRNum', $this->PRNum])
            ->andFilterWhere(['like', 'GRSubtotal', $this->GRSubtotal])
            ->andFilterWhere(['like', 'GRVat', $this->GRVat])
            ->andFilterWhere(['like', 'GRTotal', $this->GRTotal])
            ->andFilterWhere(['like', 'VenderInvoiceNum', $this->VenderInvoiceNum])
            ->andFilterWhere(['like', 'GRNote', $this->GRNote]);

        return $dataProvider;
    }
    public function SearchGrDonateHistory($params)
    {
        $query = TbGr2::find();
        
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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(5,7)]);

        return $dataProvider;
    }

    public function SearchHistoryStk($params)
    {
        $query = TbGr2::find();
             //->where(['GRTypeID'=>6,'GRStatusID'=>3]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'StkID', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(6)]);

        return $dataProvider;
    }
    public function SearchHistoryLond($params)
    {
        $query = TbGr2::find();
             //->where(['GRTypeID'=>3,'GRStatusID'=>3]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

         $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(3)]);

        return $dataProvider;
    }
     public function SearchHistoryLend($params)
    {
        $query = TbGr2::find();
             //->where(['GRTypeID'=>4]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

          $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(4)]);


        return $dataProvider;
    }
     public function SearchHistoryClaim($params)
    {
        $query = TbGr2::find();
             //->where(['GRTypeID'=>2]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

         $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(2)]);

        return $dataProvider;
    }

    public function SearchHistoryPO($params)
    {
        $query = TbGr2::find();
             //->where(['GRTypeID'=>1]);

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
            'GRID' => $this->GRID,
            'GRDate' => $this->GRDate,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'StkID' => $this->StkID,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->andWhere(['tb_gr2.GRTypeID' => array(1)]);

        return $dataProvider;
    }
}
