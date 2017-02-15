<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStListDraft;

/**
 * TbPr2TempSearch represents the model behind the search form about `app\modules\Purchasing\models\TbPr2Temp`.
 */
class VwStListDraftSearch extends VwStListDraft {

    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['STID', 'STIssue_StkID', 'STRecieve_StkID', 'STStatus','STDate', 'STCreateDate', 'STRecievedDate','Stk_issue', 'Stk_receive', 'STStatusDesc','STNum', 'SRNum','Stk_issue', 'Stk_receive', 'STStatusDesc','STNote','STPerson','STDueDate','q'], 'safe'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function Claimsearch($params) {
        $query = VwStListDraft::find();
        //->where(['STTypeID'=>2,'STStatus'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STNum' => SORT_DESC]]
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
            'STNum' => $this->STNum,
            'SRNum' => $this->SRNum,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'Stk_issue' => $this->Stk_issue,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'Stk_receive' => $this->Stk_receive,
            'STRecievedDate' => $this->STRecievedDate,
            'STStatus' => $this->STStatus,
            'STStatusDesc' => $this->STStatusDesc,
            'STNote' => $this->STNote,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            'VenderName'=> $this->VenderName,
           
        ]);

        $query  ->orFilterWhere(['like', 'STNum', $this->q])
                ->orFilterWhere(['like', 'Stk_issue', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->andFilterWhere(['STTypeID' =>2]);
                
                

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function Lendsearch($params) {
        $query = VwStListDraft::find();
        //->where(['STTypeID'=>4,'STStatus'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STNum' => SORT_DESC]],
           
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
            'STNum' => $this->STNum,
            'SRNum' => $this->SRNum,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'Stk_issue' => $this->Stk_issue,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'Stk_receive' => $this->Stk_receive,
            'STRecievedDate' => $this->STRecievedDate,
            'STStatus' => $this->STStatus,
            'STStatusDesc' => $this->STStatusDesc,
            'STNote' => $this->STNote,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            'VenderName'=> $this->VenderName,
           
        ]);

        $query  ->orFilterWhere(['like', 'STNum', $this->q])
                ->orFilterWhere(['like', 'Stk_issue', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->andFilterWhere(['STTypeID' =>4]);
                

        return $dataProvider;
    }
    
    public function historysearch($params) {
        $query = VwStListDraft::find()
        ->where(['STTypeID'=>4,'STStatus'=>[5,6]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STNum' => SORT_DESC]],
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
            'STID' => $this->STID,
            'STDate' => $this->STDate,
            'STNum' => $this->STNum,
            'SRNum' => $this->SRNum,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'Stk_issue' => $this->Stk_issue,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'Stk_receive' => $this->Stk_receive,
            'STRecievedDate' => $this->STRecievedDate,
            'STStatus' => $this->STStatus,
            'STStatusDesc' => $this->STStatusDesc,
            'STNote' => $this->STNote,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            'VenderName'=> $this->VenderName,
           
        ]);

        $query->orFilterWhere(['like', 'STID', $this->q])
                ->orFilterWhere(['like', 'STDate', $this->q])
                ->orFilterWhere(['like', 'STNum', $this->q])
                ->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'STCreateDate', $this->q])
                ->orFilterWhere(['like', 'STIssue_StkID', $this->q])
                ->orFilterWhere(['like', 'Stk_issue', $this->q])
                ->orFilterWhere(['like', 'STRecieve_StkID', $this->q])
                ->orFilterWhere(['like', 'Stk_receive', $this->q])
                ->orFilterWhere(['like', 'STRecievedDate', $this->q])
                ->orFilterWhere(['like', 'STStatus', $this->q])
                ->orFilterWhere(['like', 'STStatusDesc', $this->q])
                ->orFilterWhere(['like', 'STNote', $this->q])
                ->orFilterWhere(['like', 'STPerson', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->orFilterWhere(['like', 'STDueDate', $this->q]);
                

        return $dataProvider;
    }
    public function historyclaimsearch($params) {
        $query = VwStListDraft::find()
        ->where(['STTypeID'=>2,'STStatus'=>[5,6]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STNum' => SORT_DESC]],
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
            'STID' => $this->STID,
            'STDate' => $this->STDate,
            'STNum' => $this->STNum,
            'SRNum' => $this->SRNum,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'Stk_issue' => $this->Stk_issue,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'Stk_receive' => $this->Stk_receive,
            'STRecievedDate' => $this->STRecievedDate,
            'STStatus' => $this->STStatus,
            'STStatusDesc' => $this->STStatusDesc,
            'STNote' => $this->STNote,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            'VenderName'=> $this->VenderName,
           
        ]);

        $query->orFilterWhere(['like', 'STID', $this->q])
                ->orFilterWhere(['like', 'STDate', $this->q])
                ->orFilterWhere(['like', 'STNum', $this->q])
                ->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'STCreateDate', $this->q])
                ->orFilterWhere(['like', 'STIssue_StkID', $this->q])
                ->orFilterWhere(['like', 'Stk_issue', $this->q])
                ->orFilterWhere(['like', 'STRecieve_StkID', $this->q])
                ->orFilterWhere(['like', 'Stk_receive', $this->q])
                ->orFilterWhere(['like', 'STRecievedDate', $this->q])
                ->orFilterWhere(['like', 'STStatus', $this->q])
                ->orFilterWhere(['like', 'STStatusDesc', $this->q])
                ->orFilterWhere(['like', 'STNote', $this->q])
                ->orFilterWhere(['like', 'STPerson', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->orFilterWhere(['like', 'STDueDate', $this->q]);
                

        return $dataProvider;
    }
    
    public function DailySearch($params) {
        $query = VwStListDraft::find();
        //->where(['STTypeID'=>6,'STStatus'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['STNum' => SORT_DESC]]
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
            'STNum' => $this->STNum,
            'SRNum' => $this->SRNum,
            'STCreateDate' => $this->STCreateDate,
            'STIssue_StkID' => $this->STIssue_StkID,
            'Stk_issue' => $this->Stk_issue,
            'STRecieve_StkID' => $this->STRecieve_StkID,
            'Stk_receive' => $this->Stk_receive,
            'STRecievedDate' => $this->STRecievedDate,
            'STStatus' => $this->STStatus,
            'STStatusDesc' => $this->STStatusDesc,
            'STNote' => $this->STNote,
            'STPerson' => $this->STPerson,
            'STDueDate' => $this->STDueDate,
            'VenderName'=> $this->VenderName,
           
        ]);

        $query  ->orFilterWhere(['like', 'STNum', $this->q])
                ->orFilterWhere(['like', 'Stk_issue', $this->q])
                ->andFilterWhere(['STTypeID' =>6]);
                
                

        return $dataProvider;
    }

}
