<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbGr2Temp;

/**
 * TbGr2TempSearch represents the model behind the search form about `app\modules\Inventory\models\TbGr2Temp`.
 */
class TbGr2TempSearch extends TbGr2Temp
{   
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRID', 'GRTypeID', 'VenderID', 'GRStatusID', 'GRCreatedBy'], 'integer'],
            [['GRNum', 'GRDate', 'PONum', 'PODate', 'POType', 'PRNum', 'PODueDate', 'GRSubtotal', 'GRVat', 'GRTotal', 'GRCreatedDate', 'GRCreatedTime', 'VenderInvoiceNum','StkID','q'], 'safe'],
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
        $query = TbGr2Temp::find();

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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->orFilterWhere(['like', 'POType', $this->q])
            ->orFilterWhere(['like', 'PRNum', $this->q])
            ->orFilterWhere(['like', 'StkID', $this->q])
            ->orFilterWhere(['like', 'GRSubtotal', $this->q])
            ->orFilterWhere(['like', 'GRVat', $this->q])
            ->orFilterWhere(['like', 'GRTotal', $this->q])
            ->orFilterWhere(['like', 'VenderInvoiceNum', $this->q]);

        return $dataProvider;
    }
    public function SearchGrDonate($params)
    {
        $query = TbGr2Temp::find();
                 //->where(['GRTypeID'=>5,'GRStatusID'=>1]);

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
            'GRNum'=>$this->GRNum,
            'GRTypeID' => $this->GRTypeID,
            'PODate' => $this->PODate,
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

       $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andWhere(['tb_gr2_temp.GRTypeID' => array(5,7,8)]);

        return $dataProvider;
    }
    public function SearchStinitail($params)
    {
        $query = TbGr2Temp::find();
                //->where(['GRTypeID'=>6,'GRStatusID'=>1]);

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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);
       $array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all();
            if ($array_stk != null) {
                foreach ($array_stk as $data) {
                    $StkID[] = $data['StkID'];
            }
        }
        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'StkID', $this->q])
            ->andWhere(['tb_gr2_temp.GRTypeID' => array(6)]);
            if(!empty($StkID)){
                $query->andWhere(['tb_gr2_temp.StkID' => $StkID]);
            }

        return $dataProvider;
    }
    
    public function SearchLond($params)
    {
        $query = TbGr2Temp::find();
                //->where(['GRTypeID'=>3,'GRStatusID'=>1]);

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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

       $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andWhere(['tb_gr2_temp.GRTypeID' => array(3)]);

        return $dataProvider;
    }
    public function SearchHistoryLond($params)
    {
        $query = TbGr2Temp::find()
                ->where(['GRTypeID'=>3,'GRStatusID'=>3]);

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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

        $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->orFilterWhere(['like', 'POType', $this->q])
            ->orFilterWhere(['like', 'PRNum', $this->q])
            ->orFilterWhere(['like', 'StkID', $this->q])
            ->orFilterWhere(['like', 'GRSubtotal', $this->q])
            ->orFilterWhere(['like', 'GRVat', $this->q])
            ->orFilterWhere(['like', 'GRTotal', $this->q])
            ->orFilterWhere(['like', 'VenderInvoiceNum', $this->q]);

        return $dataProvider;
    }
    public function SearchClaimTemp($params)
    {
        $query = TbGr2Temp::find();
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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

       $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andFilterWhere(['GRTypeID' =>2]);

        return $dataProvider;
    }

    public function SearchLendTemp($params)
    {
        $query = TbGr2Temp::find();
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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

         $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->orFilterWhere(['like', 'VenderID', $this->q])
            ->andFilterWhere(['GRTypeID' =>4]);

        return $dataProvider;
    }
    public function SearchPO($params)
    {
        $query = TbGr2Temp::find();
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
            'VenderID' => $this->VenderID,
            'PODueDate' => $this->PODueDate,
            'GRStatusID' => $this->GRStatusID,
            'GRCreatedBy' => $this->GRCreatedBy,
            'GRCreatedDate' => $this->GRCreatedDate,
            'GRCreatedTime' => $this->GRCreatedTime,
            'StkID' => $this->StkID,
        ]);

       $query->orFilterWhere(['like', 'GRNum', $this->q])
            ->orFilterWhere(['like', 'PONum', $this->q])
            ->orFilterWhere(['like', 'StkID', $this->q])
            ->andWhere(['tb_gr2_temp.GRTypeID' => array(1)]);

        return $dataProvider;
    }
}
