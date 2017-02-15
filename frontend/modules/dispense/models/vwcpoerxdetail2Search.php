<?php

namespace app\modules\dispense\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dispense\models\vwcpoerxdetail2;

/**
 * vwcpoerxdetail2Search represents the model behind the search form about `app\modules\dispense\models\vwcpoerxdetail2`.
 */
class vwcpoerxdetail2Search extends vwcpoerxdetail2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cpoe_ids', 'cpoe_seq', 'cpoe_id', 'cpoe_Itemtype', 'ItemID', 'cpoe_ItemStatus', 'cpoe_parentid'], 'integer'],
            [['ItemDetail', 'ItemQty1', 'ised_reason', 'ised_reason_decs', 'Item_comment1', 'Item_comment2', 'Item_comment3', 'Item_comment4', 'schedule_period', 'schedule_begin2end', 'cpoe_itemtype_decs', 'ItemName', 'cpoe_adj_note'], 'safe'],
            [['ItemPrice', 'Item_Amt', 'Item_Cr_Amt_Sum', 'Item_Pay_Amt_Sum'], 'number'],
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
    public function search($params,$id)
    {
        $query = vwcpoerxdetail2::find()->where(['cpoe_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['cpoe_Itemtype'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'cpoe_ids' => $this->cpoe_ids,
            'cpoe_seq' => $this->cpoe_seq,
            'cpoe_id' => $this->cpoe_id,
            'cpoe_Itemtype' => $this->cpoe_Itemtype,
            'ItemID' => $this->ItemID,
            'ItemPrice' => $this->ItemPrice,
            'Item_Amt' => $this->Item_Amt,
            'Item_Cr_Amt_Sum' => $this->Item_Cr_Amt_Sum,
            'Item_Pay_Amt_Sum' => $this->Item_Pay_Amt_Sum,
            'cpoe_ItemStatus' => $this->cpoe_ItemStatus,
            'cpoe_parentid' => $this->cpoe_parentid,
        ]);

        $query->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail])
            ->andFilterWhere(['like', 'ItemQty1', $this->ItemQty1])
            ->andFilterWhere(['like', 'ised_reason', $this->ised_reason])
            ->andFilterWhere(['like', 'ised_reason_decs', $this->ised_reason_decs])
            ->andFilterWhere(['like', 'Item_comment1', $this->Item_comment1])
            ->andFilterWhere(['like', 'Item_comment2', $this->Item_comment2])
            ->andFilterWhere(['like', 'Item_comment3', $this->Item_comment3])
            ->andFilterWhere(['like', 'Item_comment4', $this->Item_comment4])
            ->andFilterWhere(['like', 'schedule_period', $this->schedule_period])
            ->andFilterWhere(['like', 'schedule_begin2end', $this->schedule_begin2end])
            ->andFilterWhere(['like', 'cpoe_itemtype_decs', $this->cpoe_itemtype_decs])
            ->andFilterWhere(['like', 'ItemName', $this->ItemName])
            ->andFilterWhere(['like', 'cpoe_adj_note', $this->cpoe_adj_note]);

        return $dataProvider;
    }
}
