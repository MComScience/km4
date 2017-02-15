<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\TbSt2;

/**
 * SearchTbst2 represents the model behind the search form about `app\modules\Inventory\models\TbSt2`.
 */
class TbSt2Search extends TbSt2
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'STTypeID', 'STCreateBy', 'STIssue_StkID', 'STRecieve_StkID', 'STRecievedBy', 'STStatus', 'STPerson'], 'integer'],
            [['STDate', 'STNum', 'SRNum', 'STCreateDate', 'STRecievedDate', 'STNote', 'STDueDate','q'], 'safe'],
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
        $query = TbSt2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'STID' => $this->STID,
//            'STDate' => $this->STDate,
//            'STTypeID' => $this->STTypeID,
//            'STCreateBy' => $this->STCreateBy,
//            'STCreateDate' => $this->STCreateDate,
//            'STIssue_StkID' => $this->STIssue_StkID,
//            'STRecieve_StkID' => $this->STRecieve_StkID,
//            'STRecievedDate' => $this->STRecievedDate,
//            'STRecievedBy' => $this->STRecievedBy,
//            'STStatus' => $this->STStatus,
//            'STPerson' => $this->STPerson,
//            'STDueDate' => $this->STDueDate,
//        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'SRNum', $this->q])
            ->orFilterWhere(['like', 'STNote', $this->q]);

        return $dataProvider;
    }
    
    public function searchrecevie($params)
    {
        $query = TbSt2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'STID' => $this->STID,
//            'STDate' => $this->STDate,
//            'STTypeID' => $this->STTypeID,
//            'STCreateBy' => $this->STCreateBy,
//            'STCreateDate' => $this->STCreateDate,
//            'STIssue_StkID' => $this->STIssue_StkID,
//            'STRecieve_StkID' => $this->STRecieve_StkID,
//            'STRecievedDate' => $this->STRecievedDate,
//            'STRecievedBy' => $this->STRecievedBy,
//            'STStatus' => $this->STStatus,
//            'STPerson' => $this->STPerson,
//            'STDueDate' => $this->STDueDate,
//        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'SRNum', $this->q])
            ->orFilterWhere(['like', 'STNote', $this->q])
         ->andWhere(['STStatus'=> ['2','3','4']]);

        return $dataProvider;
    }
    public function searchreceviehistory($params)
    {
        $query = TbSt2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'STID' => $this->STID,
//            'STDate' => $this->STDate,
//            'STTypeID' => $this->STTypeID,
//            'STCreateBy' => $this->STCreateBy,
//            'STCreateDate' => $this->STCreateDate,
//            'STIssue_StkID' => $this->STIssue_StkID,
//            'STRecieve_StkID' => $this->STRecieve_StkID,
//            'STRecievedDate' => $this->STRecievedDate,
//            'STRecievedBy' => $this->STRecievedBy,
//            'STStatus' => $this->STStatus,
//            'STPerson' => $this->STPerson,
//            'STDueDate' => $this->STDueDate,
//        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'SRNum', $this->q])
            ->orFilterWhere(['like', 'STNote', $this->q])
         ->andWhere(['STStatus'=> [5,6]]);

        return $dataProvider;
    }
    

    public function SearchHistoryClaim($params)
    {
        $query = TbSt2::find();
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
            'STTypeID' => $this->STTypeID,
            'STCreateBy' => $this->STCreateBy,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'STRecievedDate' => $this->STRecievedDate,
            'STRecievedBy' => $this->STRecievedBy,
            'STStatus' => $this->STStatus,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            //'DepartmentID' => $this->DepartmentID,
        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
                ->andFilterWhere(['STTypeID' =>2]);
            

        return $dataProvider;
    }

     public function SearchHistoryLend($params)
    {
        $query = TbSt2::find();
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
            'STTypeID' => $this->STTypeID,
            'STCreateBy' => $this->STCreateBy,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'STRecievedDate' => $this->STRecievedDate,
            'STRecievedBy' => $this->STRecievedBy,
            'STStatus' => $this->STStatus,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            //'DepartmentID' => $this->DepartmentID,
        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
              ->andFilterWhere(['STTypeID' =>4]);

        return $dataProvider;
    }
    public function SearchLondST($params)
    {
        $query = TbSt2::find();
                //->where(['STTypeID'=>3]);

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
            'STTypeID' => $this->STTypeID,
            'STCreateBy' => $this->STCreateBy,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'STRecievedDate' => $this->STRecievedDate,
            'STRecievedBy' => $this->STRecievedBy,
            'STStatus' => $this->STStatus,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            //'DepartmentID' => $this->DepartmentID,
        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
            ->orFilterWhere(['like', 'STPerson', $this->q])
            ->andFilterWhere(['STTypeID' =>3]);

        return $dataProvider;
    }

    public function SearchHistoryDaily($params)
    {
        $query = TbSt2::find();
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
            'STTypeID' => $this->STTypeID,
            'STCreateBy' => $this->STCreateBy,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'STRecievedDate' => $this->STRecievedDate,
            'STRecievedBy' => $this->STRecievedBy,
            'STStatus' => $this->STStatus,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            //'DepartmentID' => $this->DepartmentID,
        ]);

        $query->orFilterWhere(['like', 'STNum', $this->q])
                ->andFilterWhere(['STTypeID' =>6]);
            

        return $dataProvider;
    }
}
