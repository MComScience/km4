<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwStkBalanceItemid;

/**
 * VwStkBalanceItemIDSearch represents the model behind the search form about `app\modules\Inventory\models\VwStkBalanceItemID`.
 */
class VwStkBalanceItemIDSearch extends VwStkBalanceItemid {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ids', 'StkTransID', 'StkID', 'ItemID', 'ItemCatID'], 'integer'],
            [['StkTransDateTime', 'StkName','StkID', 'ItemName','ROPStatus', 'DispUnit', 'q', 'SectionID'], 'safe'],
            [['ItemQtyBalance', 'Reorderpoint', 'ItemTargetLevel', 'ItemROPDiff'], 'number'],
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
    public function search($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
          //  'ItemID' => $this->ItemID,
            //  'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
				'ROPStatus' => $this->ROPStatus,
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                 ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid]);
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }

		  /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }

    public function search_details($params,$id)
    {
        $query = VwStkBalanceItemid::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
            'ROPStatus' => $this->ROPStatus,
        ]);

        $query->andFilterWhere(['like', 'StkName', $this->q])
                ->andFilterWhere(['like', 'ItemName', $this->q])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andwhere(['ItemID' => $id]);

        return $dataProvider;
    }
    public function search_new($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            //'ItemID' => $this->ItemID,
            //'ItemName' => $this->ItemName,
            //  'ItemCatID' => $this->ItemCatID,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
            'ROPStatus' => $this->ROPStatus,
                
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid])
                ->andwhere("ItemID LIKE '2%'");
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }      

        //$query->andWhere(['StkID'=>$StkID]);    
        // $query = YII::$app->db->createCommand("SELECT * from vw_stk_balance_ItemID WHERE ItemCatID = '2' AND (ItemID LIKE '3%' or ItemID LIKE '4%' or ItemID LIKE '5%' or ItemID LIKE '6%')")->query();
          /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }
    public function search_bio($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            //'ItemID' => $this->ItemID,
            //'ItemName' => $this->ItemName,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
                'ROPStatus' => $this->ROPStatus,
                
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid])
                ->andwhere("ItemID LIKE '3%'");
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }
        // $query = YII::$app->db->createCommand("SELECT * from vw_stk_balance_ItemID WHERE ItemCatID = '2' AND (ItemID LIKE '3%' or ItemID LIKE '4%' or ItemID LIKE '5%' or ItemID LIKE '6%')")->query();
          /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }
    public function search_cssd($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            //'ItemID' => $this->ItemID,
            //'ItemName' => $this->ItemName,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
                'ROPStatus' => $this->ROPStatus,
                
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid])
                ->andwhere("ItemID LIKE '4%'");
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }
        // $query = YII::$app->db->createCommand("SELECT * from vw_stk_balance_ItemID WHERE ItemCatID = '2' AND (ItemID LIKE '3%' or ItemID LIKE '4%' or ItemID LIKE '5%' or ItemID LIKE '6%')")->query();
          /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }
    public function search_science($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            //'ItemID' => $this->ItemID,
            //'ItemName' => $this->ItemName,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
                'ROPStatus' => $this->ROPStatus,
                
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andFilterWhere(['like', 'StkID', $this->StkID])
                ->andFilterWhere(['like', 'DispUnit', $this->DispUnit])
                ->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andwhere(['ItemCatID' => $catid])
                ->andwhere("ItemID LIKE '5%'");
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }
        // $query = YII::$app->db->createCommand("SELECT * from vw_stk_balance_ItemID WHERE ItemCatID = '2' AND (ItemID LIKE '3%' or ItemID LIKE '4%' or ItemID LIKE '5%' or ItemID LIKE '6%')")->query();
          /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }
    public function search_parcel($params, $catid) {
        $query = VwStkBalanceItemID::find();

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
            'ids' => $this->ids,
            'StkTransID' => $this->StkTransID,
            'StkTransDateTime' => $this->StkTransDateTime,
            'StkID' => $this->StkID,
            //'ItemID' => $this->ItemID,
            //'ItemName' => $this->ItemName,
            'ItemQtyBalance' => $this->ItemQtyBalance,
            'Reorderpoint' => $this->Reorderpoint,
            'ItemTargetLevel' => $this->ItemTargetLevel,
            'ItemROPDiff' => $this->ItemROPDiff,
                'ROPStatus' => $this->ROPStatus,
        ]);
        $section_user = Yii::$app->user->identity->profile->User_sectionid;
        $query->andFilterWhere(['like', 'ItemID', $this->ItemID])
                ->andFilterWhere(['like', 'ItemName', $this->ItemName])
                ->andwhere(['ItemCatID' => $catid])
                ->andwhere("ItemID LIKE '6%'");
        if(empty($this->StkID)){
          if(!empty($section_user)){
            $query->andWhere(['SectionID'=>$section_user]);
            }   
        }
        //$query->        
          /*if (!empty($params['ItemQtyBalance'])) {
            if ($params['ItemQtyBalance'] == 1) {
                $query->andwhere(["<", "ItemQtyBalance", 1]);
            }
        }
          if (!empty($params['ItemROPDiff'])) {
            if ($params['ItemROPDiff'] == 1) {
                $query->andwhere(["<", "ItemROPDiff", 1]);
            }
        }*/
        return $dataProvider;
    }
}
