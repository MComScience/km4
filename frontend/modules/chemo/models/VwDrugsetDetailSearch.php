<?php

namespace app\modules\chemo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chemo\models\VwDrugsetDetail;

/**
 * VwDrugsetDetailSearch represents the model behind the search form about `app\modules\chemo\models\VwDrugsetDetail`.
 */
class VwDrugsetDetailSearch extends VwDrugsetDetail {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['drugset_ids', 'drugset_id', 'cpoe_seq', 'cpoe_parentid', 'cpoe_Itemtype', 'ItemID', 'drugset_status'], 'integer'],
            [['ItemDetail', 'ItemQty1', 'ised_reason_decs', 'schedule_period', 'schedule_begin2end', 'cpoe_itemtype_decs', 'cpoe_detail_date', 'cpoe_detail_time', 'Item_Cr_Amt_Sum', 'Item_Pay_Amt', 'ised', 'ised_reason', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4','chemo_regimen_ids'], 'safe'],
            [['ItemQty', 'ItemPrice', 'Item_Amt'], 'number'],
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
    
    public function ivsearch($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['chemo_regimen_ids' => $ids,'cpoe_Itemtype' => [50,53]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_keep($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['chemo_regimen_ids' => $ids,'cpoe_Itemtype' => 21]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_premed($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['chemo_regimen_ids' => $ids,'cpoe_Itemtype' => 22]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_medicat($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['chemo_regimen_ids' => $ids,'cpoe_Itemtype' => [10,20,54]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_std_keep($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['std_trp_chemo_ids' => $ids,'cpoe_Itemtype' => [21]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'std_trp_chemo_ids' => $this->std_trp_chemo_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'std_trp_chemo_ids', $this->std_trp_chemo_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_std_premed($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['std_trp_chemo_ids' => $ids,'cpoe_Itemtype' => [22]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'std_trp_chemo_ids' => $this->std_trp_chemo_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'std_trp_chemo_ids', $this->std_trp_chemo_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_std_iv($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['std_trp_chemo_ids' => $ids,'cpoe_Itemtype' => [50,53]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'std_trp_chemo_ids' => $this->std_trp_chemo_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'std_trp_chemo_ids', $this->std_trp_chemo_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
    
    public function search_std_medicat($params, $ids) {
        $query = VwDrugsetDetail::find()
                ->where(['std_trp_chemo_ids' => $ids,'cpoe_Itemtype' => [10,20,54]]);

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
            'drugset_ids' => $this->drugset_ids,
            'drugset_id' => $this->drugset_id,
            'cpoe_detail_date' => $this->cpoe_detail_date,
            'cpoe_detail_time' => $this->cpoe_detail_time,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_parentid' => $this->cpoe_parentid,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemQty' => $this->ItemQty,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'drugset_status' => $this->drugset_status,
            'chemo_regimen_ids' => $this->chemo_regimen_ids,
            'std_trp_chemo_ids' => $this->std_trp_chemo_ids,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
                ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
                ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
                ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
                ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
                ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
                ->andFilterWhere(['like', 'Item_Cr_Amt_Sum', $this->Item_Cr_Amt_Sum])
                ->andFilterWhere(['like', 'Item_Pay_Amt', $this->Item_Pay_Amt])
                ->andFilterWhere(['like', 'ised', $this->ised])
                ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
                ->andFilterWhere(['like', 'chemo_regimen_ids', $this->chemo_regimen_ids])
                ->andFilterWhere(['like', 'std_trp_chemo_ids', $this->std_trp_chemo_ids])
                ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
                ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
                ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
                ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4]);

        return $dataProvider;
    }
  
  

}
